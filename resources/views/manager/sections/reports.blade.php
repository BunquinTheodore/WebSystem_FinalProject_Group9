 
 <div style="background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:12px">
  <div style="font-weight:700;color:#0f172a;margin-bottom:4px">Financial Report</div>
  <div style="font-size:12px;color:#6b7280;margin-bottom:12px">Opening and closing shift financial details</div>
  <!-- Financial Report Form -->
  <form id="mgr-report-form" method="POST" action="{{ route('manager.reports.unified') }}" enctype="multipart/form-data" data-no-loader>
    @csrf
    <div style="display:grid;gap:12px;grid-template-columns:1fr 1fr">
      <div style="border:1px solid #e3e3e0;border-radius:8px;padding:12px;background:#f0f9ff">
        <div style="font-weight:600;color:#0f172a;margin-bottom:8px">Opening Shift</div>
        <div style="display:grid;gap:8px">
          <input name="opening_cash" type="number" step="0.01" placeholder="Cash (₱)" style="width:97%;padding:8px;border:1px solid #e3e3e0;border-radius:6px" />
          <input name="opening_wallet" type="number" step="0.01" placeholder="Digital Wallet (₱)" style="width:97%;padding:8px;border:1px solid #e3e3e0;border-radius:6px" />
          <input name="opening_bank" type="number" step="0.01" placeholder="Bank Amount (₱)" style="width:97%;padding:8px;border:1px solid #e3e3e0;border-radius:6px" />
          <input name="opening_turnover_cash" type="number" step="0.01" placeholder="Turnover Cash (₱)" style="width:97%;padding:8px;border:1px solid #e3e3e0;border-radius:6px" />
          <input name="opening_turnover_wallet" type="number" step="0.01" placeholder="Turnover Digital Wallet (₱)" style="width:97%;padding:8px;border:1px solid #e3e3e0;border-radius:6px" />
          <input name="opening_turnover_bank" type="number" step="0.01" placeholder="Turnover Bank Amount (₱)" style="width:97%;padding:8px;border:1px solid #e3e3e0;border-radius:6px" />
          <input name="opening_image" type="file" accept="image/*" style="width:97%;padding:8px;border:1px solid #e3e3e0;border-radius:6px;background:#fff" />
        </div>
      </div>
      <div style="border:1px solid #e3e3e0;border-radius:8px;padding:12px;background:#fff7ed">
        <div style="font-weight:600;color:#0f172a;margin-bottom:8px">Closing Shift</div>
        <div style="display:grid;gap:8px">
          <input name="closing_cash" type="number" step="0.01" placeholder="Cash (₱)" style="width:97%;padding:8px;border:1px solid #e3e3e0;border-radius:6px" />
          <input name="closing_wallet" type="number" step="0.01" placeholder="Digital Wallet (₱)" style="width:97%;padding:8px;border:1px solid #e3e3e0;border-radius:6px" />
          <input name="closing_bank" type="number" step="0.01" placeholder="Bank Amount (₱)" style="width:97%;padding:8px;border:1px solid #e3e3e0;border-radius:6px" />
          <input name="closing_turnover_cash" type="number" step="0.01" placeholder="Turnover Cash (₱)" style="width:97%;padding:8px;border:1px solid #e3e3e0;border-radius:6px" />
          <input name="closing_turnover_wallet" type="number" step="0.01" placeholder="Turnover Digital Wallet (₱)" style="width:97%;padding:8px;border:1px solid #e3e3e0;border-radius:6px" />
          <input name="closing_turnover_bank" type="number" step="0.01" placeholder="Turnover Bank Amount (₱)" style="width:97%;padding:8px;border:1px solid #e3e3e0;border-radius:6px" />
          <input name="closing_image" type="file" accept="image/*" style="width:97%;padding:8px;border:1px solid #e3e3e0;border-radius:6px;background:#fff" />
        </div>
      </div>
    </div>
    <div style="margin-top:10px;display:flex;justify-content:flex-end">
      <button class="btn-primary" style="background:#0891b2;color:#fff;border:none;border-radius:8px;padding:10px 16px">Submit Financial</button>
    </div>
  </form>
    
    

  <div id="mgr-report-list" style="margin-top:12px;display:grid;gap:10px">
    @forelse($reports as $r)
      <div class="card" style="border-radius:8px;border:1px solid #e3e3e0;overflow:hidden">
        <table style="width:100%;border-collapse:collapse">
          <thead>
            <tr>
              <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Type</th>
              <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Amounts</th>
              <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Submitted</th>
              <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px;width:1%">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td style="padding:8px">{{ strtoupper($r->shift ?? 'N/A') }}</td>
              <td style="padding:8px">₱{{ number_format(($r->cash ?? 0)+($r->wallet ?? 0)+($r->bank ?? 0),2) }}</td>
              <td style="padding:8px;color:#706f6c">{{ \Carbon\Carbon::parse($r->created_at)->format('M d, Y H:i') }}</td>
              <td style="padding:8px">
                @if(session('username') === ($r->manager_username ?? null))
                  <form class="mgr-del-form" method="POST" action="{{ route('manager.report.delete', ['id' => $r->id]) }}" style="margin:0">
                    @csrf
                    <button data-confirm-title="Please confirm" data-confirm-ok="Delete" data-confirm-type="danger" data-confirm="Remove this report?" style="padding:4px 8px;background:#b91c1c;color:#fff;border-radius:6px">Delete</button>
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
    @endforelse
  </div>
