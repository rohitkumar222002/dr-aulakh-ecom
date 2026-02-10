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
                <form class="row g-3" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-header card-header-bordered justify-content-between">
                                <h3 class="card-title">Create Product</h3>
                            </div>

                            <div class="card-body">
                                

                                {{-- CATEGORY --}}
                                <div class="col-md-12">
                                    <label class="form-label">Category <span class="text-danger">*</span></label>
                                    <select name="category_id" id="category" class="form-control">
                                        <option value="">-- Select Category --</option>
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- SUBCATEGORY --}}
                                <div class="col-md-12">
                                    <label class="form-label">Subcategory</label>
                                    <select name="subcategory_id" id="subcategory" class="form-control">
                                        <option value="">-- Select Subcategory --</option>
                                    </select>
                                    @error('subcategory_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- PRODUCT NAME --}}
                                <div class="col-md-12">
                                    <label class="form-label">Product Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- STOCK --}}
                                <div class="col-md-12">
                                    <label class="form-label">Stock Quantity</label>
                                    <input type="number" class="form-control" name="stock_qty" value="{{ old('stock_qty', 0) }}">
                                    @error('stock_qty')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- BADGE --}}
                                <div class="col-md-12">
                                    <label class="form-label">Badge</label>
                                    <select name="badge" class="form-control">
                                        <option value="">None</option>
                                        <option value="NEW" {{ old('badge') == 'NEW' ? 'selected' : '' }}>NEW</option>
                                        <option value="BESTSELLER" {{ old('badge') == 'BESTSELLER' ? 'selected' : '' }}>BESTSELLER</option>
                                        <option value="PREMIUM" {{ old('badge') == 'PREMIUM' ? 'selected' : '' }}>PREMIUM</option>
                                        <option value="IMMUNITY" {{ old('badge') == 'IMMUNITY' ? 'selected' : '' }}>IMMUNITY</option>
                                    </select>
                                    @error('badge')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- PRIMARY IMAGE --}}
                                <div class="col-md-12">
                                    <label class="form-label">Primary Image</label>
                                    <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="false">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-soft-secondary font-weight-medium">Browse</div>
                                        </div>
                                        <div class="form-control file-amount">Choose File</div>
                                        <input type="hidden" name="primary_image" value="{{ old('primary_image') }}" class="selected-files">
                                    </div>
                                    <div class="file-preview box sm"></div>
                                    @error('primary_image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- MULTIPLE IMAGES --}}
                                <div class="col-md-12">
                                    <label class="form-label">Gallery Images (Multiple)</label>
                                    <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="true">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-soft-secondary font-weight-medium">Browse</div>
                                        </div>
                                        <div class="form-control file-amount">Choose File</div>
                                        <input type="hidden" name="images" value="{{ old('images') }}" class="selected-files">
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
{{-- YOUTUBE LINK --}}
<div class="col-md-12 mt-3">
    <label class="form-label">YouTube Video Link</label>
    <input type="url"
           class="form-control"
           name="youtube_link"
           placeholder="https://www.youtube.com/watch?v=xxxxxxx"
           value="{{ old('youtube_link') }}">
    @error('youtube_link')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

                                {{-- STATUS --}}
                                <div class="col-md-12">
                                    <label class="form-label">Status</label>
                                   <select name="is_active" class="form-control">
    <option value="1" {{ old('is_active', $model->is_active ?? 1) == 1 ? 'selected' : '' }}>Active</option>
    <option value="0" {{ old('is_active', $model->is_active ?? 1) == 0 ? 'selected' : '' }}>Inactive</option>
</select>

                                    @error('is_active')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                        </div>
                    </div>
                    
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-header card-header-bordered justify-content-between">
                                <h3 class="card-title">Add Price</h3>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    {{-- PRICE --}}
                                    <div class="col-md-6 mt-3">
                                        <label class="form-label">Mrp Price <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="price" id="price" value="{{ old('price') }}" step="0.01">
                                        @error('price')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- MRP (Our Cost) --}}
                                    <div class="col-md-6 mt-3">
                                        <label class="form-label">Our Cost <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="mrp" id="mrp" value="{{ old('mrp') }}" step="0.01">
                                        @error('mrp')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>  
                                    
                                    {{-- PURCHASE GST --}}
                                    <div class="col-md-6 mt-3">
                                        <label class="form-label">Purchase GST (%)</label>
                                        <input type="number" class="form-control" name="purchase_gst" id="purchase_gst" value="{{ old('purchase_gst') }}" step="0.01">
                                        @error('purchase_gst')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <small id="purchase_gst_amount" class="text-muted"></small>
                                    </div>
                                    
                                    {{-- NET COST --}}
                                    <div class="col-md-6 mt-3">
                                        <label class="form-label">Net Cost <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="net_cost" id="net_cost" value="{{ old('net_cost') }}" step="0.01" readonly>
                                        @error('net_cost')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    
                                    {{-- DISCOUNT PRICE --}}
                                    <div class="col-md-6 mt-3">
                                        <label class="form-label">Sale Price (After Discount)</label>
                                        <input type="number" class="form-control" name="discount_price" id="discount_price" value="{{ old('discount_price') }}" step="0.01">
                                        @error('discount_price')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <small id="margin_amount" class="text-primary fw-bold"></small>
                                    </div>

                                    {{-- SALE GST --}}
                                    <div class="col-md-6 mt-3">
                                        <label class="form-label">Sale GST (%)</label>
                                        <input type="number" class="form-control" name="sale_gst" id="sale_gst" value="{{ old('sale_gst') }}" step="0.01">
                                        @error('sale_gst')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <small id="sale_gst_amount" class="text-muted"></small>
                                    </div>
                                    
                                    {{-- DISTRIBUTE PERCENTAGE --}}
                                    <div class="col-md-6 mt-3">
                                        <label class="form-label">Distribute Percentage (%)</label>
                                        <input type="number" class="form-control" name="distribute" id="distribute" value="{{ old('distribute') }}" step="0.01">
                                        @error('distribute')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <small id="distribute_amount" class="text-success"></small>
                                    </div>
                                    
                                    {{-- PAYABLE GST --}}
                                    <div class="col-md-6 mt-3">
                                        <label class="form-label">Payable Gst Amount (to Gov)</label>
                                        <input type="number" class="form-control" name="payable_gst" id="payable_gst" value="{{ old('payable_gst') }}" step="0.01" readonly>
                                        @error('payable_gst')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <small id="payable_gst_note" class="text-muted"></small>
                                    </div>
                                    
                                    {{-- PROFIT AMOUNT --}}
                                    <div class="col-md-6 mt-3">
                                        <label class="form-label">Profit Amount</label>
                                        <input type="number" class="form-control" name="profit_amount" id="profit_amount" value="{{ old('profit_amount') }}" step="0.01" readonly>
                                        @error('profit_amount')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <button type="submit" class="p-2 w-100 btn btn-primary text-white">Save Product</button>
                    </div>
                </form>
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
        $(document).ready(function() {
            // ====================
            // CATEGORY-SUBCATEGORY DYNAMIC LOADING
            // ====================
            const selectedCategoryId = "{{ old('category_id') }}";
            const selectedSubcategoryId = "{{ old('subcategory_id') }}";

            // If category is preselected, load subcategories
            if (selectedCategoryId) {
                loadSubcategories(selectedCategoryId, selectedSubcategoryId);
            }

            // When category changes
            $('#category').on('change', function() {
                const categoryId = $(this).val();
                if (categoryId) {
                    loadSubcategories(categoryId);
                } else {
                    $('#subcategory').html('<option value="">-- Select Subcategory --</option>');
                }
            });

            function loadSubcategories(categoryId, preselectedSubcategoryId = null) {
                $.ajax({
                    url: `/admin/get-subcategories/${categoryId}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function(subcategories) {
                        let options = '<option value="">-- Select Subcategory --</option>';
                        $.each(subcategories, function(index, subcategory) {
                            const isSelected = preselectedSubcategoryId == subcategory.id ? 'selected' : '';
                            options += `<option value="${subcategory.id}" ${isSelected}>${subcategory.name}</option>`;
                        });
                        $('#subcategory').html(options);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading subcategories:', error);
                    }
                });
            }

            // ====================
            // PRICE CALCULATIONS
            // ====================
            let taxPurchase = 0; // Global variable for purchase GST amount
            let netCostValue = 0; // Global variable for net cost
            let discountAmount = 0; // Global variable for discount amount

            // Calculate Net Cost when Our Cost or Purchase GST changes
            $('#mrp, #purchase_gst').on('keyup', function() {
                const mrp = parseFloat($('#mrp').val()) || 0;
                const purchaseGst = parseFloat($('#purchase_gst').val()) || 0;

                // Calculate purchase GST amount
                taxPurchase = mrp * purchaseGst / 100;
                netCostValue = mrp + taxPurchase;

                // Update fields
                $('#net_cost').val(netCostValue.toFixed(2));
                $('#sale_gst').val(purchaseGst.toFixed(2));
                
                // Show purchase GST amount
                $('#purchase_gst_amount').text(`Amount: ₹${taxPurchase.toFixed(2)}`);

                // Trigger profit calculation
                calculateProfit();
            });

            // Calculate Payable GST and Profit when Sale Price, Sale GST, or Distribute changes
            $('#discount_price, #sale_gst, #distribute').on('keyup', function() {
                calculateProfit();
            });

        function calculateProfit() {
    const salePrice = parseFloat($('#discount_price').val()) || 0;
    const saleGst = parseFloat($('#sale_gst').val()) || 0;
    const distributePercentage = parseFloat($('#distribute').val()) || 0;
    const netCost = parseFloat($('#net_cost').val()) || 0;

    const saleGstAmount = salePrice * saleGst / 100;
    const payableGst = saleGstAmount - taxPurchase;
    discountAmount = salePrice * distributePercentage / 100;

    const profit = salePrice - (payableGst + netCost + discountAmount);

    $('#payable_gst').val(payableGst.toFixed(2));
    $('#profit_amount').val(profit.toFixed(2));

    $('#sale_gst_amount').text(`Amount: ₹${saleGstAmount.toFixed(2)}`);
    $('#distribute_amount').text(`Amount: ₹${discountAmount.toFixed(2)}`);
    $('#payable_gst_note').text(`Sale GST: ₹${saleGstAmount.toFixed(2)} - Purchase GST: ₹${taxPurchase.toFixed(2)}`);

    const margin = salePrice - netCost;
    $('#margin_amount').text(`Margin (Sale - Net Cost): ₹${margin.toFixed(2)}`);
}

            // Initialize calculations if old values exist
            if ("{{ old('mrp') }}" || "{{ old('purchase_gst') }}" || "{{ old('discount_price') }}") {
                // Trigger calculations for old values
                $('#mrp').trigger('keyup');
                $('#discount_price').trigger('keyup');
            }

            // ====================
            // DELETE CONFIRMATION
            // ====================
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
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        }).then(response => {
                            if (!response.ok) {
                                throw new Error(response.statusText);
                            }
                            return response.json();
                        }).then(data => {
                            Swal.fire('Deleted!', 'Record has been deleted.', 'success').then(() => {
                                location.reload();
                            });
                        }).catch(error => {
                            Swal.fire('Oops...', 'Something went wrong!', 'error');
                        });
                    }
                });
            });
        });
    </script>
@endpush