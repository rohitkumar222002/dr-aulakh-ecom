@extends('admin.layouts.app')
@section('content')


    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
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
                        <div class="card">
                            <div class="card-header card-header-bordered justify-content-between">
                                <h3 class="card-title">My Videos</h3>
                                <button class="btn btn-dark text-white" data-bs-toggle="modal" data-bs-target="#modal0">Add
                                    New</button>
                            </div>

                            <div class="card-body">
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>My Videos</th>
                                            <th>Operation</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($videoLinks as $key => $Links)
                                            <tr>
                                                <th style="width:10%">
                                                    {{ ($videoLinks->currentPage() - 1) * $videoLinks->perPage() + $key + 1 }}
                                                </th>


                                                <td style="width:80%">
                                                    <iframe width="200" height="100"
                                                        src="{{ getEmbedUrl($Links->links) }}" title="YouTube video player"
                                                        frameborder="0"
                                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                        referrerpolicy="strict-origin-when-cross-origin"
                                                        allowfullscreen></iframe>


                                                </td>
                                                <td style="width:10%">
                                                    <div class="d-flex">

                                                        <button class="btn btn-danger m-1 delete" id="swal-7"
                                                            data-id="{{ $Links->id }}"> <i class="fas fa-trash-alt"></i>
                                                        </button>

                                                        <button class="btn btn-primary m-1 update" id="swal-10"
                                                            data-id="{{ $Links->id }}"><i
                                                                class="fas fa-pencil-alt"></i></button>

                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-end">
                                {{ $videoLinks->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modal0">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">My Videos</h5>
                    <button type="button" class="btn btn-sm btn-label-danger btn-icon" data-bs-dismiss="modal">
                        <i class="mdi mdi-close"></i>
                    </button>


                </div>
                <div class="modal-body">
                    <form action="{{ route('advertiser.videos') }}" method="post">
                        @csrf
                        <div>
                            <label class="form-label" for="email">YouTubeLink
                                (https://www.youtube.com/watch?v=LXb3EKWsInQ) </label>
                            <input class="form-control @error('youtubelink') is-invalid @enderror" name="youtubelink"
                                value="{{ old('youtubelink') }}" type="text" required>
                            @error('youtubelink')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary">Submit</button>
                            <button class="btn btn-outline-danger">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <!-- Include SweetAlert2 CSS properly -->
    <link rel="stylesheet" href="{{ asset('panel/libs/sweetalert2/sweetalert2.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('panel/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
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
                    $.ajax({
                        url: `/admin/videos/delete/${itemId}`, // Assuming your route is like /advertiser/videos/{id}
                        method: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}" // Include CSRF token for security
                        },
                        success: function(response) {
                            Swal.fire("Deleted!", "Your item has been deleted.", "success");
                            $(`#item-${itemId}`)
                                .remove();
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        },
                        error: function(xhr, status, error) {
                            Swal.fire("Error!", "An error occurred. Please try again.",
                                "error");
                        }
                    });
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $(".update").on("click", function() {
                let itemId = $(this).data("id"); // Get the ID of the item to be updated
                Swal.fire({
                    title: "Please Enter The Link",
                    input: "text",
                    inputAttributes: {
                        autocapitalize: "off"
                    },
                    showCancelButton: true,
                    confirmButtonText: "Update",
                    showLoaderOnConfirm: true,
                    preConfirm: function(link) {
                        // Check if the input link is not empty
                        if (!link) {
                            Swal.showValidationMessage("You need to write something!");
                            return false; // Prevent further processing
                        }
                        return $.ajax({
                            url: `/admin/videos/update`, // Update with your actual route
                            method: 'POST',
                            data: {
                                youtubelink: link, // Ensure the key matches the expected parameter in your controller
                                id: itemId,
                                _token: "{{ csrf_token() }}" // Include CSRF token for security
                            },
                            dataType: 'json'
                        }).then(function(response) {
                            return response; // Passes the response to `.then` for the next step
                        }).catch(function(error) {
                            // Handle any errors from the AJAX request
                            Swal.showValidationMessage(
                                `Request failed: ${error.responseJSON.message || 'Unknown error'}`
                            );
                        });
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then(function(result) {
                    if (result.isConfirmed) {
                        // Check if the result contains a success response
                        if (result.value.success) {
                            Swal.fire({
                                title: "Link Updated!",
                                text: "The link has been successfully updated.",
                                icon: "success"
                            });
                            setTimeout(() => {
                                location.reload(); // Reload the page after a delay
                            }, 2000);
                        } else {
                            Swal.fire({
                                title: "Update Failed",
                                text: result.value.error ||
                                    "An error occurred while updating the link.",
                                icon: "error"
                            });
                        }
                    }
                });
            });
        });
    </script>
@endpush
