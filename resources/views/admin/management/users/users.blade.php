@extends('admin.layouts.app')
@section('content')
@push('styles')
<style>
    @media (max-width: 768px) {
    .card-body {
        height: 100vh !important; /* Full height on mobile */
        max-height: none !important; /* Remove max-height */
    }
}
</style>
@endpush
    <div id="layout-wrapper">
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <!--<div class="row">-->
                    <!--    <div class="col-12">-->
                    <!--        <div class="page-title-box d-flex align-items-center justify-content-between">-->
                    <!--            <h4 class="mb-sm-0">Home</h4>-->
                    <!--            <div class="page-title-right">-->
                    <!--                <ol class="breadcrumb m-0">-->
                    <!--                    <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>-->
                    <!--                    <li class="breadcrumb-item active">Users</li>-->
                    <!--                </ol>-->
                    <!--            </div>-->
                    <!--        </div>-->
                    <!--    </div>-->
                    <!--</div>-->

                    <div class="row">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <div class="col-12">
                            <div class="card">
                               
                            <div class="card-header bg-primary d-flex justify-content-between align-items-center position-sticky top-0  shadow" style="z-index: 0;">
                                <h4 class="card-title">Users Table</h4>
                                <div class="d-flex justify-content-end">
                                    <form action="{{ route('admin.users') }}" method="GET" class="d-flex justify-content-end">
                                        <input type="text" name="search" class="form-control me-2" placeholder="Search ..." value="{{ request('search') }}">
                                        <button type="submit" class="btn btn-light me-2">Search</button>
                                        <a href="{{ route('admin.users') }}" class="btn btn-danger pt-2 me-2">Reset</a>
                                    </form>
                                    <a href="{{ route('admin.download.users') }}" class="btn btn-dark pt-2">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                </div>
                            </div>

                                <div class="card-body" style="max-height: 400px; overflow-y: auto;>
                                <div class="table-responsive">
                                    <table id="datatable-row-callback"
                                        class="table table-hover table-bordered table-striped dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Phone</th>
                                                 <th>State</th>
                                                 <th>City</th>
                                                <th>Status</th>
                                                <th>Created</th>
                                                <th>Operation</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $index => $user)
                                                <tr>
                                                    <td>
                                                    {{ $index + 1 + ($users->currentPage() - 1) * $users->perPage() }}
                                                    </td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->phone }}</td>
                                         
                                                    <td>{{ $user->state }}</td>
                                                    <td>{{ $user->city }}</td>
                                                    <td>
                                                        @if ($user->status == 1)
                                                            <span class="badge bg-success">Active</span>
                                                        @else
                                                            <span class="badge bg-danger">Inactive</span>
                                                        @endif
                                                    </td>

                                                    <td>{{ $user->created_at->format('d-M-Y') }}</td>

                                                    <td>
                                                        <button class="btn btn-primary" data-bs-toggle="modal"
                                                            data-bs-target="#editUserModal{{ $user->id }}">
                                                            <i class="fas fa-pencil-alt"></i> </button>




                                                        <button type="button" class="btn btn-danger delete-btn"
                                                            data-id="{{ $user->id }}">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>

                                                        <a href="{{ route('admin.user.view', $user->id) }}" target="blank"
                                                            class="btn btn-info"><i class="fas fa-eye"></i></a>
                                                    </td>
                                                </tr>

                                                <!-- Edit Modal for each User -->
                                                <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1"
                                                    aria-labelledby="editUserModalLabel{{ $user->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="editUserModalLabel{{ $user->id }}">Edit User
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form action="{{ route('admin.users.update', $user->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-body">
                                                                    <div class="row">

                                                                        <div class="col-md-12 mb-3">
                                                                            <label for="exampleFormControlInput1"
                                                                                class="form-label">Status<span
                                                                                    class="text-danger">*</span></label>

                                                                            <select name="status" class="form-control">
                                                                                <option value="1"
                                                                                    {{ old('status', $user->status) == '1' ? 'selected' : '' }}>
                                                                                    Active</option>
                                                                                <option value="0"
                                                                                    {{ old('status', $user->status) == '0' ? 'selected' : '' }}>
                                                                                    In-Active
                                                                                </option>
                                                                            </select>

                                                                            @error('status')
                                                                                <span class="text-danger" role="alert">
                                                                                    <strong>{{ ucwords($message) }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>


                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="name{{ $user->id }}"
                                                                                class="form-label">Name</label>
                                                                            <input type="text" class="form-control"
                                                                                id="name{{ $user->id }}" name="name"
                                                                                value="{{ $user->name }}">
                                                                            @error('name')
                                                                                <div class="text-danger">{{ $message }}
                                                                                </div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="email{{ $user->id }}"
                                                                                class="form-label">Email</label>
                                                                            <input type="email" class="form-control"
                                                                                id="email{{ $user->id }}"
                                                                                name="email" value="{{ $user->email }}">
                                                                            @error('email')
                                                                                <div class="text-danger">{{ $message }}
                                                                                </div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="phone{{ $user->id }}"
                                                                                class="form-label">Phone</label>
                                                                            <input type="text" class="form-control"
                                                                                id="phone{{ $user->id }}"
                                                                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)"
                                                                                maxlength="10"
                                                                                name="phone" value="{{ $user->phone }}">
                                                                            @error('phone')
                                                                                <div class="text-danger">{{ $message }}
                                                                                </div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="phone_2{{ $user->id }}"
                                                                                class="form-label">Alternate Phone</label>
                                                                            <input type="text" class="form-control"
                                                                                id="phone_2{{ $user->id }}"
                                                                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)"
                                                                                maxlength="10"
                                                                                name="phone_2"
                                                                                value="{{ $user->phone_2 }}">
                                                                            @error('phone_2')
                                                                                <div class="text-danger">{{ $message }}
                                                                                </div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="state{{ $user->id }}"
                                                                                class="form-label">State</label>
                                                                            <input type="text" class="form-control"
                                                                                id="state{{ $user->id }}"
                                                                                name="state"
                                                                                value="{{ $user->state }}">
                                                                            @error('state')
                                                                                <div class="text-danger">{{ $message }}
                                                                                </div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="city{{ $user->id }}"
                                                                                class="form-label">City</label>
                                                                            <input type="text" class="form-control"
                                                                                id="city{{ $user->id }}"
                                                                                name="city"
                                                                                value="{{ $user->city }}">
                                                                            @error('city')
                                                                                <div class="text-danger">{{ $message }}
                                                                                </div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="zip_code{{ $user->id }}"
                                                                                class="form-label">Zip Code</label>
                                                                            <input type="text" class="form-control"
                                                                                id="zip_code{{ $user->id }}"
                                                                                name="zip_code"
                                                                                value="{{ $user->zip_code }}">
                                                                            @error('zip_code')
                                                                                <div class="text-danger">{{ $message }}
                                                                                </div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="address{{ $user->id }}"
                                                                                class="form-label">Address</label>
                                                                            <input type="text" class="form-control"
                                                                                id="address{{ $user->id }}"
                                                                                name="address"
                                                                                value="{{ $user->address }}">
                                                                            @error('address')
                                                                                <div class="text-danger">{{ $message }}
                                                                                </div>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-dark"
                                                                            data-bs-dismiss="modal">Close</button>
                                                                        <button type="submit"
                                                                            class="btn btn-success">Update</button>
                                                                    </div>
                                                                </div>

                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="d-flex justify-content-center mt-4">
                                         {{ $users->links('pagination::bootstrap-4') }} 
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div> <!-- end col -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection