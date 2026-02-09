@extends('user.layouts.app')

@section('content')

<div id="layout-wrapper">
<div class="main-content">
<div class="page-content">
<div class="container-fluid">

<div class="card">
<div class="row">
    <div class="col-md-4">
          <div class="card-header d-flex justify-content-between">
        <h4>Total Level</h4>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <td>Level</td>
                <td>Percentage(%)</td>
            </tr>
@foreach ($levels as $level)
    <tr>
        <td>
            {{ $level->level }}
        </td>
        <td>
            {{ $level->percentage }}
        </td>
    </tr>
@endforeach
</table>
    </div>

    </div>
    <div class="col-md-8">
    <div class="card-header d-flex justify-content-between">
        <h4>Total Downline</h4>
    </div>

    <div class="card-body">

        {{-- FILTER SECTION --}}
        <form method="GET" class="row mb-3">

            <div class="col-md-3">
                <select name="level" class="form-control form-select">
                    @foreach ($levels as $i)
                        
                        <option value="{{ $i->level }}"
                            {{ $selectedLevel == $i->level ? 'selected' : '' }}>
                            Level {{ $i->level }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       class="form-control"
                       placeholder="Search by name, username, email">
            </div>

            <div class="col-md-2">
                <button class="btn p-2 btn-primary w-100">Filter</button>
            </div>

        </form>

        {{-- TABLE --}}
        @if($users->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Join Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $index => $u)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->username }}</td>
                    <td>{{ $u->email }}</td>
                    <td>{{ $u->created_at->format('d M Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
            <div class="alert alert-info">
                No users found in this level.
            </div>
        @endif

    </div>
    </div>
    </div>

</div>

</div>
</div>
</div>
</div>

@endsection
