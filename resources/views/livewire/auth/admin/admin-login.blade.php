<div class="login-box">
    <h1>Login Information</h1>
    <h2>Welcome to Admin Login </h2>

    @if (session()->has('error'))
        <p style="color:red;">{{ session('error') }}</p>
    @endif

    <form method="POST" wire:submit.prevent="login">
        @csrf
        <div class="input-group">
            <label for="email">Email</label>
            <input type="text" class="{{ $errors->has('email') ? ' is-invalid' : '' }}" id="email"
                placeholder="Enter Email" wire:model="email">
            @error('email')
                <em style="color:red; "> {{ $message }}</em>
            @enderror
        </div>
        <div class="input-group">
            <label for="password">Password</label>
            <input type="password" id="password" class="{{ $errors->has('password') ? ' is-invalid' : '' }}"
                placeholder="********" wire:model="password" name="password">
            @error('password')
                <em style="color:red; "> {{ $message }}</em>
            @enderror
        </div>
        <div class="actions">
            <button type="submit" class="btn">Login</button>
        </div>
    </form>
</div>
