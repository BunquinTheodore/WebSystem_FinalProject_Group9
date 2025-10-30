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
      <form id="apepo-filter-form" method="GET" action="{{ route('owner.home') }}" style="margin:8px 0 12px;display:grid;gap:8px;grid-template-columns:1.5fr 1fr 1fr auto">
        <div>
          <input id="mgr-input" list="apepo-managers" placeholder="Type manager name, then Add" style="padding:6px 8px;border:1px solid #e3e3e0;border-radius:6px;width:100%" />
          <div id="mgr-chips" style="display:flex;flex-wrap:wrap;gap:6px;margin-top:6px">
            @php
              $mgrParam = request()->query('manager');
              $mgrVals = is_array($mgrParam) ? $mgrParam : (strlen((string)$mgrParam) ? [(string)$mgrParam] : []);
            @endphp
            @foreach($mgrVals as $val)
              <span class="mgr-chip" data-value="{{ $val }}" style="display:inline-flex;align-items:center;gap:6px;background:#eef2ff;border:1px solid #dbe2ff;color:#1b1b18;padding:4px 8px;border-radius:999px">
                <span>{{ $val }}</span>
                <button type="button" class="chip-x" aria-label="Remove" style="background:transparent;border:none;color:#555;cursor:pointer">×</button>
              </span>
            @endforeach
          </div>
          <div id="mgr-hidden" aria-hidden="true" style="display:none">
            @foreach($mgrVals as $val)
              <input type="hidden" name="manager[]" value="{{ $val }}" />
            @endforeach
          </div>
        </div>
        <input name="from" type="date" value="{{ request('from') }}" style="padding:6px 8px;border:1px solid #e3e3e0;border-radius:6px" />
        <input name="to" type="date" value="{{ request('to') }}" style="padding:6px 8px;border:1px solid #e3e3e0;border-radius:6px" />
        <div style="display:flex;gap:8px;align-items:center">
          <button style="background:#0891b2;color:#fff;border-radius:6px;padding:8px 12px">Filter</button>
          <a href="{{ route('owner.home') }}" style="padding:8px 12px;border:1px solid #e3e3e0;border-radius:6px;background:#fff;color:#1b1b18;text-decoration:none">Clear</a>
        </div>
      </form>
      <datalist id="apepo-managers">
        @foreach(($apepoManagers ?? []) as $m)
          <option value="{{ $m }}"></option>
        @endforeach
      </datalist>
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
      <div style="margin-top:8px">
        {!! $apepo->appends(request()->query())->links() !!}
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
@push('scripts')
<script>
(function(){
  const form = document.getElementById('apepo-filter-form');
  const input = document.getElementById('mgr-input');
  const chips = document.getElementById('mgr-chips');
  const hidden = document.getElementById('mgr-hidden');
  function addManager(val){
    val = String(val||'').trim();
    if(!val) return;
    // Prevent duplicates (case-insensitive)
    const exists = Array.from(hidden.querySelectorAll('input[name="manager[]"]')).some(i => (i.value||'').toLowerCase() === val.toLowerCase());
    if(exists) { input.value=''; return; }
    const chip = document.createElement('span');
    chip.className = 'mgr-chip';
    chip.setAttribute('data-value', val);
    chip.style.display = 'inline-flex';
    chip.style.alignItems = 'center';
    chip.style.gap = '6px';
    chip.style.background = '#eef2ff';
    chip.style.border = '1px solid #dbe2ff';
    chip.style.color = '#1b1b18';
    chip.style.padding = '4px 8px';
    chip.style.borderRadius = '999px';
    const label = document.createElement('span');
    label.textContent = val;
    const x = document.createElement('button');
    x.type = 'button';
    x.className = 'chip-x';
    x.setAttribute('aria-label','Remove');
    x.style.background = 'transparent';
    x.style.border = 'none';
    x.style.color = '#555';
    x.style.cursor = 'pointer';
    x.textContent = '×';
    x.addEventListener('click', function(){
      const h = hidden.querySelector('input[name="manager[]"][value="'+CSS.escape(val)+'"]');
      if(h && h.parentElement) h.parentElement.removeChild(h);
      if(chip && chip.parentElement) chip.parentElement.removeChild(chip);
    });
    chip.appendChild(label);
    chip.appendChild(x);
    chips.appendChild(chip);
    const h = document.createElement('input');
    h.type = 'hidden';
    h.name = 'manager[]';
    h.value = val;
    hidden.appendChild(h);
    input.value = '';
  }
  if(form && input && chips && hidden){
    // Add with Enter key in input
    input.addEventListener('keydown', function(ev){
      if(ev.key === 'Enter') { ev.preventDefault(); addManager(input.value); }
    });
  }
})();
</script>
@endpush
