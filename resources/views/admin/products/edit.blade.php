@extends('admin.layouts.app')

@section('content')
<div id="layout-wrapper">
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
          <form class="row g-3"
                                      action="{{ route('admin.products.update', $product->id) }}"
                                      method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                <div class="row">
                    <div class="col-xl-6">

                        <div class="card">
                            <div class="card-header card-header-bordered justify-content-between">
                                <h3 class="card-title">Edit Product</h3>
                                <a href="{{ route('admin.products.index') }}" class="btn btn-dark text-white">
                                    Back to Products
                                </a>
                            </div>

                            <div class="card-body">

                      

                                    {{-- CATEGORY --}}
                                    <div class="col-md-12">
                                        <label class="form-label">Category</label>
                                        <select name="category_id" id="category" class="form-control">
                                            <option value="">-- Select Category --</option>

                                            @foreach ($categories as $cat)
                                                <option value="{{ $cat->id }}"
                                                    {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                                                    {{ $cat->name }}
                                                </option>
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

                                            @foreach ($subcategories as $sub)
                                                <option value="{{ $sub->id }}"
                                                    {{ $product->subcategory_id == $sub->id ? 'selected' : '' }}>
                                                    {{ $sub->name }}
                                                </option>
                                            @endforeach

                                        </select>
                                        @error('subcategory_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- PRODUCT NAME --}}
                                    <div class="col-md-12 mt-3">
                                        <label class="form-label">Product Name</label>
                                        <input type="text" name="name" value="{{ old('name', $product->name) }}" class="form-control">
                                    </div>


                                    {{-- STOCK --}}
                                    <div class="col-md-12 mt-3">
                                        <label class="form-label">Stock Quantity</label>
                                        <input type="number" name="stock_qty"
                                               value="{{ $product->stock_qty }}" class="form-control">
                                    </div>

                                    {{-- BADGE --}}
                                    <div class="col-md-12 mt-3">
                                        <label class="form-label">Badge</label>
                                        <select name="badge" class="form-control">
                                            <option value="">None</option>
                                            <option value="NEW" {{ $product->badge == 'NEW' ? 'selected' : '' }}>NEW</option>
                                            <option value="BESTSELLER" {{ $product->badge == 'BESTSELLER' ? 'selected' : '' }}>BESTSELLER</option>
                                            <option value="PREMIUM" {{ $product->badge == 'PREMIUM' ? 'selected' : '' }}>PREMIUM</option>
                                            <option value="IMMUNITY" {{ $product->badge == 'IMMUNITY' ? 'selected' : '' }}>IMMUNITY</option>
                                        </select>
                                    </div>

                                    {{-- STATUS --}}
                                    <div class="col-md-12 mt-3">
                                        <label class="form-label">Status</label>
                                        <select name="is_active" class="form-control">
                                            <option value="1" {{ $product->is_active ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ !$product->is_active ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>

                                    {{-- PRIMARY IMAGE --}}
                                    <div class="col-md-12 mt-3">
                                        <label>Select Primary Image</label>
                                        <div class="input-group" data-toggle="aizuploader" data-type="image">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                    Browse
                                                </div>
                                            </div>
                                            <div class="form-control file-amount">Choose File</div>

                                            <input type="hidden" name="primary_image"
                                                   value="{{ $product->primary_image }}"
                                                   class="selected-files">
                                        </div>

                                        <div class="file-preview box sm">
                                            <img src="{{ uploaded_asset($product->primary_image) }}" height="100">
                                        </div>

                                        @error('primary_image')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- GALLERY IMAGES --}}
                                    <div class="col-md-12 mt-3">
                                        <label>Gallery Images (Multiple)</label>

                                        <div class="input-group"
                                             data-toggle="aizuploader"
                                             data-type="image"
                                             data-multiple="true">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                    Browse
                                                </div>
                                            </div>
                                            <div class="form-control file-amount">Choose Files</div>

                                            <input type="hidden" name="images"
                                                   value="{{ $product->images }}"
                                                   class="selected-files">
                                        </div>

                                        <div class="file-preview box sm">
                                            @foreach(explode(',', $product->images ?? '') as $img)
                                                <img src="{{ uploaded_asset($img) }}" height="80" class="m-1 rounded">
                                            @endforeach
                                        </div>

                                        @error('images')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- DESCRIPTION --}}
                                    <div class="col-md-12">
                                        <label>Short Description</label>
                                        <textarea name="short_description" rows="4" class="form-control">{{ $product->short_description }}</textarea>
                                    </div>

                                    
                            </div>
                        </div>
                    </div>
                       <div class="col-xl-6">
                        <div class="card">
                            <div class="card-header card-header-bordered justify-content-between">
                                <h3 class="card-title">Edit Price</h3>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    {{-- PRICE --}}
                                    <div class="col-md-6 mt-3">
                                        <label class="form-label">Price <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="price" id="price" value="{{ old('price', $product->price) }}" step="0.01">
                                        @error('price')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- MRP (Our Cost) --}}
                                    <div class="col-md-6 mt-3">
                                        <label class="form-label">Our Cost <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="mrp" id="mrp" value="{{ old('mrp', $product->mrp) }}" step="0.01">
                                        @error('mrp')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>  
                                    
                                    {{-- PURCHASE GST --}}
                                    <div class="col-md-6 mt-3">
                                        <label class="form-label">Purchase GST (%)</label>
                                        <input type="number" class="form-control" name="purchase_gst" id="purchase_gst" value="{{ old('purchase_gst', $product->purchase_gst) }}" step="0.01">
                                        @error('purchase_gst')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <small id="purchase_gst_amount" class="text-muted"></small>
                                    </div>
                                    
                                    {{-- NET COST --}}
                                    <div class="col-md-6 mt-3">
                                        <label class="form-label">Net Cost <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="net_cost" id="net_cost" value="{{ old('net_cost', $product->net_cost) }}" step="0.01" readonly>
                                        @error('net_cost')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    
                                    {{-- DISCOUNT PRICE --}}
                                    <div class="col-md-6 mt-3">
                                        <label class="form-label">Sale Price (After Discount)</label>
                                        <input type="number" class="form-control" name="discount_price" id="discount_price" value="{{ old('discount_price', $product->discount_price) }}" step="0.01">
                                        @error('discount_price')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- SALE GST --}}
                                    <div class="col-md-6 mt-3">
                                        <label class="form-label">Sale GST (%)</label>
                                        <input type="number" class="form-control" name="sale_gst" id="sale_gst" value="{{ old('sale_gst', $product->sale_gst) }}" step="0.01">
                                        @error('sale_gst')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <small id="sale_gst_amount" class="text-muted"></small>
                                    </div>
                                    
                                    {{-- DISTRIBUTE PERCENTAGE --}}
                                    <div class="col-md-6 mt-3">
                                        <label class="form-label">Distribute Percentage (%)</label>
                                        <input type="number" class="form-control" name="distribute" id="distribute" value="{{ old('distribute', $product->distribute) }}" step="0.01">
                                        @error('distribute')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <small id="distribute_amount" class="text-success"></small>
                                    </div>
                                    
                                    {{-- PAYABLE GST --}}
                                    <div class="col-md-6 mt-3">
                                        <label class="form-label">Payable Gst Amount (to Gov)</label>
                                        <input type="number" class="form-control" name="payable_gst" id="payable_gst" value="{{ old('payable_gst', $product->payable_gst) }}" step="0.01" readonly>
                                        @error('payable_gst')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <small id="payable_gst_note" class="text-muted"></small>
                                    </div>
                                    
                                    {{-- PROFIT AMOUNT --}}
                                    <div class="col-md-6 mt-3">
                                        <label class="form-label">Profit Amount</label>
                                        <input type="number" class="form-control" name="profit_amount" id="profit_amount" value="{{ old('profit_amount', $product->profit_amount) }}" step="0.01" readonly>
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
                </div>