</div>

<div style="background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:12px;margin-top:12px">
  <div style="font-weight:700;color:#0f172a;margin-bottom:4px">APEPO Report</div>
  <div style="font-size:12px;color:#6b7280;margin-bottom:10px">Audit, People, Equipment, Product, Others</div>
  <form id="mgr-apepo-form" method="POST" action="{{ route('manager.reports.unified') }}" data-no-loader>
    @csrf
    <div style="display:grid;gap:10px">
      <input name="audit" placeholder="A - Audit: findings and observations..." style="width:97%;padding:10px;border:1px solid #e3e3e0;border-radius:8px;background:#f3f4f6" />
      <input name="people" placeholder="P - People: employee/role notes..." style="width:97%;padding:10px;border:1px solid #e3e3e0;border-radius:8px;background:#f3f4f6" />
      <input name="equipment" placeholder="E - Equipment: status and maintenance..." style="width:97%;padding:10px;border:1px solid #e3e3e0;border-radius:8px;background:#f3f4f6" />
      <input name="product" placeholder="P - Product: quality and inventory notes..." style="width:97%;padding:10px;border:1px solid #e3e3e0;border-radius:8px;background:#f3f4f6" />
      <input name="others" placeholder="O - Others: additional observations..." style="width:97%;padding:10px;border:1px solid #e3e3e0;border-radius:8px;background:#f3f4f6" />
      <input name="notes" placeholder="Notes (optional)" style="width:97%;padding:10px;border:1px solid #e3e3e0;border-radius:8px" />
    </div>
    <div style="margin-top:10px;display:flex;justify-content:flex-end">
      <button class="btn-primary" style="background:#0891b2;color:#fff;border:none;border-radius:8px;padding:10px 16px">Submit APEPO</button>
    </div>
  </form>

  <div id="mgr-apepo-list" style="margin-top:12px;display:grid;gap:10px">
    @forelse($apepo as $p)
      <div class="card" style="border-radius:8px;border:1px solid #e3e3e0;overflow:hidden">
        <table style="width:100%;border-collapse:collapse">
          <thead>
            <tr>
              <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Section</th>
              <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Details</th>
              <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Submitted</th>
              <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px;width:1%">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td style="padding:8px">Audit</td>
              <td style="padding:8px">{{ $p->audit }}</td>
              <td style="padding:8px;color:#706f6c">{{ \Carbon\Carbon::parse($p->created_at)->format('M d, Y H:i') }}</td>
              <td style="padding:8px" rowspan="5">
                @if(session('username') === ($p->manager_username ?? null))
                  <form class="mgr-del-form" method="POST" action="{{ route('manager.apepo.delete', ['id' => $p->id]) }}" style="margin:0">
                    @csrf
                    <button data-confirm-title="Please confirm" data-confirm-ok="Delete" data-confirm-type="danger" data-confirm="Remove this APEPO report?" style="padding:4px 8px;background:#b91c1c;color:#fff;border-radius:6px">Delete</button>
                  </form>
                @else
                  <span style="color:#706f6c">—</span>
                @endif
              </td>
            </tr>
            <tr><td style="padding:8px">People</td><td style="padding:8px">{{ $p->people }}</td><td style="padding:8px;color:#706f6c"></td></tr>
            <tr><td style="padding:8px">Equipment</td><td style="padding:8px">{{ $p->equipment }}</td><td style="padding:8px;color:#706f6c"></td></tr>
            <tr><td style="padding:8px">Product</td><td style="padding:8px">{{ $p->product }}</td><td style="padding:8px;color:#706f6c"></td></tr>
            <tr><td style="padding:8px">Others</td><td style="padding:8px">{{ $p->others }}</td><td style="padding:8px;color:#706f6c"></td></tr>
            @if(!empty($p->notes))
              <tr><td style="padding:8px">Notes</td><td style="padding:8px" colspan="2">{{ $p->notes }}</td></tr>
            @endif
          </tbody>
        </table>
      </div>
    @empty
    @endforelse
  </div>
