<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Manager</title>
  <style>html,body{background:#f6f6f6;color:#1b1b18;font-family:ui-sans-serif,system-ui;-webkit-font-smoothing:antialiased}</style>
</head>
<body>
  <div style="max-width:880px;margin:40px auto;display:grid;gap:16px">
    @if(session('status'))<div style="background:#fff;border:1px solid #e3e3e0;padding:10px;border-radius:8px">{{ session('status') }}</div>@endif

    <div style="background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:8px">
      <h3>Daily Report</h3>
      <form method="POST" action="{{ route('manager.report') }}" style="display:grid;gap:8px;grid-template-columns:repeat(4,minmax(0,1fr))">
        @csrf
        <select name="shift"><option value="opening">Opening</option><option value="closing">Closing</option></select>
        <input name="cash" type="number" step="0.01" placeholder="Cash">
        <input name="wallet" type="number" step="0.01" placeholder="Wallet">
        <input name="bank" type="number" step="0.01" placeholder="Bank">
        <button style="grid-column:1/-1;background:#0891b2;color:#fff;border-radius:6px;padding:8px">Submit</button>
      </form>
      <ul style="margin-top:10px">
        @forelse($reports as $r)
          <li>{{ strtoupper($r->shift) }} • ₱{{ number_format($r->cash,2) }}/₱{{ number_format($r->wallet,2) }}/₱{{ number_format($r->bank,2) }} <span style="color:#706f6c">{{ \Carbon\Carbon::parse($r->created_at)->format('M d, Y H:i') }}</span></li>
        @empty
          <li style="color:#706f6c">No reports yet.</li>
        @endforelse
      </ul>
    </div>

    <div style="background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:8px">
      <h3>Manager Fund</h3>
      <div>Current balance: <strong>₱{{ number_format($fundBalance ?? 0, 2) }}</strong></div>
      <form method="POST" action="{{ route('manager.fund') }}" style="margin-top:8px;display:flex;gap:8px">
        @csrf
        <input name="amount" type="number" step="0.01" placeholder="Amount">
        <button style="background:#0891b2;color:#fff;border-radius:6px;padding:8px">Add / Adjust</button>
      </form>
    </div>

    <div style="background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:8px">
      <h3>Expenses</h3>
      <form method="POST" action="{{ route('manager.expense') }}" style="display:flex;gap:8px">
        @csrf
        <input name="note" placeholder="Describe expense..." style="flex:1">
        <button style="background:#0891b2;color:#fff;border-radius:6px;padding:8px">Add</button>
      </form>
      <ul style="margin-top:10px">
        @forelse($expenses as $e)
          <li>{{ $e->note }} <span style="color:#706f6c">{{ \Carbon\Carbon::parse($e->created_at)->format('M d, Y H:i') }}</span></li>
        @empty
          <li style="color:#706f6c">No expenses yet.</li>
        @endforelse
      </ul>
    </div>

    <div style="background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:8px">
      <h3>Requests</h3>
      <form method="POST" action="{{ route('manager.request') }}" style="display:grid;gap:8px;grid-template-columns:repeat(4,minmax(0,1fr))">
        @csrf
        <input name="item" placeholder="Item" style="grid-column:span 2">
        <input name="quantity" type="number" min="1" value="1">
        <select name="priority"><option>low</option><option selected>medium</option><option>high</option></select>
        <button style="grid-column:1/-1;background:#0891b2;color:#fff;border-radius:6px;padding:8px">Submit</button>
      </form>
      <ul style="margin-top:10px">
        @forelse($requests as $q)
          <li style="display:flex;justify-content:space-between">
            <span>{{ $q->item }} × {{ $q->quantity }} • {{ ucfirst($q->priority) }}</span>
            <span style="color:#706f6c">{{ ucfirst($q->status) }}</span>
          </li>
        @empty
          <li style="color:#706f6c">No requests yet.</li>
        @endforelse
      </ul>
    </div>

    <div style="background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:8px">
      <h3>Assign Task</h3>
      <form method="POST" action="{{ route('manager.assign') }}" style="display:grid;gap:8px;grid-template-columns:repeat(3,minmax(0,1fr))">
        @csrf
        <select name="task_id" style="grid-column:span 2">
          @foreach($tasks as $t)
            <option value="{{ $t->id }}">{{ $t->title }} ({{ $t->type }})</option>
          @endforeach
        </select>
        <input name="employee_username" placeholder="employee">
        <input name="due_at" type="datetime-local" style="grid-column:1/-1">
        <button style="grid-column:1/-1;background:#0891b2;color:#fff;border-radius:6px;padding:8px">Create Assignment</button>
      </form>
    </div>
  </div>
</body>
</html>
