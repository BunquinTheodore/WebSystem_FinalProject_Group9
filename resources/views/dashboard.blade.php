<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Dashboard</title>
  <style>html,body{background:#f6f6f6;color:#1b1b18;font-family:ui-sans-serif,system-ui;-webkit-font-smoothing:antialiased}</style>
</head>
<body>
  <div style="max-width:720px;margin:40px auto;background:#fff;padding:20px;border:1px solid #e3e3e0;border-radius:8px">
    <h1 style="margin:0 0 12px;font-size:20px">Dashboard</h1>
    <form method="POST" action="{{ route('logout') }}" style="margin-bottom:16px">@csrf<button>Logout</button></form>

    @php($role = session('role'))
    <div style="display:flex;gap:8px;flex-wrap:wrap">
      @if($role==='owner')
        <a href="{{ route('owner.home') }}">Owner</a>
      @endif
      @if($role==='manager')
        <a href="{{ route('manager.home') }}">Manager</a>
      @endif
      @if($role==='employee')
        <a href="{{ url('/employee/tasks/opening') }}">Opening Tasks</a>
        <a href="{{ url('/employee/tasks/closing') }}">Closing Tasks</a>
        <a href="{{ route('scan') }}">Scan</a>
      @endif
    </div>
  </div>
</body>
</html>
