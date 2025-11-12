@extends('layouts.app')

@section('title', 'Tasks - '.ucfirst($type))
@section('hide-back-button')@endsection

@section('content')
  <style>
    .tabs-wrap{display:flex;justify-content:center;margin:10px 0 16px}
    .tabs{display:inline-flex;background:#e6f6fa;border-radius:999px;padding:4px;gap:4px}
    .tab{padding:8px 14px;border-radius:999px;border:1px solid transparent;background:#ffffff;color:#0b7285;font-weight:600}
    .tab.inactive{background:transparent;border-color:#cce9f1;color:#0b7285}
    .tab:hover{filter:brightness(0.98)}
    .panel{position:relative;overflow:hidden}
    .anim{animation-duration:220ms;animation-timing-function:cubic-bezier(.2,.8,.2,1)}
    @keyframes slideIn{from{opacity:0;transform:translateY(6px)}to{opacity:1;transform:translateY(0)}}
    @keyframes slideOutLeft{from{opacity:1;transform:translateX(0)}to{opacity:0;transform:translateX(-8px)}}
    @keyframes slideOutRight{from{opacity:1;transform:translateX(0)}to{opacity:0;transform:translateX(8px)}}
    .in{animation-name:slideIn}
    .out-left{animation-name:slideOutLeft}
    .out-right{animation-name:slideOutRight}
    .task{border:1px solid #e3e3e0;border-radius:12px;padding:12px;background:#fff;display:flex;align-items:flex-start;gap:12px}
    .task .badge{margin-left:auto;background:#0ea5b7;color:#fff;border:1px solid #0ea5b7;border-radius:8px;padding:8px 10px;text-decoration:none;display:inline-flex;align-items:center;gap:6px}
    .muted{color:#706f6c}
    .section-box{border:1px solid #e3e3e0;border-radius:12px;background:#fff;padding:16px}
    .fade{transition:opacity .25s ease, transform .25s ease}
    .fade.is-hide{opacity:0;transform:translateY(6px)}
    .completed{opacity:.55}
    .controls{display:flex;gap:10px;align-items:center;margin-bottom:8px;justify-content:space-between}
    .toggle{display:inline-flex;gap:8px;align-items:center;font-size:14px}
    .toast{position:fixed;top:16px;right:16px;background:#0ea5b7;color:#fff;padding:10px 14px;border-radius:8px;box-shadow:0 4px 18px rgba(0,0,0,.12);opacity:0;transform:translateY(-6px);transition:opacity .2s ease, transform .2s ease;z-index:50}
    .toast.show{opacity:1;transform:translateY(0)}
  </style>

  <div class="card" style="max-width:1000px;margin:0 auto;padding:16px 16px 24px">
    <div class="tabs-wrap">
      <div class="tabs" role="tablist" aria-label="Task Type">
        <a id="tab-opening" class="tab {{ $type==='opening' ? '' : 'inactive' }}" role="tab" aria-selected="{{ $type==='opening' ? 'true':'false' }}" href="{{ url('/employee/tasks/opening') }}" data-no-loader>Opening Tasks</a>
        <a id="tab-closing" class="tab {{ $type==='closing' ? '' : 'inactive' }}" role="tab" aria-selected="{{ $type==='closing' ? 'true':'false' }}" href="{{ url('/employee/tasks/closing') }}" data-no-loader>Closing Tasks</a>
      </div>
    </div>

    <div id="panel" class="panel anim in section-box">
      <div class="controls">
        <h2 class="section-title" style="margin:0">{{ ucfirst($type) }} Tasks</h2>
        <label class="toggle">
          <input id="toggle-completed" type="checkbox" {{ $includeCompleted ? 'checked' : '' }}>
          <span class="muted">Show completed</span>
        </label>
      </div>

      <ul style="display:grid;gap:10px">
        @foreach($tasks as $task)
          @php($isDone = in_array($task->id, $completedIds ?? []))
          @php($subtitle = optional($task->checklistItems->first())->label)
          <li class="task {{ $isDone ? 'completed' : '' }}">
            <div style="margin-top:3px;width:20px;height:20px;border:1px solid #dcdcdc;border-radius:999px;background:#fff;flex:0 0 20px"></div>
            <div style="flex:1 1 auto">
              <div style="font-weight:600">{{ $task->title }}</div>
              <div class="muted" style="font-size:13px">{{ $subtitle }}</div>
            </div>
            <button class="badge pick-photo" data-task-id="{{ $task->id }}" type="button" title="Add photo">
              <span style="font-size:16px">📷</span><span style="font-weight:600">Photo</span>
            </button>
          </li>
        @endforeach
      </ul>
    </div>
  </div>

  <div id="toast" class="toast" role="status" aria-live="polite">Uploaded</div>

  <script>
    (function(){
      const panel = document.getElementById('panel');
      const opening = document.getElementById('tab-opening');
      const closing = document.getElementById('tab-closing');
      // Hidden file input and form for uploading base64 image
      const file = document.createElement('input');
      file.type = 'file';
      file.accept = 'image/*';
      file.style.display = 'none';
      document.body.appendChild(file);

      let currentTaskId = null;
      const CSRF = '{{ csrf_token() }}';

      async function compressImage(dataUrl, maxW=1280, maxH=1280, quality=0.8){
        return new Promise((resolve)=>{
          const img = new Image();
          img.onload = function(){
            let {width:w, height:h} = img;
            const ratio = Math.min(maxW / w, maxH / h, 1);
            const cw = Math.round(w * ratio), ch = Math.round(h * ratio);
            const canvas = document.createElement('canvas');
            canvas.width = cw; canvas.height = ch;
            const ctx = canvas.getContext('2d');
            ctx.drawImage(img, 0, 0, cw, ch);
            resolve(canvas.toDataURL('image/jpeg', quality));
          };
          img.src = dataUrl;
        });
      }

      function showToast(){
        const t = document.getElementById('toast');
        if(!t) return;
        t.classList.add('show');
        setTimeout(()=> t.classList.remove('show'), 1500);
      }

      async function submitImage(dataUrl, triggerBtn){
        const li = triggerBtn ? triggerBtn.closest('li') : null;
        try{
          // compress before sending
          const compressed = await compressImage(dataUrl, 1280, 1280, 0.82);
          const res = await fetch("{{ route('employee.proof') }}", {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'Accept': 'application/json',
              'X-CSRF-TOKEN': CSRF,
              'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify({
              task_id: currentTaskId,
              qr_payload: 'manual-upload',
              photo_base64: compressed,
            })
          });
          if(!res.ok){ throw new Error('Upload failed'); }
          const json = await res.json();
          if(li){
            li.classList.add('fade','is-hide');
            setTimeout(()=>{ li.remove(); }, 260);
          }
          showToast();
        }catch(e){
          // fallback: navigate to scan page
          window.location.href = "{{ route('scan') }}?task_id=" + encodeURIComponent(currentTaskId);
        }
      }

      file.addEventListener('change', function(){
        const f = this.files && this.files[0];
        if(!f) return;
        const reader = new FileReader();
        const btnRef = document.querySelector('.pick-photo[data-task-id="'+currentTaskId+'"]');
        reader.onload = function(e){ submitImage(e.target.result, btnRef); };
        reader.readAsDataURL(f);
        // Optional: reset value so same file can be re-picked later
        this.value = '';
      });

      document.addEventListener('click', function(e){
        const btn = e.target.closest('.pick-photo');
        if(!btn) return;
        e.preventDefault();
        currentTaskId = btn.getAttribute('data-task-id');
        file.click();
      });

      // toggle completed
      const toggle = document.getElementById('toggle-completed');
      if(toggle){
        toggle.addEventListener('change', function(){
          const url = new URL(window.location.href);
          if(this.checked){ url.searchParams.set('include_completed', '1'); }
          else { url.searchParams.delete('include_completed'); }
          window.location.href = url.toString();
        });
      }
      function go(el, dir){
        if(!panel) return;
        panel.classList.remove('in');
        panel.classList.add(dir === 'left' ? 'out-left' : 'out-right');
        setTimeout(()=>{ window.location.href = el.getAttribute('href'); }, 180);
      }
      if(opening){ opening.addEventListener('click', function(e){
        if(this.classList.contains('inactive')){ e.preventDefault(); go(this, 'right'); }
      }); }
      if(closing){ closing.addEventListener('click', function(e){
        if(this.classList.contains('inactive')){ e.preventDefault(); go(this, 'left'); }
      }); }
    })();
  </script>
@endsection
