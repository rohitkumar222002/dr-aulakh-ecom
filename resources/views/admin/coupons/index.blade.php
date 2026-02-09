@extends('admin.layouts.app')
@section('content')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            {{-- Alerts --}}
            @if ($errors->any() || session()->has('message') || session()->has('error') || session()->has('success'))
                <div class="alert 
                    {{ $errors->any() ? 'alert-danger' : (session('error') ? 'alert-danger' : (session('success') ? 'alert-success' : 'alert-warning')) }}">
                    <ul class="list-group">
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        @endif

                        @if (session()->has('message') || session()->has('error') || session()->has('success'))
                            {{ session('message') ?? (session('error') ?? session('success')) }}
                        @endif
                    </ul>
                </div>
            @endif


            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header card-header-bordered justify-content-between">
                        <h3 class="card-title">Create Coupon</h3>
                    </div>

                    <div class="card-body">
                        <form class="row g-3" action="{{ route('admin.coupons.store') }}" method="POST">
                            @csrf

                            <div class="col-md-4">
                                <label class="form-label">Coupon Code <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="code" value="{{ old('code') }}" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Discount Type</label>
                                <select class="form-control" name="discount_type">
                                    <option value="percent">Percent</option>
                                    <option value="fixed">Fixed</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Discount Value (%) or ₹</label>
                                <input type="number" class="form-control" name="discount_value" value="{{ old('discount_value') }}" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Start Date</label>
                                <input type="datetime-local" class="form-control" name="start_date" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">End Date</label>
                                <input type="datetime-local" class="form-control" name="end_date" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Status</label>
                                <select class="form-control" name="status">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary text-white">Submit</button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>

            {{-- Coupons Listing --}}
            <div class="col-md-12 mt-3">

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">List of Coupons</h4>
                    </div>

                    <div class="card-body">

                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Code</th>
                                    <th>Discount</th>
                                    <th>Start</th>
                                    <th>End</th>
                                    <th>Status</th>
                                    <th>Operation</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($coupons as $key => $coupon)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $coupon->code }}</td>

                                        <td>
                                            @if($coupon->discount_type == 'percent')
                                                {{ $coupon->discount_value }}%
                                            @else
                                                ₹{{ $coupon->discount_value }}
                                            @endif
                                        </td>

                                        <td>{{ $coupon->start_date }}</td>
                                        <td>{{ $coupon->end_date }}</td>

                                        <td>
                                            @if ($coupon->status == 1)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-warning">Inactive</span>
                                            @endif
                                        </td>

                                        <td>
                                            <div class="d-flex">

                                                {{-- Delete --}}
                                                <button class="btn btn-danger m-1 delete" data-id="{{ $coupon->id }}">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>

                                                {{-- Edit Button --}}
                                                <button class="btn btn-primary m-1" data-bs-toggle="modal"
                                                    data-bs-target="#modal{{ $coupon->id }}">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </button>

                                                {{-- Edit Modal --}}
                                                <div class="modal fade" id="modal{{ $coupon->id }}">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">

                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Update Coupon</h5>
                                                                <button type="button" class="btn btn-sm btn-label-danger btn-icon"
                                                                    data-bs-dismiss="modal">
                                                                    <i class="mdi mdi-close"></i>
                                                                </button>
                                                            </div>

                                                            <div class="modal-body">

                                                                <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST">
                                                                    @csrf
                                                                    @method('PUT')

                                                                    <label class="form-label">Coupon Code</label>
                                                                    <input type="text" class="form-control" name="code"
                                                                        value="{{ $coupon->code }}" required>

                                                                    <label class="form-label mt-2">Discount Type</label>
                                                                    <select class="form-control" name="discount_type">
                                                                        <option value="percent" {{ $coupon->discount_type=='percent' ? 'selected' : '' }}>Percent</option>
                                                                        <option value="fixed" {{ $coupon->discount_type=='fixed' ? 'selected' : '' }}>Fixed</option>
                                                                    </select>

                                                                    <label class="form-label mt-2">Discount Value</label>
                                                                    <input type="number" class="form-control" name="discount_value"
                                                                        value="{{ $coupon->discount_value }}" required>

                                                                    <label class="form-label mt-2">Start Date</label>
                                                                    <input type="datetime-local" class="form-control"
                                                                        name="start_date" value="{{ $coupon->start_date }}" required>

                                                                    <label class="form-label mt-2">End Date</label>
                                                                    <input type="datetime-local" class="form-control"
                                                                        name="end_date" value="{{ $coupon->end_date }}" required>

                                                                    <label class="form-label mt-2">Status</label>
                                                                    <select class="form-control" name="status">
                                                                        <option value="1" {{ $coupon->status==1 ? 'selected' : '' }}>Active</option>
                                                                        <option value="0" {{ $coupon->status==0 ? 'selected' : '' }}>Inactive</option>
                                                                    </select>

                                                                    <div class="modal-footer">
                                                                        <button class="btn btn-primary">Submit</button>
                                                                        <button class="btn btn-outline-danger" type="reset">Reset</button>
                                                                    </div>

                                                                </form>

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>

                        </table>

                    </div>
                </div>

            </div>


        </div>
    </div>
</div>

@endsection

@push('styles')
    <!-- Include SweetAlert2 CSS properly -->
    <link rel="stylesheet" href="{{ asset('panel/libs/sweetalert2/sweetalert2.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('panel/libs/sweetalert2/sweetalert2.min.js') }}"></script>

<script>
    $(document).on("click", ".delete", function() {
        let id = $(this).data("id");
        Swal.fire({
            title: "Are you sure?",
            text: "This coupon will be deleted!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`{{ url('admin/coupons') }}/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }).then(response => {
                    location.reload();
                });
            }
        });
    });
</script>
@endpush
