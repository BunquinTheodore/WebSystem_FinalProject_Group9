    <div id="apepo" class="owner-section" data-section="apepo" style="display:none;background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:8px">
      <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px">
        <button onclick="backToMain()" style="display:flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:50%;background:#f0f9ff;color:#0891b2;border:none;cursor:pointer;transition:all 0.2s ease" onmouseover="this.style.background='#0891b2'; this.style.color='#fff'; this.style.transform='scale(1.05)'" onmouseout="this.style.background='#f0f9ff'; this.style.color='#0891b2'; this.style.transform='scale(1)'">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M19 12H5M12 19l-7-7 7-7"/>
          </svg>
        </button>
        <h3 class="section-title" style="margin:0">Recent APEPO Reports</h3>
      </div>
      <form id="apepo-filter-form" method="GET" action="{{ route('owner.home') }}" style="margin:8px 0 12px;display:grid;gap:8px;grid-template-columns:1.5fr 1fr 1fr auto">
        <div>
          <input id="mgr-input" list="apepo-managers" placeholder="Type manager name, then Add" style="padding:6px 8px;border:1px solid #e3e3e0;border-radius:6px;width:100%" />
          <div id="mgr-chips" style="display:flex;flex-wrap:wrap;gap:6px;margin-top:6px">
            @php
              $mgrParam = request()->query('manager');
              $mgrVals = is_array($mgrParam) ? $mgrParam : (strlen((string)$mgrParam) ? [(string)$mgrParam] : []);
            @endphp
            @foreach($mgrVals as $val)
              <span class="mgr-chip" data-value="{{ $val }}" style="display:inline-flex;align-items:center;gap:6px;background:#eef2ff;border:1px solid #dbe2ff;color:#1b1b18;padding:4px 8px;border-radius:999px">
                <span>{{ $val }}</span>
                <button type="button" class="chip-x" aria-label="Remove" style="background:transparent;border:none;color:#555;cursor:pointer">×</button>
              </span>
            @endforeach
          </div>
          <div id="mgr-hidden" aria-hidden="true" style="display:none">
            @foreach($mgrVals as $val)
              <input type="hidden" name="manager[]" value="{{ $val }}" />
            @endforeach
          </div>
        </div>
        <input name="from" type="date" value="{{ request('from') }}" style="padding:6px 8px;border:1px solid #e3e3e0;border-radius:6px" />
        <input name="to" type="date" value="{{ request('to') }}" style="padding:6px 8px;border:1px solid #e3e3e0;border-radius:6px" />
        <div style="display:flex;gap:8px;align-items:center">
          <button style="background:#0891b2;color:#fff;border-radius:6px;padding:8px 12px">Filter</button>
          <a href="{{ route('owner.home') }}" style="padding:8px 12px;border:1px solid #e3e3e0;border-radius:6px;background:#fff;color:#1b1b18;text-decoration:none">Clear</a>
        </div>
      </form>
      <datalist id="apepo-managers">
        @foreach(($apepoManagers ?? []) as $m)
          <option value="{{ $m }}"></option>
        @endforeach
      </datalist>
      <div style="display:grid;gap:10px">
        @forelse($apepo as $p)
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
        {!! $apepo->appends(request()->query())->links() !!}
      </div>
    </div>
