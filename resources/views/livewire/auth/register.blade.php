<div class="container">

    @section('meta_title'){{ config('app.name') }} User Register @stop
    @section('meta_keywords'){{ config('app.name') }} User Register @stop
    @section('meta_description'){{ config('app.name') }} User Register @stop
<div class="auth-wrapper">
    <div class="container">

        <!-- BREADCRUMB (HIDDEN) -->
        <nav aria-label="breadcrumb" class="d-none mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('site.index') }}">Home</a></li>
                <li class="breadcrumb-item active">Register</li>
            </ol>
        </nav>

        <!-- ALERTS -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 small">
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session()->has('message') || session()->has('error') || session()->has('success'))
            <div class="alert 
                {{ session()->has('error') ? 'alert-danger' : (session()->has('success') ? 'alert-success' : 'alert-warning') }}">
                {{ session('message') ?? (session('error') ?? session('success')) }}
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="auth-card shadow p-4">

                    <h3 class="text-center mb-4">
                        <i class="fa-solid d-none fa-user-plus me-2"></i> Create Account
                    </h3>

                    <form wire:submit.prevent="register">

                        <!-- NAME -->
                        <div class="mb-3">
                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fa-solid fa-user"></i>
                                </span>
                                <input type="text" class="form-control" wire:model="name" placeholder="Enter your name">
                            </div>
                            @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <!-- EMAIL -->
                        <div class="mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fa-solid fa-envelope"></i>
                                </span>
                                <input type="email" class="form-control" wire:model="email" placeholder="Enter email address">
                            </div>
                            @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <!-- PHONE -->
                        <div class="mb-3">
                            <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fa-solid fa-phone"></i>
                                </span>
                                <input type="text" class="form-control" wire:model="phone" placeholder="Enter phone number">
                            </div>
                            @error('phone') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <!-- PASSWORD -->
                        <div class="mb-3 position-relative">
                            <label class="form-label">Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fa-solid fa-lock"></i>
                                </span>
                                <input type="password" class="form-control" wire:model="password"
                                       id="regPassword" placeholder="Enter password">

                                <span class="input-group-text cursor-pointer" onclick="toggleRegPass()">
                                    <i id="regToggleIcon" class="fa-solid fa-eye"></i>
                                </span>
                            </div>
                            @error('password') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <!-- SUBMIT -->
                        <button class="btn btn-signin w-100 mt-2">
                            <i class="fa-solid fa-user-check me-2"></i> Register
                        </button>

                        <!-- LOGIN LINK -->
                        <p class="text-center mt-3">
                            Already have an account?
                            <a class="link" href="{{ route('login') }}"><strong>Login</strong></a>
                        </p>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .auth-wrapper {
    padding: 50px 0;
}

.auth-card {
    border-radius: 10px;
    background: #ffffff;
}

.input-group-text {
    background: #f8f9fa;
    border-right: none;
    cursor: pointer;
    transition: 0.2s ease;
}

.input-group-text:hover {
    background: #e9ecef;
}

.form-control {
    border-left: none;
}

.form-control:focus {
    box-shadow: none;
    border-color: #daa520;
}

.link {
    color: #daa520;
    text-decoration: none;
}

.link:hover {
    text-decoration: underline;
}
</style>
<script>
    function toggleRegPass() {
    const input = document.getElementById('regPassword');
    const icon = document.getElementById('regToggleIcon');

    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}

</script>
</div>
