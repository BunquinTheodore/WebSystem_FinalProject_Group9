<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Task;
use App\Models\TaskAssignment;
use App\Models\TaskProof;

Route::get('/', function (Request $request) {
    $role = $request->session()->get('role');
    $username = $request->session()->get('username');
    if ($role && $username) {
        return match ((string) $role) {
            'owner' => redirect()->route('owner.home'),
            'manager' => redirect()->route('manager.home'),
            'employee' => redirect(url('/employee/tasks/opening')),
            default => redirect('/dashboard'),
        };
    }
    // If there is a partial session (role without username), reset it
    if ($role xor $username) {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
    return view('auth.login');
});

Route::post('/register', function (Request $request) {
    $data = $request->validate([
        'username' => 'required|string|max:255|unique:users,username',
        'email' => 'required|email|max:255|unique:users,email',
        'role' => 'required|in:owner,manager,employee',
        'password' => 'required|string|min:6|confirmed',
    ]);

    // User model casts will hash the password automatically
    $user = User::create([
        'name' => (string) ($request->input('name') ?: $data['username']),
        'username' => $data['username'],
        'email' => $data['email'],
        'role' => $data['role'],
        'password' => $data['password'],
    ]);

    $request->session()->put('username', $user->username);
    $request->session()->put('role', $user->role);

    // Redirect to role-specific home after signup
    return match ($user->role) {
        'owner' => redirect()->route('owner.home'),
        'manager' => redirect()->route('manager.home'),
        default => redirect(url('/employee/tasks/opening')),
    };
})->name('register');

Route::get('/login', function (Request $request) {
    $role = $request->session()->get('role');
    $username = $request->session()->get('username');
    if ($role && $username) {
        return match ((string) $role) {
            'owner' => redirect()->route('owner.home'),
            'manager' => redirect()->route('manager.home'),
            'employee' => redirect(url('/employee/tasks/opening')),
            default => redirect('/dashboard'),
        };
    }
    // clear partial session on login page too
    if ($role xor $username) {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
    return view('auth.login');
})->name('login');

Route::get('/register', function (Request $request) {
    if ($request->session()->has('role')) {
        return redirect('/dashboard');
    }
    return view('auth.register');
})->name('register.show');

Route::post('/login', function (Request $request) {
    $request->validate([
        'username' => 'required|string',
        'password' => 'required|string',
    ]);

    $login = (string) $request->string('username');
    $password = (string) $request->string('password');

    // Try authenticating against the database (username or email)
    $user = User::where('username', $login)->orWhere('email', $login)->first();
    if ($user && Hash::check($password, $user->password)) {
        $request->session()->put('username', $user->username);
        $request->session()->put('role', $user->role);
        return match ($user->role) {
            'owner' => redirect()->route('owner.home'),
            'manager' => redirect()->route('manager.home'),
            default => redirect(url('/employee/tasks/opening')),
        };
    }

    // Fallback to demo accounts (optional)
    $demo = [
        'owner' => ['role' => 'owner', 'pass' => '1234'],
        'manager' => ['role' => 'manager', 'pass' => '1234'],
        'employee' => ['role' => 'employee', 'pass' => '1234'],
    ];
    if (isset($demo[$login]) && $password === $demo[$login]['pass']) {
        $request->session()->put('username', $login);
        $request->session()->put('role', $demo[$login]['role']);
        return match ($demo[$login]['role']) {
            'owner' => redirect()->route('owner.home'),
            'manager' => redirect()->route('manager.home'),
            default => redirect(url('/employee/tasks/opening')),
        };
    }

    return back()->withErrors(['auth' => 'Invalid credentials'])->withInput();
});

Route::post('/logout', function (Request $request) {
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

Route::get('/dashboard', function (Request $request) {
    if (!$request->session()->has('role')) {
        return redirect()->route('login');
    }
    return view('dashboard');
})->name('dashboard');

Route::get('/owner', function (Request $request) {
    if ($request->session()->get('role') !== 'owner') {
        return redirect()->route('dashboard');
    }

    $reports = DB::table('manager_reports')->orderByDesc('id')->limit(20)->get();
    $fundBalance = (float) (DB::table('manager_funds')->sum('amount') ?? 0);
    $expenses = DB::table('expenses')->orderByDesc('id')->limit(20)->get();
    $expensesTotal = (float) (DB::table('expenses')->sum('amount') ?? 0);
    $availableBalance = $fundBalance - $expensesTotal;
    $requests = DB::table('requests')->orderByDesc('id')->limit(50)->get();
    // Filters for APEPO list only
    $apepoQuery = DB::table('apepo_reports');
    $from = $request->query('from');
    $to = $request->query('to');
    // Manager can be string or array (manager[])
    $managerParam = $request->query('manager');
    $managerTerms = [];
    if (is_array($managerParam)) {
        foreach ($managerParam as $mp) {
            $mp = trim((string) $mp);
            if ($mp !== '') { $managerTerms[] = strtolower($mp); }
        }
    } else {
        $single = trim((string) $managerParam);
        if ($single !== '') { $managerTerms[] = strtolower($single); }
    }
    if (!empty($managerTerms)) {
        $apepoQuery->where(function($q) use ($managerTerms) {
            foreach ($managerTerms as $idx => $term) {
                $q->orWhereRaw('LOWER(manager_username) LIKE ?', ['%'.$term.'%']);
            }
        });
    }
    if (!empty($from) || !empty($to)) {
        try {
            $fromDt = $from ? \Carbon\Carbon::parse($from)->startOfDay() : \Carbon\Carbon::create(1970,1,1,0,0,0);
            $toDt = $to ? \Carbon\Carbon::parse($to)->endOfDay() : \Carbon\Carbon::now()->endOfDay();
            $apepoQuery->whereBetween('created_at', [$fromDt, $toDt]);
        } catch (\Throwable $e) {
            
        }
    }
    $apepo = $apepoQuery->orderByDesc('id')->paginate(20);
    $apepoManagers = DB::table('apepo_reports')->distinct()->orderBy('manager_username')->pluck('manager_username');

    // Audit / Payroll aggregates
    $employeeCount = (int) DB::table('employees')->count();
    $payrollAllTimeTotal = (float) (DB::table('payroll')->selectRaw('COALESCE(SUM(hourly_rate * hours_worked), 0) as total')->value('total') ?? 0);
    $weekStart = \Carbon\Carbon::now()->startOfWeek();
    $weekEnd = \Carbon\Carbon::now()->endOfWeek();
    $payrollWeekTotal = (float) (DB::table('payroll')
        ->whereBetween('created_at', [$weekStart, $weekEnd])
        ->selectRaw('COALESCE(SUM(hourly_rate * hours_worked), 0) as total')
        ->value('total') ?? 0);
    $payrollRecords = DB::table('payroll')
        ->leftJoin('employees','payroll.employee_id','=','employees.id')
        ->orderByDesc('payroll.id')
        ->limit(12)
        ->get(['payroll.*','employees.name as employee_name','employees.employment_type']);

    // Employees directory data
    $employees = DB::table('employees')->orderBy('name')->get();
    $empTotal = (int) $employees->count();
    $empFull = (int) $employees->where('employment_type','fulltime')->count();
    $empPart = (int) $employees->where('employment_type','parttime')->count();

    // Inventory overview for owner with status computation
    $rawInventory = DB::table('inventory_items')->orderBy('category')->orderBy('name')->get();
    $inventory = collect($rawInventory)->map(function($it){
        $qty = (int) ($it->quantity ?? 0);
        $min = max(0, (int) ($it->min_threshold ?? 0));
        $status = 'Good';
        if ($min > 0 && $qty <= $min) { $status = 'Critical'; }
        elseif ($min > 0 && $qty <= (int) ceil($min * 1.5)) { $status = 'Low Stock'; }
        return (object) array_merge((array) $it, [
            'status' => $status,
        ]);
    });
    $invCriticalCount = $inventory->where('status','Critical')->count();
    $invLowCount = $inventory->where('status','Low Stock')->count();

    // Store KPIs and data
    $today = \Carbon\Carbon::today();
    $openingTotal = (int) DB::table('tasks')->where('active', true)->where('type', 'opening')->count();
    $closingTotal = (int) DB::table('tasks')->where('active', true)->where('type', 'closing')->count();
    $openingCompleted = (int) DB::table('task_assignments')
        ->join('tasks','task_assignments.task_id','=','tasks.id')
        ->where('tasks.type','opening')
        ->where('task_assignments.status','completed')
        ->whereDate('task_assignments.updated_at', $today)
        ->count();
    $closingCompleted = (int) DB::table('task_assignments')
        ->join('tasks','task_assignments.task_id','=','tasks.id')
        ->where('tasks.type','closing')
        ->where('task_assignments.status','completed')
        ->whereDate('task_assignments.updated_at', $today)
        ->count();

    // Sales aggregates per shift (today)
    $openAgg = DB::table('manager_reports')
        ->whereDate('created_at', $today)
        ->where('shift', 'opening')
        ->selectRaw('COALESCE(SUM(cash),0) as cash, COALESCE(SUM(wallet),0) as wallet, COALESCE(SUM(bank),0) as bank')
        ->first();
    $closeAgg = DB::table('manager_reports')
        ->whereDate('created_at', $today)
        ->where('shift', 'closing')
        ->selectRaw('COALESCE(SUM(cash),0) as cash, COALESCE(SUM(wallet),0) as wallet, COALESCE(SUM(bank),0) as bank')
        ->first();
    $openingSales = (object) [
        'cash' => (float) ($openAgg->cash ?? 0),
        'wallet' => (float) ($openAgg->wallet ?? 0),
        'bank' => (float) ($openAgg->bank ?? 0),
    ];
    $openingSales->total = (float) ($openingSales->cash + $openingSales->wallet + $openingSales->bank);
    $closingSales = (object) [
        'cash' => (float) ($closeAgg->cash ?? 0),
        'wallet' => (float) ($closeAgg->wallet ?? 0),
        'bank' => (float) ($closeAgg->bank ?? 0),
    ];
    $closingSales->total = (float) ($closingSales->cash + $closingSales->wallet + $closingSales->bank);
    $dailyEarnings = (float) ($openingSales->total + $closingSales->total);
    $kitchenTasks = (int) DB::table('tasks')
        ->leftJoin('locations','tasks.location_id','=','locations.id')
        ->where('tasks.active', true)
        ->whereRaw("LOWER(COALESCE(locations.name, '')) LIKE ?", ['%kitchen%'])
        ->count();
    $coffeeBarTasks = (int) DB::table('tasks')
        ->leftJoin('locations','tasks.location_id','=','locations.id')
        ->where('tasks.active', true)
        ->whereRaw("LOWER(COALESCE(locations.name, '')) LIKE ?", ['%coffee%'])
        ->count();

    $locations = DB::table('locations')->orderBy('name')->get();
    $ownerTasks = DB::table('tasks')
        ->leftJoin('locations','tasks.location_id','=','locations.id')
        ->select('tasks.id','tasks.title','tasks.type','tasks.active','tasks.location_id','locations.name as location_name')
        ->orderBy('tasks.type')->orderBy('tasks.id')
        ->get();

    // Build task lists with completion info for today
    $openingTasks = DB::table('tasks')
        ->leftJoin('locations','tasks.location_id','=','locations.id')
        ->where('tasks.active', true)->where('tasks.type','opening')
        ->select('tasks.id','tasks.title','tasks.location_id','locations.name as location_name')
        ->orderBy('tasks.id')->get();
    $closingTasks = DB::table('tasks')
        ->leftJoin('locations','tasks.location_id','=','locations.id')
        ->where('tasks.active', true)->where('tasks.type','closing')
        ->select('tasks.id','tasks.title','tasks.location_id','locations.name as location_name')
        ->orderBy('tasks.id')->get();

    $openingIds = $openingTasks->pluck('id')->all();
    $closingIds = $closingTasks->pluck('id')->all();
    $todayCompletedRows = DB::table('task_assignments')
        ->whereIn('task_id', array_merge($openingIds, $closingIds))
        ->where('status','completed')
        ->whereDate('updated_at', $today)
        ->orderBy('task_id')->orderByDesc('updated_at')
        ->get();
    $latestByTask = [];
    foreach ($todayCompletedRows as $row) {
        if (!isset($latestByTask[$row->task_id])) {
            $latestByTask[$row->task_id] = $row; // first row per task_id is the latest due to order
        }
    }
    $openingList = [];
    foreach ($openingTasks as $t) {
        $meta = $latestByTask[$t->id] ?? null;
        $openingList[] = [
            'id' => $t->id,
            'title' => $t->title,
            'location' => $t->location_name,
            'completed' => (bool) $meta,
            'employee' => $meta?->employee_username,
            'time' => $meta?->updated_at,
        ];
    }
    $closingList = [];
    foreach ($closingTasks as $t) {
        $meta = $latestByTask[$t->id] ?? null;
        $closingList[] = [
            'id' => $t->id,
            'title' => $t->title,
            'location' => $t->location_name,
            'completed' => (bool) $meta,
            'employee' => $meta?->employee_username,
            'time' => $meta?->updated_at,
        ];
    }

    // Fetch latest APEPO report for sales view
    $latestApepo = DB::table('apepo_reports')
        ->orderBy('created_at', 'desc')
        ->first();

    return view('owner.index', [
        'reports' => $reports,
        'fundBalance' => $fundBalance,
        'expensesTotal' => $expensesTotal,
        'availableBalance' => $availableBalance,
        'expenses' => $expenses,
        'requests' => $requests,
        'apepo' => $apepo,
        'apepoManagers' => $apepoManagers,
        'inventory' => $inventory,
        'invCriticalCount' => $invCriticalCount,
        'invLowCount' => $invLowCount,
        'openingTotal' => $openingTotal,
        'closingTotal' => $closingTotal,
        'openingCompleted' => $openingCompleted,
        'closingCompleted' => $closingCompleted,
        'kitchenTasks' => $kitchenTasks,
        'coffeeBarTasks' => $coffeeBarTasks,
        'locations' => $locations,
        'ownerTasks' => $ownerTasks,
        'openingTaskList' => $openingList,
        'closingTaskList' => $closingList,
        'openingSales' => $openingSales,
        'closingSales' => $closingSales,
        'dailyEarnings' => $dailyEarnings,
        'latestApepo' => $latestApepo,
        // Audit / Payroll data
        'employeeCount' => $employeeCount,
        'payrollAllTimeTotal' => $payrollAllTimeTotal,
        'payrollWeekTotal' => $payrollWeekTotal,
        'payrollRecords' => $payrollRecords,
        // Employees data
        'employees' => $employees,
        'empTotal' => $empTotal,
        'empFull' => $empFull,
        'empPart' => $empPart,
    ]);
})->name('owner.home');

Route::post('/owner/requests/{id}/approve', function (Request $request, int $id) {
    if ($request->session()->get('role') !== 'owner') return redirect()->route('login');
    DB::table('requests')->where('id', $id)->update([
        'status' => 'approved',
        'updated_at' => now(),
    ]);
    return back()->with('status', 'Request approved');
})->name('owner.request.approve');

Route::post('/owner/requests/{id}/deny', function (Request $request, int $id) {
    if ($request->session()->get('role') !== 'owner') return redirect()->route('login');
    DB::table('requests')->where('id', $id)->update([
        'status' => 'rejected',
        'updated_at' => now(),
    ]);
    return back()->with('status', 'Request rejected');
})->name('owner.request.deny');

// Owner: Store management endpoints
Route::post('/owner/location', function (Request $request) {
    if ($request->session()->get('role') !== 'owner') return redirect()->route('login');
    $data = $request->validate([
        'name' => 'required|string|max:255',
    ]);
    $slug = Str::slug($data['name']);
    $base = $slug; $i = 1;
    while (DB::table('locations')->where('slug', $slug)->exists()) { $slug = $base.'-'.$i++; }
    DB::table('locations')->insert([
        'name' => $data['name'],
        'slug' => $slug,
        'qrcode_payload' => (string) Str::uuid(),
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    return $request->ajax() ? response()->json(['ok' => true]) : back()->with('status','Location added');
})->name('owner.location.create');

Route::post('/owner/location/{id}/delete', function (Request $request, int $id) {
    if ($request->session()->get('role') !== 'owner') return redirect()->route('login');
    DB::table('locations')->where('id', $id)->delete();
    DB::table('tasks')->where('location_id', $id)->update(['location_id' => null, 'updated_at' => now()]);
    return $request->ajax() ? response()->json(['ok' => true]) : back()->with('status','Location removed');
})->name('owner.location.delete');

Route::post('/owner/location/{id}/regen', function (Request $request, int $id) {
    if ($request->session()->get('role') !== 'owner') return redirect()->route('login');
    DB::table('locations')->where('id', $id)->update([
        'qrcode_payload' => (string) Str::uuid(),
        'updated_at' => now(),
    ]);
    return $request->ajax() ? response()->json(['ok' => true]) : back()->with('status','QR regenerated');
})->name('owner.location.regen');

Route::post('/owner/task/{id}/set-location', function (Request $request, int $id) {
    if ($request->session()->get('role') !== 'owner') return redirect()->route('login');
    $data = $request->validate([
        'location_id' => 'nullable|integer|exists:locations,id',
    ]);
    DB::table('tasks')->where('id', $id)->update([
        'location_id' => $data['location_id'] ?? null,
        'updated_at' => now(),
    ]);
    return $request->ajax() ? response()->json(['ok' => true]) : back()->with('status','Task updated');
})->name('owner.task.setLocation');

// Owner: Manage Tasks for Managers
Route::get('/owner/manage-tasks', function (Request $request) {
    if ($request->session()->get('role') !== 'owner') return redirect()->route('login');
    
    $managers = DB::table('users')->where('role', 'manager')->orderBy('username')->get();
    $recentTasks = DB::table('manager_tasks')
        ->leftJoin('users', 'manager_tasks.manager_id', '=', 'users.id')
        ->select('manager_tasks.*', 'users.username as manager_username')
        ->orderBy('manager_tasks.created_at', 'desc')
        ->limit(10)
        ->get();
    
    return view('owner.manage-tasks', [
        'managers' => $managers,
        'recentTasks' => $recentTasks->map(function($task) {
            $task->manager = (object)['username' => $task->manager_username ?? 'N/A'];
            return $task;
        }),
    ]);
})->name('owner.manageTasks');

Route::post('/owner/manage-tasks', function (Request $request) {
    if ($request->session()->get('role') !== 'owner') return redirect()->route('login');
    
    $data = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'priority' => 'required|in:low,medium,high',
    ]);
    
    DB::table('manager_tasks')->insert([
        'title' => $data['title'],
        'description' => $data['description'] ?? null,
        'manager_id' => null, // Not assigned to specific manager
        'priority' => $data['priority'],
        'due_date' => null, // No due date
        'status' => 'pending',
        'created_by' => $request->session()->get('username', 'owner'),
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    
    return back()->with('success', 'Task created successfully!');
})->name('owner.manageTasks.store');

Route::get('/manager/store-preview', function () {
    $openingTaskList = [
        ['id'=>1,'title'=>'Turn on espresso machine','location'=>'Coffee Bar','completed'=>true,'employee'=>'Emma Davis','time'=>now()->setTime(7,50)],
        ['id'=>2,'title'=>'Clean group heads and portafilters','location'=>'Coffee Bar','completed'=>true,'employee'=>'Emma Davis','time'=>now()->setTime(8,0)],
        ['id'=>3,'title'=>'Grind fresh coffee beans','location'=>'Coffee Bar','completed'=>true,'employee'=>'James Wilson','time'=>now()->setTime(8,10)],
        ['id'=>4,'title'=>'Check dishwashing area','location'=>'Kitchen','completed'=>false,'employee'=>'Mike Chen','time'=>now()->setTime(8,20)],
        ['id'=>5,'title'=>'Label and date open items','location'=>'Kitchen','completed'=>false,'employee'=>'Mike Chen','time'=>now()->setTime(8,25)],
    ];
    $closingTaskList = [
        ['id'=>6,'title'=>'Wipe counters and machines','location'=>'Coffee Bar','completed'=>false,'employee'=>'Emma Davis','time'=>now()->setTime(20,30)],
        ['id'=>7,'title'=>'Mop kitchen floor','location'=>'Kitchen','completed'=>false,'employee'=>'Mike Chen','time'=>now()->setTime(20,45)],
    ];
    $openingTotal = count($openingTaskList);
    $closingTotal = count($closingTaskList);
    $openingCompleted = collect($openingTaskList)->where('completed', true)->count();
    $closingCompleted = collect($closingTaskList)->where('completed', true)->count();
    $kitchenTasks = collect(array_merge($openingTaskList, $closingTaskList))->where(fn($t)=>stripos($t['location'],'kitchen')!==false)->count();
    $coffeeBarTasks = collect(array_merge($openingTaskList, $closingTaskList))->where(fn($t)=>stripos($t['location'],'coffee')!==false)->count();
    return view('manager.store_preview', compact(
        'openingTaskList','closingTaskList','openingTotal','closingTotal','openingCompleted','closingCompleted','kitchenTasks','coffeeBarTasks'
    ));
})->name('manager.store.preview');

Route::get('/manager', function (Request $request) {
    if ($request->session()->get('role') !== 'manager') {
        return redirect()->route('dashboard');
    }

    $manager = (string) $request->session()->get('username');
    $reports = DB::table('manager_reports')->orderByDesc('id')->limit(10)->get();
    // Per-manager totals
    $fundBalance = (float) (DB::table('manager_funds')->where('manager_username', $manager)->sum('amount') ?? 0);
    $expenses = DB::table('expenses')->where('manager_username', $manager)->orderByDesc('id')->limit(10)->get();
    $expensesTotal = (float) (DB::table('expenses')->where('manager_username', $manager)->sum('amount') ?? 0);
    $availableBalance = $fundBalance - $expensesTotal;
    $requests = DB::table('requests')->orderByDesc('id')->limit(10)->get();
    $tasks = Task::where('active', true)->orderBy('id')->get();
    $apepo = DB::table('apepo_reports')->where('manager_username', $manager)->orderByDesc('id')->limit(10)->get();
    $inventory = DB::table('inventory_items')->orderBy('category')->orderBy('name')->get();
    $employees = DB::table('employees')->orderBy('name')->get();

    return view('manager.index', [
        'reports' => $reports,
        'fundBalance' => $fundBalance,
        'expensesTotal' => $expensesTotal,
        'availableBalance' => $availableBalance,
        'expenses' => $expenses,
        'requests' => $requests,
        'tasks' => $tasks,
        'apepo' => $apepo,
        'inventory' => $inventory,
        'employees' => $employees,
    ]);
})->name('manager.home');

Route::post('/manager/employees', function (Request $request) {
    if ($request->session()->get('role') !== 'manager') return redirect()->route('login');
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'role' => 'nullable|string|max:255', // position/title
        'birthday' => 'nullable|date',
        'status' => 'nullable|in:full-time,part-time,fulltime,parttime',
        'email' => 'nullable|email|max:255',
        'contact' => 'nullable|string|max:255',
    ]);
    $employment = (string) ($data['status'] ?? 'full-time');
    $employment_type = (str_replace('-', '', strtolower($employment)) === 'parttime') ? 'parttime' : 'fulltime';

    $payload = [
        'name' => $data['name'],
        'role' => 'employee',
        'email' => $data['email'] ?? null,
        'employment_type' => $employment_type,
        'position' => $data['role'] ?? null,
        'birthday' => $data['birthday'] ?? null,
        'contact' => $data['contact'] ?? null,
        'created_at' => now(),
        'updated_at' => now(),
    ];
    // Only keep keys that exist on employees table
    $cols = \Schema::hasTable('employees') ? \Schema::getColumnListing('employees') : [];
    $payload = array_filter($payload, function($k) use ($cols){ return in_array($k, $cols, true); }, ARRAY_FILTER_USE_KEY);

    DB::table('employees')->insert($payload);
    return back()->with('status','Employee added');
})->name('manager.employees.store');

// Inventory: create item
Route::post('/manager/inventory/item', function (Request $request) {
    if ($request->session()->get('role') !== 'manager') return redirect()->route('login');
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'category' => 'nullable|string|max:255',
        'unit' => 'nullable|string|max:50',
        'quantity' => 'nullable|integer|min:0',
        'min_threshold' => 'nullable|integer|min:0',
        'notes' => 'nullable|string',
    ]);
    $now = now();
    $id = DB::table('inventory_items')->insertGetId([
        'name' => $data['name'],
        'category' => $data['category'] ?? null,
        'unit' => $data['unit'] ?? null,
        'quantity' => (int) ($data['quantity'] ?? 0),
        'min_threshold' => (int) ($data['min_threshold'] ?? 0),
        'notes' => $data['notes'] ?? null,
        'created_at' => $now,
        'updated_at' => $now,
    ]);
    if ($request->ajax()) {
        return response()->json(['ok' => true, 'item' => DB::table('inventory_items')->where('id', $id)->first()]);
    }
    return redirect()->route('manager.home')->with('status','Item added');
})->name('manager.inventory.item');

// Inventory: adjust quantity (non-negative enforcement)
Route::post('/manager/inventory/{id}/adjust', function (Request $request, int $id) {
    if ($request->session()->get('role') !== 'manager') return redirect()->route('login');
    $data = $request->validate([
        'delta' => 'required|integer',
        'reason' => 'nullable|string|max:255',
    ]);
    $item = DB::table('inventory_items')->where('id', $id)->first();
    if (!$item) return back()->withErrors(['inventory' => 'Item not found']);
    $newQty = (int) max(0, ((int)$item->quantity) + $data['delta']);
    DB::table('inventory_items')->where('id', $id)->update([
        'quantity' => $newQty,
        'updated_at' => now(),
    ]);
    DB::table('inventory_adjustments')->insert([
        'item_id' => $id,
        'manager_username' => (string) $request->session()->get('username'),
        'delta' => (int) $data['delta'],
        'reason' => $data['reason'] ?? null,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    if ($request->ajax()) {
        return response()->json(['ok' => true, 'quantity' => $newQty]);
    }
    return redirect()->route('manager.home')->with('status','Inventory updated');
})->name('manager.inventory.adjust');
// Manager APEPO create
Route::post('/manager/apepo', function (Request $request) {
    if ($request->session()->get('role') !== 'manager') return redirect()->route('login');
    $data = $request->validate([
        'audit' => 'nullable|string',
        'people' => 'nullable|string',
        'equipment' => 'nullable|string',
        'product' => 'nullable|string',
        'others' => 'nullable|string',
        'notes' => 'nullable|string',
    ]);
    $now = now();
    $manager = (string) $request->session()->get('username');
    $id = DB::table('apepo_reports')->insertGetId([
        'manager_username' => $manager,
        'audit' => $data['audit'] ?? '',
        'people' => $data['people'] ?? '',
        'equipment' => $data['equipment'] ?? '',
        'product' => $data['product'] ?? '',
        'others' => $data['others'] ?? '',
        'notes' => $data['notes'] ?? '',
        'created_at' => $now,
        'updated_at' => $now,
    ]);
    if ($request->ajax()) {
        return response()->json([
            'ok' => true,
            'apepo' => [
                'id' => $id,
                'manager_username' => $manager,
                'audit' => (string) ($data['audit'] ?? ''),
                'people' => (string) ($data['people'] ?? ''),
                'equipment' => (string) ($data['equipment'] ?? ''),
                'product' => (string) ($data['product'] ?? ''),
                'others' => (string) ($data['others'] ?? ''),
                'notes' => (string) ($data['notes'] ?? ''),
                'created_at' => (string) $now,
            ],
        ]);
    }
    return redirect()->route('manager.home')->with('status', 'APEPO submitted');
})->name('manager.apepo');

// Manager APEPO delete
Route::post('/manager/apepo/{id}/delete', function (Request $request, int $id) {
    if ($request->session()->get('role') !== 'manager') return redirect()->route('login');
    $manager = (string) $request->session()->get('username');
    $deleted = DB::table('apepo_reports')->where('id', $id)->where('manager_username', $manager)->delete();
    if ($request->ajax()) {
        return response()->json(['ok' => (bool) $deleted]);
    }
    return redirect()->route('manager.home')->with('status', 'APEPO removed');
})->name('manager.apepo.delete');

// Owner: Employees CRUD
Route::post('/owner/employee', function (Request $request) {
    if ($request->session()->get('role') !== 'owner') return redirect()->route('login');
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'role' => 'required|in:owner,manager,employee',
        'email' => 'nullable|email|max:255',
        'employment_type' => 'required|in:fulltime,parttime',
        // Optional profile fields
        'position' => 'nullable|string|max:255',
        'birthday' => 'nullable|date',
        'contact' => 'nullable|string|max:255',
        'join_date' => 'nullable|date',
    ]);
    $payload = [
        'name' => $data['name'],
        'role' => $data['role'],
        'email' => $data['email'] ?? null,
        'employment_type' => $data['employment_type'],
        'created_at' => now(),
        'updated_at' => now(),
    ];
    // Only include optional columns if they exist, to work before/after migration
    if (\Schema::hasColumn('employees','position')) { $payload['position'] = $data['position'] ?? null; }
    if (\Schema::hasColumn('employees','birthday')) { $payload['birthday'] = $data['birthday'] ?? null; }
    if (\Schema::hasColumn('employees','contact')) { $payload['contact'] = $data['contact'] ?? null; }
    if (\Schema::hasColumn('employees','join_date')) { $payload['join_date'] = $data['join_date'] ?? null; }

    DB::table('employees')->insert($payload);
    return $request->ajax() ? response()->json(['ok' => true]) : back()->with('status','Employee added');
})->name('owner.employee.create');

Route::post('/owner/employee/{id}/update', function (Request $request, int $id) {
    if ($request->session()->get('role') !== 'owner') return redirect()->route('login');
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'role' => 'sometimes|in:owner,manager,employee',
        'email' => 'nullable|email|max:255',
        'employment_type' => 'required|in:fulltime,parttime',
        // Optional profile fields
        'position' => 'nullable|string|max:255',
        'birthday' => 'nullable|date',
        'contact' => 'nullable|string|max:255',
        'join_date' => 'nullable|date',
    ]);
    $payload = [
        'name' => $data['name'],
        'email' => $data['email'] ?? null,
        'employment_type' => $data['employment_type'],
        'updated_at' => now(),
    ];
    // Only change role if provided
    if (array_key_exists('role', $data)) { $payload['role'] = $data['role']; }

    if (\Schema::hasColumn('employees','position')) { $payload['position'] = $data['position'] ?? null; }
    if (\Schema::hasColumn('employees','birthday')) { $payload['birthday'] = $data['birthday'] ?? null; }
    if (\Schema::hasColumn('employees','contact')) { $payload['contact'] = $data['contact'] ?? null; }
    if (\Schema::hasColumn('employees','join_date')) { $payload['join_date'] = $data['join_date'] ?? null; }

    DB::table('employees')->where('id',$id)->update($payload);
    return $request->ajax() ? response()->json(['ok' => true]) : back()->with('status','Employee updated');
})->name('owner.employee.update');

