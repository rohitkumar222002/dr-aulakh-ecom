@extends('admin.layouts.app')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                @if (session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                @endif
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header card-header-bordered justify-content-between">
                                <h3 class="card-title">Add District</h3>
                            </div>
                            <div class="card-body">
                                <form class="row g-3" action="{{ route('admin.city-save') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-md-6">
                                        <label for="state_id" class="form-label">Select State<span
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
                                        <label for="city" class="form-label">District Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="city" name="city"
                                            value="{{ old('city') }}">
                                        @error('city')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" name="save"
                                            class="btn btn-primary text-white">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-bordered justify-content-between">
                                <h3 class="card-title">List Of Districts</h3>
                            </div>

                            <div class="card-body">
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>State Name</th>
                                            <th>District Name</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cities as $city)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $city->state->name }}</td>
                                                <td>{{ $city->name }}</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <!-- Delete Button -->
                                                        <button class="btn btn-danger m-1 delete-btn" id="swal-7"
                                                            data-id="{{ $city->id }}"> <i class="fas fa-trash-alt"></i>
                                                        </button>

                                                        <!-- Edit Button -->
                                                        <button class="btn btn-primary m-1" data-bs-toggle="modal"
                                                            data-bs-target="#modal{{ $city->id }}">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </button>

                                                        <!-- Modal for Editing City -->
                                                        <div class="modal fade" id="modal{{ $city->id }}"
                                                            tabindex="-1" aria-labelledby="modalLabel{{ $city->id }}"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Update District</h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form
                                                                            action="{{ route('admin.city-update', $city->id) }}"
                                                                            method="post">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <input type="hidden" name="id"
                                                                                value="{{ $city->id }}">

                                                                            <!-- State Selection -->
                                                                            <div class="col-md-12">
                                                                                <label class="form-label mt-2">State <span
                                                                                        class="text-danger">*</span></label>
                                                                                <select class="form-control" id="select2-2"
                                                                                    name="state_id">
                                                                                    <option value="">Select State
                                                                                    </option>
                                                                                    @foreach ($states as $state)
                                                                                        <option value="{{ $state->id }}"
                                                                                            {{ $city->state_id == $state->id ? 'selected' : '' }}>
                                                                                            {{ $state->name }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                                @error('state_id')
                                                                                    <span
                                                                                        class="text-danger">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>

                                                                            <!-- City Name Input -->
                                                                            <div class="col-md-12">
                                                                                <label class="form-label mt-2">District Name
                                                                                    <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input type="text" class="form-control"
                                                                                    name="city"
                                                                                    value="{{ $city->name }}">
                                                                                @error('city')
                                                                                    <span
                                                                                        class="text-danger">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>

                                                                            <!-- Submit Button -->
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

                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <!-- Pagination Links (if available) -->
                                <div class="d-flex justify-content-end mt-3">
                                    {{ $cities->links('pagination::bootstrap-5') }}
                                </div>
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
@endpush

@push('scripts')
    <script src="{{ asset('panel/js/pages/form-select2.init.js') }}"></script>
    <script src="{{ asset('panel/libs/select2/js/select2.min.js') }}"></script>

    <script src="{{ asset('panel/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', async function() {
                    const cityId = this.getAttribute('data-id');

                    const result = await Swal.fire({
                        title: 'Are you sure?',
                        text: 'You are about to delete this district. This action cannot be undone.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!',
                    });

                    if (result.isConfirmed) {
                        try {
                            const response = await fetch(
                                `{{ url('admin/district/delete') }}/${cityId}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]').getAttribute(
                                            'content')
                                    }
                                });

                            const responseData = await response.json();

                            if (response.ok && responseData.success) {
                                await Swal.fire('Deleted!', 'District has been deleted.',
                                    'success');
                                location.reload();
                            } else {
                                throw new Error(responseData.error || 'Failed to delete.');
                            }
                        } catch (error) {
                            Swal.fire('Oops...', error.message || 'City not deleted.', 'error');
                        }
                    }
                });
            });
        });
    </script>
@endpush
