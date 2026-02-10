@extends('user.layouts.app')
@section('content')
    <div id="layout-wrapper">
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <div>
                                    @php
                                        $currentHour = \Carbon\Carbon::now()->format('H');

                                        if ($currentHour < 12) {
                                            $greeting = 'Good Morning';
                                        } elseif ($currentHour < 18) {
                                            $greeting = 'Good Afternoon';
                                        } else {
                                            $greeting = 'Good Evening';
                                        }
                                    @endphp
                                    <h4 class="fs-16 fw-semibold mb-1 mb-md-2">{{ $greeting }}, <span
                                            class="text-primary">{{ auth()->user()->name }}</span></h4>
                                    <p class="text-muted mb-0">Here's what's happening with your store today.</p>
                                </div>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">User</a></li>
                                        <li class="breadcrumb-item active">Dashboard</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                   <div class="row">
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
    <div class="col-xxl-9">
        <div class="card">
            
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="d-flex justify-content-between align-content-end shadow-lg p-3">
                            <div>
                                <p class="text-muted text-truncate mb-2">Total Direct Referrals: </p>
                               <h5 class="mb-0">{{ $directCount }}</h5>

                            </div>
                           
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="d-flex justify-content-between align-content-end shadow-lg p-3">
                            <div>
                                <p class="text-muted text-truncate mb-2">Total Team: </p>
                                <h5 class="mb-0">{{ $totalDownline }}</h5>
                            </div>
                           
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="d-flex justify-content-between align-content-end shadow-lg p-3">
                            <div>
                                <p class="text-muted text-truncate mb-2">Balance</p>
                                <h5 class="mb-0">{{ auth()->user()->balance }}</h5>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div id="sales_figures"
                     data-colors='["--bs-info", "--bs-success"]'
                     class="apex-charts"
                     dir="ltr"></div>
            </div>
        </div>
    </div>
</div>

                </div>
            </div>
        </div>
    </div>
@endsection

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