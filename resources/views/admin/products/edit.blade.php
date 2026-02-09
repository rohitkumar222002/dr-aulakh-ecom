@extends('admin.layouts.app')

@section('content')
<div id="layout-wrapper">
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-xl-12">

                        <div class="card">
                            <div class="card-header card-header-bordered justify-content-between">
                                <h3 class="card-title">Edit Product</h3>
                                <a href="{{ route('admin.products.index') }}" class="btn btn-dark text-white">
                                    Back to Products
                                </a>
                            </div>

                            <div class="card-body">

                                <form class="row g-3"
                                      action="{{ route('admin.products.update', $product->id) }}"
                                      method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    {{-- CATEGORY --}}
                                    <div class="col-md-6">
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
                                    <div class="col-md-6">
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
                                    <div class="col-md-6">
                                        <label class="form-label">Product Name</label>
                                        <input type="text" name="name" value="{{ $product->name }}" class="form-control">
                                    </div>

                                    {{-- PRICE --}}
                                    <div class="col-md-4">
                                        <label class="form-label">Price</label>
                                        <input type="number" name="price" value="{{ $product->price }}" class="form-control">
                                    </div>

                                    {{-- DISCOUNT PRICE --}}
                                    <div class="col-md-4">
                                        <label class="form-label">Discount Price</label>
                                        <input type="number" name="discount_price"
                                               value="{{ $product->discount_price }}" class="form-control">
                                    </div>

                                    {{-- MRP --}}
                                    <div class="col-md-4">
                                        <label class="form-label">MRP</label>
                                        <input type="number" name="mrp" value="{{ $product->mrp }}" class="form-control">
                                    </div>

                                    {{-- STOCK --}}
                                    <div class="col-md-4">
                                        <label class="form-label">Stock Quantity</label>
                                        <input type="number" name="stock_qty"
                                               value="{{ $product->stock_qty }}" class="form-control">
                                    </div>

                                    {{-- BADGE --}}
                                    <div class="col-md-4">
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
                                    <div class="col-md-4">
                                        <label class="form-label">Status</label>
                                        <select name="is_active" class="form-control">
                                            <option value="1" {{ $product->is_active ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ !$product->is_active ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>

                                    {{-- PRIMARY IMAGE --}}
                                    <div class="col-md-12">
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
                                    <div class="col-md-12">
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

                                    <div class="col-12 mt-3">
                                        <button type="submit" class="btn btn-success">Update Product</button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
