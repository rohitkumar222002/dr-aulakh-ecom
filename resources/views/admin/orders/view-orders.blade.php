@extends('admin.layouts.app')
@section('content')
<div id="layout-wrapper">
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">


                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title">View Of Orders </h4>
                                <a href="{{ route('admin.orders') }}" class="btn btn-dark btn-sm text-white"> <i class="fa fa-arrow-left"></i> Back </a>
                            </div>
                            <div class="card-body">


                                <table id="datatable-row-callback"
                                    class="table table-hover table-bordered table-striped dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                        <th>#</th>
                                        <th>Product </th>
                                        <th>User </th>
                                        <th>Seller </th>
                                        <th>MRP Price</th>
                                        <th>Status</th>
                                        <th>Order Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($orders as $index=>$order)
            <tr>
                <td>{{ ++$index }}</td>
                <td>{{ $order->product->product_name ?? 'N/A' }}</td>
                <td>{{ $order->user->name ?? 'N/A' }}</td>
                <td>{{ $order->seller_name ?? 'Unknown Seller' }}</td>
                <td>{{ $order->mrp_price ?? 'N/A' }}</td>
                <td>
                    @if ($order->status == 0)
                        <strong class="text-warning">Pending</strong>
                    @elseif ($order->status == 1)
                        <strong class="text-success">Approved</strong>
                    @elseif ($order->status == 2)
                        <strong class="text-danger">Cancelled</strong>
                    @else
                        <strong class="text-muted">Unknown</strong>
                    @endif
                </td>
                <td>{{ $order->order_date ?? 'N/A' }}</td>
            </tr>
        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center">
                                    {{ $orders ->links('pagination::bootstrap-5') }}

                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
