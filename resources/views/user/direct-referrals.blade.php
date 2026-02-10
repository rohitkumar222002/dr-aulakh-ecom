@extends('user.layouts.app')

@section('content')

<div id="layout-wrapper">
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">

                            <div class="card-header card-header-bordered justify-content-between">
                                <h3 class="card-title">My  Referrals</h3>
                                <a href="{{ route('user.dashboard') }}" class="btn btn-dark text-white">
                                    Back to Dashboard
                                </a>
                            </div>

                            <div class="card-body">

                                @if($referrals->count())
                                <table class="table mb-0">
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
                                        @foreach ($referrals as $index => $ref)
                                        <tr>

                                            {{-- SERIAL NUMBER --}}
                                            <td>
                                                {{ ($referrals->currentPage() - 1) * $referrals->perPage() + $index + 1 }}
                                            </td>

                                            {{-- NAME --}}
                                            <td>{{ $ref->name }}</td>

                                            {{-- USERNAME --}}
                                            <td>{{ $ref->username }}</td>

                                            {{-- EMAIL --}}
                                            <td>{{ $ref->email }}</td>

                                            {{-- JOIN DATE --}}
                                            <td>{{ $ref->created_at->format('d M Y') }}</td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                {{-- PAGINATION --}}
                                <div class="mt-3">
                                    {{ $referrals->links("pagination::bootstrap-5") }}
                                </div>

                                @else
                                <div class="alert alert-info">
                                    No direct referrals found.
                                </div>
                                <div class="col-md-6">
                            <div class="card text-center">
                                <div class="card-header bg-primary">
                                    <h4 class="card-title text-white">Referral Link</h4>
                                </div>
                                <div class="card-body">
                                    <div class="input-group mb-3">
                                        <input type="text" id="referralLink"
                                            class="form-control text-success text-center fw-bold"
                                            value="{{ url('/register?referral=' . auth()->user()->username) }}" readonly />
                                        <button class="btn btn-primary" type="button" onclick="copyReferralLink()">
                                            Copy
                                        </button>

                                    </div>
                                </div>
                            </div>
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
@push('scripts')
    <script>
        function copyReferralLink() {
            const referralLink = document.getElementById('referralLink');
            referralLink.select();
            referralLink.setSelectionRange(0, 99999); // For mobile devices
            navigator.clipboard.writeText(referralLink.value).then(() => {
                alert('Referral link copied to clipboard!');
            });
        }
    </script>
@endpush
@endsection
