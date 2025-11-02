<style>
  .qty-cell{padding:8px}
  .qty-cell.is-low{color:#b91c1c;font-weight:600}
</style>
<div style="background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:12px">
  <div style="font-weight:700;color:#0f172a;margin-bottom:4px">Inventory Overview</div>
  <div style="font-size:12px;color:#6b7280;margin-bottom:10px">View inventory updates from employees</div>
  <div style="overflow:auto">
    <table style="width:100%;border-collapse:separate;border-spacing:0 6px">
      <thead>
        <tr style="text-align:left;color:#0f172a">
          <th style="padding:8px 12px">Product Name</th>
          <th style="padding:8px 12px">Unit</th>
          <th style="padding:8px 12px">Sealed</th>
          <th style="padding:8px 12px">Loose</th>
          <th style="padding:8px 12px">Delivered</th>
          <th style="padding:8px 12px">Date Delivered</th>
          <th style="padding:8px 12px">Last Updated</th>
        </tr>
      </thead>
      <tbody>
        @forelse(($inventory ?? []) as $it)
          <tr style="background:#fafafa;border:1px solid #ececea">
            <td style="padding:8px 12px;white-space:nowrap">{{ $it->name }}</td>
            <td style="padding:8px 12px">{{ $it->unit }}</td>
            <td style="padding:8px 12px">{{ $it->sealed ?? $it->sealed_qty ?? 0 }}</td>
            <td style="padding:8px 12px">{{ $it->loose ?? $it->loose_qty ?? 0 }}</td>
            <td style="padding:8px 12px">{{ $it->delivered ?? $it->delivered_qty ?? 0 }}</td>
            @php($__mgrDateDelivered = data_get($it,'date_delivered') ?? data_get($it,'delivered_at'))
            <td style="padding:8px 12px">{{ $__mgrDateDelivered ? \Carbon\Carbon::parse($__mgrDateDelivered)->format('m/d/Y') : '-' }}</td>
            <td style="padding:8px 12px">{{ optional($it->updated_at ?? null) ? \Carbon\Carbon::parse($it->updated_at)->format('m/d/Y') : '-' }}</td>
          </tr>
        @empty
          <tr><td colspan="7" style="padding:8px 12px;color:#706f6c">No inventory yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div style="display:grid;gap:12px;margin-top:12px">
  <div style="background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:12px">
    <div style="font-weight:700;color:#0f172a;margin-bottom:4px">Kitchen Section</div>
    <div style="font-size:12px;color:#6b7280;margin-bottom:8px">Food ingredients, cooking supplies, disposables</div>
    <div style="overflow:auto">
      <table style="width:100%;border-collapse:collapse">
        <thead>
          <tr>
            <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Item</th>
            <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Unit</th>
            <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Qty</th>
            <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Min</th>
            <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Supplier</th>
            <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px;width:1%"></th>
          </tr>
        </thead>
        <tbody>
          @php($hasKitchen=false)
          @foreach(($inventory ?? []) as $it)
            @php($isKitchen = str_contains(strtolower($it->category ?? ''), 'kitchen'))
            @if($isKitchen)
              @php($hasKitchen=true)
              @php($low = (int)($it->quantity ?? 0) <= (int)($it->min_threshold ?? 0))
              <tr>
                <td style="padding:8px">{{ $it->name }}</td>
                <td style="padding:8px">{{ $it->unit }}</td>
                <td class="qty-cell {{ $low ? 'is-low' : '' }}">{{ $it->quantity ?? 0 }}</td>
                <td style="padding:8px">{{ $it->min_threshold ?? 0 }}</td>
                <td style="padding:8px">{{ $it->supplier ?? '-' }}</td>
                <td style="padding:8px">
                  <form method="POST" action="{{ route('manager.request') }}" style="margin:0">
                    @csrf
                    <input type="hidden" name="item" value="{{ $it->name }}" />
                    <input type="hidden" name="quantity" value="{{ max( (int)($it->min_threshold ?? 0) - (int)($it->quantity ?? 0), 1 ) }}" />
                    <input type="hidden" name="priority" value="{{ $low ? 'high' : 'medium' }}" />
                    <button style="padding:6px 10px;border-radius:6px;background:#0ea5e9;color:#fff">Request</button>
                  </form>
                </td>
              </tr>
            @endif
          @endforeach
          @if(!$hasKitchen)
            <tr><td colspan="6" style="padding:8px;color:#706f6c">No kitchen items.</td></tr>
          @endif
        </tbody>
      </table>
    </div>
  </div>

  <div style="background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:12px">
    <div style="font-weight:700;color:#0f172a;margin-bottom:4px">Coffee Bar Section</div>
    <div style="font-size:12px;color:#6b7280;margin-bottom:8px">Beans, milk, syrups, cups, lids, stirrers</div>
    <div style="overflow:auto">
      <table style="width:100%;border-collapse:collapse">
        <thead>
          <tr>
            <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Item</th>
            <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Unit</th>
            <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Qty</th>
            <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Min</th>
            <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Supplier</th>
            <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px;width:1%"></th>
          </tr>
        </thead>
        <tbody>
          @php($hasCoffee=false)
          @foreach(($inventory ?? []) as $it)
            @php($isCoffee = str_contains(strtolower($it->category ?? ''), 'coffee'))
            @if($isCoffee)
              @php($hasCoffee=true)
              @php($low = (int)($it->quantity ?? 0) <= (int)($it->min_threshold ?? 0))
              <tr>
                <td style="padding:8px">{{ $it->name }}</td>
                <td style="padding:8px">{{ $it->unit }}</td>
                <td class="qty-cell {{ $low ? 'is-low' : '' }}">{{ $it->quantity ?? 0 }}</td>
                <td style="padding:8px">{{ $it->min_threshold ?? 0 }}</td>
                <td style="padding:8px">{{ $it->supplier ?? '-' }}</td>
                <td style="padding:8px">
                  <form method="POST" action="{{ route('manager.request') }}" style="margin:0">
                    @csrf
                    <input type="hidden" name="item" value="{{ $it->name }}" />
                    <input type="hidden" name="quantity" value="{{ max( (int)($it->min_threshold ?? 0) - (int)($it->quantity ?? 0), 1 ) }}" />
                    <input type="hidden" name="priority" value="{{ $low ? 'high' : 'medium' }}" />
                    <button style="padding:6px 10px;border-radius:6px;background:#0ea5e9;color:#fff">Request</button>
                  </form>
                </td>
              </tr>
            @endif
          @endforeach
          @if(!$hasCoffee)
            <tr><td colspan="6" style="padding:8px;color:#706f6c">No coffee bar items.</td></tr>
          @endif
        </tbody>
      </table>
    </div>
  </div>
</div>