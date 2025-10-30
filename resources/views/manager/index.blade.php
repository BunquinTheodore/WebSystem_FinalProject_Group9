@extends('layouts.app')

@section('title', 'Manager')

@section('content')
  <div style="max-width:880px;margin:0 auto;display:grid;gap:16px">

      <div style="background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:8px">
        <h3 class="section-title">Overview</h3>
        <div id="mgr-total-fund">Current balance: <strong>₱{{ number_format($fundBalance ?? 0, 2) }}</strong></div>
        <div id="mgr-total-exp">Total expenses: <strong>₱{{ number_format($expensesTotal ?? 0, 2) }}</strong></div>
        <div id="mgr-total-avail">Available balance: <strong>₱{{ number_format($availableBalance ?? 0, 2) }}</strong></div>
      </div>

    <div style="background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:8px">
      <h3 class="section-title">Daily Report</h3>
      <form id="mgr-report-form" method="POST" action="{{ route('manager.report') }}">
        @csrf
        <table style="width:100%;border-collapse:collapse">
          <tbody>
            <tr>
              <th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px;width:180px">Shift</th>
              <td style="border-bottom:1px solid #e3e3e0;padding:8px">
                <select name="shift" style="width:100%"><option value="opening">Opening</option><option value="closing">Closing</option></select>
              </td>
            </tr>
            <tr>
              <th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px">Cash (₱)</th>
              <td style="border-bottom:1px solid #e3e3e0;padding:8px"><input name="cash" type="number" step="0.01" placeholder="Cash" style="width:100%"></td>
            </tr>
            <tr>
              <th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px">Wallet (₱)</th>
              <td style="border-bottom:1px solid #e3e3e0;padding:8px"><input name="wallet" type="number" step="0.01" placeholder="Wallet" style="width:100%"></td>
            </tr>
            <tr>
              <th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px">Bank (₱)</th>
              <td style="border-bottom:1px solid #e3e3e0;padding:8px"><input name="bank" type="number" step="0.01" placeholder="Bank" style="width:100%"></td>
            </tr>
            <tr>
              <td colspan="2" style="padding:8px">
                <div style="display:flex;justify-content:flex-end;gap:8px">
                  <button type="button" onclick="this.form.reset()" style="padding:8px 12px;border:1px solid #e3e3e0;border-radius:6px;background:#fff;color:#1b1b18">Clear</button>
                  <button style="background:#0891b2;color:#fff;border-radius:6px;padding:8px 12px">Submit</button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </form>
      <div id="mgr-report-list" style="margin-top:10px;display:grid;gap:10px">
        @forelse($reports as $r)
          <div class="card" style="border-radius:8px;border:1px solid #e3e3e0;overflow:hidden">
            <table style="width:100%;border-collapse:collapse">
              <thead>
                <tr>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Shift</th>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Cash (₱)</th>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Wallet (₱)</th>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Bank (₱)</th>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Submitted</th>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px;width:1%">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="padding:8px">{{ strtoupper($r->shift) }}</td>
                  <td style="padding:8px">₱{{ number_format($r->cash,2) }}</td>
                  <td style="padding:8px">₱{{ number_format($r->wallet,2) }}</td>
                  <td style="padding:8px">₱{{ number_format($r->bank,2) }}</td>
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
          <div style="color:#706f6c">No reports yet.</div>
        @endforelse
      </div>
    </div>

    <div style="background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:8px">
      <h3 class="section-title">APEPO Report</h3>
      <form id="mgr-apepo-form" method="POST" action="{{ route('manager.apepo') }}">
        @csrf
        <table style="width:100%;border-collapse:collapse">
          <tbody>
            <tr>
              <th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px;width:180px">Audit</th>
              <td style="border-bottom:1px solid #e3e3e0;padding:8px"><textarea name="audit" rows="2" style="width:100%" placeholder="Audit notes..."></textarea></td>
            </tr>
            <tr>
              <th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px">People</th>
              <td style="border-bottom:1px solid #e3e3e0;padding:8px"><textarea name="people" rows="2" style="width:100%" placeholder="People updates..."></textarea></td>
            </tr>
            <tr>
              <th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px">Equipment</th>
              <td style="border-bottom:1px solid #e3e3e0;padding:8px"><textarea name="equipment" rows="2" style="width:100%" placeholder="Equipment status..."></textarea></td>
            </tr>
            <tr>
              <th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px">Product</th>
              <td style="border-bottom:1px solid #e3e3e0;padding:8px"><textarea name="product" rows="2" style="width:100%" placeholder="Product quality/stock..."></textarea></td>
            </tr>
            <tr>
              <th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px">Others</th>
              <td style="border-bottom:1px solid #e3e3e0;padding:8px"><textarea name="others" rows="2" style="width:100%" placeholder="Other notes..."></textarea></td>
            </tr>
            <tr>
              <th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px">Notes</th>
              <td style="border-bottom:1px solid #e3e3e0;padding:8px"><input name="notes" style="width:100%" placeholder="Optional notes"></td>
            </tr>
            <tr>
              <td colspan="2" style="padding:8px">
                <div style="display:flex;justify-content:flex-end;gap:8px">
                  <button type="button" onclick="this.form.reset()" style="padding:8px 12px;border:1px solid #e3e3e0;border-radius:6px;background:#fff;color:#1b1b18">Clear</button>
                  <button style="background:#0891b2;color:#fff;border-radius:6px;padding:8px 12px">Submit APEPO</button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </form>
      <div id="mgr-apepo-list" style="margin-top:10px;display:grid;gap:10px">
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
    </div>

    <div style="background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:8px">
      <h3 class="section-title">Manager Fund</h3>
      <form id="mgr-fund-form" method="POST" action="{{ route('manager.fund') }}" style="margin-top:8px">
        @csrf
        <table style="width:100%;border-collapse:collapse">
          <tbody>
            <tr>
              <th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px;width:180px">Amount (₱)</th>
              <td style="border-bottom:1px solid #e3e3e0;padding:8px"><input name="amount" type="number" step="0.01" placeholder="Amount" style="width:100%"></td>
            </tr>
            <tr>
              <td colspan="2" style="padding:8px">
                <div style="display:flex;justify-content:flex-end;gap:8px">
                  <button type="button" onclick="this.form.reset()" style="padding:8px 12px;border:1px solid #e3e3e0;border-radius:6px;background:#fff;color:#1b1b18">Clear</button>
                  <button style="background:#0891b2;color:#fff;border-radius:6px;padding:8px 12px">Add / Adjust</button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </form>
    </div>

    <div style="background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:8px">
      <h3 class="section-title">Expenses</h3>
      <form id="mgr-expense-form" method="POST" action="{{ route('manager.expense') }}">
        @csrf
        <table style="width:100%;border-collapse:collapse">
          <tbody>
            <tr>
              <th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px;width:180px">Amount (₱)</th>
              <td style="border-bottom:1px solid #e3e3e0;padding:8px"><input name="amount" type="number" step="0.01" min="0" placeholder="0.00" style="width:100%"></td>
            </tr>
            <tr>
              <th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px;width:180px">Description</th>
              <td style="border-bottom:1px solid #e3e3e0;padding:8px"><input name="note" placeholder="Describe expense..." style="width:100%"></td>
            </tr>
            <tr>
              <td colspan="2" style="padding:8px">
                <div style="display:flex;justify-content:flex-end;gap:8px">
                  <button type="button" onclick="this.form.reset()" style="padding:8px 12px;border:1px solid #e3e3e0;border-radius:6px;background:#fff;color:#1b1b18">Clear</button>
                  <button style="background:#0891b2;color:#fff;border-radius:6px;padding:8px 12px">Add</button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </form>
      <div id="mgr-expense-list" style="margin-top:10px;display:grid;gap:10px">
        @forelse($expenses as $e)
          <div class="card" style="border-radius:8px;border:1px solid #e3e3e0;overflow:hidden">
            <table style="width:100%;border-collapse:collapse">
              <thead>
                <tr>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Amount (₱)</th>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Description</th>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Date</th>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px;width:1%">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="padding:8px">₱{{ number_format(($e->amount ?? 0), 2) }}</td>
                  <td style="padding:8px">{{ $e->note }}</td>
                  <td style="padding:8px;color:#706f6c">{{ \Carbon\Carbon::parse($e->created_at)->format('M d, Y H:i') }}</td>
                  <td style="padding:8px">
                    @if(session('username') === ($e->manager_username ?? null))
                      <form class="mgr-del-form" method="POST" action="{{ route('manager.expense.delete', ['id' => $e->id]) }}" style="margin:0">
                        @csrf
                        <button style="padding:4px 8px;background:#b91c1c;color:#fff;border-radius:6px" data-confirm="Remove this expense?">Delete</button>
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
          <div style="color:#706f6c">No expenses yet.</div>
        @endforelse
      </div>
    </div>

    <div style="background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:8px">
      <h3 class="section-title">Requests</h3>
      <form method="POST" action="{{ route('manager.request') }}">
        @csrf
        <table style="width:100%;border-collapse:collapse">
          <tbody>
            <tr>
              <th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px;width:180px">Item</th>
              <td style="border-bottom:1px solid #e3e3e0;padding:8px"><input name="item" placeholder="Item" style="width:100%"></td>
            </tr>
            <tr>
              <th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px">Quantity</th>
              <td style="border-bottom:1px solid #e3e3e0;padding:8px"><input name="quantity" type="number" min="1" value="1" style="width:100%"></td>
            </tr>
            <tr>
              <th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px">Priority</th>
              <td style="border-bottom:1px solid #e3e3e0;padding:8px"><select name="priority" style="width:100%"><option>low</option><option selected>medium</option><option>high</option></select></td>
            </tr>
            <tr>
              <td colspan="2" style="padding:8px">
                <div style="display:flex;justify-content:flex-end;gap:8px">
                  <button type="button" onclick="this.form.reset()" style="padding:8px 12px;border:1px solid #e3e3e0;border-radius:6px;background:#fff;color:#1b1b18">Clear</button>
                  <button style="background:#0891b2;color:#fff;border-radius:6px;padding:8px 12px">Submit</button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </form>
      <ul style="margin-top:10px">
        @forelse($requests as $q)
          <li style="display:flex;justify-content:space-between;align-items:center;gap:8px">
            <span>{{ $q->item }} × {{ $q->quantity }} • {{ ucfirst($q->priority) }}</span>
            <span style="display:flex;align-items:center;gap:8px">
              <span style="color:#706f6c">{{ ucfirst($q->status) }}</span>
              @if(session('username') === ($q->manager_username ?? null))
                <form class="mgr-del-form" method="POST" action="{{ route('manager.request.delete', ['id' => $q->id]) }}">
                  @csrf
                  <button style="padding:4px 8px;background:#b91c1c;color:#fff;border-radius:6px" data-confirm="Remove this request?">Delete</button>
                </form>
              @endif
            </span>
          </li>
        @empty
          <li style="color:#706f6c">No requests yet.</li>
        @endforelse
      </ul>
    </div>

    <div style="background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:8px">
      <h3 class="section-title">Assign Task</h3>
      <form method="POST" action="{{ route('manager.assign') }}">
        @csrf
        <table style="width:100%;border-collapse:collapse">
          <tbody>
            <tr>
              <th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px;width:180px">Task</th>
              <td style="border-bottom:1px solid #e3e3e0;padding:8px">
                <select name="task_id" style="width:100%">
                  @foreach($tasks as $t)
                    <option value="{{ $t->id }}">{{ $t->title }} ({{ $t->type }})</option>
                  @endforeach
                </select>
              </td>
            </tr>
            <tr>
              <th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px">Employee Username</th>
              <td style="border-bottom:1px solid #e3e3e0;padding:8px"><input name="employee_username" placeholder="employee" style="width:100%"></td>
            </tr>
            <tr>
              <th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px">Due At</th>
              <td style="border-bottom:1px solid #e3e3e0;padding:8px"><input name="due_at" type="datetime-local" style="width:100%"></td>
            </tr>
            <tr>
              <td colspan="2" style="padding:8px">
                <div style="display:flex;justify-content:flex-end;gap:8px">
                  <button type="button" onclick="this.form.reset()" style="padding:8px 12px;border:1px solid #e3e3e0;border-radius:6px;background:#fff;color:#1b1b18">Clear</button>
                  <button style="background:#0891b2;color:#fff;border-radius:6px;padding:8px 12px">Create Assignment</button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </form>
    </div>
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
                  <td class="inv-qty" data-id="{{ $it->id }}" style="padding:8px;{{ ($it->quantity <= $it->min_threshold) ? 'color:#b91c1c;font-weight:600' : '' }}">{{ $it->quantity }}</td>
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
    <script>
      (function(){
        const CSRF_TOKEN = '{{ csrf_token() }}';
        const EXP_DEL_BASE = "{{ url('/manager/expense') }}";
        const REP_DEL_BASE = "{{ url('/manager/report') }}";
        const APEPO_DEL_BASE = "{{ url('/manager/apepo') }}";
        function fmt(n){ try { return new Intl.NumberFormat('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(Number(n || 0)); } catch(e){ return Number(n||0).toFixed(2); } }
        function dt(s){ try { const d = new Date(s); return d.toLocaleString(); } catch(e){ return s; } }
        function makeReportCard(rep){
          const wrapper = document.createElement('div');
          wrapper.className = 'card';
          wrapper.style.borderRadius = '8px';
          wrapper.style.border = '1px solid #e3e3e0';
          wrapper.style.overflow = 'hidden';
          const shift = String(rep.shift || '').toUpperCase();
          wrapper.innerHTML = `
            <table style="width:100%;border-collapse:collapse">
              <thead>
                <tr>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Shift</th>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Cash (₱)</th>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Wallet (₱)</th>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Bank (₱)</th>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Submitted</th>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px;width:1%">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="padding:8px">${shift}</td>
                  <td style="padding:8px">₱${fmt(rep.cash)}</td>
                  <td style="padding:8px">₱${fmt(rep.wallet)}</td>
                  <td style="padding:8px">₱${fmt(rep.bank)}</td>
                  <td style="padding:8px;color:#706f6c">${dt(rep.created_at)}</td>
                  <td style="padding:8px">
                    <form class="mgr-del-form" method="POST" action="${REP_DEL_BASE}/${rep.id}/delete" style="margin:0">
                      <input type="hidden" name="_token" value="${CSRF_TOKEN}" />
                      <button style="padding:4px 8px;background:#b91c1c;color:#fff;border-radius:6px" data-confirm="Remove this report?">Delete</button>
                    </form>
                  </td>
                </tr>
              </tbody>
            </table>`;
          return wrapper;
        }
        function makeExpenseCard(exp){
          const wrapper = document.createElement('div');
          wrapper.className = 'card';
          wrapper.style.borderRadius = '8px';
          wrapper.style.border = '1px solid #e3e3e0';
          wrapper.style.overflow = 'hidden';
          wrapper.innerHTML = `
            <table style="width:100%;border-collapse:collapse">
              <thead>
                <tr>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Amount (₱)</th>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Description</th>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Date</th>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px;width:1%">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="padding:8px">₱${fmt(exp.amount)}</td>
                  <td style="padding:8px">${exp.note || ''}</td>
                  <td style="padding:8px;color:#706f6c">${dt(exp.created_at)}</td>
                  <td style="padding:8px">
                    <form class="mgr-del-form" method="POST" action="${EXP_DEL_BASE}/${exp.id}/delete" style="margin:0">
                      <input type="hidden" name="_token" value="${CSRF_TOKEN}" />
                      <button style="padding:4px 8px;background:#b91c1c;color:#fff;border-radius:6px" data-confirm="Remove this expense?">Delete</button>
                    </form>
                  </td>
                </tr>
              </tbody>
            </table>`;
          return wrapper;
        }
        function makeApepoCard(p){
          const wrapper = document.createElement('div');
          wrapper.className = 'card';
          wrapper.style.borderRadius = '8px';
          wrapper.style.border = '1px solid #e3e3e0';
          wrapper.style.overflow = 'hidden';
          wrapper.innerHTML = `
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
                  <td style="padding:8px">${(p.audit||'')}</td>
                  <td style="padding:8px;color:#706f6c">${dt(p.created_at)}</td>
                  <td style="padding:8px" rowspan="5">
                    <form class="mgr-del-form" method="POST" action="${APEPO_DEL_BASE}/${p.id}/delete" style="margin:0">
                      <input type="hidden" name="_token" value="${CSRF_TOKEN}" />
                      <button style="padding:4px 8px;background:#b91c1c;color:#fff;border-radius:6px" data-confirm="Remove this APEPO report?">Delete</button>
                    </form>
                  </td>
                </tr>
                <tr>
                  <td style="padding:8px">People</td>
                  <td style="padding:8px">${(p.people||'')}</td>
                  <td style="padding:8px;color:#706f6c"></td>
                </tr>
                <tr>
                  <td style="padding:8px">Equipment</td>
                  <td style="padding:8px">${(p.equipment||'')}</td>
                  <td style="padding:8px;color:#706f6c"></td>
                </tr>
                <tr>
                  <td style="padding:8px">Product</td>
                  <td style="padding:8px">${(p.product||'')}</td>
                  <td style="padding:8px;color:#706f6c"></td>
                </tr>
                <tr>
                  <td style="padding:8px">Others</td>
                  <td style="padding:8px">${(p.others||'')}</td>
                  <td style="padding:8px;color:#706f6c"></td>
                </tr>
                ${p.notes ? `<tr><td style="padding:8px">Notes</td><td style="padding:8px" colspan="2">${p.notes}</td></tr>` : ''}
              </tbody>
            </table>`;
          return wrapper;
        }
        async function refreshTotals(){
          try {
            const res = await fetch("{{ route('manager.totals') }}", { headers: { "X-Requested-With":"XMLHttpRequest" } });
            if(!res.ok) return;
            const data = await res.json();
            const f = document.getElementById('mgr-total-fund');
            const e = document.getElementById('mgr-total-exp');
            const a = document.getElementById('mgr-total-avail');
            if(f) f.innerHTML = 'Current balance: <strong>₱'+fmt(data.fundBalance)+'</strong>';
            if(e) e.innerHTML = 'Total expenses: <strong>₱'+fmt(data.expensesTotal)+'</strong>';
            if(a) a.innerHTML = 'Available balance: <strong>₱'+fmt(data.availableBalance)+'</strong>';
          } catch(err) { /* silent */ }
        }
        function pulse(el, color){
          if(!el) return;
          try{
            el.style.transition = 'background-color 320ms ease, box-shadow 320ms ease';
            el.style.background = color;
            el.style.boxShadow = 'inset 0 0 0 1px rgba(0,0,0,0.05)';
            setTimeout(function(){ if(el){ el.style.background=''; el.style.boxShadow=''; } }, 800);
          }catch(_){/* noop */}
        }
        function highlightTotals(opts){
          const f = document.getElementById('mgr-total-fund');
          const e = document.getElementById('mgr-total-exp');
          const a = document.getElementById('mgr-total-avail');
          if(opts && opts.fund) pulse(f, '#eaf7ee');
          if(opts && opts.exp) pulse(e, '#fdecea');
          if(opts && opts.avail) pulse(a, '#eef5ff');
        }
        async function submitAjax(form){
          try {
            const fd = new FormData(form);
            const res = await fetch(form.action, { method:"POST", body: fd, headers: { "X-Requested-With":"XMLHttpRequest" } });
            if(!res.ok){ throw new Error('Save failed'); }
            let payload = null; try { const ct = (res.headers.get('content-type')||'').toLowerCase(); if(ct.includes('application/json')) payload = await res.json(); } catch(_){}
            form.reset();
            await refreshTotals();
            // Highlight changed totals based on form
            if(form.id === 'mgr-fund-form'){
              highlightTotals({ fund:true, avail:true });
            } else if(form.id === 'mgr-expense-form'){
              highlightTotals({ exp:true, avail:true });
              // Try to append the newly created expense card without reload
              try {
                if(payload && payload.expense){
                  const host = document.getElementById('mgr-expense-list');
                  if(host){
                    const card = makeExpenseCard(payload.expense);
                    card.style.opacity = '0';
                    card.style.transform = 'scale(0.98)';
                    card.style.transition = 'opacity 180ms ease, transform 180ms ease';
                    host.prepend(card);
                    requestAnimationFrame(()=>{ card.style.opacity='1'; card.style.transform='scale(1)'; });
                  }
                }
              } catch(_){ /* ignore append errors */ }
            } else if(form.id === 'mgr-report-form'){
              // Append new report card
              try {
                if(payload && payload.report){
                  const host = document.getElementById('mgr-report-list');
                  if(host){
                    const card = makeReportCard(payload.report);
                    card.style.opacity = '0';
                    card.style.transform = 'scale(0.98)';
                    card.style.transition = 'opacity 180ms ease, transform 180ms ease';
                    host.prepend(card);
                    requestAnimationFrame(()=>{ card.style.opacity='1'; card.style.transform='scale(1)'; });
                  }
                }
              } catch(_){ /* ignore append errors */ }
            } else if(form.id === 'mgr-apepo-form'){
              // Append new APEPO card
              try {
                if(payload && payload.apepo){
                  const host = document.getElementById('mgr-apepo-list');
                  if(host){
                    const card = makeApepoCard(payload.apepo);
                    card.style.opacity = '0';
                    card.style.transform = 'scale(0.98)';
                    card.style.transition = 'opacity 180ms ease, transform 180ms ease';
                    host.prepend(card);
                    requestAnimationFrame(()=>{ card.style.opacity='1'; card.style.transform='scale(1)'; });
                  }
                }
              } catch(_){ /* ignore append errors */ }
            } else {
              highlightTotals({ avail:true });
            }
            if(window.toast){ window.toast('Saved. Totals updated.','success'); }
          } catch(err){
            // Fallback to normal submit if AJAX fails
            form.submit();
          }
        }
        const fundForm = document.getElementById('mgr-fund-form');
        if(fundForm){ fundForm.addEventListener('submit', function(ev){ ev.preventDefault(); submitAjax(fundForm); }); }
        const expForm = document.getElementById('mgr-expense-form');
        if(expForm){ expForm.addEventListener('submit', function(ev){ ev.preventDefault(); submitAjax(expForm); }); }
  const apepoForm = document.getElementById('mgr-apepo-form');
  if(apepoForm){ apepoForm.addEventListener('submit', function(ev){ ev.preventDefault(); submitAjax(apepoForm); }); }
        // Inventory forms
        const invItemForm = document.getElementById('inv-item-form');
        if(invItemForm){ invItemForm.addEventListener('submit', async function(ev){
          ev.preventDefault();
          try{
            const fd = new FormData(invItemForm);
            const res = await fetch(invItemForm.action, { method:'POST', body: fd, headers: { 'X-Requested-With':'XMLHttpRequest' } });
            if(!res.ok) throw new Error('Add failed');
            const data = await res.json();
            invItemForm.reset();
            if(data && data.item){
              const host = document.getElementById('inv-list');
              if(host){
                const card = document.createElement('div');
                card.className = 'card';
                card.style.borderRadius='8px'; card.style.border='1px solid #e3e3e0'; card.style.overflow='hidden';
                const it = data.item;
                card.innerHTML = `
                  <table style="width:100%;border-collapse:collapse">
                    <thead>
                      <tr>
                        <th style=\"text-align:left;border-bottom:1px solid #f0f0ef;padding:8px\">Item</th>
                        <th style=\"text-align:left;border-bottom:1px solid #f0f0ef;padding:8px\">Category</th>
                        <th style=\"text-align:left;border-bottom:1px solid #f0f0ef;padding:8px\">Qty</th>
                        <th style=\"text-align:left;border-bottom:1px solid #f0f0ef;padding:8px\">Min</th>
                        <th style=\"text-align:left;border-bottom:1px solid #f0f0ef;padding:8px\">Unit</th>
                        <th style=\"text-align:left;border-bottom:1px solid #f0f0ef;padding:8px\">Adjust</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td style=\"padding:8px\">${it.name||''}</td>
                        <td style=\"padding:8px\">${it.category||''}</td>
                        <td class=\"inv-qty\" data-id=\"${it.id}\" style=\"padding:8px\">${it.quantity||0}</td>
                        <td style=\"padding:8px\">${it.min_threshold||0}</td>
                        <td style=\"padding:8px\">${it.unit||''}</td>
                        <td style=\"padding:8px\">
                          <form class=\"inv-adjust\" method=\"POST\" action=\"{{ url('/manager/inventory') }}/${it.id}/adjust\" style=\"display:inline-flex;gap:6px;align-items:center\">
                            <input type=\"hidden\" name=\"_token\" value=\"${CSRF_TOKEN}\" />
                            <input name=\"delta\" type=\"number\" value=\"1\" style=\"width:80px\" />
                            <input name=\"reason\" placeholder=\"reason\" style=\"width:160px\" />
                            <button style=\"padding:6px 10px;background:#16a34a;color:#fff;border-radius:6px\">Apply</button>
                          </form>
                        </td>
                      </tr>
                    </tbody>
                  </table>`;
                card.style.opacity='0'; card.style.transform='scale(0.98)'; card.style.transition='opacity 180ms ease, transform 180ms ease';
                host.prepend(card);
                requestAnimationFrame(()=>{ card.style.opacity='1'; card.style.transform='scale(1)'; });
              }
            }
            if(window.toast){ window.toast('Item added.','success'); }
          }catch(err){ invItemForm.submit(); }
        }); }
        document.addEventListener('submit', async function(ev){
          const f = ev.target.closest('form.inv-adjust');
          if(!f) return;
          ev.preventDefault();
          try{
            const fd = new FormData(f);
            const res = await fetch(f.action, { method:'POST', body: fd, headers: { 'X-Requested-With':'XMLHttpRequest' } });
            if(!res.ok) throw new Error('Adjust failed');
            const data = await res.json();
            const rowQty = f.closest('tr')?.querySelector('.inv-qty');
            if(rowQty && data && typeof data.quantity !== 'undefined'){
              rowQty.textContent = data.quantity;
              // low-stock highlight when <= min
              const minCell = f.closest('tr')?.children[3];
              const min = minCell ? parseInt(minCell.textContent||'0',10) : 0;
              if(data.quantity <= min){ rowQty.style.color = '#b91c1c'; rowQty.style.fontWeight = '600'; } else { rowQty.style.color=''; rowQty.style.fontWeight=''; }
              // animate pulse
              rowQty.style.transition='background-color 320ms ease'; rowQty.style.background='#eef5ff'; setTimeout(()=>{ rowQty.style.background=''; }, 700);
            }
            if(window.toast){ window.toast('Inventory updated.','success'); }
          }catch(err){ f.submit(); }
        });
        // Deletion via AJAX for manager lists
        function findEntryContainer(el){
          let node = el;
          while(node){
            if(node.classList && node.classList.contains('card')) return node;
            if(node.tagName && node.tagName.toLowerCase() === 'li') return node;
            node = node.parentElement;
          }
          return null;
        }
        function animateRemove(el){
          if(!el) return false;
          try {
            const h = el.getBoundingClientRect().height;
            el.style.boxSizing = 'border-box';
            el.style.height = h + 'px';
            el.style.transition = 'height 180ms ease, opacity 160ms ease, transform 160ms ease, margin 160ms ease, padding 160ms ease';
            // Force reflow
            void el.offsetHeight;
            el.style.opacity = '0';
            el.style.transform = 'scale(0.98)';
            el.style.height = '0px';
            el.style.marginTop = '0px';
            el.style.marginBottom = '0px';
            el.style.paddingTop = '0px';
            el.style.paddingBottom = '0px';
            setTimeout(function(){ if(el && el.parentElement){ el.parentElement.removeChild(el); } }, 220);
            return true;
          } catch(_) { return false; }
        }
        async function handleDelete(form){
          try{
            const fd = new FormData(form);
            const res = await fetch(form.action, { method: 'POST', body: fd, headers: { "X-Requested-With":"XMLHttpRequest" } });
            if(!res.ok) throw new Error('Delete failed');
            const el = findEntryContainer(form);
            if(!animateRemove(el)){
              if(el && el.parentElement){ el.parentElement.removeChild(el); }
            }
            try {
              await refreshTotals();
              // Heuristic: if deleting an expense, highlight expenses + available
              const url = (form && form.action) || '';
              if(url.indexOf('/manager/expense/') !== -1){
                highlightTotals({ exp:true, avail:true });
              } else if(url.indexOf('/manager/report/') !== -1){
                // No totals change for reports; subtle available pulse for feedback
                highlightTotals({ avail:true });
              }
            } catch(e){}
              if(window.toast){ window.toast('Removed. Totals updated.','success'); }
          }catch(err){ form.submit(); }
        }
        document.addEventListener('submit', async function(ev){
          const form = ev.target.closest('form.mgr-del-form');
          if(form){
            const btn = form.querySelector('button');
            const msg = (btn && btn.getAttribute('data-confirm')) || 'Remove this item?';
            ev.preventDefault();
            let ok = true;
            if(window.modalConfirm){
              try { ok = await window.modalConfirm(msg, { type:'danger', confirmText:'Delete', title:'Please confirm' }); } catch(_) { ok = false; }
            } else {
              ok = window.confirm(msg);
            }
            if(!ok) return;
            handleDelete(form);
          }
        });
      })();
    </script>
  </div>
@endsection
