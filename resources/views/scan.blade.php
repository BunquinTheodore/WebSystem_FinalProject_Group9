@extends('layouts.app')

@section('title', 'Scan')

@section('content')
  <div class="card" style="max-width:720px;margin:0 auto;padding:16px">
    <h1 class="section-title" style="margin:0 0 12px">Scan {{ $task?->title }}</h1>
    <p>This is the scan page. Plug in your existing html5-qrcode and capture UI here.</p>
    <form method="POST" action="{{ route('employee.proof') }}" style="display:grid;gap:8px">
      @csrf
      <input type="hidden" name="task_id" value="{{ $task?->id }}">
      <input type="text" name="qr_payload" placeholder="QR payload">
      <textarea name="photo_base64" placeholder="data:image/png;base64,..."></textarea>
      <button style="background:#0891b2;color:#fff;border-radius:6px;padding:8px">Submit Proof</button>
    </form>
  </div>
@endsection
