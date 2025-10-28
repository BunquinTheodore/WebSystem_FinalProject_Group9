<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Task;
use App\Models\TaskAssignment;
use App\Models\TaskProof;

Route::get('/', function (Request $request) {
    if ($request->session()->has('role')) {
        return redirect('/dashboard');
    }
    return view('welcome', ['view' => 'login']);
});

Route::get('/login', function (Request $request) {
    if ($request->session()->has('role')) {
        return redirect('/dashboard');
    }
    return view('welcome', ['view' => 'login']);
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

    return view('welcome', ['view' => 'dashboard']);
})->name('dashboard');

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

    return view('welcome', [
        'view' => 'employee_tasks',
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
    return view('welcome', ['view' => 'scan', 'task' => $task]);
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
