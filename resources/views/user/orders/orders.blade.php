@extends('user.layouts.app')

@section('content')
    <div id="layout-wrapper">
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">List Of Orders </h4>
                                </div>
                                <div class="card-body">


                                    <table id="datatable-row-callback"
                                        class="table table-hover table-bordered table-striped dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Product Name</th>
                                                <th>Product Code</th>
                                                <th>Price</th>
                                                <th>Status</th>
                                                <th>Expiry</th>
                                                <th>Completed</th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($orders as $key=> $order)
                                                <tr>
                                                    <td>{{ ++$key ?? '' }}</td>
                                                    <td>
                                                        
                                                    @php
    $productDetails = json_decode($order->product_details, true);
@endphp

@isset($productDetails['product_name'])
    @if(!empty($order->advertiser->store->store_slug))
        <a href="{{ route('product.detail', [
            'store' => $order->advertiser->store->store_slug,
            'slug' => $productDetails['product_slug']
        ]) }}">
            {{ Str::limit($productDetails['product_name'], 30, '...') ?? 'N/A' }}
        </a>
    @else
        <span>{{ Str::limit($productDetails['product_name'], 30, '...') ?? 'N/A' }}</span>
    @endif
@endisset

                                                        
                                                    </td>
                                                    <td>{{ $order->product_code }}</td>
                                                    <td>

                                                        {{ json_decode($order->product_details, true)['offer_price'] ?? 'N/A' }}

                                                    </td>
                                                    <td>
                                                        @if ($order->status == 0)
                                                            <span class="badge badge-warning">
                                                                Pending
                                                            </span>
                                                        @endif
                                                        @if ($order->status == 1)
                                                            <span class="badge badge-success">
                                                                Accepted
                                                            </span>
                                                        @endif
                                                        @if ($order->status == 2)
                                                            <span class="badge badge-danger">
                                                                Rejected
                                                            </span>
                                                        @endif

                                                    </td>
                                                    <td>
                                                        @if (\Carbon\Carbon::now()->lessThan($order->valid_from))
                                                            @if ($order->status == 1)
                                                                <span class="badge badge-success">
                                                                    Used
                                                                </span>
                                                            @else
                                                                <span class="badge badge-success">
                                                                     {{ \Carbon\Carbon::parse($order->valid_from)->format('d,M Y') }}
                                                                </span>
                                                            @endif
                                                        @else
                                                            <span class="badge badge-danger">
                                                                Expired
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-dark">
                                                            {{ $order->updated_at->format('d,M Y') }}
                                                        </span>
                                                    </td>

                                                </tr>
                                            @endforeach



                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="{{ asset('panel/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('panel/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
@endpush


@push('scripts')
    <script src="{{ asset('panel/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('panel/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('panel/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('panel/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('panel/js/pages/datatables-advanced.init.js') }}"></script>
@endpush