Route::post('/owner/employee/{id}/delete', function (Request $request, int $id) {
    if ($request->session()->get('role') !== 'owner') return redirect()->route('login');
    DB::table('employees')->where('id',$id)->delete();
    return $request->ajax() ? response()->json(['ok' => true]) : back()->with('status','Employee removed');
})->name('owner.employee.delete');

// Owner: Inventory bulk delete (owner only)
Route::post('/owner/inventory/bulk-delete', function (Request $request) {
    if ($request->session()->get('role') !== 'owner') return redirect()->route('login');
    $data = $request->validate([
        'ids' => 'required|array',
        'ids.*' => 'integer',
    ]);
    DB::table('inventory_items')->whereIn('id', $data['ids'])->delete();
    return $request->ajax() ? response()->json(['ok' => true]) : back()->with('status','Items deleted');
})->name('owner.inventory.bulkDelete');

// Manager totals JSON endpoint for live updates
Route::get('/manager/totals', function (Request $request) {
    if ($request->session()->get('role') !== 'manager') return response()->json(['error' => 'Unauthorized'], 401);
    $manager = (string) $request->session()->get('username');
    $fundBalance = (float) (DB::table('manager_funds')->where('manager_username', $manager)->sum('amount') ?? 0);
    $expensesTotal = (float) (DB::table('expenses')->where('manager_username', $manager)->sum('amount') ?? 0);
    $availableBalance = $fundBalance - $expensesTotal;
    return response()->json([
        'fundBalance' => $fundBalance,
        'expensesTotal' => $expensesTotal,
        'availableBalance' => $availableBalance,
    ]);
})->name('manager.totals');

