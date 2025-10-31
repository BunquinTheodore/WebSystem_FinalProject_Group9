<div style="background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:8px">
  <h3 class="section-title">Overview</h3>
  <div id="mgr-total-fund">Current balance: <strong>₱{{ number_format($fundBalance ?? 0, 2) }}</strong></div>
  <div id="mgr-total-exp">Total expenses: <strong>₱{{ number_format($expensesTotal ?? 0, 2) }}</strong></div>
  <div id="mgr-total-avail">Available balance: <strong>₱{{ number_format($availableBalance ?? 0, 2) }}</strong></div>
</div>

<div style="background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:8px">
  <h3 class="section-title">Daily Report</h3>
  <form id="mgr-report-form" method="POST" action="{{ route('manager.report') }}">
    @csrf
    <table style="width:100%;border-collapse:collapse">
      <tbody>
        <tr>
          <th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px;width:180px">Shift</th>
          <td style="border-bottom:1px solid #e3e3e0;padding:8px">
            <select name="shift" style="width:100%"><option value="opening">Opening</option><option value="closing">Closing</option></select>
          </td>
        </tr>
        <tr>
          <th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px">Cash (₱)</th>
          <td style="border-bottom:1px solid #e3e3e0;padding:8px"><input name="cash" type="number" step="0.01" placeholder="Cash" style="width:100%"></td>
        </tr>
        <tr>
          <th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px">Wallet (₱)</th>
          <td style="border-bottom:1px solid #e3e3e0;padding:8px"><input name="wallet" type="number" step="0.01" placeholder="Wallet" style="width:100%"></td>
        </tr>
        <tr>
          <th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px">Bank (₱)</th>
          <td style="border-bottom:1px solid #e3e3e0;padding:8px"><input name="bank" type="number" step="0.01" placeholder="Bank" style="width:100%"></td>
        </tr>
        <tr>
          <td colspan="2" style="padding:8px">
            <div style="display:flex;justify-content:flex-end;gap:8px">
              <button type="button" onclick="this.form.reset()" style="padding:8px 12px;border:1px solid #e3e3e0;border-radius:6px;background:#fff;color:#1b1b18">Clear</button>
              <button style="background:#0891b2;color:#fff;border-radius:6px;padding:8px 12px">Submit</button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </form>
  <div id="mgr-report-list" style="margin-top:10px;display:grid;gap:10px">
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
              <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px;width:1%">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td style="padding:8px">{{ strtoupper($r->shift) }}</td>
              <td style="padding:8px">₱{{ number_format($r->cash,2) }}</td>
              <td style="padding:8px">₱{{ number_format($r->wallet,2) }}</td>
              <td style="padding:8px">₱{{ number_format($r->bank,2) }}</td>
              <td style="padding:8px;color:#706f6c">{{ \Carbon\Carbon::parse($r->created_at)->format('M d, Y H:i') }}</td>
              <td style="padding:8px">
                @if(session('username') === ($r->manager_username ?? null))
                  <form class="mgr-del-form" method="POST" action="{{ route('manager.report.delete', ['id' => $r->id]) }}" style="margin:0">
                    @csrf
                    <button style="padding:4px 8px;background:#b91c1c;color:#fff;border-radius:6px" data-confirm="Remove this report?">Delete</button>
                  </form>
                @else
                  <span style="color:#706f6c">—</span>
                @endif
              </td>
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
  <h3 class="section-title">APEPO Report</h3>
  <form id="mgr-apepo-form" method="POST" action="{{ route('manager.apepo') }}">
    @csrf
    <table style="width:100%;border-collapse:collapse">
      <tbody>
        <tr><th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px;width:180px">Audit</th><td style="border-bottom:1px solid #e3e3e0;padding:8px"><textarea name="audit" rows="2" style="width:100%" placeholder="Audit notes..."></textarea></td></tr>
        <tr><th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px">People</th><td style="border-bottom:1px solid #e3e3e0;padding:8px"><textarea name="people" rows="2" style="width:100%" placeholder="People updates..."></textarea></td></tr>
        <tr><th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px">Equipment</th><td style="border-bottom:1px solid #e3e3e0;padding:8px"><textarea name="equipment" rows="2" style="width:100%" placeholder="Equipment status..."></textarea></td></tr>
        <tr><th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px">Product</th><td style="border-bottom:1px solid #e3e3e0;padding:8px"><textarea name="product" rows="2" style="width:100%" placeholder="Product quality/stock..."></textarea></td></tr>
        <tr><th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px">Others</th><td style="border-bottom:1px solid #e3e3e0;padding:8px"><textarea name="others" rows="2" style="width:100%" placeholder="Other notes..."></textarea></td></tr>
        <tr><th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px">Notes</th><td style="border-bottom:1px solid #e3e3e0;padding:8px"><input name="notes" style="width:100%" placeholder="Optional notes"></td></tr>
        <tr>
          <td colspan="2" style="padding:8px">
            <div style="display:flex;justify-content:flex-end;gap:8px">
              <button type="button" onclick="this.form.reset()" style="padding:8px 12px;border:1px solid #e3e3e0;border-radius:6px;background:#fff;color:#1b1b18">Clear</button>
              <button style="background:#0891b2;color:#fff;border-radius:6px;padding:8px 12px">Submit APEPO</button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </form>
  <div id="mgr-apepo-list" style="margin-top:10px;display:grid;gap:10px">
    @forelse($apepo as $p)
      <div class="card" style="border-radius:8px;border:1px solid #e3e3e0;overflow:hidden">
        <table style="width:100%;border-collapse:collapse">
          <thead>
            <tr>
              <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Section</th>
              <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Details</th>
              <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Submitted</th>
              <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px;width:1%">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td style="padding:8px">Audit</td>
              <td style="padding:8px">{{ $p->audit }}</td>
              <td style="padding:8px;color:#706f6c">{{ \Carbon\Carbon::parse($p->created_at)->format('M d, Y H:i') }}</td>
              <td style="padding:8px" rowspan="5">
                @if(session('username') === ($p->manager_username ?? null))
                  <form class="mgr-del-form" method="POST" action="{{ route('manager.apepo.delete', ['id' => $p->id]) }}" style="margin:0">
                    @csrf
                    <button style="padding:4px 8px;background:#b91c1c;color:#fff;border-radius:6px" data-confirm="Remove this APEPO report?">Delete</button>
                  </form>
                @else
                  <span style="color:#706f6c">—</span>
                @endif
              </td>
            </tr>
            <tr><td style="padding:8px">People</td><td style="padding:8px">{{ $p->people }}</td><td style="padding:8px;color:#706f6c"></td></tr>
            <tr><td style="padding:8px">Equipment</td><td style="padding:8px">{{ $p->equipment }}</td><td style="padding:8px;color:#706f6c"></td></tr>
            <tr><td style="padding:8px">Product</td><td style="padding:8px">{{ $p->product }}</td><td style="padding:8px;color:#706f6c"></td></tr>
            <tr><td style="padding:8px">Others</td><td style="padding:8px">{{ $p->others }}</td><td style="padding:8px;color:#706f6c"></td></tr>
            @if(!empty($p->notes))
              <tr><td style="padding:8px">Notes</td><td style="padding:8px" colspan="2">{{ $p->notes }}</td></tr>
            @endif
          </tbody>
        </table>
      </div>
    @empty
      <div style="color:#706f6c">No APEPO reports yet.</div>
    @endforelse
  </div>
</div>