</div>

<div style="background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:12px;margin-top:12px">
  <div style="font-weight:700;color:#0f172a;margin-bottom:4px">Manager Fund</div>
  <div style="font-size:12px;color:#6b7280;margin-bottom:10px">Daily manager fund tracking</div>
  <form id="mgr-fund-form" method="POST" action="{{ route('manager.reports.unified') }}" enctype="multipart/form-data" data-no-loader>
    @csrf
    <div style="display:grid;gap:10px">
      <input name="fund_amount" type="number" step="0.01" placeholder="Amount (₱)" style="width:98%;padding:10px;border:1px solid #e3e3e0;border-radius:8px" />
      <div style="display:flex;gap:8px;align-items:center">
        <input name="fund_image" type="file" accept="image/*" style="flex:1;padding:8px;border:1px solid #e3e3e0;border-radius:8px;background:#fff" />
      </div>
    </div>
    <div style="margin-top:10px;display:flex;justify-content:flex-end">
      <button class="btn-primary" style="background:#0891b2;color:#fff;border:none;border-radius:8px;padding:10px 16px">Submit Fund</button>
    </div>
  </form>
</div>

<div style="background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:12px;margin-top:12px">
  <div style="font-weight:700;color:#0f172a;margin-bottom:4px">Expenses</div>
  <div style="font-size:12px;color:#6b7280;margin-bottom:10px">Record daily expenses</div>
  <form id="mgr-expense-form" method="POST" action="{{ route('manager.reports.unified') }}" data-no-loader>
    @csrf
    <div style="display:grid;gap:10px">
      <input name="expense_amount" type="number" step="0.01" min="0" placeholder="Amount (₱)" style="width:98%;padding:10px;border:1px solid #e3e3e0;border-radius:8px" />
      <textarea name="expense_note" rows="4" placeholder="Expense details (no character limit)..." style="width:98%;padding:10px;border:1px solid #e3e3e0;border-radius:8px"></textarea>
    </div>
    <div style="margin-top:10px;display:flex;justify-content:flex-end">
      <button class="btn-primary" style="background:#0891b2;color:#fff;border:none;border-radius:8px;padding:10px 16px">Submit Expense</button>
    </div>
  </form>
</div>


