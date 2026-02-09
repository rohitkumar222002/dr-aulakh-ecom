@extends('admin.layouts.app')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                @if (session()->has('message') || session()->has('error') || session()->has('success'))
                <div
                    class="alert {{ session()->has('error') ? 'alert-danger' : (session()->has('success') ? 'alert-success' : 'alert-warning') }}">
                    {{ session('message') ?? (session('error') ?? session('success')) }}
                </div>
                @endif

                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4 class="card-title">Articles</h4>
                            <a href="{{ route('admin.articles.create') }}" class="btn btn-dark "><i class="fas fa-plus"></i> Add New</a>
                        </div>

                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Thumbnail</th>
                                        <th>Title</th>
                                        <th>Status</th>
                                        <th>Operation</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($articles as $i => $a)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>

                                        <td>
                                            @if($a->thumbnail)
                                            <img src="{{ uploaded_asset($a->thumbnail) }}" height="60">
                                            @else
                                            —
                                            @endif
                                        </td>

                                        <td>{{ $a->title }}</td>

                                        <td>
                                            @if($a->is_active)
                                            <span class="badge bg-success">Active</span>
                                            @else
                                            <span class="badge bg-danger">Draft</span>
                                            @endif
                                        </td>

                                        <td>
                                            <a href="{{ route('admin.articles.edit', $a->id) }}"
                                                class="btn btn-primary btn-sm">
                                                Edit
                                            </a>

                                            <button class="btn btn-danger btn-sm delete" data-id="{{ $a->id }}">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>

                            </table>

                            {{ $articles->links("pagination::bootstrap-5") }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>
    @endsection