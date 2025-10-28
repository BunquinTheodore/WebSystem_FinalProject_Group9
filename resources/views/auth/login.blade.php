<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Login</title>
  <style>
    html,body{background:#f6f6f6;color:#1b1b18;font-family:ui-sans-serif,system-ui;-webkit-font-smoothing:antialiased}
    .card{max-width:480px;margin:40px auto;background:#fff;padding:20px;border:1px solid #e3e3e0;border-radius:12px;box-shadow:0 6px 16px rgba(0,0,0,.04)}
    .tabs{display:flex;gap:8px;margin-bottom:16px;background:#f3f4f6;border-radius:12px;padding:4px}
    .tab{flex:1;text-align:center;min-height:50px;display:flex;align-items:center;justify-content:center;border-radius:12px;cursor:pointer;font-weight:700;color:#6b7280;border:2px solid transparent;transition:border-color .15s ease, box-shadow .15s ease, background-color .15s ease}
    .tab:hover{border-color:#d1d5db}
    .tab.active{background:#fff;color:#111827;box-shadow:0 1px 2px rgba(0,0,0,.06);border-color:#000}
    .tab:focus-visible,.tab:active{outline:none;border-color:#2563eb;box-shadow:0 0 0 3px rgba(37,99,235,.25)}
    .field{padding:12px;border:1px solid #e5e7eb;border-radius:12px}
    .btn{min-height:50px;width:100%;border-radius:12px;color:#fff;border:none;cursor:pointer;font-weight:700}
    .btn-primary{background:#2563eb}
    .btn-primary:hover{background:#1d4ed8}
    .btn-success{background:#16a34a}
    .btn-success:hover{background:#15803d}
    .muted{font-size:14px;color:#6b7280}
    .hidden{display:none}
    .logo{display:flex;justify-content:center;margin-bottom:12px}
    .logo img{max-width:260px;height:auto}
  </style>
</head>
<body>
  <div class="card">
    <div class="logo">
      <img src="{{ asset('images/bluemoon-logo.png') }}" alt="Bluemoon logo">
    </div>
    <div class="tabs">
      <button class="tab" id="tab-login" type="button">Login</button>
      <button class="tab" id="tab-register" type="button">Register</button>
    </div>

    @if($errors->any())
      <div style="color:#b91c1c;margin-bottom:8px">{{ $errors->first() }}</div>
    @endif

    <div id="panel-login">
      <form method="POST" action="{{ url('/login') }}" style="display:grid;gap:10px">
        @csrf
        <input class="field" name="username" type="text" placeholder="Owner | Manager | Employee" value="{{ old('username') }}">
        <input class="field" name="password" type="password" placeholder="1234">
        <button class="btn btn-primary">Log In</button>
      </form>
      <p class="muted" style="margin-top:10px">No account? <a href="{{ url('/login?tab=register') }}">Create one</a></p>
    </div>

    <div id="panel-register" class="hidden">
      <form method="POST" action="{{ url('/register') }}" style="display:grid;gap:10px">
        @csrf
        <input class="field" name="username" placeholder="Username" value="{{ old('username') }}">
        <input class="field" name="email" type="email" placeholder="Email" value="{{ old('email') }}">
        <select class="field" name="role">
          <option value="" disabled {{ old('role') ? '' : 'selected' }}>Select role</option>
          <option value="owner" {{ old('role')==='owner' ? 'selected' : '' }}>Owner</option>
          <option value="manager" {{ old('role')==='manager' ? 'selected' : '' }}>Manager</option>
          <option value="employee" {{ old('role')==='employee' ? 'selected' : '' }}>Employee</option>
        </select>
        <input class="field" name="password" type="password" placeholder="Create a password">
        <input class="field" name="password_confirmation" type="password" placeholder="Confirm password">
        <button class="btn btn-success">Sign Up</button>
      </form>
      <p class="muted" style="margin-top:10px">Already have an account? <a href="{{ url('/login?tab=login') }}">Sign in</a></p>
    </div>
  </div>

  <script>
    (function(){
      function q(k){return new URLSearchParams(window.location.search).get(k)}
      var current = (q('tab')||'login').toLowerCase();
      var tabLogin = document.getElementById('tab-login');
      var tabRegister = document.getElementById('tab-register');
      var pLogin = document.getElementById('panel-login');
      var pRegister = document.getElementById('panel-register');
      function setTab(name){
        var isLogin = name==='login';
        tabLogin.classList.toggle('active', isLogin);
        tabRegister.classList.toggle('active', !isLogin);
        pLogin.classList.toggle('hidden', !isLogin);
        pRegister.classList.toggle('hidden', isLogin);
        var url = new URL(window.location);
        url.searchParams.set('tab', name);
        window.history.replaceState({}, '', url);
      }
      tabLogin.addEventListener('click', function(){ setTab('login'); });
      tabRegister.addEventListener('click', function(){ setTab('register'); });
      setTab(current==='register' ? 'register' : 'login');
    })();
  </script>
</body>
</html>