</form>
            </div>
        </div>
    </div>
</div>
@push('scripts')
@push('scripts')
<script>
$(document).ready(function(){

    let taxPurchase = 0;
    let netCostValue = 0;
    let discountAmount = 0;

    function calculateAll() {

        const mrp = parseFloat($('input[name="mrp"]').val()) || 0;
        const purchaseGst = parseFloat($('#purchase_gst').val()) || 0;
        const salePrice = parseFloat($('input[name="discount_price"]').val()) || 0;
        const saleGst = parseFloat($('#sale_gst').val()) || 0;
        const distribute = parseFloat($('#distribute').val()) || 0;

        taxPurchase = mrp * purchaseGst / 100;
        netCostValue = mrp + taxPurchase;

        const saleGstAmount = salePrice * saleGst / 100;
        const payableGst = saleGstAmount - taxPurchase;

        discountAmount = salePrice * distribute / 100;

        // CLIENT FORMULA
        const profit = salePrice - (payableGst + netCostValue + discountAmount);

        $('#net_cost').val(netCostValue.toFixed(2));
        $('#payable_gst').val(payableGst.toFixed(2));
        $('#profit_amount').val(profit.toFixed(2));
    }

    $('#mrp, #purchase_gst, #sale_gst, #distribute, input[name="discount_price"]')
        .on('input', function(){
            calculateAll();
        });

    calculateAll();

});
</script>
@endpush

@endpush

@endsection
