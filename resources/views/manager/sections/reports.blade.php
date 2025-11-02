 
 <div style="background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:12px">
  <div style="font-weight:700;color:#0f172a;margin-bottom:4px">Financial Report</div>
  <div style="font-size:12px;color:#6b7280;margin-bottom:12px">Opening and closing shift financial details</div>
  <form id="mgr-reports-unified" method="POST" action="{{ route('manager.reports.unified') }}" enctype="multipart/form-data">
    @csrf
    <div style="display:grid;gap:12px;grid-template-columns:1fr 1fr">
      <div style="border:1px solid #e3e3e0;border-radius:8px;padding:12px;background:#f0f9ff">
        <div style="font-weight:600;color:#0f172a;margin-bottom:8px">Opening Shift</div>
        <div style="display:grid;gap:8px">
          <input name="opening_cash" type="number" step="0.01" placeholder="Cash (₱)" style="width:97%;padding:8px;border:1px solid #e3e3e0;border-radius:6px" />
          <input name="opening_wallet" type="number" step="0.01" placeholder="Digital Wallet (₱)" style="width:97%;padding:8px;border:1px solid #e3e3e0;border-radius:6px" />
          <input name="opening_bank" type="number" step="0.01" placeholder="Bank Amount (₱)" style="width:97%;padding:8px;border:1px solid #e3e3e0;border-radius:6px" />
          <input name="opening_turnover_cash" type="number" step="0.01" placeholder="Turnover Cash (₱)" style="width:97%;padding:8px;border:1px solid #e3e3e0;border-radius:6px" />
          <input name="opening_turnover_wallet" type="number" step="0.01" placeholder="Turnover Digital Wallet (₱)" style="width:97%;padding:8px;border:1px solid #e3e3e0;border-radius:6px" />
          <input name="opening_turnover_bank" type="number" step="0.01" placeholder="Turnover Bank Amount (₱)" style="width:97%;padding:8px;border:1px solid #e3e3e0;border-radius:6px" />
          <input name="opening_image" type="file" accept="image/*" style="width:97%;padding:8px;border:1px solid #e3e3e0;border-radius:6px;background:#fff" />
        </div>
      </div>
      <div style="border:1px solid #e3e3e0;border-radius:8px;padding:12px;background:#fff7ed">
        <div style="font-weight:600;color:#0f172a;margin-bottom:8px">Closing Shift</div>
        <div style="display:grid;gap:8px">
          <input name="closing_cash" type="number" step="0.01" placeholder="Cash (₱)" style="width:97%;padding:8px;border:1px solid #e3e3e0;border-radius:6px" />
          <input name="closing_wallet" type="number" step="0.01" placeholder="Digital Wallet (₱)" style="width:97%;padding:8px;border:1px solid #e3e3e0;border-radius:6px" />
          <input name="closing_bank" type="number" step="0.01" placeholder="Bank Amount (₱)" style="width:97%;padding:8px;border:1px solid #e3e3e0;border-radius:6px" />
          <input name="closing_turnover_cash" type="number" step="0.01" placeholder="Turnover Cash (₱)" style="width:97%;padding:8px;border:1px solid #e3e3e0;border-radius:6px" />
          <input name="closing_turnover_wallet" type="number" step="0.01" placeholder="Turnover Digital Wallet (₱)" style="width:97%;padding:8px;border:1px solid #e3e3e0;border-radius:6px" />
          <input name="closing_turnover_bank" type="number" step="0.01" placeholder="Turnover Bank Amount (₱)" style="width:97%;padding:8px;border:1px solid #e3e3e0;border-radius:6px" />
          <input name="closing_image" type="file" accept="image/*" style="width:97%;padding:8px;border:1px solid #e3e3e0;border-radius:6px;background:#fff" />
        </div>
      </div>
    </div>
    
    

  <div id="mgr-report-list" style="margin-top:12px;display:grid;gap:10px">
    @forelse($reports as $r)
      <div class="card" style="border-radius:8px;border:1px solid #e3e3e0;overflow:hidden">
        <table style="width:100%;border-collapse:collapse">
          <thead>
            <tr>
              <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Type</th>
              <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Amounts</th>
              <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Submitted</th>
              <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px;width:1%">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td style="padding:8px">{{ strtoupper($r->shift ?? 'N/A') }}</td>
              <td style="padding:8px">₱{{ number_format(($r->cash ?? 0)+($r->wallet ?? 0)+($r->bank ?? 0),2) }}</td>
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
    @endforelse
  </div>
</div>

<div style="background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:12px;margin-top:12px">
  <div style="font-weight:700;color:#0f172a;margin-bottom:4px">APEPO Report</div>
  <div style="font-size:12px;color:#6b7280;margin-bottom:10px">Audit, People, Equipment, Product, Others</div>
  <div style="display:grid;gap:10px">
    <input name="audit" placeholder="A - Audit: findings and observations..." style="width:97%;padding:10px;border:1px solid #e3e3e0;border-radius:8px;background:#f3f4f6" />
    <input name="people" placeholder="P - People: employee/role notes..." style="width:97%;padding:10px;border:1px solid #e3e3e0;border-radius:8px;background:#f3f4f6" />
    <input name="equipment" placeholder="E - Equipment: status and maintenance..." style="width:97%;padding:10px;border:1px solid #e3e3e0;border-radius:8px;background:#f3f4f6" />
    <input name="product" placeholder="P - Product: quality and inventory notes..." style="width:97%;padding:10px;border:1px solid #e3e3e0;border-radius:8px;background:#f3f4f6" />
    <input name="others" placeholder="O - Others: additional observations..." style="width:97%;padding:10px;border:1px solid #e3e3e0;border-radius:8px;background:#f3f4f6" />
    <input name="notes" placeholder="Notes (optional)" style="width:97%;padding:10px;border:1px solid #e3e3e0;border-radius:8px" />
  </div>

  <div id="mgr-apepo-list" style="margin-top:12px;display:grid;gap:10px">
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
    @endforelse
  </div>
</div>

<div style="background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:12px;margin-top:12px">
  <div style="font-weight:700;color:#0f172a;margin-bottom:4px">Manager Fund</div>
  <div style="font-size:12px;color:#6b7280;margin-bottom:10px">Daily manager fund tracking</div>
  <div style="display:grid;gap:10px">
    <input name="fund_amount" type="number" step="0.01" placeholder="Amount (₱)" style="width:98%;padding:10px;border:1px solid #e3e3e0;border-radius:8px" />
    <div style="display:flex;gap:8px;align-items:center">
      <input name="fund_image" type="file" accept="image/*" style="flex:1;padding:8px;border:1px solid #e3e3e0;border-radius:8px;background:#fff" />
    </div>
  </div>
</div>

<div style="background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:12px;margin-top:12px">
  <div style="font-weight:700;color:#0f172a;margin-bottom:4px">Expenses</div>
  <div style="font-size:12px;color:#6b7280;margin-bottom:10px">Record daily expenses</div>
  <div style="display:grid;gap:10px">
    <input name="expense_amount" type="number" step="0.01" min="0" placeholder="Amount (₱)" style="width:98%;padding:10px;border:1px solid #e3e3e0;border-radius:8px" />
    <textarea name="expense_note" rows="4" placeholder="Expense details (no character limit)..." style="width:98%;padding:10px;border:1px solid #e3e3e0;border-radius:8px"></textarea>
  </div>
</div>

<div style="margin-top:12px">
  <button style="width:100%;background:#16a34a;color:#fff;border-radius:8px;padding:10px 14px">Submit All</button>
</div>

</form>
