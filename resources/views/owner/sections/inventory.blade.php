    <div id="inventory" class="owner-section" data-section="inventory" style="display:none;background:#f9fafb;padding:32px;border-radius:12px;max-width:1000px;margin:0 auto 40px auto">
      <div style="display:flex;align-items:center;gap:12px;margin-bottom:24px">
  <button data-owner-back onclick="backToMain()" style="display:flex;align-items:center;justify-content:center;width:40px;height:40px;border-radius:50%;background:#f0f9ff;color:#0891b2;border:none;cursor:pointer;transition:all 0.2s ease" onmouseover="this.style.background='#0891b2'; this.style.color='#fff'; this.style.transform='scale(1.05)'" onmouseout="this.style.background='#f0f9ff'; this.style.color='#0891b2'; this.style.transform='scale(1)'">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M19 12H5M12 19l-7-7 7-7"/>
          </svg>
        </button>
        <div style="display:flex;flex-direction:column">
          <div style="font-weight:700;font-size:18px;color:#0f172a;line-height:1">Inventory</div>
          <div style="font-size:12px;color:#6b7280">Current stock levels</div>
        </div>
      </div>

      <!-- Alert Boxes -->
      <div style="display:grid;gap:16px;grid-template-columns:repeat(2,1fr);margin-bottom:24px">
        <div style="background:linear-gradient(135deg,#fef2f2 0%,#fee2e2 100%);border:2px solid #fca5a5;border-radius:14px;padding:20px;box-shadow:0 2px 8px rgba(220,38,38,0.1)">
          <div style="display:flex;align-items:center;gap:12px">
            <div style="width:48px;height:48px;background:#dc2626;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:24px;color:#fff">⚠️</div>
            <div>
              <div style="font-size:20px;font-weight:800;color:#991b1b;margin-bottom:4px">{{ (int)($invCriticalCount ?? 0) }} Critical Items</div>
              <div style="font-size:13px;color:#b91c1c;font-weight:600">Immediate restocking needed</div>
            </div>
          </div>
        </div>
        <div style="background:linear-gradient(135deg,#fffbeb 0%,#fef3c7 100%);border:2px solid #fcd34d;border-radius:14px;padding:20px;box-shadow:0 2px 8px rgba(245,158,11,0.1)">
          <div style="display:flex;align-items:center;gap:12px">
            <div style="width:48px;height:48px;background:#f59e0b;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:24px;color:#fff">⚠️</div>
            <div>
              <div style="font-size:20px;font-weight:800;color:#92400e;margin-bottom:4px">{{ (int)($invLowCount ?? 0) }} Low Stock Items</div>
              <div style="font-size:13px;color:#b45309;font-weight:600">Plan to restock soon</div>
            </div>
          </div>
        </div>
      </div>

      <!-- All Products Section -->
      <style>
        .inv-row{transition:background .2s ease}
        .inv-row.crit{background:#fef2f2}
        .inv-row.low{background:#fffbeb}
        .inv-row.good{background:#fff}
        .inv-row:hover{background:#f3f4f6}
        .inv-badge{display:inline-block;padding:6px 12px;border-radius:8px;color:#fff;font-size:13px;font-weight:600}
        .inv-badge.crit{background:#dc2626}
        .inv-badge.low{background:#f59e0b}
        .inv-badge.good{background:#16a34a}
      </style>
      <div style="background:#fff;border:2px solid #e5e7eb;border-radius:14px;padding:24px;box-shadow:0 2px 8px rgba(0,0,0,0.05)">
        <div style="margin-bottom:20px">
          <div style="font-size:18px;font-weight:700;color:#0f172a;margin-bottom:4px">All Products</div>
          <div style="font-size:13px;color:#6b7280">Complete inventory overview</div>
        </div>

        <div style="border:1px solid #e5e7eb;border-radius:12px;overflow:hidden">
          <table style="width:100%;border-collapse:collapse">
            <thead>
              <tr style="background:#f9fafb">
                <th style="text-align:left;border-bottom:2px solid #e5e7eb;padding:14px 16px;font-weight:600;color:#374151;font-size:13px">Product Name</th>
                <th style="text-align:left;border-bottom:2px solid #e5e7eb;padding:14px 16px;font-weight:600;color:#374151;font-size:13px">Unit</th>
                <th style="text-align:left;border-bottom:2px solid #e5e7eb;padding:14px 16px;font-weight:600;color:#374151;font-size:13px">Sealed</th>
                <th style="text-align:left;border-bottom:2px solid #e5e7eb;padding:14px 16px;font-weight:600;color:#374151;font-size:13px">Loose</th>
                <th style="text-align:left;border-bottom:2px solid #e5e7eb;padding:14px 16px;font-weight:600;color:#374151;font-size:13px">Delivered</th>
                <th style="text-align:left;border-bottom:2px solid #e5e7eb;padding:14px 16px;font-weight:600;color:#374151;font-size:13px">Status</th>
                <th style="text-align:left;border-bottom:2px solid #e5e7eb;padding:14px 16px;font-weight:600;color:#374151;font-size:13px">Last Updated</th>
              </tr>
            </thead>
            <tbody>
              @forelse(($inventory ?? []) as $it)
                @php
                  $isCritical = $it->status === 'Critical';
                  $isLowStock = $it->status === 'Low Stock';
                  $badgeText = $isCritical ? 'Critical' : ($isLowStock ? 'Low Stock' : 'Good');
                  $rowClass = $isCritical ? 'crit' : ($isLowStock ? 'low' : 'good');
                  $badgeClass = $rowClass;
                @endphp
                <tr class="inv-row {{ $rowClass }}">
                  <td style="padding:14px 16px;border-bottom:1px solid #e5e7eb">
                    <div style="display:flex;align-items:center;gap:8px">
                      @if($isCritical || $isLowStock)
                        <span style="color:#f59e0b;font-size:16px">⚠️</span>
                      @endif
                      <span style="font-weight:600;color:#0f172a;font-size:14px">{{ $it->name }}</span>
                    </div>
                  </td>
                  <td style="padding:14px 16px;border-bottom:1px solid #e5e7eb;color:#374151;font-size:14px">{{ $it->unit }}</td>
                  <td style="padding:14px 16px;border-bottom:1px solid #e5e7eb;color:#374151;font-size:14px">{{ (int)($it->sealed ?? 0) }}</td>
                  <td style="padding:14px 16px;border-bottom:1px solid #e5e7eb;color:#374151;font-size:14px">{{ (int)($it->loose ?? 0) }}</td>
                  <td style="padding:14px 16px;border-bottom:1px solid #e5e7eb;color:#374151;font-size:14px">{{ (int)($it->delivered_total ?? 0) }}</td>
                  <td style="padding:14px 16px;border-bottom:1px solid #e5e7eb">
                    <span class="inv-badge {{ $badgeClass }}">{{ $badgeText }}</span>
                  </td>
                  <td style="padding:14px 16px;border-bottom:1px solid #e5e7eb;color:#6b7280;font-size:14px">{{ \Carbon\Carbon::parse($it->updated_at ?? now())->format('M d') }}</td>
                </tr>
              @empty
                <tr><td colspan="7" style="padding:20px;color:#6b7280;text-align:center">No inventory items yet.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
