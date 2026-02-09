@extends('admin.layouts.app')
@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                @if(session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                @endif
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header card-header-bordered justify-content-between">
                            <h3 class="card-title">Add State</h3>
                        </div>
                        <div class="card-body">
                            <form class="row g-3" action="{{ route('admin.state-save') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-6">
                                    <label for="state_name" class="form-label">State Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="state_name" name="state" value="{{ old('state') }}">
                                    @error('state')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <button type="submit" name="save" class="btn btn-primary text-white">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-bordered justify-content-between" >
                            <h3 class="card-title">List Of States</h3>
                        </div>

                        <div class="card-body">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>State Name</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($states as $state)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $state->name }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <!-- Delete Button -->
                                                     <button class="btn btn-danger m-1 delete-btn" id="swal-7"
                                                            data-id="{{ $state->id }}"> <i class="fas fa-trash-alt"></i>
                                                        </button>

                                                    <!-- Edit Button -->
                                                    <button class="btn btn-primary m-1" data-bs-toggle="modal" data-bs-target="#modal{{ $state->id }}">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </button>

                                                    <!-- Modal for Editing State -->
                                                    <div class="modal fade" id="modal{{ $state->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $state->id }}" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Update State</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="{{ route('admin.state-update', $state->id) }}" method="post">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <input type="hidden" name="id" value="{{ $state->id }}">
                                                                        <div class="col-md-12">
                                                                            <label class="form-label">State Name <span class="text-danger">*</span></label>
                                                                            <input type="text" class="form-control" name="state" value="{{ $state->name }}">
                                                                        @error('state')
                                                                        <span class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                        </div>

                                                                        <div class="modal-footer">
                                                                            <button type="submit" class="btn btn-primary text-white">Update</button>
                                                                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>

                                                                            <!-- <button type="reset" class="btn btn-outline-danger">Reset</button> -->
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
                            {{ $states->links('pagination::bootstrap-5') }}
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
@endpush

@push('scripts')
    <script src="{{ asset('panel/libs/sweetalert2/sweetalert2.min.js') }}"></script>


    <script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', async function () {
                const stateId = this.getAttribute('data-id');

                const result = await Swal.fire({
                    title: 'Are you sure?',
                    text: 'You are about to delete this state. This action cannot be undone.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                });

                if (result.isConfirmed) {
                    try {
                        const response = await fetch(`{{ url('admin/state/delete') }}/${stateId}`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        });

                        const data = await response.json();

                        if (data.success) {
                            await Swal.fire('Deleted!', data.success, 'success');
                            location.reload();
                        } else {
                            Swal.fire('Oops...', data.error || 'Something went wrong!', 'error');
                        }
                    } catch (error) {
                        Swal.fire('Oops...', 'Something went wrong!', 'error');
                    }
                }
            });
        });
    });
</script>
@endpush
