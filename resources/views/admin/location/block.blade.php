@extends('admin.layouts.app')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header card-header-bordered justify-content-between">

                                <h3 class="card-title">Add City</h3>
                            </div>
                            <div class="card-body">
                                <form class="row g-3" action="{{ route('admin.block-save') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-md-6">
                                        <label for="state_id" class="form-label">Select State <span
                                                class="text-danger">*</span></label>
                                        <select class="form-control" name="state_id" id="select2-1">
                                            <option value="">Select State</option>
                                            @foreach ($states as $state)
                                                <option value="{{ $state->id }}"
                                                    {{ old('state_id') == $state->id ? 'selected' : '' }}>
                                                    {{ $state->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('state_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="city_id" class="form-label">Select District <span
                                                class="text-danger">*</span></label>
                                        <select class="form-control" name="city_id" id="select2-2">
                                            <option value="">Select District</option>
                                            @foreach ($cities as $city)
                                                <option value="{{ $city->id }}"
                                                    {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                                    {{ $city->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('city_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="blockName" class="form-label">City Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="blockName" name="block_name"
                                            value="{{ old('block_name') }}">
                                        @error('block_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary text-white">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-bordered justify-content-between">
                                <h3 class="card-title">List of Blocks</h3>
                            </div>

                            <div class="card-body">
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>State</th>
                                            <th>District</th>
                                            <th>City</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($blocks as $block)
                                            <tr>
                                                <td>{{ $block->id }}</td>
                                                <td>{{ $block->state->name }}</td>
                                                <td>{{ $block->city->name }}</td>
                                                <td>{{ $block->name }}</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <button class="btn btn-danger m-1 delete-btn" id="swal-7"
                                                            data-id="{{ $block->id }}"> <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                        <button class="btn btn-primary m-1" data-bs-toggle="modal"
                                                            data-bs-target="#modal{{ $block->id }}">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </button>

                                                    </div>

                                                    <!-- Update Modal -->
                                                    <div class="modal fade" id="modal{{ $block->id }}" tabindex="-1"
                                                        role="dialog" aria-labelledby="modalLabel{{ $block->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="modalLabel{{ $block->id }}">Update City
                                                                    </h5>

                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form
                                                                        action="{{ route('admin.block-update', $block->id) }}"
                                                                        method="post">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <div class="col-md-12">
                                                                            <label for="state_id" class="form-label">Select
                                                                                State <span
                                                                                    class="text-danger">*</span></label>
                                                                            <select class="form-control" name="state_id"
                                                                                id="">
                                                                                <option value="">Select State</option>
                                                                                @foreach ($states as $state)
                                                                                    <option value="{{ $state->id }}"
                                                                                        {{ $block->state_id == $state->id ? 'selected' : '' }}>
                                                                                        {{ $state->name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>

                                                                        <div class="col-md-12 mt-2">
                                                                            <label for="city_id" class="form-label">Select
                                                                                District <span
                                                                                    class="text-danger">*</span></label>
                                                                            <select class="form-control" name="city_id"
                                                                                id="">
                                                                                <option value="">Select District
                                                                                </option>
                                                                                @foreach ($cities as $city)
                                                                                    <option value="{{ $city->id }}"
                                                                                        {{ $block->city_id == $city->id ? 'selected' : '' }}>
                                                                                        {{ $city->name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>

                                                                        <div class="col-md-12 mt-2">
                                                                            <label for="blockName" class="form-label">City
                                                                                Name <span
                                                                                    class="text-danger">*</span></label>
                                                                            <input type="text" class="form-control"
                                                                                name="block_name"
                                                                                value="{{ $block->name }}">
                                                                        </div>

                                                                        <div class="modal-footer">
                                                                            <button type="submit"
                                                                                class="btn btn-primary text-white">Update</button>
                                                                            <button type="button"
                                                                                class="btn btn-outline-danger"
                                                                                data-bs-dismiss="modal">Cancel</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End Update Modal -->
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-end">
                                {{ $blocks->links('pagination::bootstrap-5') }}

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
    <link href="{{ asset('panel/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
    <style>
        .select2-container .selection .select2-selection--single {
            background-color: white !important;
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('panel/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('panel/js/pages/form-select2.init.js') }}"></script>
    <script src="{{ asset('panel/libs/select2/js/select2.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', async function() {
                    const blockId = this.getAttribute('data-id');

                    const result = await Swal.fire({
                        title: 'Are you sure?',
                        text: 'You are about to delete . This action cannot be undone.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!',
                    });

                    if (result.isConfirmed) {
                        try {
                            const response = await fetch(
                                `{{ url('admin/city/delete') }}/${blockId}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]').getAttribute(
                                            'content')
                                    }
                                });

                            if (!response.ok) throw new Error('Failed to delete');

                            await Swal.fire('Deleted!', 'city has been deleted.', 'success');
                            location.reload();
                        } catch (error) {
                            Swal.fire('Oops...', 'Something went wrong!', 'error');
                        }
                    }
                });
            });
        });
    </script>
@endpush