<script>
  (function(){
    // Utility: attach image compression to a form and input names
    function attachCompression(form, inputNames){
      if(!form) return;
      form.addEventListener('submit', async function(e){
        try{
          const inputs = inputNames.map(n=> form.querySelector('input[name="'+n+'"]')).filter(Boolean);
          const anyFile = inputs.some(i => i.files && i.files.length);
          if(!anyFile) return; // proceed normally
          e.preventDefault();
          // no loading overlay
          for(const inp of inputs){ await maybeCompressInput(inp); }
          const total = inputs.reduce((sum, i)=> sum + (i.files && i.files[0] ? i.files[0].size : 0), 0);
          if(total > 5 * 1024 * 1024){
            try{ if(window.toast) window.toast('Attached photos are too large even after optimization. Please choose smaller images.', 'error'); }catch(_){ alert('Attached photos are too large even after optimization. Please choose smaller images.'); }
            const overlay = document.getElementById('loading-overlay'); if(overlay) overlay.classList.remove('show');
            return;
          }
          this.submit();
        }catch(_){ /* ignore */ }
      });
    }

    // Attach compression to relevant forms
    attachCompression(document.getElementById('mgr-report-form'), ['opening_image','closing_image']);
    attachCompression(document.getElementById('mgr-fund-form'), ['fund_image']);
    const submitBtn = document.getElementById('mgr-submit-all');
    if(submitBtn){ submitBtn.addEventListener('click', function(e){ e.stopPropagation(); }, true); }

    // Inline delete now handled by normal forms with global modal confirm
    (function(){ /* no-op */ })();

    function readFileAsDataURL(file){
      return new Promise((resolve, reject)=>{
        const r = new FileReader();
        r.onload = () => resolve(r.result);
        r.onerror = reject;
        r.readAsDataURL(file);
      });
    }

    function loadImage(url){
      return new Promise((resolve, reject)=>{
        const img = new Image();
        img.onload = () => resolve(img);
        img.onerror = reject;
        img.src = url;
      });
    }
    async function compressFile(file, targetBytes = 1.2 * 1024 * 1024){
      try{
        let dataUrl = await readFileAsDataURL(file);
        let img = await loadImage(dataUrl);
        let maxW = 1400, maxH = 1400, quality = 0.75;
        for(let attempt=0; attempt<2; attempt++){
          const ratio = Math.min(maxW / img.width, maxH / img.height, 1);
          const w = Math.round(img.width * ratio);
          const h = Math.round(img.height * ratio);
          const canvas = document.createElement('canvas');
          canvas.width = w; canvas.height = h;
          const ctx = canvas.getContext('2d');
          ctx.drawImage(img, 0, 0, w, h);
          const blob = await new Promise(resolve=> canvas.toBlob(resolve, 'image/jpeg', quality));
          if(!blob) break;
          if (blob.size <= targetBytes) {
            return new File([blob], (file.name || 'image').replace(/\.[^.]+$/, '') + '.jpg', { type:'image/jpeg' });
          }
          // tighten constraints and try again
          quality = Math.max(0.6, quality - 0.1);
          maxW = Math.round(maxW * 0.9);
          maxH = Math.round(maxH * 0.9);
        }
        return file; // fall back to original if still large
      }catch(_){
        return file;
      }
    }

    async function maybeCompressInput(input){
      const f = input && input.files ? input.files[0] : null;
      if(!f) return;
      // Skip files smaller than 1.2MB to keep submits snappy
      if(f.size && f.size < 1.2 * 1024 * 1024) return;
      const compressed = await compressFile(f);
      if(compressed && compressed.size < f.size){
        const dt = new DataTransfer();
        dt.items.add(compressed);
        input.files = dt.files;
      }
    }

    form.addEventListener('submit', async function(e){
      e.stopPropagation();
      try{
        // only intercept if there are image files
        const inputs = [
          form.querySelector('input[name="opening_image"]'),
          form.querySelector('input[name="closing_image"]'),
          form.querySelector('input[name="fund_image"]'),
        ].filter(Boolean);
        const anyFile = inputs.some(i => i.files && i.files.length);
        if(!anyFile) return; // proceed normally
        e.preventDefault();
        // Optional visual hint using global overlay if present
        try{
          const overlay = document.getElementById('loading-overlay');
          const textEl = document.getElementById('loading-text');
          if(overlay && textEl){ textEl.textContent = 'Optimizing photos…'; overlay.classList.add('show'); }
        }catch(_){ }
        for(const inp of inputs){ await maybeCompressInput(inp); }
        // if still very large, warn and abort
        const total = inputs.reduce((sum, i)=> sum + (i.files && i.files[0] ? i.files[0].size : 0), 0);
        if(total > 5 * 1024 * 1024){
          try{
            if(window.toast) window.toast('Attached photos are too large even after optimization. Please choose smaller images.', 'error');
          }catch(_){ alert('Attached photos are too large even after optimization. Please choose smaller images.'); }
          const overlay = document.getElementById('loading-overlay'); if(overlay) overlay.classList.remove('show');
          return; // do not submit
        }
        // submit after compression
        this.submit();
      }catch(_){ /* ignore and let submit proceed */ }
    });
  })();
</script>
