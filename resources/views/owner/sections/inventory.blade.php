    <div id="inventory" class="owner-section" data-section="inventory" style="display:none;background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:8px">
      <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px">
        <button onclick="backToMain()" style="display:flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:50%;background:#f0f9ff;color:#0891b2;border:none;cursor:pointer;transition:all 0.2s ease" onmouseover="this.style.background='#0891b2'; this.style.color='#fff'; this.style.transform='scale(1.05)'" onmouseout="this.style.background='#f0f9ff'; this.style.color='#0891b2'; this.style.transform='scale(1)'">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M19 12H5M12 19l-7-7 7-7"/>
          </svg>
        </button>
        <div>
          <h3 class="section-title" style="margin:0;color:#0f172a">Inventory</h3>
          <div style="font-size:12px;color:#6b7280">Current stock levels</div>
        </div>
      </div>

      <div style="display:grid;gap:10px;grid-template-columns:repeat(2,minmax(0,1fr));margin:8px 0 12px">
        <div style="display:flex;align-items:center;gap:10px;background:#fff6f6;border:1px solid #f7c6c6;color:#991b1b;border-radius:10px;padding:10px">
          <div style="font-size:18px">⚠️</div>
          <div>
            <div style="font-weight:600">{{ (int)($invCriticalCount ?? 0) }} Critical Items</div>
            <div style="font-size:12px;color:#b42318">Immediate restocking needed</div>
          </div>
        </div>
        <div style="display:flex;align-items:center;gap:10px;background:#fff7ed;border:1px solid #fde7c7;color:#a04900;border-radius:10px;padding:10px">
          <div style="font-size:18px">⚠️</div>
          <div>
            <div style="font-weight:600">{{ (int)($invLowCount ?? 0) }} Low Stock Items</div>
            <div style="font-size:12px;color:#9a6700">Plan to restock soon</div>
          </div>
        </div>
      </div>

      <div id="inventory-filters" style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:10px">
        <button class="pill inv-pill is-active" data-filter="all" style="padding:6px 12px;border-radius:999px;border:1px solid #e5e7eb;background:#111827;color:#fff">All Products</button>
        <button class="pill inv-pill" data-filter="kitchen" style="padding:6px 12px;border-radius:999px;border:1px solid #e5e7eb;background:#fff">Kitchen Section</button>
        <button class="pill inv-pill" data-filter="coffee" style="padding:6px 12px;border-radius:999px;border:1px solid #e5e7eb;background:#fff">Coffee Bar Section</button>
      </div>

      <form id="inv-bulk-form" method="POST" action="{{ route('owner.inventory.bulkDelete') }}" style="margin:0">
        @csrf
        <div style="border:1px solid #e3e3e0;border-radius:12px;overflow:hidden">
          <table id="inv-table" style="width:100%;border-collapse:collapse">
            <thead>
              <tr style="background:#f8fafc">
                @if(session('role') === 'owner')
                  <th style="padding:8px;border-bottom:1px solid #f0f0ef;width:1%"><input id="inv-check-all" type="checkbox" /></th>
                @endif
                <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Product Name</th>
                <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Unit</th>
                <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Sealed</th>
                <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Loose</th>
                <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Delivered</th>
                <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Date Delivered</th>
                <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Status</th>
                <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Last Updated</th>
                <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Total Delivered</th>
                <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Owner Date Delivered</th>
              </tr>
            </thead>
            <tbody>
              @forelse(($inventory ?? []) as $it)
                @php
                  $cat = strtolower((string)($it->category ?? ''));
                  $rowBg = $it->status === 'Critical' ? '#fff1f2' : ($it->status === 'Low Stock' ? '#fff7ed' : '#fff');
                  $badgeBg = $it->status === 'Critical' ? '#dc2626' : ($it->status === 'Low Stock' ? '#f59e0b' : '#16a34a');
                @endphp
                <tr class="inv-row" data-cat="{{ $cat }}" style="background:{{ $rowBg }}">
                  @if(session('role') === 'owner')
                    <td style="padding:8px;border-bottom:1px solid #f6f6f5"><input class="inv-check" type="checkbox" name="ids[]" value="{{ $it->id }}" /></td>
                  @endif
                  <td style="padding:8px;border-bottom:1px solid #f6f6f5">{{ $it->name }}</td>
                  <td style="padding:8px;border-bottom:1px solid #f6f6f5">{{ $it->unit }}</td>
                  <td style="padding:8px;border-bottom:1px solid #f6f6f5">{{ (int)($it->sealed ?? 0) }}</td>
                  <td style="padding:8px;border-bottom:1px solid #f6f6f5">{{ (int)($it->loose ?? 0) }}</td>
                  <td style="padding:8px;border-bottom:1px solid #f6f6f5"><input type="number" placeholder="Qty" style="width:80px;padding:4px 6px;border:1px solid #e5e7eb;border-radius:6px" /></td>
                  <td style="padding:8px;border-bottom:1px solid #f6f6f5"><input type="date" style="padding:4px 6px;border:1px solid #e5e7eb;border-radius:6px" /></td>
                  <td style="padding:8px;border-bottom:1px solid #f6f6f5"><span style="display:inline-block;padding:3px 8px;border-radius:999px;color:#fff;background:{{ $badgeBg }};font-size:12px">{{ $it->status }}</span></td>
                  <td style="padding:8px;border-bottom:1px solid #f6f6f5;color:#6b7280">{{ \Carbon\Carbon::parse($it->updated_at ?? now())->format('M d, Y') }}</td>
                  <td style="padding:8px;border-bottom:1px solid #f6f6f5">{{ (int)($it->delivered_total ?? 0) ?: 'Qty' }}</td>
                  <td style="padding:8px;border-bottom:1px solid #f6f6f5"><input type="date" style="padding:4px 6px;border:1px solid #e5e7eb;border-radius:6px" /></td>
                </tr>
              @empty
                <tr><td colspan="11" style="padding:10px;color:#706f6c">No inventory items yet.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
        @if(session('role') === 'owner')
          <div style="position:sticky;bottom:0;background:#fff;border-top:1px solid #e3e3e0;padding:10px;border-bottom-left-radius:12px;border-bottom-right-radius:12px;display:flex;justify-content:space-between;gap:8px;align-items:center;flex-wrap:wrap">
            <div style="display:flex;gap:8px;align-items:center">
              <button id="inv-bulk-delete" type="submit" style="padding:10px 14px;background:#1d4ed8;color:#fff;border-radius:8px">Delete Selected</button>
            </div>
            <button type="button" style="padding:10px 14px;background:#1f2937;color:#fff;border-radius:8px">Save Delivery Information</button>
          </div>
        @endif
      </form>
    </div>
