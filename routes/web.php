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
    if ($request->session()->has('role')) {
        return redirect('/dashboard');
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
    if ($request->session()->has('role')) {
        return redirect('/dashboard');
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
        return redirect('/dashboard');
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
        return redirect('/dashboard');
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
    $apepo = DB::table('apepo_reports')->orderByDesc('id')->limit(20)->get();

    return view('owner.index', [
        'reports' => $reports,
        'fundBalance' => $fundBalance,
        'expensesTotal' => $expensesTotal,
        'availableBalance' => $availableBalance,
        'expenses' => $expenses,
        'requests' => $requests,
        'apepo' => $apepo,
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
        'status' => 'denied',
        'updated_at' => now(),
    ]);
    return back()->with('status', 'Request denied');
})->name('owner.request.deny');

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

    return view('manager.index', [
        'reports' => $reports,
        'fundBalance' => $fundBalance,
        'expensesTotal' => $expensesTotal,
        'availableBalance' => $availableBalance,
        'expenses' => $expenses,
        'requests' => $requests,
        'tasks' => $tasks,
        'apepo' => $apepo,
    ]);
})->name('manager.home');
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

    $tasks = Task::with(['checklistItems', 'location'])
        ->where('type', $type)
        ->where('active', true)
        ->orderBy('id')
        ->get();

    return view('employee.tasks', [
        'type' => $type,
        'tasks' => $tasks,
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

    return redirect(url('/employee/tasks/'.$taskType))->with('status', 'Proof submitted');
})->name('employee.proof');
