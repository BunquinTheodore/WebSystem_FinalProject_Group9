    <div id="sales-overview" class="owner-section" data-section="sales" style="display:none;background:#fff;padding:24px;border-radius:12px;max-width:900px;margin:0 auto 40px auto">
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;padding-bottom:16px;border-bottom:2px solid #f0f0f0">
        <div style="display:flex;align-items:center;gap:12px">
          <button data-owner-back onclick="backToMain()" style="display:flex;align-items:center;justify-content:center;width:40px;height:40px;border-radius:50%;background:#f0f9ff;color:#0891b2;border:none;cursor:pointer;transition:all 0.2s ease" onmouseover="this.style.background='#0891b2'; this.style.color='#fff'; this.style.transform='scale(1.05)'" onmouseout="this.style.background='#f0f9ff'; this.style.color='#0891b2'; this.style.transform='scale(1)'">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
          </button>
          <div style="width:40px;height:40px;border-radius:50%;background:linear-gradient(135deg,#10b981,#059669);display:flex;align-items:center;justify-content:center;font-size:20px;color:#fff">💰</div>
          <div>
            <h2 style="margin:0;font-size:20px;font-weight:700;color:#0f172a">Sales & Reports</h2>
            <div style="font-size:13px;color:#6b7280">Financial and operational reports</div>
          </div>
        </div>
      </div>

      <div style="display:grid;gap:16px;grid-template-columns:repeat(2,1fr);margin-bottom:16px">
        <!-- Opening Shift Card -->
        <div style="background:linear-gradient(135deg,#ecfeff 0%,#cffafe 100%);border:2px solid #67e8f9;border-radius:14px;padding:20px;box-shadow:0 2px 8px rgba(6,182,212,0.15)">
          <div style="font-weight:700;font-size:16px;color:#0e7490;margin-bottom:4px">Opening Shift</div>
          <div style="font-size:13px;color:#155e75;margin-bottom:16px">Morning financial summary</div>
          <div style="display:grid;gap:10px">
            <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 12px;background:#fff;border-radius:8px;border:1px solid #e0f2fe">
              <span style="color:#475569;font-size:14px">Cash</span>
              <strong style="color:#0c4a6e;font-size:16px">₱{{ number_format(($openingSales->cash ?? 0), 0) }}</strong>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 12px;background:#fff;border-radius:8px;border:1px solid #e0f2fe">
              <span style="color:#475569;font-size:14px">Digital Wallet</span>
              <strong style="color:#0c4a6e;font-size:16px">₱{{ number_format(($openingSales->wallet ?? 0), 0) }}</strong>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 12px;background:#fff;border-radius:8px;border:1px solid #e0f2fe">
              <span style="color:#475569;font-size:14px">Bank Amount</span>
              <strong style="color:#0c4a6e;font-size:16px">₱{{ number_format(($openingSales->bank ?? 0), 0) }}</strong>
            </div>
            <div style="border-top:3px solid #06b6d4;margin:8px 0"></div>
            <div style="display:flex;justify-content:space-between;align-items:center;padding:4px 0">
              <span style="color:#0e7490;font-weight:600;font-size:15px">Total</span>
              <strong style="color:#0c4a6e;font-size:20px;font-weight:800">₱{{ number_format(($openingSales->total ?? 0), 0) }}</strong>
            </div>
          </div>
        </div>

        <!-- Closing Shift Card -->
        <div style="background:linear-gradient(135deg,#fff7ed 0%,#ffedd5 100%);border:2px solid #fdba74;border-radius:14px;padding:20px;box-shadow:0 2px 8px rgba(251,146,60,0.15)">
          <div style="font-weight:700;font-size:16px;color:#c2410c;margin-bottom:4px">Closing Shift</div>
          <div style="font-size:13px;color:#9a3412;margin-bottom:16px">Evening financial summary</div>
          <div style="display:grid;gap:10px">
            <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 12px;background:#fff;border-radius:8px;border:1px solid #fed7aa">
              <span style="color:#475569;font-size:14px">Cash</span>
              <strong style="color:#7c2d12;font-size:16px">₱{{ number_format(($closingSales->cash ?? 0), 0) }}</strong>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 12px;background:#fff;border-radius:8px;border:1px solid #fed7aa">
              <span style="color:#475569;font-size:14px">Digital Wallet</span>
              <strong style="color:#7c2d12;font-size:16px">₱{{ number_format(($closingSales->wallet ?? 0), 0) }}</strong>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 12px;background:#fff;border-radius:8px;border:1px solid #fed7aa">
              <span style="color:#475569;font-size:14px">Bank Amount</span>
              <strong style="color:#7c2d12;font-size:16px">₱{{ number_format(($closingSales->bank ?? 0), 0) }}</strong>
            </div>
            <div style="border-top:3px solid#fb923c;margin:8px 0"></div>
            <div style="display:flex;justify-content:space-between;align-items:center;padding:4px 0">
              <span style="color:#c2410c;font-weight:600;font-size:15px">Total</span>
              <strong style="color:#7c2d12;font-size:20px;font-weight:800">₱{{ number_format(($closingSales->total ?? 0), 0) }}</strong>
            </div>
          </div>
        </div>
      </div>

      <!-- Total Daily Earnings -->
      <div style="background:linear-gradient(135deg,#f0fdf4 0%,#dcfce7 100%);border:2px solid #86efac;border-radius:14px;padding:20px;display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;box-shadow:0 2px 8px rgba(34,197,94,0.15)">
        <div style="font-size:16px;font-weight:700;color:#047857">Total Daily Earnings</div>
        <div style="display:flex;align-items:center;gap:12px">
          <div style="font-size:32px;font-weight:900;color:#065f46">₱{{ number_format(($dailyEarnings ?? 0), 0) }}</div>
          <div style="width:48px;height:48px;border-radius:12px;background:linear-gradient(135deg,#10b981,#059669);display:flex;align-items:center;justify-content:center;font-size:24px;color:#fff;box-shadow:0 4px 12px rgba(16,185,129,0.3)">💰</div>
        </div>
      </div>

      <!-- Manager Fund & Expenses Summary -->
      <div style="display:grid;gap:16px;grid-template-columns:repeat(3,1fr);margin-bottom:20px">
        <div style="background:#ecfeff;border:2px solid #67e8f9;border-radius:14px;padding:16px">
          <div style="font-weight:700;color:#0e7490;margin-bottom:6px">Manager Fund Balance</div>
          <div style="font-size:22px;font-weight:800;color:#0c4a6e">₱{{ number_format(($fundBalance ?? 0), 2) }}</div>
        </div>
        <div style="background:#fff7ed;border:2px solid #fdba74;border-radius:14px;padding:16px">
          <div style="font-weight:700;color:#9a3412;margin-bottom:6px">Total Expenses</div>
          <div style="font-size:22px;font-weight:800;color:#7c2d12">₱{{ number_format(($expensesTotal ?? 0), 2) }}</div>
        </div>
        <div style="background:#f0f9ff;border:2px solid #bae6fd;border-radius:14px;padding:16px">
          <div style="font-weight:700;color:#075985;margin-bottom:6px">Available Balance</div>
          <div style="font-size:22px;font-weight:800;color:#0c4a6e">₱{{ number_format(($availableBalance ?? 0), 2) }}</div>
        </div>
      </div>

      <!-- Recent Expenses -->
      @if(isset($expenses) && count($expenses))
      <div style="background:#fff;border:2px solid #e5e7eb;border-radius:14px;padding:16px;box-shadow:0 2px 8px rgba(0,0,0,0.05);margin-bottom:20px">
        <div style="font-weight:700;color:#0f172a;margin-bottom:12px">Recent Expenses</div>
        <table style="width:100%;border-collapse:collapse">
          <thead>
            <tr>
              <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Amount</th>
              <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Note</th>
              <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Manager</th>
              <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Date</th>
            </tr>
          </thead>
          <tbody>
            @foreach($expenses as $ex)
              <tr>
                <td style="padding:8px">₱{{ number_format(($ex->amount ?? 0), 2) }}</td>
                <td style="padding:8px">{{ $ex->note ?? '' }}</td>
                <td style="padding:8px">{{ $ex->manager_username ?? '' }}</td>
                <td style="padding:8px;color:#706f6c">{{ \Carbon\Carbon::parse($ex->created_at)->format('M d, Y H:i') }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      @endif

      <!-- APEPO Report -->
      @if(isset($latestApepo) && $latestApepo)
      <div style="background:#fff;border:2px solid #e5e7eb;border-radius:14px;padding:24px;box-shadow:0 2px 8px rgba(0,0,0,0.05);margin-top:24px">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
          <div>
            <div style="font-size:18px;font-weight:700;color:#0f172a;margin-bottom:4px">APEPO Report</div>
            <div style="font-size:13px;color:#6b7280">Submitted by {{ $latestApepo->manager_username }} on {{ \Carbon\Carbon::parse($latestApepo->created_at)->format('m/d/Y') }}</div>
          </div>
          <div style="background:#0891b2;color:#fff;padding:6px 16px;border-radius:8px;font-size:13px;font-weight:600">Manager Report</div>
        </div>

        <div style="display:grid;gap:18px">
          @if($latestApepo->audit)
          <div style="border-left:4px solid #3b82f6;background:#eff6ff;padding:18px;border-radius:8px">
            <div style="font-weight:700;color:#1e40af;margin-bottom:6px">A - Audit</div>
            <div style="color:#475569;font-size:14px;line-height:1.6">{{ $latestApepo->audit }}</div>
          </div>
          @endif

          @if($latestApepo->people)
          <div style="border-left:4px solid #a855f7;background:#faf5ff;padding:18px;border-radius:8px">
            <div style="font-weight:700;color:#7e22ce;margin-bottom:6px">P - People (Employees and Roles)</div>
            <div style="color:#475569;font-size:14px;line-height:1.6">{{ $latestApepo->people }}</div>
          </div>
          @endif

          @if($latestApepo->equipment)
          <div style="border-left:4px solid #06b6d4;background:#ecfeff;padding:18px;border-radius:8px">
            <div style="font-weight:700;color:#0e7490;margin-bottom:6px">E - Equipment Check</div>
            <div style="color:#475569;font-size:14px;line-height:1.6">{{ $latestApepo->equipment }}</div>
          </div>
          @endif

          @if($latestApepo->product)
          <div style="border-left:4px solid #10b981;background:#f0fdf4;padding:18px;border-radius:8px">
            <div style="font-weight:700;color:#047857;margin-bottom:6px">P - Product</div>
            <div style="color:#475569;font-size:14px;line-height:1.6">{{ $latestApepo->product }}</div>
          </div>
          @endif

          @if($latestApepo->others)
          <div style="border-left:4px solid #f97316;background:#fff7ed;padding:18px;border-radius:8px">
            <div style="font-weight:700;color:#c2410c;margin-bottom:6px">O - Others</div>
            <div style="color:#475569;font-size:14px;line-height:1.6">{{ $latestApepo->others }}</div>
          </div>
          @endif
        </div>
      </div>
      @endif
    </div>

   