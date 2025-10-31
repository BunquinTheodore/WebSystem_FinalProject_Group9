<div style="background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:8px">
  <h3 class="section-title">Manager Fund</h3>
  <form id="mgr-fund-form" method="POST" action="{{ route('manager.fund') }}" style="margin-top:8px">
    @csrf
    <table style="width:100%;border-collapse:collapse">
      <tbody>
        <tr>
          <th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px;width:180px">Amount (₱)</th>
          <td style="border-bottom:1px solid #e3e3e0;padding:8px"><input name="amount" type="number" step="0.01" placeholder="Amount" style="width:100%"></td>
        </tr>
        <tr>
          <td colspan="2" style="padding:8px">
            <div style="display:flex;justify-content:flex-end;gap:8px">
              <button type="button" onclick="this.form.reset()" style="padding:8px 12px;border:1px solid #e3e3e0;border-radius:6px;background:#fff;color:#1b1b18">Clear</button>
              <button style="background:#0891b2;color:#fff;border-radius:6px;padding:8px 12px">Add / Adjust</button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </form>
</div>

<div style="background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:8px">
  <h3 class="section-title">Expenses</h3>
  <form id="mgr-expense-form" method="POST" action="{{ route('manager.expense') }}">
    @csrf
    <table style="width:100%;border-collapse:collapse">
      <tbody>
        <tr>
          <th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px;width:180px">Amount (₱)</th>
          <td style="border-bottom:1px solid #e3e3e0;padding:8px"><input name="amount" type="number" step="0.01" min="0" placeholder="0.00" style="width:100%"></td>
        </tr>
        <tr>
          <th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px;width:180px">Description</th>
          <td style="border-bottom:1px solid #e3e3e0;padding:8px"><input name="note" placeholder="Describe expense..." style="width:100%"></td>
        </tr>
        <tr>
          <td colspan="2" style="padding:8px">
            <div style="display:flex;justify-content:flex-end;gap:8px">
              <button type="button" onclick="this.form.reset()" style="padding:8px 12px;border:1px solid #e3e3e0;border-radius:6px;background:#fff;color:#1b1b18">Clear</button>
              <button style="background:#0891b2;color:#fff;border-radius:6px;padding:8px 12px">Add</button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </form>
  <div id="mgr-expense-list" style="margin-top:10px;display:grid;gap:10px">
    @forelse($expenses as $e)
      <div class="card" style="border-radius:8px;border:1px solid #e3e3e0;overflow:hidden">
        <table style="width:100%;border-collapse:collapse">
          <thead>
            <tr>
              <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Amount (₱)</th>
              <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Description</th>
              <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Date</th>
              <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px;width:1%">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td style="padding:8px">₱{{ number_format(($e->amount ?? 0), 2) }}</td>
              <td style="padding:8px">{{ $e->note }}</td>
              <td style="padding:8px;color:#706f6c">{{ \Carbon\Carbon::parse($e->created_at)->format('M d, Y H:i') }}</td>
              <td style="padding:8px">
                @if(session('username') === ($e->manager_username ?? null))
                  <form class="mgr-del-form" method="POST" action="{{ route('manager.expense.delete', ['id' => $e->id]) }}" style="margin:0">
                    @csrf
                    <button style="padding:4px 8px;background:#b91c1c;color:#fff;border-radius:6px" data-confirm="Remove this expense?">Delete</button>
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
      <div style="color:#706f6c">No expenses yet.</div>
    @endforelse
  </div>
</div>