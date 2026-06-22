<x-guest-layout>
    {{-- Session Status --}}
    @if (session('status'))
        <div class="session-status">{{ session('status') }}</div>
    @endif

    <h1 class="login-title">Welcome back</h1>
    <p class="login-subtitle">
        Don't have an account?
        <a href="{{ route('register') }}">Create an account</a>
    </p>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email Address --}}
        <div class="input-group">
            <label for="email" class="input-label">Email address</label>
            <div class="input-wrapper">
                <span class="input-icon">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </span>
                <input
                    id="email"
                    class="input-field"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="you@company.com"
                    required
                    autofocus
                    autocomplete="username"
                />
            </div>
            @error('email')
                <div class="input-error-msg">{{ $message }}</div>
            @enderror
        </div>

        {{-- Password --}}
        <div class="input-group">
            <label for="password" class="input-label">Password</label>
            <div class="input-wrapper">
                <span class="input-icon">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </span>
                <input
                    id="password"
                    class="input-field"
                    type="password"
                    name="password"
                    placeholder="••••••••"
                    required
                    autocomplete="current-password"
                />
            </div>
            @error('password')
                <div class="input-error-msg">{{ $message }}</div>
            @enderror
        </div>

        {{-- Remember Me & Forgot Password --}}
        <div class="row-actions">
            <label class="remember-label">
                <input type="checkbox" name="remember" id="remember_me">
                <span>Remember me</span>
            </label>
            @if (Route::has('password.request'))
                <a class="forgot-link" href="{{ route('password.request') }}">
                    Forgot password?
                </a>
            @endif
        </div>

        {{-- Sign In Button --}}
        <button type="submit" class="btn-signin">Sign in</button>
    </form>

    {{-- Demo Quick Login --}}
    <div class="demo-section">
        <p class="demo-label">Demo: Quick Login as Role</p>
        <div class="demo-buttons">
            <button
                type="button"
                class="demo-btn demo-btn-admin"
                onclick="quickLogin('admin@admin.com', 'password')"
            >
                Admin
            </button>
            <button
                type="button"
                class="demo-btn demo-btn-manager"
                onclick="quickLogin('manager@manager.com', 'password')"
            >
                Manager
            </button>
            <button
                type="button"
                class="demo-btn demo-btn-staff"
                onclick="quickLogin('staff@staff.com', 'password')"
            >
                Staff
            </button>
        </div>
    </div>
</x-guest-layout>
