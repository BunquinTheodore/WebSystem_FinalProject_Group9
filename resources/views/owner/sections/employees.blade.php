    <div id="employees" class="owner-section" data-section="employees" style="display:none;background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:8px">
      <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px">
        <button onclick="backToMain()" style="display:flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:50%;background:#f0f9ff;color:#0891b2;border:none;cursor:pointer;transition:all 0.2s ease" onmouseover="this.style.background='#0891b2'; this.style.color='#fff'; this.style.transform='scale(1.05)'" onmouseout="this.style.background='#f0f9ff'; this.style.color='#0891b2'; this.style.transform='scale(1)'">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M19 12H5M12 19l-7-7 7-7"/>
          </svg>
        </button>
        <div>
          <h3 class="section-title" style="margin:0;color:#0f172a">Employees</h3>
          <div style="font-size:12px;color:#6b7280">Staff directory and management</div>
        </div>
      </div>

      <div style="display:grid;gap:12px;grid-template-columns:repeat(3,minmax(0,1fr));margin-bottom:12px">
        <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;padding:14px;display:flex;align-items:center;justify-content:space-between">
          <div>
            <div style="font-size:12px;color:#0f172a;margin-bottom:4px">Total Employees</div>
            <div style="font-size:26px;font-weight:800;color:#0f172a">{{ (int)($empTotal ?? 0) }}</div>
          </div>
          <div aria-hidden="true" style="width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;background:#eef2ff;color:#4338ca;border:1px solid #dbe2ff">👥</div>
        </div>
        <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;padding:14px;display:flex;align-items:center;justify-content:space-between">
          <div>
            <div style="font-size:12px;color:#065f46;margin-bottom:4px">Full-Time</div>
            <div style="font-size:26px;font-weight:800;color:#065f46">{{ (int)($empFull ?? 0) }}</div>
          </div>
          <div aria-hidden="true" style="width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;background:#ecfdf5;color:#047857;border:1px solid #bbf7d0">👤</div>
        </div>
        <div style="background:#fff7ed;border:1px solid #fed7aa;border-radius:12px;padding:14px;display:flex;align-items:center;justify-content:space-between">
          <div>
            <div style="font-size:12px;color:#9a3412;margin-bottom:4px">Part-Time</div>
            <div style="font-size:26px;font-weight:800;color:#9a3412">{{ (int)($empPart ?? 0) }}</div>
          </div>
          <div aria-hidden="true" style="width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;background:#fffbeb;color:#b45309;border:1px solid #fed7aa">👥</div>
        </div>
      </div>

      <div class="card" style="border-radius:12px;border:1px solid #e3e3e0;padding:14px">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px">
          <div>
            <div style="font-weight:700;color:#0f172a">All Employees</div>
            <div style="font-size:12px;color:#6b7280">Complete staff directory</div>
          </div>
          <button type="button" onclick="document.getElementById('owner-add-emp').style.display = document.getElementById('owner-add-emp').style.display==='none'?'block':'none'" style="display:inline-flex;align-items:center;gap:8px;background:#0ea5e9;color:#fff;border-radius:8px;padding:8px 12px;border:1px solid #7dd3fc">
            <span aria-hidden="true">＋</span>
            <span>Add Employee</span>
          </button>
        </div>
        <div style="overflow:auto">
          <table style="width:100%;border-collapse:separate;border-spacing:0;min-width:980px">
            <thead>
              <tr>
                <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Employee</th>
                <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Status</th>
                <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Position</th>
                <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Birthday</th>
                <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Email</th>
                <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Contact</th>
                <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Join Date</th>
                <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px;width:1%">Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse(($employees ?? []) as $emp)
                @php($nm = trim((string)($emp->name ?? '')))
                @php($ini = strtoupper(collect(explode(' ', $nm))->map(fn($p)=>substr($p,0,1))->take(2)->implode('')))
                @php($et = strtolower($emp->employment_type ?? ''))
                @php($isFull = $et === 'fulltime')
                @php($join = $emp->join_date ?? null)
                <tr>
                  <td style="padding:8px;border-bottom:1px solid #f6f6f5">
                    <div style="display:flex;align-items:center;gap:10px">
                      <div style="width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;background:#e2e8f0;color:#0f172a;font-weight:700;font-size:12px">{{ $ini ?: 'EMP' }}</div>
                      <div>{{ $nm ?: '—' }}</div>
                    </div>
                  </td>
                  <td style="padding:8px;border-bottom:1px solid #f6f6f5">
                    <span style="display:inline-block;padding:4px 8px;border-radius:999px;font-size:12px;{{ $isFull ? 'color:#2563eb;background:#eef2ff;border:1px solid #bfdbfe' : 'color:#06b6d4;background:#ecfeff;border:1px solid #a5f3fc' }}">{{ $isFull ? 'Full-time' : 'Part-time' }}</span>
                  </td>
                  <td style="padding:8px;border-bottom:1px solid #f6f6f5">{{ $emp->position ?? '-' }}</td>
                  <td style="padding:8px;border-bottom:1px solid #f6f6f5">{{ optional($emp->birthday ?? null) ? \Carbon\Carbon::parse($emp->birthday)->format('M d, Y') : '-' }}</td>
                  <td style="padding:8px;border-bottom:1px solid #f6f6f5">{{ $emp->email ?? '-' }}</td>
                  <td style="padding:8px;border-bottom:1px solid #f6f6f5">{{ $emp->contact ?? '-' }}</td>
                  <td style="padding:8px;border-bottom:1px solid #f6f6f5">{{ optional($join) ? \Carbon\Carbon::parse($join)->format('M d, Y') : '-' }}</td>
                  <td style="padding:8px;border-bottom:1px solid #f6f6f5">
                    <div style="display:flex;gap:8px;align-items:center">
                      <button type="button" onclick="document.getElementById('owner-edit-emp-{{ $emp->id }}').style.display = (document.getElementById('owner-edit-emp-{{ $emp->id }}').style.display==='none' || document.getElementById('owner-edit-emp-{{ $emp->id }}').style.display==='') ? 'table-row' : 'none'" style="padding:6px;border:1px solid #e3e3e0;border-radius:6px;background:#fff;color:#0f172a">✎</button>
                      <form method="POST" action="{{ route('owner.employee.delete', ['id'=>$emp->id]) }}" onsubmit="return confirm('Delete this employee?')" style="margin:0">
                        @csrf
                        <button style="padding:6px;border:1px solid #e3e3e0;border-radius:6px;background:#fff;color:#b91c1c">🗑</button>
                      </form>
                    </div>
                  </td>
                </tr>
                <tr id="owner-edit-emp-{{ $emp->id }}" style="display:none;background:#fafafa">
                  <td colspan="8" style="padding:8px">
                    <form method="POST" action="{{ route('owner.employee.update', ['id'=>$emp->id]) }}" style="display:grid;gap:10px">
                      @csrf
                      <div style="display:grid;gap:8px;grid-template-columns:1.2fr 1fr 1fr">
                        <input name="name" value="{{ $emp->name }}" placeholder="Full name" style="padding:8px;border:1px solid #e3e3e0;border-radius:6px" />
                        <select name="employment_type" style="padding:8px;border:1px solid #e3e3e0;border-radius:6px">
                          <option value="fulltime" {{ $isFull ? 'selected' : '' }}>Full-time</option>
                          <option value="parttime" {{ !$isFull ? 'selected' : '' }}>Part-time</option>
                        </select>
                        <input name="position" value="{{ $emp->position ?? '' }}" placeholder="Position" style="padding:8px;border:1px solid #e3e3e0;border-radius:6px" />
                      </div>
                      <div style="display:grid;gap:8px;grid-template-columns:1fr 1fr 1fr 1fr">
                        <input name="birthday" type="date" value="{{ optional($emp->birthday ?? null) ? \Carbon\Carbon::parse($emp->birthday)->format('Y-m-d') : '' }}" style="padding:8px;border:1px solid #e3e3e0;border-radius:6px" />
                        <input name="email" type="email" value="{{ $emp->email ?? '' }}" placeholder="Email" style="padding:8px;border:1px solid #e3e3e0;border-radius:6px" />
                        <input name="contact" value="{{ $emp->contact ?? '' }}" placeholder="Contact" style="padding:8px;border:1px solid #e3e3e0;border-radius:6px" />
                        <input name="join_date" type="date" value="{{ optional($join) ? \Carbon\Carbon::parse($join)->format('Y-m-d') : '' }}" style="padding:8px;border:1px solid #e3e3e0;border-radius:6px" />
                      </div>
                      <div style="display:flex;gap:8px;justify-content:flex-end">
                        <button type="button" onclick="document.getElementById('owner-edit-emp-{{ $emp->id }}').style.display='none'" style="padding:8px 12px;border:1px solid #e3e3e0;border-radius:6px;background:#fff;color:#1b1b18">Cancel</button>
                        <button style="padding:8px 12px;background:#16a34a;color:#fff;border-radius:6px">Save</button>
                      </div>
                    </form>
                  </td>
                </tr>
              @empty
                <tr><td colspan="8" style="padding:8px;color:#706f6c">No employees found.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

      <div id="owner-add-emp" class="card" style="display:none;margin-top:12px;background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:12px">
        <div style="font-weight:700;color:#0f172a;margin-bottom:4px">Add New Employee</div>
        <form method="POST" action="{{ route('owner.employee.create') }}">
          @csrf
          <div style="display:grid;gap:10px">
            <div style="display:grid;gap:6px;grid-template-columns:1.2fr 1fr 1fr">
              <input name="name" placeholder="Full name" style="padding:10px;border:1px solid #e3e3e0;border-radius:8px" />
              <select name="employment_type" style="padding:10px;border:1px solid #e3e3e0;border-radius:8px">
                <option value="fulltime">Full-time</option>
                <option value="parttime">Part-time</option>
              </select>
              <input name="position" placeholder="Position" style="padding:10px;border:1px solid #e3e3e0;border-radius:8px" />
            </div>
            <div style="display:grid;gap:6px;grid-template-columns:1fr 1fr 1fr 1fr">
              <input name="birthday" type="date" placeholder="Birthday" style="padding:10px;border:1px solid #e3e3e0;border-radius:8px" />
              <input name="email" type="email" placeholder="Email" style="padding:10px;border:1px solid #e3e3e0;border-radius:8px" />
              <input name="contact" placeholder="Contact" style="padding:10px;border:1px solid #e3e3e0;border-radius:8px" />
              <input name="join_date" type="date" placeholder="Join date" style="padding:10px;border:1px solid #e3e3e0;border-radius:8px" />
            </div>
            <div style="display:grid;gap:6px;grid-template-columns:1fr">
              <select name="role" style="padding:10px;border:1px solid #e3e3e0;border-radius:8px">
                <option value="employee">Employee</option>
                <option value="manager">Manager</option>
                <option value="owner">Owner</option>
              </select>
            </div>
            <div style="display:flex;gap:8px;justify-content:flex-end">
              <button type="button" onclick="document.getElementById('owner-add-emp').style.display='none'" style="padding:10px 14px;border:1px solid #e3e3e0;border-radius:8px;background:#fff;color:#1b1b18">Cancel</button>
              <button style="padding:10px 14px;background:#16a34a;color:#fff;border-radius:8px">Add Employee</button>
            </div>
          </div>
        </form>
      </div>
    </div>
