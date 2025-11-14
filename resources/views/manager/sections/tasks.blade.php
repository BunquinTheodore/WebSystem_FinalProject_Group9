<div class="card" style="border-radius:12px;border:1px solid #e3e3e0;padding:16px">
  <div style="font-weight:700;color:#0f172a;margin-bottom:4px">Manager's Tasks</div>
  <div style="font-size:12px;color:#6b7280;margin-bottom:10px">Your daily tasks assigned by the owner</div>
  @php($mgrTasks = $managerTasks ?? [])
  <div style="display:grid;gap:8px">
    @forelse($mgrTasks as $mt)
      <form method="POST" action="{{ route('manager.tasks.toggle', ['id' => $mt['id'] ?? 0]) }}" class="mgr-task-form" style="display:flex;align-items:center;gap:10px;border:1px solid #e3e3e0;border-radius:8px;padding:10px;background:#fff;margin:0">
        @csrf
        <input type="hidden" name="done" value="0">
        <input type="checkbox" name="done" value="1" class="mgr-task-checkbox" @if(!empty($mt['done'])) checked @endif>
        <div style="flex:1">
          <div style="color:#0f172a">{{ $mt['title'] ?? 'Untitled task' }}</div>
        </div>
        @if(!empty($mt['done']))
          <span style="color:#16a34a">✔</span>
        @endif
      </form>
    @empty
      <div style="color:#706f6c">No tasks yet.</div>
    @endforelse
  </div>
  <script>
    (function(){
      document.addEventListener('change', function(ev){
        var cb = ev.target.closest('.mgr-task-checkbox');
        if(!cb) return;
        var form = cb.form;
        if(!form) return;
        ev.preventDefault();
        try {
          var fd = new FormData(form);
          fetch(form.action, { method:'POST', body: fd, headers: { 'X-Requested-With':'XMLHttpRequest' } })
            .then(function(res){ /* no-op */ })
            .catch(function(){ form.submit(); });
        } catch(_){ form.submit(); }
      });
    })();
  </script>
</div>

<div class="card" style="border-radius:12px;border:1px solid #e3e3e0;padding:16px;margin-top:12px">
  <div style="display:flex;align-items:center;justify-content:space-between;gap:8px;margin-bottom:8px">
    <div>
      <div style="font-weight:700;color:#0f172a">Assign Tasks to Employees</div>
      <div style="font-size:12px;color:#6b7280">Create and assign tasks to your team</div>
    </div>
  </div>
  <form method="POST" action="{{ route('manager.assign') }}">
    @csrf
    <div style="display:grid;gap:10px">
      <div>
        <div style="font-size:12px;color:#6b7280;margin-bottom:4px">Task Title</div>
        <input name="title" placeholder="e.g., Clean coffee machine" style="width:98%;padding:8px;border:1px solid #e3e3e0;border-radius:6px" />
      </div>
      <div>
        <div style="font-size:12px;color:#6b7280;margin-bottom:4px">Task Description</div>
        <input name="description" placeholder="Add details or instructions (optional)" style="width:98%;padding:8px;border:1px solid #e3e3e0;border-radius:6px" />
      </div>
      
      <div style="display:grid;gap:10px;grid-template-columns:1fr 1fr">
        <div>
          <div style="font-size:12px;color:#6b7280;margin-bottom:4px">Category</div>
          <select name="category" style="width:100%;padding:8px;border:1px solid #e3e3e0;border-radius:6px">
            <option>Opening</option>
            <option>Closing</option>
            <option>Cleaning</option>
            <option>Maintenance</option>
            <option>Inventory</option>
            <option>Administrative</option>
          </select>
        </div>
        <div>
          <div style="font-size:12px;color:#6b7280;margin-bottom:4px">Priority</div>
          <select name="priority" style="width:100%;padding:8px;border:1px solid #e3e3e0;border-radius:6px">
            <option value="medium" selected>Medium</option>
            <option value="high">High</option>
            <option value="low">Low</option>
          </select>
        </div>
      </div>
      
      

      

      <div style="display:flex;justify-content:flex-end;gap:8px">
        <button type="button" onclick="this.form.reset()" style="padding:10px 14px;border:1px solid #e3e3e0;border-radius:6px;background:#fff;color:#1b1b18">Clear</button>
        <button style="background:#0ea5e9;color:#fff;border-radius:6px;padding:10px 14px">Assign Task to Employee</button>
      </div>
    </div>
  </form>
</div>