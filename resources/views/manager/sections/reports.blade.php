 
 <div style="background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:12px">
  <div style="font-weight:700;color:#0f172a;margin-bottom:4px">Financial Report</div>
  <div style="font-size:12px;color:#6b7280;margin-bottom:12px">Opening and closing shift financial details</div>
  <form id="mgr-reports-unified" method="POST" action="{{ route('manager.reports.unified') }}" enctype="multipart/form-data">
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
                    <button style="padding:4px 8px;background:#b91c1c;color:#fff;border-radius:6px" data-confirm="Remove this report?">Delete</button>
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
  <div style="display:grid;gap:10px">
    <input name="audit" placeholder="A - Audit: findings and observations..." style="width:97%;padding:10px;border:1px solid #e3e3e0;border-radius:8px;background:#f3f4f6" />
    <input name="people" placeholder="P - People: employee/role notes..." style="width:97%;padding:10px;border:1px solid #e3e3e0;border-radius:8px;background:#f3f4f6" />
    <input name="equipment" placeholder="E - Equipment: status and maintenance..." style="width:97%;padding:10px;border:1px solid #e3e3e0;border-radius:8px;background:#f3f4f6" />
    <input name="product" placeholder="P - Product: quality and inventory notes..." style="width:97%;padding:10px;border:1px solid #e3e3e0;border-radius:8px;background:#f3f4f6" />
    <input name="others" placeholder="O - Others: additional observations..." style="width:97%;padding:10px;border:1px solid #e3e3e0;border-radius:8px;background:#f3f4f6" />
    <input name="notes" placeholder="Notes (optional)" style="width:97%;padding:10px;border:1px solid #e3e3e0;border-radius:8px" />
  </div>

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
                    <button style="padding:4px 8px;background:#b91c1c;color:#fff;border-radius:6px" data-confirm="Remove this APEPO report?">Delete</button>
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
  <div style="display:grid;gap:10px">
    <input name="fund_amount" type="number" step="0.01" placeholder="Amount (₱)" style="width:98%;padding:10px;border:1px solid #e3e3e0;border-radius:8px" />
    <div style="display:flex;gap:8px;align-items:center">
      <input name="fund_image" type="file" accept="image/*" style="flex:1;padding:8px;border:1px solid #e3e3e0;border-radius:8px;background:#fff" />
    </div>
  </div>
</div>

<div style="background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:12px;margin-top:12px">
  <div style="font-weight:700;color:#0f172a;margin-bottom:4px">Expenses</div>
  <div style="font-size:12px;color:#6b7280;margin-bottom:10px">Record daily expenses</div>
  <div style="display:grid;gap:10px">
    <input name="expense_amount" type="number" step="0.01" min="0" placeholder="Amount (₱)" style="width:98%;padding:10px;border:1px solid #e3e3e0;border-radius:8px" />
    <textarea name="expense_note" rows="4" placeholder="Expense details (no character limit)..." style="width:98%;padding:10px;border:1px solid #e3e3e0;border-radius:8px"></textarea>
  </div>
</div>

<div style="margin-top:12px">
  <button style="width:100%;background:#16a34a;color:#fff;border-radius:8px;padding:10px 14px">Submit All</button>
</div>

</form>

<script>
  (function(){
    const form = document.getElementById('mgr-reports-unified');
    if(!form) return;

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
        let maxW = 1600, maxH = 1600, quality = 0.78;
        for(let attempt=0; attempt<4; attempt++){
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
          quality = Math.max(0.5, quality - 0.1);
          maxW = Math.round(maxW * 0.85);
          maxH = Math.round(maxH * 0.85);
        }
        // final output with last blob even if larger
        const finalBlob = await new Promise(resolve=> {
          const ratio = Math.min(maxW / img.width, maxH / img.height, 1);
          const w = Math.round(img.width * ratio);
          const h = Math.round(img.height * ratio);
          const canvas = document.createElement('canvas');
          canvas.width = w; canvas.height = h;
          const ctx = canvas.getContext('2d');
          ctx.drawImage(img, 0, 0, w, h);
          canvas.toBlob(resolve, 'image/jpeg', quality);
        });
        if(finalBlob){
          return new File([finalBlob], (file.name || 'image').replace(/\.[^.]+$/, '') + '.jpg', { type:'image/jpeg' });
        }
        return file;
      }catch(_){
        return file;
      }
    }

    async function maybeCompressInput(input){
      const f = input && input.files ? input.files[0] : null;
      if(!f) return;
      // Skip small files (< 600KB)
      if(f.size && f.size < 600 * 1024) return;
      const compressed = await compressFile(f);
      if(compressed && compressed.size < f.size){
        // Replace the input's file with compressed one
        const dt = new DataTransfer();
        dt.items.add(compressed);
        input.files = dt.files;
      }
    }

    form.addEventListener('submit', async function(e){
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
