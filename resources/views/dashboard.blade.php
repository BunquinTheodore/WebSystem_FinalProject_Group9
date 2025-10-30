@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
  <div class="card" style="max-width:720px;margin:0 auto;padding:20px">
    <h1 class="section-title" style="margin:0 0 12px">Dashboard</h1>

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
@endsection
