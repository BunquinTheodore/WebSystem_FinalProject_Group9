<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Tasks - {{ ucfirst($type) }}</title>
  <style>html,body{background:#f6f6f6;color:#1b1b18;font-family:ui-sans-serif,system-ui;-webkit-font-smoothing:antialiased}</style>
</head>
<body>
  <div style="max-width:880px;margin:40px auto;background:#fff;padding:16px;border:1px solid #e3e3e0;border-radius:8px">
    <h1 style="margin:0 0 12px">{{ ucfirst($type) }} Tasks</h1>
    @if(session('status'))<div style="margin-bottom:10px">{{ session('status') }}</div>@endif
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
</body>
</html>
