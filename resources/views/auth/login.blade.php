@extends('layouts.app')

@section('title', 'Login')
@section('hide-auth-button', '1')

@section('content')
  <style>
    /* Override parent layout styles */
    html, body {
      background: linear-gradient(135deg, #e0f7fa 0%, #b2ebf2 100%) !important;
      min-height: 100vh;
      margin: 0;
      padding: 0;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    }
    /* Hide header on auth pages */
    .app-header {
      display: none !important;
    }
    /* Override app-shell to center content */
    .app-shell {
      max-width: none !important;
      margin: 0 !important;
      padding: 0 !important;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    /* Hide decorative pattern on auth pages */
    body::before {
      display: none !important;
    }
    .auth-container {
      width: 100%;
      max-width: 420px;
      padding: 20px;
    }
    .logo-section {
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 30px;
    }
    .logo-section img {
      max-width: 280px;
      height: auto;
    }
    .card {
      background: white;
      border-radius: 16px;
      padding: 40px 35px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }
    /* Removed tabs (register moved to Owner dashboard) */
    .form-title {
      font-size: 16px;
      color: #333;
      margin-bottom: 20px;
      text-align: center;
      font-weight: 400;
    }
    .form-group {
      margin-bottom: 16px;
    }
    .form-label {
      display: block;
      font-size: 14px;
      color: #333;
      margin-bottom: 8px;
      font-weight: 500;
    }
    .form-control {
      width: 100%;
      padding: 12px 16px;
      border: none;
      background: #f5f5f5;
      border-radius: 8px;
      font-size: 14px;
      color: #333;
      box-sizing: border-box;
      transition: background 0.2s ease;
    }
    .form-control:focus {
      outline: none;
      background: #ebebeb;
    }
    .form-control::placeholder {
      color: #999;
    }
    .btn {
      width: 100%;
      padding: 14px;
      border: none;
      border-radius: 8px;
      font-size: 15px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-top: 10px;
    }
    .btn-primary {
      background: #17a2b8;
      color: white;
    }
    .btn-primary:hover {
      background: #138496;
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(23, 162, 184, 0.3);
    }
    .btn-success {
      background: #17a2b8;
      color: white;
    }
    .btn-success:hover {
      background: #138496;
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(23, 162, 184, 0.3);
    }
    .hidden {
      display: none;
    }
    .error-message {
      background: #fee;
      color: #c33;
      padding: 10px;
      border-radius: 8px;
      margin-bottom: 16px;
      font-size: 14px;
    }
  </style>
  <div class="auth-container">
    <div class="logo-section">
      <img src="{{ asset('images/bluemoon-logo.png') }}" alt="Bluemoon">
    </div>
    <div class="card">
      <div class="form-title">Login to your account</div>
      <form method="POST" action="{{ url('/login') }}">
        @csrf
        <div class="form-group">
          <label class="form-label">Email or Username</label>
          <input class="form-control" name="username" type="text" placeholder="Enter your email or username" value="{{ old('username') }}">
        </div>
        <div class="form-group">
          <label class="form-label">Password</label>
          <input class="form-control" name="password" type="password" placeholder="Enter your password">
        </div>
        <button class="btn btn-primary">Sign In</button>
      </form>
      <div style="margin-top:12px;color:#64748b;font-size:12px;text-align:center">
        Registration is managed by the Owner.
      </div>
    </div>
  </div>
  <script>
    // No tabs logic required; register is handled in the Owner dashboard.
  </script>
@endsection
