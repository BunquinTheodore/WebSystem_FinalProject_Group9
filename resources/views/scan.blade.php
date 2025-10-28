<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Scan</title>
  <style>html,body{background:#f6f6f6;color:#1b1b18;font-family:ui-sans-serif,system-ui;-webkit-font-smoothing:antialiased}</style>
</head>
<body>
  <div style="max-width:720px;margin:40px auto;background:#fff;padding:16px;border:1px solid #e3e3e0;border-radius:8px">
    <h1 style="margin:0 0 12px">Scan {{ $task?->title }}</h1>
    <p>This is the scan page. Plug in your existing html5-qrcode and capture UI here.</p>
    <form method="POST" action="{{ route('employee.proof') }}" style="display:grid;gap:8px">
      @csrf
      <input type="hidden" name="task_id" value="{{ $task?->id }}">
      <input type="text" name="qr_payload" placeholder="QR payload">
      <textarea name="photo_base64" placeholder="data:image/png;base64,..."></textarea>
      <button style="background:#0891b2;color:#fff;border-radius:6px;padding:8px">Submit Proof</button>
    </form>
  </div>
</body>
</html>
