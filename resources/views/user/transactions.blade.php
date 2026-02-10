@extends('user.layouts.app')

@section('content')

<div class="main-content">
<div class="page-content">
<div class="container-fluid">

<div class="card">

    <div class="card-header">
        <h4>My Transactions</h4>
    </div>

    <div class="card-body">

        {{-- FILTER --}}
        <form method="GET" class="row mb-3">

            <div class="col-md-3">
                <select name="date_type" class="form-control">
                    <option value="">All</option>
                    <option value="today">Today</option>
                    <option value="week">Last 7 Days</option>
                    <option value="month">Last 30 Days</option>
                </select>
            </div>

            <div class="col-md-2">
                <button class="btn btn-primary w-100">Filter</button>
            </div>

        </form>

        {{-- TABLE --}}
        <table class="table table-bordered">

            <thead>
                <tr>
                    <th>#</th>
                    <th>From User</th>
                    <th>Level</th>
                    <th>Amount</th>
                    <th>Tax</th>
                    <th>Type</th>
                    <th>Date</th>
                </tr>
            </thead>

            <tbody>
                @foreach($transactions as $index => $trx)
                <tr>
                    <td>
                        {{ ($transactions->currentPage()-1)*$transactions->perPage()+$index+1 }}
                    </td>

                    <td>
                        {{ $trx->fromUser->name ?? '-' }}<br>
                        <b>({{ $trx->fromUser->username ?? '-' }})</b>
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

                    <td>
                        {{ $trx->created_at->format('d M Y') }}
                    </td>
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

@endsection
