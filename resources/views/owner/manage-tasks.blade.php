@extends('layouts.app')

@section('title', 'Manage Tasks')

@section('content')
<style>
  /* Override parent layout */
  body {
    background: linear-gradient(135deg, #e0f7fa 0%, #b2ebf2 100%) !important;
    min-height: 100vh;
    margin: 0;
    padding: 0;
  }
  .app-header {
    display: none !important;
  }
  .app-shell {
    max-width: none !important;
    margin: 0 !important;
    padding: 0 !important;
  }
  body::before {
    display: none !important;
  }
  
  /* Top navigation bar */
  .owner-topbar {
    background: #fff;
    padding: 12px 32px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
  }
  .owner-topbar-logo {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 18px;
    font-weight: 600;
    color: #0891b2;
    text-decoration: none;
  }
  .owner-topbar-right {
    display: flex;
    align-items: center;
    gap: 20px;
  }
  .owner-topbar-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f0f9ff;
    color: #0891b2;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
  }
  .owner-topbar-icon:hover {
    background: #0891b2;
    color: #fff;
    transform: scale(1.05);
  }
  .owner-topbar-user {
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    padding: 6px 12px;
    border-radius: 999px;
    transition: background 0.2s ease;
  }
  .owner-topbar-user:hover {
    background: #f0f9ff;
  }
  .owner-topbar-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #0891b2;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 14px;
  }
  .owner-topbar-info {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
  }
  .owner-topbar-name {
    font-weight: 600;
    color: #0f172a;
    font-size: 14px;
  }
  .owner-topbar-role {
    font-size: 12px;
    color: #64748b;
  }
  
  .task-form-card {
    background: #fff;
    border-radius: 16px;
    padding: 32px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
  }
  .form-group {
    margin-bottom: 20px;
  }
  .form-label {
    display: block;
    font-weight: 600;
    color: #0f172a;
    margin-bottom: 8px;
    font-size: 14px;
  }
  .form-control {
    width: 100%;
    padding: 10px 14px;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    font-size: 14px;
    transition: all 0.2s ease;
  }
  .form-control:focus {
    outline: none;
    border-color: #0891b2;
    box-shadow: 0 0 0 3px rgba(8, 145, 178, 0.1);
  }
  .btn-primary {
    background: #0891b2;
    color: #fff;
    padding: 12px 24px;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
  }
  .btn-primary:hover {
    background: #0e7490;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(8, 145, 178, 0.3);
  }
  .btn-secondary {
    background: #e5e7eb;
    color: #0f172a;
    padding: 12px 24px;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
    display: inline-block;
  }
  .btn-secondary:hover {
    background: #d1d5db;
  }
</style>

<!-- Top Navigation Bar -->
<div class="owner-topbar">
  <div class="owner-topbar-logo">
      <img src="{{ asset('images/bluemoon-logo.png') }}" alt="Bluemoon" style="height:48px;width:auto;object-fit:contain">
    </div>
  <div class="owner-topbar-right">
    <a href="#" class="owner-topbar-icon" title="Notifications">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
        <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
      </svg>
    </a>
    <a href="{{ url('/owner/manage-tasks') }}" class="owner-topbar-icon" title="Manage Tasks" style="background:#0891b2;color:#fff;">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
        <polyline points="14 2 14 8 20 8"/>
        <line x1="12" y1="18" x2="12" y2="12"/>
        <line x1="9" y1="15" x2="15" y2="15"/>
      </svg>
    </a>
    <div class="owner-topbar-user" onclick="document.getElementById('logout-form').submit();">
      <div class="owner-topbar-avatar">{{ strtoupper(substr(session('username', 'O'), 0, 1)) }}</div>
      <div class="owner-topbar-info">
        <div class="owner-topbar-name">{{ session('username', 'Owner') }}</div>
        <div class="owner-topbar-role">Owner</div>
      </div>
    </div>
    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display:none">@csrf</form>
  </div>
</div>

<div style="max-width:800px;margin:0 auto;padding:40px 20px">
  <div style="margin-bottom:32px;display:flex;align-items:center;gap:16px">
    <a href="{{ url('/owner/home') }}" style="display:flex;align-items:center;justify-content:center;width:40px;height:40px;border-radius:50%;background:#f0f9ff;color:#0891b2;text-decoration:none;transition:all 0.2s ease" onmouseover="this.style.background='#0891b2'; this.style.color='#fff'; this.style.transform='scale(1.05)'" onmouseout="this.style.background='#f0f9ff'; this.style.color='#0891b2'; this.style.transform='scale(1)'">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M19 12H5M12 19l-7-7 7-7"/>
      </svg>
    </a>
    <div>
      <h1 style="margin:0 0 8px;font-size:28px;color:#0f172a;font-weight:600">Manage Tasks</h1>
      <p style="color:#64748b;margin:0">Create tasks for managers</p>
    </div>
  </div>

  @if(session('success'))
    <div style="background:#d1fae5;border:1px solid #86efac;color:#065f46;padding:12px 16px;border-radius:8px;margin-bottom:20px">
      {{ session('success') }}
    </div>
  @endif

  @if($errors->any())
    <div style="background:#fee2e2;border:1px solid #fca5a5;color:#991b1b;padding:12px 16px;border-radius:8px;margin-bottom:20px">
      <ul style="margin:0;padding-left:20px">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="task-form-card">
    <form method="POST" action="{{ url('/owner/manage-tasks') }}">
      @csrf
      <div class="form-group">
        <label class="form-label">Task Title</label>
        <input type="text" name="title" class="form-control" placeholder="Enter task title" value="{{ old('title') }}" required>
      </div>

      <div class="form-group">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="4" placeholder="Enter task description">{{ old('description') }}</textarea>
      </div>

      <div class="form-group">
        <label class="form-label">Priority</label>
        <select name="priority" class="form-control">
          <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
          <option value="medium" {{ old('priority') == 'medium' ? 'selected' : 'selected' }}>Medium</option>
          <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
        </select>
      </div>

      <div style="display:flex;gap:12px">
        <button type="submit" class="btn-primary">Create Task</button>
        <a href="{{ url('/owner/home') }}" class="btn-secondary">Cancel</a>
      </div>
    </form>
  </div>

  <div style="margin-top:40px">
    <h2 style="font-size:20px;color:#0f172a;font-weight:600;margin-bottom:16px">Recent Tasks</h2>
    <div style="display:grid;gap:12px">
      @forelse($recentTasks as $task)
        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:16px">
          <div style="display:flex;justify-content:space-between;align-items:start;margin-bottom:8px">
            <h3 style="margin:0;font-size:16px;font-weight:600;color:#0f172a">{{ $task->title }}</h3>
            @php
              $priorityColor = $task->priority === 'high' ? '#dc2626' : ($task->priority === 'medium' ? '#f59e0b' : '#64748b');
            @endphp
            <span style="background:{{ $priorityColor }};color:#fff;padding:4px 10px;border-radius:999px;font-size:12px;font-weight:600">
              {{ strtoupper($task->priority) }}
            </span>
          </div>
          @if($task->description)
            <p style="color:#64748b;margin:0 0 12px;font-size:14px">{{ $task->description }}</p>
          @endif
          <div style="display:flex;gap:16px;font-size:13px;color:#64748b">
            <span>Status: <strong>{{ ucfirst($task->status ?? 'pending') }}</strong></span>
          </div>
        </div>
      @empty
        <div style="text-align:center;padding:40px;color:#64748b">
          No tasks created yet. Create your first task above!
        </div>
      @endforelse
    </div>
  </div>
</div>
@endsection
