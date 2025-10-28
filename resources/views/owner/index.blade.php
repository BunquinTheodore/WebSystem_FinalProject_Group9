<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Owner</title>
  <style>html,body{background:#f6f6f6;color:#1b1b18;font-family:ui-sans-serif,system-ui;-webkit-font-smoothing:antialiased} a{color:#0891b2}</style>
</head>
<body>
  <div style="max-width:1000px;margin:40px auto;display:grid;gap:16px">
    @if(session('status'))<div style="background:#fff;border:1px solid #e3e3e0;padding:10px;border-radius:8px">{{ session('status') }}</div>@endif

    <div style="background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:8px">
      <h2 style="margin:0 0 8px">Overview</h2>
      <div>Current Fund Balance: <strong>₱{{ number_format($fundBalance ?? 0, 2) }}</strong></div>
    </div>

    <div style="display:grid;gap:16px;grid-template-columns:repeat(2,minmax(0,1fr))">
      <div style="background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:8px">
        <h3 style="margin:0 0 8px">Recent Reports</h3>
        <ul>
          @forelse($reports as $r)
            <li>{{ strtoupper($r->shift) }} • ₱{{ number_format($r->cash,2) }}/₱{{ number_format($r->wallet,2) }}/₱{{ number_format($r->bank,2) }} <span style="color:#706f6c">{{ \Carbon\Carbon::parse($r->created_at)->format('M d, Y H:i') }}</span></li>
          @empty
            <li style="color:#706f6c">No reports yet.</li>
          @endforelse
        </ul>
      </div>

      <div style="background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:8px">
        <h3 style="margin:0 0 8px">Recent Expenses</h3>
        <ul>
          @forelse($expenses as $e)
            <li>{{ $e->note }} <span style="color:#706f6c">{{ \Carbon\Carbon::parse($e->created_at)->format('M d, Y H:i') }}</span></li>
          @empty
            <li style="color:#706f6c">No expenses yet.</li>
          @endforelse
        </ul>
      </div>
    </div>

    <div style="background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:8px">
      <h3 style="margin:0 0 8px">Requests</h3>
      <table style="width:100%;border-collapse:collapse">
        <thead>
          <tr>
            <th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px">Item</th>
            <th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px">Qty</th>
            <th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px">Priority</th>
            <th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px">Status</th>
            <th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($requests as $q)
            <tr>
              <td style="border-bottom:1px solid #f0f0ef;padding:8px">{{ $q->item }}</td>
              <td style="border-bottom:1px solid #f0f0ef;padding:8px">{{ $q->quantity }}</td>
              <td style="border-bottom:1px solid #f0f0ef;padding:8px">{{ ucfirst($q->priority) }}</td>
              <td style="border-bottom:1px solid #f0f0ef;padding:8px">{{ ucfirst($q->status) }}</td>
              <td style="border-bottom:1px solid #f0f0ef;padding:8px">
                @if($q->status === 'pending')
                  <form method="POST" action="{{ route('owner.request.approve', ['id' => $q->id]) }}" style="display:inline">@csrf<button style="padding:6px 10px;background:#16a34a;color:#fff;border-radius:6px">Approve</button></form>
                  <form method="POST" action="{{ route('owner.request.deny', ['id' => $q->id]) }}" style="display:inline;margin-left:6px">@csrf<button style="padding:6px 10px;background:#b91c1c;color:#fff;border-radius:6px">Deny</button></form>
                @else
                  <span style="color:#706f6c">No actions</span>
                @endif
              </td>
            </tr>
          @empty
            <tr><td colspan="5" style="color:#706f6c;padding:8px">No requests yet.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div><a href="{{ route('dashboard') }}">Back to Dashboard</a></div>
  </div>
</body>
</html>
