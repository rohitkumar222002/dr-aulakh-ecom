@extends('user.layouts.app')

@section('content')
<div id="layout-wrapper">
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                {{-- Alerts --}}
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card">

                    {{-- TAB HEADER --}}
                    <div class="card-header bg-primary">
                        <ul class="nav nav-tabs card-header-tabs">
                            <li class="nav-item">
                                <button class="nav-link active text-white" data-bs-toggle="tab"
                                    data-bs-target="#profileTab" type="button">Profile</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link text-white" data-bs-toggle="tab"
                                    data-bs-target="#kycTab" type="button">KYC</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link text-white" data-bs-toggle="tab"
                                    data-bs-target="#passwordTab" type="button">Change Password</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link text-white" data-bs-toggle="tab"
                                    data-bs-target="#bankTab" type="button">Bank</button>
                            </li>
                        </ul>
                    </div>

                    {{-- TAB BODY --}}
                    <div class="card-body">
                        <div class="tab-content">

                            {{-- ================= PROFILE ================= --}}
                            <div class="tab-pane fade show active" id="profileTab">
                                <form method="POST" action="{{ route('user.profileupdate') }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="row g-3">

                                        <div class="col-md-6">
                                            <label class="form-label">Full Name</label>
                                            <input type="text" name="full_name"
                                                value="{{ old('full_name', auth()->user()->name) }}"
                                                class="form-control">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Email</label>
                                            <input type="email" name="email"
                                                value="{{ old('email', auth()->user()->email) }}"
                                                class="form-control">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Phone</label>
                                            <input type="text" name="phone"
                                                value="{{ old('phone', auth()->user()->phone) }}"
                                                class="form-control">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">DOB</label>
                                            <input type="date" name="dob"
                                                value="{{ old('dob', auth()->user()->dob) }}"
                                                class="form-control">
                                        </div>

                                        {{-- STATE SELECT (FIXED) --}}
                                        <div class="col-md-4">
                                            <label class="form-label">State</label>
                                            <select name="state" class="form-select form-control">
                                                <option value="">Select State</option>
                                                @foreach($states as $state)
                                                    <option value="{{ $state->id }}"
                                                        {{ old('state', auth()->user()->state) == $state->id ? 'selected' : '' }}>
                                                        {{ $state->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">City</label>
                                            <input type="text" name="city"
                                                value="{{ old('city', auth()->user()->city) }}"
                                                class="form-control">
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">Zip Code</label>
                                            <input type="text" name="zip_code"
                                                value="{{ old('zip_code', auth()->user()->zip_code) }}"
                                                class="form-control">
                                        </div>

                                        <div class="col-md-12">
                                            <label class="form-label">Address</label>
                                            <textarea name="address" rows="3"
                                                class="form-control">{{ old('address', auth()->user()->address) }}</textarea>
                                        </div>

                                        <div class="col-md-12">
                                            <button class="btn btn-primary">Update Profile</button>
                                        </div>

                                    </div>
                                </form>
                            </div>

                            {{-- ================= KYC ================= --}}
                            <div class="tab-pane fade" id="kycTab">
                                <form method="POST" action="{{ route('user.kyc.update') }}">
                                    @csrf
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Aadhaar Number</label>
                                            <input type="text" name="aadhaar_number"
                                                value="{{ old('aadhaar_number', auth()->user()->aadhaar_number) }}"
                                                class="form-control">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">PAN Number</label>
                                            <input type="text" name="pan_number"
                                                value="{{ old('pan_number', auth()->user()->pan_number) }}"
                                                class="form-control">
                                        </div>

                                        <div class="col-md-12">
                                            <button class="btn btn-primary w-100">Submit KYC</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            {{-- ================= PASSWORD ================= --}}
                            <div class="tab-pane fade" id="passwordTab">
                                <form method="POST" action="{{ route('user.password.update') }}">
                                    @csrf
                                    <div class="row g-3">
                                       
                                        <div class="col-md-4">
                                            <input type="password" name="password" class="form-control"
                                                placeholder="New Password">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="password" name="password_confirmation" class="form-control"
                                                placeholder="Confirm Password">
                                        </div>
                                        <div class="col-md-12">
                                            <button class="btn btn-primary">Update Password</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            {{-- ================= BANK ================= --}}
                            <div class="tab-pane fade" id="bankTab">
                                <form method="POST" action="{{ route('user.bank.update') }}">
                                    @csrf
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <input type="text" name="bank_name"
                                                value="{{ old('bank_name', auth()->user()->bank_name) }}"
                                                class="form-control" placeholder="Bank Name">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" name="account_number"
                                                value="{{ old('account_number', auth()->user()->account_number) }}"
                                                class="form-control" placeholder="Account Number">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" name="ifsc_code"
                                                value="{{ old('ifsc_code', auth()->user()->ifsc_code) }}"
                                                class="form-control" placeholder="IFSC Code">
                                        </div>
                                        <div class="col-md-12">
                                            <button class="btn btn-primary">Save Bank</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
