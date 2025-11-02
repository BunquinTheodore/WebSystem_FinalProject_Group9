    <div id="apepo" class="owner-section" data-section="apepo" style="display:none;background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:8px">
      <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px">
  <button data-owner-back onclick="backToMain()" style="display:flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:50%;background:#f0f9ff;color:#0891b2;border:none;cursor:pointer;transition:all 0.2s ease" onmouseover="this.style.background='#0891b2'; this.style.color='#fff'; this.style.transform='scale(1.05)'" onmouseout="this.style.background='#f0f9ff'; this.style.color='#0891b2'; this.style.transform='scale(1)'">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M19 12H5M12 19l-7-7 7-7"/>
          </svg>
        </button>
        <div>
          <h3 class="section-title" style="margin:0;color:#0f172a">Audit / Payroll</h3>
          <div style="font-size:12px;color:#6b7280">Employee payments and audit trail</div>
        </div>
      </div>

      <div style="display:grid;gap:12px;grid-template-columns:repeat(3,minmax(0,1fr));margin-bottom:12px">
        <div style="background:#f0fff8;border:1px solid #c8f1dd;border-radius:12px;padding:14px;display:flex;align-items:center;justify-content:space-between">
          <div>
            <div style="font-size:12px;color:#047857;margin-bottom:4px">Current Week Total</div>
            <div style="font-size:26px;font-weight:800;color:#047857">₱{{ number_format(($payrollWeekTotal ?? 0), 0) }}</div>
          </div>
          <div aria-hidden="true" style="width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;background:#ecfdf5;color:#047857;border:1px solid #bbf7d0">💵</div>
        </div>
        <div style="background:#fff8ef;border:1px solid #fde9cc;border-radius:12px;padding:14px;display:flex;align-items:center;justify-content:space-between">
          <div>
            <div style="font-size:12px;color:#a04900;margin-bottom:4px">All-Time Total</div>
            <div style="font-size:26px;font-weight:800;color:#b91c1c">₱{{ number_format(($payrollAllTimeTotal ?? 0), 0) }}</div>
          </div>
          <div aria-hidden="true" style="width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;background:#fff7ed;color:#b45309;border:1px solid #fed7aa">🧾</div>
        </div>
        <div style="background:#eef2ff;border:1px solid #dbe2ff;border-radius:12px;padding:14px;display:flex;align-items:center;justify-content:space-between">
          <div>
            <div style="font-size:12px;color:#4338ca;margin-bottom:4px">Total Employees</div>
            <div style="font-size:26px;font-weight:800;color:#4338ca">{{ (int)($empTotal ?? 0) }}</div>
          </div>
          <div aria-hidden="true" style="width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;background:#eff6ff;color:#4338ca;border:1px solid #bfdbfe">👥</div>
        </div>
      </div>

      <div class="card" style="border-radius:12px;border:1px solid #e3e3e0;padding:14px">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px">
          <div>
            <div style="font-weight:700;color:#0f172a">Payroll Records</div>
            <div style="font-size:12px;color:#6b7280">Complete payment history for all employees</div>
          </div>
        </div>
        <div style="overflow:auto">
          <table style="width:100%;border-collapse:separate;border-spacing:0;min-width:860px">
            <thead>
              <tr>
                <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Employee Name</th>
                <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Status</th>
                <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Days Worked</th>
                <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Pay Rate</th>
                <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Total Pay</th>
                <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Period</th>
              </tr>
            </thead>
            <tbody>
              @forelse(($payrollRecords ?? []) as $row)
                @php
                  $name = $row->employee_name ?? ($row['employee_name'] ?? ($row->name ?? ($row['name'] ?? '—')));
                  $etype = $row->employment_type ?? ($row['employment_type'] ?? ($row->status ?? ($row['status'] ?? '—')));
                  $days = $row->days_worked ?? ($row['days_worked'] ?? ($row->days ?? ($row['days'] ?? 0)));
                  $rate = $row->pay_rate ?? ($row['pay_rate'] ?? ($row->rate ?? ($row['rate'] ?? 0)));
                  $total = $row->total_pay ?? ($row['total_pay'] ?? ($row->total ?? ($row['total'] ?? ($days * $rate))));
                  $from = $row->period_from ?? ($row['period_from'] ?? null);
                  $to = $row->period_to ?? ($row['period_to'] ?? null);
                  $period = ($from && $to) ? (\Carbon\Carbon::parse($from)->format('M d') . '–' . \Carbon\Carbon::parse($to)->format('d, Y')) : ($row->period ?? ($row['period'] ?? '—'));
                  $isPart = strtolower((string)$etype) === 'parttime' || strtolower((string)$etype) === 'part-time' || strtolower((string)$etype) === 'part time';
                  $badgeClr = $isPart ? ['#06b6d4','#ecfeff','#a5f3fc'] : ['#2563eb','#eef2ff','#bfdbfe'];
                @endphp
                <tr>
                  <td style="padding:8px;border-bottom:1px solid #f6f6f5">{{ $name }}</td>
                  <td style="padding:8px;border-bottom:1px solid #f6f6f5"><span style="display:inline-block;padding:4px 8px;border-radius:999px;color:{{ $badgeClr[0] }};background:{{ $badgeClr[1] }};border:1px solid {{ $badgeClr[2] }};font-size:12px">{{ $isPart ? 'Part-time' : 'Full-time' }}</span></td>
                  <td style="padding:8px;border-bottom:1px solid #f6f6f5">{{ (int)$days }}</td>
                  <td style="padding:8px;border-bottom:1px solid #f6f6f5">₱{{ number_format((float)$rate, 0) }}</td>
                  <td style="padding:8px;border-bottom:1px solid #f6f6f5;color:#047857">₱{{ number_format((float)$total, 0) }}</td>
                  <td style="padding:8px;border-bottom:1px solid #f6f6f5">{{ $period }}</td>
                </tr>
              @empty
                <tr><td colspan="6" style="padding:10px;color:#706f6c">No payroll records yet.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

      <div style="margin-top:16px;height:1px;background:#eef2f7"></div>

      <div style="display:flex;align-items:center;gap:12px;margin:16px 0 8px">
        <div style="font-weight:700;color:#0f172a">Recent APEPO Reports</div>
      </div>
      <div style="display:grid;gap:10px">
        @forelse(($apepo ?? []) as $p)
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
        {!! ($apepo ?? collect())->appends(request()->query())->links() !!}
      </div>
    </div>
