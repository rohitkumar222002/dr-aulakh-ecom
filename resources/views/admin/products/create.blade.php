@extends('admin.layouts.app')
@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                @if (session()->has('message') || session()->has('error') || session()->has('success'))
                    <div class="alert {{ session()->has('error') ? 'alert-danger' : (session()->has('success') ? 'alert-success' : 'alert-warning') }}">
                        {{ session('message') ?? (session('error') ?? session('success')) }}
                    </div>
                @endif

                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header card-header-bordered justify-content-between">
                            <h3 class="card-title">Create Product</h3>
                        </div>

                        <div class="card-body">
                            <form class="row g-3" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                {{-- CATEGORY --}}
                                <div class="col-md-6">
                                    <label class="form-label">Category <span class="text-danger">*</span></label>
                                    <select name="category_id" id="category" class="form-control">
                                        <option value="">-- Select Category --</option>
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- SUBCATEGORY --}}
                                <div class="col-md-6">
                                    <label class="form-label">Subcategory</label>
                                    <select name="subcategory_id" id="subcategory" class="form-control">
                                        <option value="">-- Select Subcategory --</option>
                                    </select>
                                    @error('subcategory_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- PRODUCT NAME --}}
                                <div class="col-md-6">
                                    <label class="form-label">Product Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- PRICE --}}
                                <div class="col-md-3">
                                    <label class="form-label">Price <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="price" value="{{ old('price') }}">
                                    @error('price')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- MRP --}}
                                <div class="col-md-3">
                                    <label class="form-label">MRP</label>
                                    <input type="number" class="form-control" name="mrp" value="{{ old('mrp') }}">
                                    @error('mrp')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- DISCOUNT PRICE --}}
                                <div class="col-md-3">
                                    <label class="form-label">Discount Price</label>
                                    <input type="number" class="form-control" name="discount_price" value="{{ old('discount_price') }}">
                                    @error('discount_price')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- STOCK --}}
                                <div class="col-md-3">
                                    <label class="form-label">Stock Quantity</label>
                                    <input type="number" class="form-control" name="stock_qty" value="{{ old('stock_qty', 0) }}">
                                    @error('stock_qty')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- BADGE --}}
                                <div class="col-md-3">
                                    <label class="form-label">Badge</label>
                                    <select name="badge" class="form-control">
                                        <option value="">None</option>
                                        <option value="NEW">NEW</option>
                                        <option value="BESTSELLER">BESTSELLER</option>
                                        <option value="PREMIUM">PREMIUM</option>
                                        <option value="IMMUNITY">IMMUNITY</option>
                                    </select>
                                    @error('badge')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- PRIMARY IMAGE --}}
                                <div class="col-md-6">
                                    <label class="form-label">Primary Image</label>
                                     <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="false">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">Browse</div>
                                </div>
                                <div class="form-control file-amount">Choose File</div>
                                <input type="hidden" name="primary_image" value="{{ old('primary_image') }}"
                                    class="selected-files">
                            </div>
                            <div class="file-preview box sm"></div>
                                    @error('primary_image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- MULTIPLE IMAGES --}}
                                <div class="col-md-6">
                                    <label class="form-label">Gallery Images (Multiple)</label>
                                        <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="true">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">Browse</div>
                                </div>
                                <div class="form-control file-amount">Choose File</div>
                                <input type="hidden" name="images" value="{{ old('images') }}"
                                    class="selected-files">
                            </div>
                            <div class="file-preview box sm"></div>
                                    @error('images')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- DESCRIPTION --}}
                                <div class="col-md-12">
                                    <label class="form-label">Short Description</label>
                                    <textarea class="form-control" name="short_description" rows="3">{{ old('short_description') }}</textarea>
                                    @error('short_description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- STATUS --}}
                                <div class="col-md-3">
                                    <label class="form-label">Status</label>
                                    <select name="is_active" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                    @error('is_active')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12 mt-3">
                                    <button type="submit" class="btn btn-primary text-white">Save Product</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

@endsection
@push('styles')
    <link rel="stylesheet" href="{{ asset('panel/libs/sweetalert2/sweetalert2.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('panel/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        $(document).on("click", ".delete", function() {
            let itemId = $(this).data("id");
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`{{ url('admin/product/delete') }}/${itemId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector(
                                'meta[name="csrf-token"]').getAttribute(
                                'content')
                        }
                    }).then(response => {
                        if (!response.ok) {
                            throw new Error(response.statusText);
                        }
                        return response.json();
                    }).then(data => {
                        Swal.fire('Deleted!',
                            ` Record has been deleted.`,
                            'success').then(() => {
                            location.reload();
                        });
                    }).catch(error => {
                        Swal.fire('Oops...', 'Something went wrong!',
                            'error');
                    });
                }
            });
        });
    </script>
@endpush
