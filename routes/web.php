<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Task;
use App\Models\TaskAssignment;
use App\Models\TaskProof;

Route::get('/', function (Request $request) {
    if ($request->session()->has('role')) {
        return redirect('/dashboard');
    }
    return view('auth.login');
});

Route::get('/login', function (Request $request) {
    if ($request->session()->has('role')) {
        return redirect('/dashboard');
    }
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {
    $request->validate([
        'username' => 'required|string',
        'password' => 'required|string',
    ]);

    $username = (string) $request->string('username');
    $password = (string) $request->string('password');

    $map = [
        'owner' => 'owner',
        'manager' => 'manager',
        'employee' => 'employee',
    ];

    $role = $map[$username] ?? null;

    $valid = (
        ($role === 'owner' && $username === 'owner' && $password === '1234') ||
        ($role === 'manager' && $username === 'manager' && $password === '1234') ||
        ($role === 'employee' && $username === 'employee' && $password === '1234')
    );

    if (!$valid) {
        return back()->withErrors(['auth' => 'Invalid credentials'])->withInput();
    }

    $request->session()->put('username', $username);
    $request->session()->put('role', $role);

    return redirect('/dashboard');
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
    $requests = DB::table('requests')->orderByDesc('id')->limit(50)->get();

    return view('owner.index', [
        'reports' => $reports,
        'fundBalance' => $fundBalance,
        'expenses' => $expenses,
        'requests' => $requests,
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

    $reports = DB::table('manager_reports')->orderByDesc('id')->limit(10)->get();
    $fundBalance = (float) (DB::table('manager_funds')->sum('amount') ?? 0);
    $expenses = DB::table('expenses')->orderByDesc('id')->limit(10)->get();
    $requests = DB::table('requests')->orderByDesc('id')->limit(10)->get();
    $tasks = Task::where('active', true)->orderBy('id')->get();

    return view('manager.index', [
        'reports' => $reports,
        'fundBalance' => $fundBalance,
        'expenses' => $expenses,
        'requests' => $requests,
        'tasks' => $tasks,
    ]);
})->name('manager.home');

Route::post('/manager/report', function (Request $request) {
    if ($request->session()->get('role') !== 'manager') return redirect()->route('login');
    $data = $request->validate([
        'shift' => 'required|in:opening,closing',
        'cash' => 'required|numeric',
        'wallet' => 'required|numeric',
        'bank' => 'required|numeric',
    ]);
    DB::table('manager_reports')->insert([
        'manager_username' => (string) $request->session()->get('username'),
        'shift' => $data['shift'],
        'cash' => $data['cash'],
        'wallet' => $data['wallet'],
        'bank' => $data['bank'],
        'submitted_at' => now(),
        'created_at' => now(),
        'updated_at' => now(),
    ]);
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
        'note' => 'required|string',
    ]);
    DB::table('expenses')->insert([
        'manager_username' => (string) $request->session()->get('username'),
        'note' => $data['note'],
        'created_at' => now(),
        'updated_at' => now(),
    ]);
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
