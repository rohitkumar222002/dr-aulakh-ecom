@extends('admin.layouts.app')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    @if ($errors->any() || session()->has('message') || session()->has('error') || session()->has('success'))
                        <div
                            class="alert {{ $errors->any() ? 'alert-danger' : (session()->has('error') ? 'alert-danger' : (session()->has('success') ? 'alert-success' : 'alert-warning')) }}">
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
                                <h3 class="card-title">Subcategories</h3>
                            </div>
                            <div class="card-body">
                                <form class="row g-3" action="{{ route('admin.subcategories.store') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-md-6">
                                        <label class="form-label">Category <span class="text-danger">*</span></label>
                                        <select name="category_id" id="category" class="form-control">
                                            <option value="">-- Select Category --</option>
                                            @foreach ($categories as $cat)
                                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                                    {{ $cat->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Subcategory Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ old('name') }}" />
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="inputGroupSelect01">Status</label>
                                        <div class="input-group">
                                            <select class="form-select form-control" name="is_active" id="inputGroupSelect01">
                                                <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Publish
                                                </option>
                                                <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Draft
                                                </option>
                                            </select>
                                        </div>
                                        @error('is_active')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group ">
                                            <label for="signinSrEmail">Select The Image </label>
                                            <div class="input-group" data-toggle="aizuploader" data-type="image"
                                                data-multiple="false">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                        Browse
                                                    </div>
                                                </div>
                                                <div class="form-control file-amount">Choose File</div>
                                                <input type="hidden" name="image" value="{{ old('image') }}"
                                                    class="selected-files">
                                            </div>
                                            <div class="file-preview box sm">
                                            </div>
                                            @error('image')
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ ucwords($message) }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary text-white">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Subcategories</h4>
                            </div>
                            <div class="card-body">
                                <table id="datatable-row-callback"
                                    class="table table-hover table-bordered table-striped dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spapse: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Category Name</th>
                                            <th>Subcategory Name</th>
                                            <th>Image</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($subcategories as $key => $subcategory)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    {{ $subcategory->category->name ?? 'N/A' }}
                                                </td>
                                                <td>{{ $subcategory->name }}</td>
                                                <td>
                                                    @if ($subcategory->image)
                                                        <img src="{{ uploaded_asset($subcategory->image) }}" height="50px"
                                                            width="50px" alt="Subcategory Image" class="rounded">
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($subcategory->is_active == 1)
                                                        <span class="badge bg-success">Publish</span>
                                                    @else
                                                        <span class="badge bg-warning">Draft</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex">
                                                        <button class="btn btn-danger m-1 delete" 
                                                            data-id="{{ $subcategory->id }}">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>

                                                        <button class="btn btn-primary m-1" data-bs-toggle="modal"
                                                            data-bs-target="#modal{{ $subcategory->id }}">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </button>

                                                        <!-- Modal -->
                                                        <div class="modal fade" id="modal{{ $subcategory->id }}">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Update Subcategory</h5>
                                                                        <button type="button"
                                                                            class="btn btn-sm btn-label-danger btn-icon"
                                                                            data-bs-dismiss="modal">
                                                                            <i class="mdi mdi-close"></i>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form action="{{ route('admin.subcategories.update', $subcategory->id) }}"
                                                                            method="post">
                                                                            @csrf
                                                                            @method('put')
                                                                            <div class="mb-3">
                                                                                <label class="form-label">Category</label>
                                                                                <select name="category_id" class="form-control">
                                                                                    <option value="">-- Select Category --</option>
                                                                                    @foreach ($categories as $cat)
                                                                                        <option value="{{ $cat->id }}"
                                                                                            {{ $subcategory->category_id == $cat->id ? 'selected' : '' }}>
                                                                                            {{ $cat->name }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                                @error('category_id')
                                                                                    <span class="text-danger">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>

                                                                            <div class="mb-3">
                                                                                <label class="form-label">Subcategory Name <span class="text-danger">*</span></label>
                                                                                <input type="text" class="form-control"
                                                                                    name="name" value="{{ old('name', $subcategory->name) }}" />
                                                                                @error('name')
                                                                                    <span class="text-danger">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>

                                                                            <div class="form-group mb-3">
                                                                                <label>Select The Image</label>
                                                                                <div class="input-group"
                                                                                    data-toggle="aizuploader"
                                                                                    data-type="image"
                                                                                    data-multiple="false">
                                                                                    <div class="input-group-prepend">
                                                                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                                                            Browse
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-control file-amount">
                                                                                        Choose File
                                                                                    </div>
                                                                                    <input type="hidden"
                                                                                        name="image"
                                                                                        value="{{ old('image', $subcategory->image) }}"
                                                                                        class="selected-files">
                                                                                </div>
                                                                                <div class="file-preview box sm">
                                                                                    @if($subcategory->image)
                                                                                        <img src="{{ uploaded_asset($subcategory->image) }}" height="50px" class="mt-2">
                                                                                    @endif
                                                                                </div>
                                                                                @error('image')
                                                                                    <span class="text-danger" role="alert">
                                                                                        <strong>{{ ucwords($message) }}</strong>
                                                                                    </span>
                                                                                @enderror
                                                                            </div>

                                                                            <div class="mb-3">
                                                                                <label class="form-label">Status</label>
                                                                                <select class="form-select form-control"
                                                                                    name="is_active">
                                                                                    <option value="1"
                                                                                        {{ old('is_active', $subcategory->is_active) == '1' ? 'selected' : '' }}>
                                                                                        Publish
                                                                                    </option>
                                                                                    <option value="0"
                                                                                        {{ old('is_active', $subcategory->is_active) == '0' ? 'selected' : '' }}>
                                                                                        Draft
                                                                                    </option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="submit" class="btn btn-primary">Update</button>
                                                                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
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
                            <div class="d-flex justify-content-end">
                                @if(method_exists($subcategories, 'links'))
                                    {{ $subcategories->links('pagination::bootstrap-5') }}
                                @endif
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
    <!-- AIZ Uploader Script (if needed) -->
    @if(file_exists(public_path('panel/assets/js/aiz-uploader.js')))
        <script src="{{ asset('panel/assets/js/aiz-uploader.js') }}"></script>
    @endif

    <script>
        $(document).ready(function() {
            // Initialize AIZ Uploader if exists
            if (typeof AIZUploader !== 'undefined') {
                AIZUploader.init();
            }

            // Delete functionality
            $(document).on("click", ".delete", function(e) {
                e.preventDefault();
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
                        $.ajax({
                            url: `{{ url('admin/subcategories') }}/${itemId}`,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire('Deleted!', 'Subcategory has been deleted.', 'success')
                                    .then(() => {
                                        location.reload();
                                    });
                            },
                            error: function(xhr) {
                                Swal.fire('Oops...', 'Something went wrong!', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush