@extends('layouts.app')

@section('title', 'Tasks - '.ucfirst($type))

@section('content')
  <div class="card" style="max-width:880px;margin:0 auto;padding:16px">
    <h1 class="section-title" style="margin:0 0 12px">{{ ucfirst($type) }} Tasks</h1>
    <ul style="display:grid;gap:10px">
      @foreach($tasks as $task)
        <li style="border:1px solid #e3e3e0;border-radius:8px;padding:12px">
          <div style="font-weight:600">{{ $task->title }}</div>
          <div style="color:#706f6c">{{ $task->location?->name }}</div>
          <ul style="margin-top:6px;color:#1b1b18">
            @foreach($task->checklistItems as $item)
              <li>- {{ $item->label }}</li>
            @endforeach
          </ul>
          <div style="margin-top:8px;display:flex;gap:8px">
            <a href="{{ route('scan', ['task_id' => $task->id]) }}">Scan</a>
          </div>
        </li>
      @endforeach
    </ul>
  </div>
@endsection
