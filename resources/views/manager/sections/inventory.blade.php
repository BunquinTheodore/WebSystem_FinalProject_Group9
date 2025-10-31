<div style="background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:8px">
  <h3 class="section-title">Inventory</h3>
  <form id="inv-item-form" method="POST" action="{{ route('manager.inventory.item') }}" style="margin:8px 0 12px">
    @csrf
    <table style="width:100%;border-collapse:collapse">
      <tbody>
        <tr>
          <th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px;width:160px">Name</th>
          <td style="border-bottom:1px solid #e3e3e0;padding:8px"><input name="name" required placeholder="Item name" style="width:100%"></td>
        </tr>
        <tr>
          <th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px">Category</th>
          <td style="border-bottom:1px solid #e3e3e0;padding:8px"><input name="category" placeholder="Category (optional)" style="width:100%"></td>
        </tr>
        <tr>
          <th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px">Unit</th>
          <td style="border-bottom:1px solid #e3e3e0;padding:8px"><input name="unit" placeholder="pcs / kg / L ..." style="width:100%"></td>
        </tr>
        <tr>
          <th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px">Initial Qty</th>
          <td style="border-bottom:1px solid #e3e3e0;padding:8px"><input name="quantity" type="number" min="0" value="0" style="width:100%"></td>
        </tr>
        <tr>
          <th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px">Min Threshold</th>
          <td style="border-bottom:1px solid #e3e3e0;padding:8px"><input name="min_threshold" type="number" min="0" value="0" style="width:100%"></td>
        </tr>
        <tr>
          <th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px">Notes</th>
          <td style="border-bottom:1px solid #e3e3e0;padding:8px"><input name="notes" placeholder="Optional" style="width:100%"></td>
        </tr>
        <tr>
          <td colspan="2" style="padding:8px">
            <div style="display:flex;justify-content:flex-end;gap:8px">
              <button type="button" onclick="this.form.reset()" style="padding:8px 12px;border:1px solid #e3e3e0;border-radius:6px;background:#fff;color:#1b1b18">Clear</button>
              <button style="background:#0891b2;color:#fff;border-radius:6px;padding:8px 12px">Add Item</button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </form>
  <div id="inv-list" style="display:grid;gap:8px">
    @forelse(($inventory ?? []) as $it)
      <div class="card" style="border-radius:8px;border:1px solid #e3e3e0;overflow:hidden">
        <table style="width:100%;border-collapse:collapse">
          <thead>
            <tr>
              <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Item</th>
              <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Category</th>
              <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Qty</th>
              <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Min</th>
              <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Unit</th>
              <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Adjust</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td style="padding:8px">{{ $it->name }}</td>
              <td style="padding:8px">{{ $it->category }}</td>
              <td class="inv-qty" data-id="{{ $it->id }}" style="padding:8px">
                <span @if($it->quantity <= $it->min_threshold) style="color:#b91c1c;font-weight:600" @endif>{{ $it->quantity }}</span>
              </td>
              <td style="padding:8px">{{ $it->min_threshold }}</td>
              <td style="padding:8px">{{ $it->unit }}</td>
              <td style="padding:8px">
                <form class="inv-adjust" method="POST" action="{{ route('manager.inventory.adjust', ['id' => $it->id]) }}" style="display:inline-flex;gap:6px;align-items:center">
                  @csrf
                  <input name="delta" type="number" value="1" style="width:80px" />
                  <input name="reason" placeholder="reason" style="width:160px" />
                  <button style="padding:6px 10px;background:#16a34a;color:#fff;border-radius:6px">Apply</button>
                </form>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    @empty
      <div style="color:#706f6c">No inventory yet.</div>
    @endforelse
  </div>
</div>