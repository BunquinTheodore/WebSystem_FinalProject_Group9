@extends('layouts.app')

@section('title', 'Register')

@section('content')
  <div class="card" style="max-width:400px;margin:0 auto;padding:20px">
    <h1 style="margin:0 0 12px;font-size:20px">Create an account</h1>
    @if($errors->any())
      <div style="color:#b91c1c;margin-bottom:8px">{{ $errors->first() }}</div>
    @endif
    <form method="POST" action="{{ url('/register') }}" style="display:grid;gap:8px">
      @csrf
      <input name="name" placeholder="full name" value="{{ old('name') }}" style="padding:8px;border:1px solid #e3e3e0;border-radius:6px">
      <input name="username" placeholder="username" value="{{ old('username') }}" style="padding:8px;border:1px solid #e3e3e0;border-radius:6px">
      <input name="email" type="email" placeholder="email" value="{{ old('email') }}" style="padding:8px;border:1px solid #e3e3e0;border-radius:6px">
      <select name="role" style="padding:8px;border:1px solid #e3e3e0;border-radius:6px">
        <option value="" disabled {{ old('role') ? '' : 'selected' }}>select role</option>
        <option value="owner" {{ old('role')==='owner' ? 'selected' : '' }}>owner</option>
        <option value="manager" {{ old('role')==='manager' ? 'selected' : '' }}>manager</option>
        <option value="employee" {{ old('role')==='employee' ? 'selected' : '' }}>employee</option>
      </select>
      <input name="password" type="password" placeholder="password" style="padding:8px;border:1px solid #e3e3e0;border-radius:6px">
      <input name="password_confirmation" type="password" placeholder="confirm password" style="padding:8px;border:1px solid #e3e3e0;border-radius:6px">
      <button style="padding:10px;border-radius:6px;background:#16a34a;color:#fff">Sign up</button>
    </form>
    <p style="margin-top:12px;font-size:14px">Already have an account? <a href="{{ url('/login') }}">Sign in</a></p>
  </div>
@endsection