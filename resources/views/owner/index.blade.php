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
        <div style="display:grid;gap:10px">
          @forelse($expenses as $e)
            <div class="card" style="border-radius:8px;border:1px solid #e3e3e0;overflow:hidden">
              <table style="width:100%;border-collapse:collapse">
                <thead>
                  <tr>
                    <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Amount (₱)</th>
                    <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Description</th>
                    <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Date</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td style="padding:8px">₱{{ number_format(($e->amount ?? 0), 2) }}</td>
                    <td style="padding:8px">{{ $e->note }}</td>
                    <td style="padding:8px;color:#706f6c">{{ \Carbon\Carbon::parse($e->created_at)->format('M d, Y H:i') }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          @empty
            <div style="color:#706f6c">No expenses yet.</div>
          @endforelse
        </div>
      </div>
    </div>

    <div style="background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:8px">
      <h3 class="section-title" style="margin:0 0 8px">Recent APEPO Reports</h3>
      <form method="GET" action="{{ route('owner.home') }}" style="margin:8px 0 12px;display:grid;gap:8px;grid-template-columns:1fr 1fr 1fr auto">
        <input name="manager" value="{{ request('manager') }}" placeholder="Manager username" style="padding:6px 8px;border:1px solid #e3e3e0;border-radius:6px" />
        <input name="from" type="date" value="{{ request('from') }}" style="padding:6px 8px;border:1px solid #e3e3e0;border-radius:6px" />
        <input name="to" type="date" value="{{ request('to') }}" style="padding:6px 8px;border:1px solid #e3e3e0;border-radius:6px" />
        <div style="display:flex;gap:8px;align-items:center">
          <button style="background:#0891b2;color:#fff;border-radius:6px;padding:8px 12px">Filter</button>
          <a href="{{ route('owner.home') }}" style="padding:8px 12px;border:1px solid #e3e3e0;border-radius:6px;background:#fff;color:#1b1b18;text-decoration:none">Clear</a>
        </div>
      </form>
      <div style="display:grid;gap:10px">
        @forelse($apepo as $p)
          <div class="card" style="border-radius:8px;border:1px solid #e3e3e0;overflow:hidden">
            <table style="width:100%;border-collapse:collapse">
              <thead>
                <tr>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Section</th>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Details</th>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Submitted</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="padding:8px">Audit</td>
                  <td style="padding:8px">{{ $p->audit }}</td>
                  <td style="padding:8px;color:#706f6c">{{ \Carbon\Carbon::parse($p->created_at)->format('M d, Y H:i') }}</td>
                </tr>
                <tr>
                  <td style="padding:8px">People</td>
                  <td style="padding:8px">{{ $p->people }}</td>
                  <td style="padding:8px;color:#706f6c"></td>
                </tr>
                <tr>
                  <td style="padding:8px">Equipment</td>
                  <td style="padding:8px">{{ $p->equipment }}</td>
                  <td style="padding:8px;color:#706f6c"></td>
                </tr>
                <tr>
                  <td style="padding:8px">Product</td>
                  <td style="padding:8px">{{ $p->product }}</td>
                  <td style="padding:8px;color:#706f6c"></td>
                </tr>
                <tr>
                  <td style="padding:8px">Others</td>
                  <td style="padding:8px">{{ $p->others }}</td>
                  <td style="padding:8px;color:#706f6c"></td>
                </tr>
                @if(!empty($p->notes))
                <tr>
                  <td style="padding:8px">Notes</td>
                  <td style="padding:8px" colspan="2">{{ $p->notes }}</td>
                </tr>
                @endif
              </tbody>
            </table>
          </div>
        @empty
          <div style="color:#706f6c">No APEPO reports yet.</div>
        @endforelse
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
              <td class="req-status" style="border-bottom:1px solid #f0f0ef;padding:8px">{{ ucfirst($q->status) }}</td>
              <td style="border-bottom:1px solid #f0f0ef;padding:8px">
                @if($q->status === 'pending')
                  <form class="owner-req-form" data-result="approved" method="POST" action="{{ route('owner.request.approve', ['id' => $q->id]) }}" style="display:inline">@csrf<button style="padding:6px 10px;background:#16a34a;color:#fff;border-radius:6px" data-confirm="Approve this request?">Approve</button></form>
                  <form class="owner-req-form" data-result="denied" method="POST" action="{{ route('owner.request.deny', ['id' => $q->id]) }}" style="display:inline;margin-left:6px">@csrf<button style="padding:6px 10px;background:#b91c1c;color:#fff;border-radius:6px" data-confirm="Deny this request?">Deny</button></form>
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
  <script>
    (function(){
      function closestRow(el){ while(el && el.tagName && el.tagName.toLowerCase() !== 'tr'){ el = el.parentElement; } return el; }
      document.addEventListener('submit', async function(ev){
        const form = ev.target.closest('form.owner-req-form');
        if(!form) return;
        ev.preventDefault();
        const btn = form.querySelector('button');
        const msg = (btn && btn.getAttribute('data-confirm')) || 'Are you sure?';
        let proceed = true;
        if(window.modalConfirm){
          try { proceed = await window.modalConfirm(msg, { title: 'Please confirm' }); } catch(_) { proceed = false; }
        } else {
          proceed = window.confirm(msg);
        }
        if(!proceed) return;
        try {
          const fd = new FormData(form);
          const res = await fetch(form.action, { method:'POST', body: fd, headers: { 'X-Requested-With':'XMLHttpRequest' } });
          if(!res.ok){ throw new Error('Request failed'); }
          const tr = closestRow(form);
          const statusCell = tr ? tr.querySelector('.req-status') : null;
          const actionsCell = tr ? tr.querySelector('td:last-child') : null;
          const result = (form.getAttribute('data-result') || '').toLowerCase();
          // Smoothly update status text
          if(statusCell){
            statusCell.style.transition = 'opacity 160ms ease';
            statusCell.style.opacity = '0';
            setTimeout(function(){
              statusCell.textContent = result ? (result.charAt(0).toUpperCase()+result.slice(1)) : 'Updated';
              statusCell.style.opacity = '1';
            }, 160);
          }
          // Fade out buttons, then replace with "No actions"
          if(actionsCell){
            actionsCell.style.transition = 'opacity 160ms ease';
            actionsCell.style.opacity = '0';
            setTimeout(function(){
              actionsCell.innerHTML = '<span style="color:#706f6c">No actions</span>';
              actionsCell.style.opacity = '1';
            }, 160);
          }
          // Row highlight feedback
          if(tr){
            tr.style.transition = 'background-color 320ms ease, box-shadow 320ms ease';
            tr.style.background = (result === 'approved') ? '#eaf7ee' : '#fdecea';
            tr.style.boxShadow = 'inset 0 0 0 1px ' + ((result === 'approved') ? '#a7e1b2' : '#f5b5b5');
            setTimeout(function(){ tr.style.background=''; tr.style.boxShadow=''; }, 900);
          }
          if(window.toast){ window.toast('Request '+(result||'updated')+'.','success'); }
        } catch(err){
          // Fallback: normal submission
          form.submit();
        }
      });
    })();
  </script>
@endsection
