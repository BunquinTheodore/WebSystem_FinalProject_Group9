<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Login</title>
  <style>html,body{background:#f6f6f6;color:#1b1b18;font-family:ui-sans-serif,system-ui;-webkit-font-smoothing:antialiased}</style>
</head>
<body>
  <div style="max-width:400px;margin:40px auto;background:#fff;padding:20px;border:1px solid #e3e3e0;border-radius:8px">
    <h1 style="margin:0 0 12px;font-size:20px">Login</h1>
    @if($errors->any())<div style="color:#b91c1c;margin-bottom:8px">{{ $errors->first() }}</div>@endif
    <form method="POST" action="{{ url('/login') }}" style="display:grid;gap:8px">
      @csrf
      <input name="username" placeholder="owner | manager | employee" value="{{ old('username') }}" style="padding:8px;border:1px solid #e3e3e0;border-radius:6px">
      <input name="password" type="password" placeholder="1234" style="padding:8px;border:1px solid #e3e3e0;border-radius:6px">
      <button style="padding:10px;border-radius:6px;background:#0891b2;color:#fff">Sign in</button>
    </form>
  </div>
</body>
</html>
