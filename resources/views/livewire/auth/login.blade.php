<div class="container">

    @section('meta_title'){{ config('app.name') }} User Login @stop
    @section('meta_keywords'){{ config('app.name') }} User Login @stop
    @section('meta_description'){{ config('app.name') }} User Login @stop
     @if (session()->has('message') || session()->has('error') || session()->has('success'))
                                <div
                                    class="alert {{ session()->has('error') ? 'alert-danger' : (session()->has('success') ? 'alert-success' : 'alert-warning') }}">
                                    {{ session('message') ?? (session('error') ?? session('success')) }}
                                </div>
                            @endif
    <div class="auth-wrapper">
    <div class="container">

        <!-- BREADCRUMB -->
        <nav aria-label="breadcrumb" class="d-none mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('site.index') }}">Home</a></li>
                <li class="breadcrumb-item active">Login</li>
            </ol>
        </nav>

        <div class="row justify-content-center">
            <div class="col-md-5">

                <!-- ALERT MESSAGE -->
                @if (session()->has('message') || session()->has('error') || session()->has('success'))
                    <div class="alert 
                        {{ session()->has('error') ? 'alert-danger' : (session()->has('success') ? 'alert-success' : 'alert-warning') }}">
                        {{ session('message') ?? (session('error') ?? session('success')) }}
                    </div>
                @endif

                <!-- LOGIN BOX -->
                <div class="auth-card shadow p-4">

                    <h3 class="text-center mb-4">
                     Login
                    </h3>

                    <form wire:submit.prevent="login">

                        <!-- EMAIL FIELD -->
                        <div class="mb-3 position-relative">
                            <label class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fa-solid fa-envelope"></i>
                                </span>
                                <input type="email" wire:model="email" class="form-control" placeholder="Enter Email Address">
                            </div>
                            @error('email')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- PIN FIELD -->
                        <div class="mb-3 position-relative">
                            <label class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fa-solid fa-lock"></i>
                                </span>

                                <input type="password" wire:model="password" id="userPinInput" class="form-control"
                                    placeholder="Enter Password">

                                <span class="input-group-text cursor-pointer" onclick="togglePasswordVisibility()">
                                    <i id="togglePasswordIcon" class="fa-solid fa-eye"></i>
                                </span>
                            </div>

                            @error('password')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- REMEMBER + FORGOT -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="form-check">
                                <input type="checkbox" wire:model="remember" id="remember" class="form-check-input">
                                <label for="remember" class="form-check-label">Remember Me</label>
                            </div>

                            <a href="{{ route('forget.password') }}" class="link">Forgot password?</a>
                        </div>

                        <!-- BUTTON -->
                        <button class="btn btn-signin w-100">
                            <i class="fa-solid fa-unlock-keyhole me-2"></i> Login
                        </button>

                        <p class="text-center mt-3">
    Don’t have an account?
    <a href="{{ route('register', ['redirect' => request('redirect')]) }}" class="link">
        <strong>Register</strong>
    </a>
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
}

.form-control {
    border-left: none;
}

.form-control:focus {
    box-shadow: none;
    border-color: #daa520;
}




.breadcrumb {
    background: transparent;
    padding: 0;
    margin-bottom: 20px;
}

.link {
    color: #daa520;
    text-decoration: none;
}

.link:hover {
    text-decoration: underline;
}
.input-group-text {
    cursor: pointer;
    transition: 0.2s ease;
}

.input-group-text:hover {
    background: #e9ecef;
}

#togglePasswordIcon {
    color: #555;
    transition: 0.2s ease;
}

#togglePasswordIcon:hover {
    color: #000;
}

</style>
<script>
    function togglePasswordVisibility() {
    const input = document.getElementById('userPinInput');
    const icon = document.getElementById('togglePasswordIcon');

    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

</script>
</div>