@extends('advertisers.layouts.app')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">

                    @if ($errors->any() || session()->has('message') || session()->has('error') || session()->has('success'))
                        <div
                            class="alert {{ $errors->any() ? 'alert-danger' : (session()->has('error') ? 'alert-danger' : (session()->has('success') ? 'alert-success' : 'alert-warning')) }}">
                            <ul>
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
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header card-header-bordered">
                                <h3 class="card-title">Social Links</h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ route($social ? 'advertiser.social.update' : 'advertiser.social') }}"
                                    method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ old('id', $social?->id) }}">

                                    <div class="d-grid gap-3">
                                        <div class="input-group">
                                            <span class="input-group-text">Facebook</span>
                                            <input type="text"
                                                class="form-control @error('facebook') is-invalid @enderror"
                                                value="{{ old('facebook', $social?->facebook) }}" name="facebook"
                                                placeholder="https://example.me" required="">

                                        </div>
                                        @error('facebook')
                                            <em class="text-danger">{{ $message }}</em>
                                        @enderror

                                        <div class="input-group">
                                            <span class="input-group-text">Instagram</span>
                                            <input type="text"
                                                class="form-control @error('instagram') is-invalid @enderror"
                                                value="{{ old('instagram', $social?->instagram) }}" name="instagram"
                                                placeholder="https://example.me" required="">

                                        </div>
                                        @error('instagram')
                                            <em class="text-danger">{{ $message }}</em>
                                        @enderror

                                        <div class="input-group">
                                            <span class="input-group-text">Twitter X</span>
                                            <input type="text"
                                                class="form-control @error('twitter_x') is-invalid @enderror"
                                                value="{{ old('twitter_x', $social?->twitter_x) }}" name="twitter_x"
                                                placeholder="https://example.me" required="">

                                        </div>
                                        @error('twitter_x')
                                            <em class="text-danger">{{ $message }}</em>
                                        @enderror

                                        {{-- <div class="input-group">
                                            <span class="input-group-text">Whatsapp</span>
                                            <input type="text"
                                                class="form-control @error('whatsapp') is-invalid @enderror"
                                                value="{{ old('whatsapp', $social?->whatsapp) }}" name="whatsapp"
                                                placeholder="https://example.me" required="">
                                        </div>
                                        @error('whatsapp')
                                            <em class="text-danger">{{ $message }}</em>
                                        @enderror --}}


                                        <div class="input-group">
                                            <span class="input-group-text">Linkedin</span>
                                            <input type="text"
                                                class="form-control @error('linkedin') is-invalid @enderror"
                                                value="{{ old('linkedin', $social?->linkedin) }}" name="linkedin"
                                                placeholder="https://example.me" required="">

                                        </div>
                                        @error('linkedin')
                                            <em class="text-danger">{{ $message }}</em>
                                        @enderror


                                        <div class="input-group">
                                            <span class="input-group-text">SnapChat</span>
                                            <input type="text"
                                                class="form-control @error('snapchat') is-invalid @enderror"
                                                value="{{ old('snapchat', $social?->snapchat) }}" name="snapchat"
                                                placeholder="https://example.me" required="">

                                        </div>
                                        @error('snapchat')
                                            <em class="text-danger">{{ $message }}</em>
                                        @enderror

                                        <div class="input-group">
                                            <span class="input-group-text">Pinterest</span>
                                            <input type="text"
                                                class="form-control @error('pinterest') is-invalid @enderror"
                                                value="{{ old('pinterest', $social?->pinterest) }}" name="pinterest"
                                                placeholder="https://example.me" required="">

                                        </div>
                                        @error('pinterest')
                                            <em class="text-danger">{{ $message }}</em>
                                        @enderror




                                        <div class="btn-group btn-group-lg mb-2 mt-2">
                                            <button type="submit" class="btn btn-success">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3"></div>


                </div>
            </div>
        </div>

    </div>
@endsection
