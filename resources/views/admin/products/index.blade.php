@extends('admin.layouts.app')
@section('content')

<div id="layout-wrapper">
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">

                            <div class="card-header card-header-bordered justify-content-between">
                                <h3 class="card-title">Products</h3>
                                <a href="{{ route('admin.products.create') }}" class="btn btn-dark text-white">
                                    Add New Product
                                </a>
                            </div>

                            <div class="card-body">
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Category</th>
                                            <th>Subcategory</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                            <th>Operation</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($products as $index => $product)
                                        <tr>
                                            {{-- SERIAL NUMBER --}}
                                            <td>
                                                {{ ($products->currentPage() - 1) * $products->perPage() + $index + 1 }}
                                            </td>

                                            {{-- IMAGE --}}
                                            <td>
                                                <img src="{{ uploaded_asset($product->primary_image) }}" height="80"
                                                    width="80" class="rounded">
                                            </td>

                                            {{-- NAME --}}
                                            <td>{{ $product->name }}</td>

                                            {{-- CATEGORY --}}
                                            <td>
                                                {{ $product->category->name ?? '-' }}
                                            </td>

                                            {{-- SUBCATEGORY --}}
                                            <td>
                                                {{ $product->subcategory->name ?? '-' }}
                                            </td>

                                            {{-- PRICE --}}
                                            <td>
                                                ₹{{ $product->price }}
                                                @if($product->discount_price)
                                                <br>
                                                <small class="text-success">Now: ₹{{ $product->discount_price }}</small>
                                                @endif
                                            </td>

                                            {{-- STATUS --}}
                                            <td>
                                                @if ($product->is_active)
                                                <span class="badge bg-success">Active</span>
                                                @else
                                                <span class="badge bg-warning">Inactive</span>
                                                @endif
                                            </td>

                                            {{-- OPERATIONS --}}
                                            <td>
                                                {{-- EDIT BUTTON --}}
                                                <a class="btn btn-primary" href="{{ route('admin.products.edit', $product->id) }}"
                                                    >
                                                    <i class="fas fa-pencil-alt"></i>
</a>

                                                {{-- DELETE BUTTON --}}
                                                <button type="button" class="btn btn-danger delete-btn"
                                                    data-id="{{ $product->id }}">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>

                                                

                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>

                                </table>

                                {{-- PAGINATION --}}
                                <div class="mt-3">
                                    {{ $products->links("pagination::bootstrap-5") }}
                                </div>

                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

@endsection
