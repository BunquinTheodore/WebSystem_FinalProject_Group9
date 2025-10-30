@extends('layouts.app')

@section('title', 'Owner')

@section('content')
  <div style="max-width:1000px;margin:0 auto;display:grid;gap:16px">

    <div style="background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:8px">
      <h2 class="section-title" style="margin:0 0 8px">Overview</h2>
      <div>Current Fund Balance: <strong>₱{{ number_format($fundBalance ?? 0, 2) }}</strong></div>
      <div>Total Expenses: <strong>₱{{ number_format($expensesTotal ?? 0, 2) }}</strong></div>
      <div>Available Balance: <strong>₱{{ number_format($availableBalance ?? 0, 2) }}</strong></div>
    </div>

  <div style="display:grid;gap:16px;grid-template-columns:2fr 1fr">
      <div style="background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:8px">
        <h3 class="section-title" style="margin:0 0 8px">Recent Reports</h3>
        <div style="display:grid;gap:10px">
          @forelse($reports as $r)
            <div class="card" style="border-radius:8px;border:1px solid #e3e3e0;overflow:hidden">
              <table style="width:100%;border-collapse:collapse">
                <thead>
                  <tr>
                    <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Shift</th>
                    <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Cash (₱)</th>
                    <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Wallet (₱)</th>
                    <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Bank (₱)</th>
                    <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Submitted</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td style="padding:8px">{{ strtoupper($r->shift) }}</td>
                    <td style="padding:8px">₱{{ number_format($r->cash,2) }}</td>
                    <td style="padding:8px">₱{{ number_format($r->wallet,2) }}</td>
                    <td style="padding:8px">₱{{ number_format($r->bank,2) }}</td>
                    <td style="padding:8px;color:#706f6c">{{ \Carbon\Carbon::parse($r->created_at)->format('M d, Y H:i') }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          @empty
            <div style="color:#706f6c">No reports yet.</div>
          @endforelse
        </div>
      </div>

      <div style="background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:8px">
        <h3 class="section-title" style="margin:0 0 8px">Recent Expenses</h3>
        <ul>
          @forelse($expenses as $e)
            <li>₱{{ number_format(($e->amount ?? 0), 2) }} — {{ $e->note }} <span style="color:#706f6c">{{ \Carbon\Carbon::parse($e->created_at)->format('M d, Y H:i') }}</span></li>
          @empty
            <li style="color:#706f6c">No expenses yet.</li>
          @endforelse
        </ul>
      </div>
    </div>

    <div style="background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:8px">
      <h3 class="section-title" style="margin:0 0 8px">Requests</h3>
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
  </div>
@endsection
