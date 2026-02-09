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
                                    <h3 class="card-title">Sliders</h3>
                                    <button class="btn btn-dark text-white" data-bs-toggle="modal"
                                        data-bs-target="#addSliderModal">Add New Slider</button>
                                </div>

                                <div class="card-body">
                                    <table class="table mb-0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Images((1500*350))</th>
                                                <th>Link</th>
                                                <th>Status</th>
                                                <th>Operation</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($sliders as $index => $slider)
                                                <tr>
                                                    <td>
                                                        {{ ($sliders->currentPage() - 1) * $sliders->perPage() + $index + 1 }}

                                                    <td>
                                                        <img src="{{ uploaded_asset($slider->images) }}" height="100px"
                                                            width="100px!important" alt="Slider Image" class="rounded">
                                                    </td>
                                                    <td>
                                                        {{ $slider->link }}
                                                    </td>
                                                    <td>
                                                        @if ($slider->status == 1)
                                                            <span class="badge bg-success">Publish</span>
                                                        @else
                                                            <span class="badge bg-warning">Draft</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-primary edit-btn" data-bs-toggle="modal"
                                                            data-bs-target="#editSliderModal{{ $slider->id }}">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-danger delete-btn"
                                                            data-id="{{ $slider->id }}">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>

                                                        <!-- Modal for Editing Slider -->
                                                        <div class="modal fade" id="editSliderModal{{ $slider->id }}"
                                                            tabindex="-1" aria-labelledby="editSliderModalLabel"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="editSliderModalLabel">
                                                                            Edit Slider</h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <form action="{{ route('admin.slider.update') }}"
                                                                        method="POST" enctype="multipart/form-data">
                                                                        @csrf
                                                                        <input type="hidden" name="id"
                                                                            value="{{ $slider->id }}">
                                                                        <div class="modal-body">

                                                                            <div class="mb3">
                                                                                <label class="form-group-text mb-0"
                                                                                    for="inputGroupSelect01">Status</label>

                                                                                <div class="input-group">
                                                                                    <select class="form-select form-control"
                                                                                        name="status"
                                                                                        id="inputGroupSelect01">
                                                                                        <option value="1"
                                                                                            {{ old('status', $slider->status) == '1' ? 'selected' : '' }}>
                                                                                            Publish
                                                                                        </option>
                                                                                        <option value="0"
                                                                                            {{ old('status', $slider->status) == '0' ? 'selected' : '' }}>
                                                                                            Draft
                                                                                        </option>
                                                                                    </select>

                                                                                </div>

                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label>Link</label>
                                                                                <div class="input-group">
                                                                                    <input type="text" name="slider_link"
                                                                                        value="{{ $slider->link }}"
                                                                                        class="form-control">
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label>Select The Slider Image</label>
                                                                                <div class="input-group"
                                                                                    data-toggle="aizuploader"
                                                                                    data-type="image">
                                                                                    <div class="input-group-prepend">
                                                                                        <div
                                                                                            class="input-group-text bg-soft-secondary font-weight-medium">
                                                                                            Browse</div>
                                                                                    </div>
                                                                                    <div class="form-control file-amount">
                                                                                        Choose File</div>
                                                                                    <input type="hidden" name="images"
                                                                                        value="{{ $slider->images }}"
                                                                                        class="selected-files">
                                                                                </div>
                                                                                <div class="file-preview box sm"></div>
                                                                                @error('images')
                                                                                    <div class="text-danger">
                                                                                        {{ $message }}
                                                                                    </div>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-dark"
                                                                                data-bs-dismiss="modal">Close</button>
                                                                            <button type="submit"
                                                                                class="btn btn-success">Save
                                                                                Changes</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Adding Slider -->
    <div class="modal fade" id="addSliderModal" tabindex="-1" aria-labelledby="addSliderModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSliderModalLabel">Add New Slider</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.slider') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-group-text mb-0" for="inputGroupSelect01">Status</label>

                            <div class="input-group">
                                <select class="form-select form-control" name="status" id="inputGroupSelect01">

                                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Publish
                                    </option>
                                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Draft
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>Link</label>
                            <div class="input-group">
                                <input type="text" name="slider_link" value="{{ old('slider_link') }}"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>Select The Slider Image</label>
                            <div class="input-group" data-toggle="aizuploader" data-type="image">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">Browse</div>
                                </div>
                                <div class="form-control file-amount">Choose File</div>
                                <input type="hidden" name="image" value="{{ old('image') }}"
                                    class="selected-files">
                            </div>
                            <div class="file-preview box sm"></div>
                            @error('image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Add Slider</button>
                    </div>
                </form>
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
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', async function() {
                    const sliderId = this.getAttribute('data-id');

                    const result = await Swal.fire({
                        title: 'Are you sure?',
                        text: 'You are about to delete the slider. This action cannot be undone.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!',
                    });

                    if (result.isConfirmed) {
                        try {
                            const response = await fetch(
                                `{{ url('admin/slider/delete') }}/${sliderId}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]').getAttribute(
                                            'content')
                                    }
                                });

                            if (!response.ok) throw new Error('Failed to delete the slider');

                            await Swal.fire('Deleted!', 'Slider has been deleted.', 'success');
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
