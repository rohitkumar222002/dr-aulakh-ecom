@extends('admin.layouts.app')

@section('content')

<div class="main-content">
    <div class="page-content">
<div class="container-fluid">

    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4>Tier Plan</h4>
        </div>

        <div class="card-body">

            {{-- Success Message --}}
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- CREATE FORM --}}
            <form method="POST" action="{{ route('admin.levels.store') }}" class="row mb-4">
                @csrf

                <div class="col-md-4">
                    <input type="number" name="level" class="form-control" placeholder="Level">
                </div>

                <div class="col-md-4">
                    <input type="number" name="percentage" class="form-control" placeholder="Percentage">
                </div>

                <div class="col-md-4">
                    <button class="btn p-2 btn-primary w-100">Add Tier</button>
                </div>
            </form>

            {{-- TABLE --}}
            
                            <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Tier</th>
                        <th>Percentage</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($levels as $level)
                    <tr>
                        <td>{{ $level->level }}</td>
                        <td>{{ $level->percentage }}%</td>
                        <td>

                            {{-- EDIT BUTTON --}}
                            <button class="btn btn-warning btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#editModal{{ $level->id }}">
                                Edit
                            </button>

                            {{-- DELETE --}}
                            <form action="{{ route('admin.levels.destroy', $level->id) }}"
                                  method="POST"
                                  style="display:inline-block">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Delete this level?')">
                                    Delete
                                </button>
                            </form>

                        </td>
                    </tr>

                    {{-- EDIT MODAL --}}
                    <div class="modal fade" id="editModal{{ $level->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST"
                                      action="{{ route('admin.levels.update', $level->id) }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="modal-header">
                                        <h5>Edit Level</h5>
                                        <button type="button" class="btn-close"
                                                data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <input type="number"
                                               name="level"
                                               value="{{ $level->level }}"
                                               class="form-control mb-2">

                                        <input type="number"
                                               name="percentage"
                                               value="{{ $level->percentage }}"
                                               class="form-control">
                                    </div>

                                    <div class="modal-footer">
                                        <button class="btn btn-success">Update</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                    @endforeach
                </tbody>
            </table>

        </div>
        </div>
    </div>

</div>
</div>
</div>
@endsection
