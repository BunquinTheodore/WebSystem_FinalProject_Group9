    <div id="sales-overview" class="owner-section" data-section="sales" style="display:none;background:#f8fffe;border:1px solid #daf1ee;padding:16px;border-radius:8px">
      <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px">
        <button onclick="backToMain()" style="display:flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:50%;background:#f0f9ff;color:#0891b2;border:none;cursor:pointer;transition:all 0.2s ease" onmouseover="this.style.background='#0891b2'; this.style.color='#fff'; this.style.transform='scale(1.05)'" onmouseout="this.style.background='#f0f9ff'; this.style.color='#0891b2'; this.style.transform='scale(1)'">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M19 12H5M12 19l-7-7 7-7"/>
          </svg>
        </button>
        <div>
          <h2 class="section-title" style="margin:0;color:#0f172a">Sales & Reports</h2>
          <div style="font-size:12px;color:#6b7280">Financial and operational reports</div>
        </div>
      </div>

      <div style="display:grid;gap:12px;grid-template-columns:repeat(2,minmax(0,1fr));margin-top:8px">
        <div style="background:#effafc;border:1px solid #ccebf4;border-radius:12px;padding:14px">
          <div style="font-weight:600;color:#0f172a">Opening Shift</div>
          <div style="font-size:12px;color:#64748b;margin-bottom:8px">Morning financial summary</div>
          <div style="display:grid;gap:8px">
            <div style="display:flex;justify-content:space-between;border:1px solid #e9f4f8;background:#fff;border-radius:8px;padding:8px 10px"><span>Cash</span><strong>₱{{ number_format(($openingSales->cash ?? 0), 0) }}</strong></div>
            <div style="display:flex;justify-content:space-between;border:1px solid #e9f4f8;background:#fff;border-radius:8px;padding:8px 10px"><span>Digital Wallet</span><strong>₱{{ number_format(($openingSales->wallet ?? 0), 0) }}</strong></div>
            <div style="display:flex;justify-content:space-between;border:1px solid #e9f4f8;background:#fff;border-radius:8px;padding:8px 10px"><span>Bank Amount</span><strong>₱{{ number_format(($openingSales->bank ?? 0), 0) }}</strong></div>
            <div style="border-top:2px solid #c9e8f3;margin:2px 0"></div>
            <div style="display:flex;justify-content:space-between;color:#0f172a"><span>Total</span><strong>₱{{ number_format(($openingSales->total ?? 0), 0) }}</strong></div>
          </div>
        </div>
        <div style="background:#fff8ef;border:1px solid #fde9cc;border-radius:12px;padding:14px">
          <div style="font-weight:600;color:#7a3f00">Closing Shift</div>
          <div style="font-size:12px;color:#9a6700;margin-bottom:8px">Evening financial summary</div>
          <div style="display:grid;gap:8px">
            <div style="display:flex;justify-content:space-between;border:1px solid #feefd8;background:#fff;border-radius:8px;padding:8px 10px"><span>Cash</span><strong>₱{{ number_format(($closingSales->cash ?? 0), 0) }}</strong></div>
            <div style="display:flex;justify-content:space-between;border:1px solid #feefd8;background:#fff;border-radius:8px;padding:8px 10px"><span>Digital Wallet</span><strong>₱{{ number_format(($closingSales->wallet ?? 0), 0) }}</strong></div>
            <div style="display:flex;justify-content:space-between;border:1px solid #feefd8;background:#fff;border-radius:8px;padding:8px 10px"><span>Bank Amount</span><strong>₱{{ number_format(($closingSales->bank ?? 0), 0) }}</strong></div>
            <div style="border-top:2px solid #f6d5a7;margin:2px 0"></div>
            <div style="display:flex;justify-content:space-between;color:#7a3f00"><span>Total</span><strong>₱{{ number_format(($closingSales->total ?? 0), 0) }}</strong></div>
          </div>
        </div>
      </div>

      <div style="margin-top:12px;background:#f0fff8;border:1px solid #c8f1dd;border-radius:12px;padding:16px;display:flex;align-items:center;justify-content:space-between">
        <div style="font-size:14px;color:#047857">Total Daily Earnings</div>
        <div style="font-size:24px;font-weight:700;color:#047857">₱{{ number_format(($dailyEarnings ?? 0), 0) }}</div>
      </div>
    </div>

    <div id="reports" class="owner-section" data-section="sales" style="display:none;background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:8px">
      <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px">
        <button onclick="backToMain()" style="display:flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:50%;background:#f0f9ff;color:#0891b2;border:none;cursor:pointer;transition:all 0.2s ease" onmouseover="this.style.background='#0891b2'; this.style.color='#fff'; this.style.transform='scale(1.05)'" onmouseout="this.style.background='#f0f9ff'; this.style.color='#0891b2'; this.style.transform='scale(1)'">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M19 12H5M12 19l-7-7 7-7"/>
          </svg>
        </button>
        <h3 class="section-title" style="margin:0">Recent Reports</h3>
      </div>
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