Route::post('/manager/report', function (Request $request) {
    if ($request->session()->get('role') !== 'manager') return redirect()->route('login');
    $data = $request->validate([
        'shift' => 'required|in:opening,closing',
        'cash' => 'required|numeric',
        'wallet' => 'required|numeric',
        'bank' => 'required|numeric',
    ]);
    $now = now();
    $manager = (string) $request->session()->get('username');
    $id = DB::table('manager_reports')->insertGetId([
        'manager_username' => $manager,
        'shift' => $data['shift'],
        'cash' => $data['cash'],
        'wallet' => $data['wallet'],
        'bank' => $data['bank'],
        'submitted_at' => $now,
        'created_at' => $now,
        'updated_at' => $now,
    ]);
    if ($request->ajax()) {
        return response()->json([
            'ok' => true,
            'report' => [
                'id' => $id,
                'manager_username' => $manager,
                'shift' => (string) $data['shift'],
                'cash' => (float) $data['cash'],
                'wallet' => (float) $data['wallet'],
                'bank' => (float) $data['bank'],
                'created_at' => (string) $now,
            ],
        ]);
    }
    return redirect()->route('manager.home')->with('status', 'Report submitted');
})->name('manager.report');

Route::post('/manager/fund', function (Request $request) {
    if ($request->session()->get('role') !== 'manager') return redirect()->route('login');
    $data = $request->validate([
        'amount' => 'required|numeric',
    ]);
    DB::table('manager_funds')->insert([
        'manager_username' => (string) $request->session()->get('username'),
        'amount' => $data['amount'],
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    return redirect()->route('manager.home')->with('status', 'Fund updated');
})->name('manager.fund');

Route::post('/manager/expense', function (Request $request) {
    if ($request->session()->get('role') !== 'manager') return redirect()->route('login');
    $data = $request->validate([
        'amount' => 'required|numeric|min:0',
        'note' => 'required|string',
    ]);
    $now = now();
    $manager = (string) $request->session()->get('username');
    $id = DB::table('expenses')->insertGetId([
        'manager_username' => $manager,
        'amount' => $data['amount'],
        'note' => $data['note'],
        'created_at' => $now,
        'updated_at' => $now,
    ]);
    if ($request->ajax()) {
        return response()->json([
            'ok' => true,
            'expense' => [
                'id' => $id,
                'manager_username' => $manager,
                'amount' => (float) $data['amount'],
                'note' => $data['note'],
                'created_at' => (string) $now,
            ],
        ]);
    }
    return redirect()->route('manager.home')->with('status', 'Expense added');
})->name('manager.expense');

Route::post('/manager/request', function (Request $request) {
    if ($request->session()->get('role') !== 'manager') return redirect()->route('login');
    $data = $request->validate([
        'item' => 'required|string',
        'quantity' => 'required|integer|min:1',
        'priority' => 'required|in:low,medium,high',
    ]);
    DB::table('requests')->insert([
        'manager_username' => (string) $request->session()->get('username'),
        'item' => $data['item'],
        'quantity' => $data['quantity'],
        'priority' => $data['priority'],
        'status' => 'pending',
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    return redirect()->route('manager.home')->with('status', 'Request submitted');
})->name('manager.request');

Route::post('/manager/assign', function (Request $request) {
    if ($request->session()->get('role') !== 'manager') return redirect()->route('login');
    $data = $request->validate([
        'task_id' => 'required|exists:tasks,id',
        'employee_username' => 'required|string',
        'due_at' => 'nullable|date',
    ]);
    TaskAssignment::create([
        'task_id' => $data['task_id'],
        'employee_username' => $data['employee_username'],
        'manager_username' => (string) $request->session()->get('username'),
        'due_at' => $data['due_at'] ? \Carbon\Carbon::parse($data['due_at']) : now()->endOfDay(),
        'status' => 'pending',
    ]);
    return redirect()->route('manager.home')->with('status', 'Task assigned');
})->name('manager.assign');

// Delete manager-owned records
Route::post('/manager/report/{id}/delete', function (Request $request, int $id) {
    if ($request->session()->get('role') !== 'manager') return redirect()->route('login');
    $manager = (string) $request->session()->get('username');
    $deleted = DB::table('manager_reports')->where('id', $id)->where('manager_username', $manager)->delete();
    if ($request->ajax()) {
        return response()->json(['ok' => (bool) $deleted]);
    }
    return redirect()->route('manager.home')->with('status', 'Report removed');
})->name('manager.report.delete');

Route::post('/manager/expense/{id}/delete', function (Request $request, int $id) {
    if ($request->session()->get('role') !== 'manager') return redirect()->route('login');
    $manager = (string) $request->session()->get('username');
    $deleted = DB::table('expenses')->where('id', $id)->where('manager_username', $manager)->delete();
    if ($request->ajax()) {
        return response()->json(['ok' => (bool) $deleted]);
    }
    return redirect()->route('manager.home')->with('status', 'Expense removed');
})->name('manager.expense.delete');

Route::post('/manager/request/{id}/delete', function (Request $request, int $id) {
    if ($request->session()->get('role') !== 'manager') return redirect()->route('login');
    $manager = (string) $request->session()->get('username');
    $deleted = DB::table('requests')->where('id', $id)->where('manager_username', $manager)->delete();
    if ($request->ajax()) {
        return response()->json(['ok' => (bool) $deleted]);
    }
    return redirect()->route('manager.home')->with('status', 'Request removed');
})->name('manager.request.delete');

Route::get('/employee/tasks/{type}', function (Request $request, string $type) {
    if ($request->session()->get('role') !== 'employee') {
        return redirect()->route('dashboard');
    }
    abort_unless(in_array($type, ['opening','closing']), 404);

    $employee = (string) $request->session()->get('username');
    $completedIds = TaskAssignment::where('employee_username', $employee)
        ->where('status', 'completed')
        ->whereDate('created_at', now()->toDateString())
        ->pluck('task_id')
        ->all();

    $includeCompleted = (bool) $request->boolean('include_completed');

    $tasks = Task::with(['checklistItems', 'location'])
        ->where('type', $type)
        ->where('active', true)
        ->when(!$includeCompleted && !empty($completedIds), function($q) use ($completedIds){
            $q->whereNotIn('id', $completedIds);
        })
        ->orderBy('id')
        ->get();

    return view('employee.tasks', [
        'type' => $type,
        'tasks' => $tasks,
        'completedIds' => $completedIds,
        'includeCompleted' => $includeCompleted,
    ]);
});

Route::get('/scan', function (Request $request) {
    if (!$request->session()->has('role')) {
        return redirect()->route('login');
    }
    $taskId = (int) $request->query('task_id');
    $task = $taskId ? Task::find($taskId) : null;
    return view('scan', ['task' => $task]);
})->name('scan');

Route::post('/employee/proof', function (Request $request) {
    if ($request->session()->get('role') !== 'employee') {
        return redirect()->route('login');
    }
    $data = $request->validate([
        'task_id' => 'required|integer|exists:tasks,id',
        'qr_payload' => 'required|string',
        'photo_base64' => 'required|string',
    ]);

    if (!preg_match('/^data:image\/(png|jpeg);base64,/', $data['photo_base64'])) {
        return back()->withErrors(['photo' => 'Invalid image data']);
    }

    $image = base64_decode(preg_replace('/^data:image\/(png|jpeg);base64,/', '', $data['photo_base64']));
    $ext = str_contains($data['photo_base64'], 'image/png') ? 'png' : 'jpg';

    $path = 'proofs/'.date('Y/m/d').'/'.Str::uuid().'.'.$ext;
    Storage::disk('public')->put($path, $image);

    $employee = (string) $request->session()->get('username');
    $assignment = TaskAssignment::create([
        'task_id' => $data['task_id'],
        'employee_username' => $employee,
        'manager_username' => null,
        'due_at' => now(),
        'status' => 'completed',
    ]);

    TaskProof::create([
        'task_assignment_id' => $assignment->id,
        'photo_path' => $path,
        'qr_payload' => $data['qr_payload'],
        'captured_at' => now(),
    ]);

    $taskType = Task::find($data['task_id'])?->type ?? 'opening';
    // If this is an AJAX/JSON request, respond with JSON so the UI can fade out without reload
    if ($request->expectsJson() || $request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
        return response()->json([
            'ok' => true,
            'assignment_id' => $assignment->id,
            'photo_path' => asset('storage/'.$path),
            'task_type' => $taskType,
        ]);
    }
    return redirect(url('/employee/tasks/'.$taskType))->with('status', 'Proof submitted');
})->name('employee.proof');
