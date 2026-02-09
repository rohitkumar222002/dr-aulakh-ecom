@extends('admin.layouts.app')
@section('content')

<div id="layout-wrapper">
<div class="main-content">
<div class="page-content">
<div class="container-fluid">

<div class="card">

    <div class="card-header d-flex justify-content-between">
        <h4>Transaction History</h4>
    </div>

    <div class="card-body">

        {{-- FILTER --}}
        {{-- FILTER --}}
<form method="GET" class="row mb-3">
    <div class="col-md-2 mb-2">
        <input type="text"
               name="search"
               value="{{ request('search') }}"
               class="form-control"
               placeholder="Search user">
    </div>

    <div class="col-md-2 mb-2">
       
               <select class="form-control form-select" name="level">
                <option>Select Level</option>
                @foreach ($levels as $level )
                    <option value="{{ $level->level }}">
                       Level {{ $level->level }}
                    </option>
                @endforeach
               </select>
    </div>

    {{-- Date Type Selector --}}
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

    {{-- Custom Date Fields (hidden by default) --}}
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

        {{-- TABLE --}}
        <table class="table table-bordered">

            <thead>
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>From User</th>
                    <th>Level</th>
                    <th>Amount</th>
                    <th>Tax</th>
                    <th>Type</th>
                    <th>TRX ID</th>
                    <th>Date</th>
                    <!-- <th>Action</th> -->
                </tr>
            </thead>

            <tbody>
                @foreach($transactions as $index => $trx)
                <tr>
                    <td>
                        {{ ($transactions->currentPage()-1)*$transactions->perPage()+$index+1 }}
                    </td>

                    <td>
                        {{ $trx->user->name ?? '-' }}
                        <br>
                        <small>{{ $trx->user->username ?? '' }}</small>
                    </td>

                    <td>
                        {{ $trx->fromUser->name ?? '-' }}
                    </td>

                    <td>
                        Level {{ $trx->level }}
                    </td>

                    <td class="text-success">
                        ₹{{ $trx->amount }}
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

                    <td>{{ $trx->trx_id }}</td>

                    <td>{{ $trx->created_at->format('d M Y') }}</td>
   {{-- <td>
        <a href="{{ route('admin.users.transactions',$trx->user_id) }}" class="btn btn-pramiry">View</a>
    </td> --}}
                </tr>
                @endforeach
            </tbody>

        </table>

        <div class="mt-3">
            {{ $transactions->links("pagination::bootstrap-5") }}
        </div>

    </div>
</div>

</div>
</div>
</div>
</div>
@push('scripts')
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
            
            // Clear custom date fields when not in use
            if (!isCustom) {
                document.querySelector('input[name="start_date"]').value = '';
                document.querySelector('input[name="end_date"]').value = '';
            }
        });
    }
});
</script>
@endpush

@endsection
