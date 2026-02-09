@extends('admin.layouts.app')
@section('content')

<div id="layout-wrapper">
<div class="main-content">
<div class="page-content">
<div class="container-fluid">

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-0">Transaction History</h4>
            <div class="mt-2">
                <span class="text-muted">User:</span>
                <strong>{{ $user->name }}</strong>
                <span class="text-muted ms-3">Username:</span>
                <strong>{{ $user->username }}</strong>
                <span class="text-muted ms-3">Balance:</span>
                <strong>₹{{ $user->balance ?? 0 }}</strong>
            </div>
        </div>
        <div>
            <a href="{{ route('admin.users') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Users
            </a>
        </div>
    </div>

    <div class="card-body">
        {{-- FILTER --}}
        <form method="GET" class="row mb-3">
            <div class="col-md-2 mb-2">
                <select name="type" class="form-control">
                    <option value="">All Types</option>
                    <option value="credit" {{ request('type') == 'credit' ? 'selected' : '' }}>Credit</option>
                    <option value="debit" {{ request('type') == 'debit' ? 'selected' : '' }}>Debit</option>
                </select>
            </div>

            <div class="col-md-2 mb-2">
                <input type="number"
                       name="level"
                       value="{{ request('level') }}"
                       class="form-control"
                       placeholder="Level">
            </div>

            <div class="col-md-2 mb-2">
                <select name="date_type" class="form-control">
                    <option value="">All Dates</option>
                    <option value="today" {{ request('date_type') == 'today' ? 'selected' : '' }}>Today</option>
                    <option value="yesterday" {{ request('date_type') == 'yesterday' ? 'selected' : '' }}>Yesterday</option>
                    <option value="week" {{ request('date_type') == 'week' ? 'selected' : '' }}>Last 7 Days</option>
                    <option value="month" {{ request('date_type') == 'month' ? 'selected' : '' }}>Last 30 Days</option>
                    <option value="custom" {{ request('date_type') == 'custom' ? 'selected' : '' }}>Custom Range</option>
                </select>
            </div>

            <div class="col-md-2 mb-2 custom-date" style="display: {{ request('date_type') == 'custom' ? 'block' : 'none' }};">
                <input type="date"
                       name="start_date"
                       value="{{ request('start_date') }}"
                       class="form-control"
                       placeholder="From Date">
            </div>

            <div class="col-md-2 mb-2 custom-date" style="display: {{ request('date_type') == 'custom' ? 'block' : 'none' }};">
                <input type="date"
                       name="end_date"
                       value="{{ request('end_date') }}"
                       class="form-control"
                       placeholder="To Date">
            </div>

            <div class="col-md-2 mb-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
            
            <div class="col-md-2 mb-2">
                <a href="{{ url()->current() }}" class="btn btn-secondary w-100">Reset</a>
            </div>
        </form>

        {{-- SUMMARY --}}
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <h6 class="text-muted">Total Credit</h6>
                        <h4 class="text-success">
                            ₹{{ $transactions->where('trx_type', 'credit')->sum('amount') }}
                        </h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <h6 class="text-muted">Total Debit</h6>
                        <h4 class="text-danger">
                            ₹{{ $transactions->where('trx_type', 'debit')->sum('amount') }}
                        </h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <h6 class="text-muted">Total Tax</h6>
                        <h4 class="text-warning">
                            ₹{{ $transactions->sum('tax') }}
                        </h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <h6 class="text-muted">Total Transactions</h6>
                        <h4>{{ $transactions->total() }}</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>From/To User</th>
                        <th>Level</th>
                        <th>Amount</th>
                        <th>Tax</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>TRX ID</th>
                        <th>Date</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($transactions as $index => $trx)
                    <tr>
                        <td>{{ ($transactions->currentPage()-1)*$transactions->perPage()+$index+1 }}</td>

                        <td>
                            @if($trx->trx_type == 'credit')
                                <span class="text-muted">From:</span><br>
                                @if($trx->fromUser)
                                    <strong>{{ $trx->fromUser->name }}</strong><br>
                                    <small>{{ $trx->fromUser->username }}</small>
                                @else
                                    <span class="text-muted">System</span>
                                @endif
                            @else
                                <span class="text-muted">To:</span><br>
                                @if($trx->user_id == $user->id)
                                    <strong>{{ $trx->user->name }}</strong><br>
                                    <small>{{ $trx->user->username }}</small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            @endif
                        </td>

                        <td>
                            @if($trx->level)
                                <span class="badge bg-info">Level {{ $trx->level }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>

                        <td>
                            <span class="{{ $trx->trx_type == 'credit' ? 'text-success' : 'text-danger' }}">
                                @if($trx->trx_type == 'credit') + @else - @endif
                                ₹{{ $trx->amount }}
                            </span>
                        </td>

                        <td>
                            ₹{{ $trx->tax ?? 0 }}
                        </td>

                        <td>
                            @if($trx->trx_type == 'credit')
                                <span class="badge bg-success">Credit</span>
                            @else
                                <span class="badge bg-danger">Debit</span>
                            @endif
                        </td>

                        <td>
                            {{ $trx->description ?? '-' }}
                        </td>

                        <td>
                            <small class="text-muted">{{ $trx->trx_id }}</small>
                        </td>

                        <td>
                            {{ $trx->created_at->format('d M Y') }}<br>
                            <small>{{ $trx->created_at->format('h:i A') }}</small>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">
                            <div class="py-4">
                                <i class="fas fa-exchange-alt fa-3x text-muted mb-3"></i>
                                <h5>No transactions found</h5>
                                <p class="text-muted">This user has no transaction history yet.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $transactions->links("pagination::bootstrap-5") }}
        </div>
    </div>
</div>

</div>
</div>
</div>
</div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dateTypeSelect = document.querySelector('select[name="date_type"]');
    const customDateFields = document.querySelectorAll('.custom-date');
    
    if (dateTypeSelect) {
        dateTypeSelect.addEventListener('change', function() {
            const isCustom = this.value === 'custom';
            
            customDateFields.forEach(field => {
                field.style.display = isCustom ? 'block' : 'none';
            });
            
            if (!isCustom) {
                document.querySelector('input[name="start_date"]').value = '';
                document.querySelector('input[name="end_date"]').value = '';
            }
        });
    }
});
</script>
@endsection

@endsection