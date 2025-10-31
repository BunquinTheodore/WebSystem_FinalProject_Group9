<div style="background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:12px">
  <div style="font-weight:700;color:#0f172a;margin-bottom:4px">Payroll Entry</div>
  <div style="font-size:12px;color:#6b7280;margin-bottom:10px">Submit employee payroll information</div>
  <form id="mgr-payroll-form" method="POST" action="{{ url()->current() }}">
    @csrf
    <div style="display:grid;gap:10px">
      <div style="display:grid;gap:6px">
        <label style="font-size:12px;color:#0f172a">Employee Name</label>
        @if(!empty($employees ?? null) && count($employees) > 0)
          <select name="employee" style="width:100%;padding:10px;border:1px solid #e3e3e0;border-radius:8px">
            <option value="">Select employee</option>
            @foreach($employees as $emp)
              <option value="{{ $emp->username ?? $emp->id ?? $emp->name }}">{{ $emp->name ?? $emp->username ?? ('Employee #'.($emp->id ?? '')) }}</option>
            @endforeach
          </select>
        @else
          <input name="employee" placeholder="Type employee name or username" style="width:100%;padding:10px;border:1px solid #e3e3e0;border-radius:8px" />
        @endif
      </div>
      <div style="display:grid;gap:10px;grid-template-columns:1fr 1fr">
        <div style="display:grid;gap:6px">
          <label style="font-size:12px;color:#0f172a">Days Worked</label>
          <input name="days_worked" type="number" min="0" step="1" placeholder="e.g., 5" style="width:100%;padding:10px;border:1px solid #e3e3e0;border-radius:8px" />
        </div>
        <div style="display:grid;gap:6px">
          <label style="font-size:12px;color:#0f172a">Pay Rate (₱/day)</label>
          <input name="pay_rate" type="number" min="0" step="0.01" placeholder="e.g., 600.00" style="width:100%;padding:10px;border:1px solid #e3e3e0;border-radius:8px" />
        </div>
      </div>
      <div>
        <button style="width:100%;background:#d97706;color:#fff;border-radius:8px;padding:10px 14px">Submit Payroll Entry</button>
      </div>
    </div>
  </form>
</div>

@if(!empty($payrollEntries ?? null))
  <div style="background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:12px;margin-top:12px">
    <div style="font-weight:700;color:#0f172a;margin-bottom:4px">Recent Entries</div>
    <div style="overflow:auto">
      <table style="width:100%;border-collapse:collapse">
        <thead>
          <tr>
            <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Employee</th>
            <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Days</th>
            <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Rate (₱/day)</th>
            <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Submitted</th>
          </tr>
        </thead>
        <tbody>
          @foreach($payrollEntries as $p)
            <tr>
              <td style="padding:8px">{{ $p->employee_name ?? $p->employee ?? '-' }}</td>
              <td style="padding:8px">{{ $p->days_worked ?? '-' }}</td>
              <td style="padding:8px">₱{{ number_format(($p->pay_rate ?? 0),2) }}</td>
              <td style="padding:8px;color:#706f6c">{{ optional($p->created_at ?? null) ? \Carbon\Carbon::parse($p->created_at)->format('M d, Y H:i') : '-' }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endif
