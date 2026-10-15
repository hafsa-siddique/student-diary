<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $institute->name }} Login</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --primary-color: {{ $primaryColor }};
            --secondary-color: {{ $secondaryColor }};
        }
        body {
            font-family: 'Inter', sans-serif;
        }
        .atmospheric-bg {
            position: relative;
            background-color: #f8fafc;
            background-image: 
                radial-gradient(ellipse at 30% 50%, color-mix(in srgb, var(--primary-color) 40%, transparent) 0%, transparent 60%),
                radial-gradient(ellipse at 80% 20%, color-mix(in srgb, var(--secondary-color) 55%, transparent) 0%, transparent 70%),
                radial-gradient(circle at 15% 85%, color-mix(in srgb, var(--primary-color) 30%, transparent) 0%, transparent 55%),
                radial-gradient(circle at 85% 90%, color-mix(in srgb, var(--secondary-color) 35%, transparent) 0%, transparent 55%);
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .atmospheric-bg::before {
            content: "";
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 50% 50%, rgba(255, 255, 255, 0.2) 0%, rgba(241, 245, 249, 0.65) 100%);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            pointer-events: none;
        }
        .atmospheric-bg > * {
            position: relative;
            z-index: 1;
        }
        .primary-focus:focus {
            border-color: var(--primary-color);
            background-color: #ffffff;
            box-shadow: 0 0 0 3px color-mix(in srgb, var(--primary-color) 15%, transparent);
        }
    </style>
</head>
<body class="min-h-screen atmospheric-bg flex items-center justify-center p-4 sm:p-6 lg:p-8">
<div class="w-full max-w-6xl grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
    
    <!-- Left Column: Atmospheric Graphic / Feature Showcase (Swapped to Left) -->
    <div class="lg:col-span-7 hidden lg:flex flex-col justify-center pr-8 lg:pr-12">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/60 backdrop-blur-md border border-slate-200/60 w-fit mb-4">
            <span class="w-2 h-2 rounded-full animate-pulse" style="background-color: var(--secondary-color);"></span>
            <span class="text-xs font-semibold text-slate-700 tracking-wide">Session 2026-2027 Digital Ecosystem</span>
        </div>
        <h1 class="text-4xl xl:text-5xl font-bold text-slate-900 tracking-tight leading-tight mb-4">
            Welcome to <span style="color: var(--primary-color);">{{ $institute->name }}</span> Digital Diary
        </h1>
        <p class="text-base text-slate-600 leading-relaxed max-w-xl mb-8">
            Seamlessly monitor daily homework assignments, class progress, school notices, and teacher attachments in a unified, secure dashboard experience.
        </p>
        <div class="grid grid-cols-2 gap-4 max-w-lg">
            <div class="p-4 rounded-2xl bg-white/50 backdrop-blur-sm border border-slate-200/60 shadow-sm">
                <span class="material-symbols-outlined text-2xl mb-2" style="color: var(--primary-color);">auto_stories</span>
                <h3 class="font-semibold text-slate-800 text-sm">Real-time Diary</h3>
                <p class="text-xs text-slate-500 mt-0.5">Instant sync for class updates.</p>
            </div>
            <div class="p-4 rounded-2xl bg-white/50 backdrop-blur-sm border border-slate-200/60 shadow-sm">
                <span class="material-symbols-outlined text-2xl mb-2" style="color: var(--secondary-color);">verified_user</span>
                <h3 class="font-semibold text-slate-800 text-sm">Secure Portal</h3>
                <p class="text-xs text-slate-500 mt-0.5">Role-based encrypted access.</p>
            </div>
        </div>
    </div>

    <!-- Right Column: Floating Glass Form Card (Swapped to Right) -->
    <div class="lg:col-span-5 w-full bg-white/80 backdrop-blur-xl border border-white/60 shadow-2xl rounded-3xl p-6 sm:p-8">
        <!-- Mobile/Card Header Branding -->
        <div class="flex items-center gap-3 mb-6 pb-6 border-b border-slate-100">
            <div class="w-12 h-12 rounded-2xl bg-white shadow-md flex items-center justify-center overflow-hidden shrink-0 border border-slate-100">
                @if($instituteLogo)
                    <img src="{{ $instituteLogo }}" alt="{{ $institute->name }} logo" class="w-full h-full object-contain p-1">
                @else
                    <span class="material-symbols-outlined text-2xl" style="color: var(--primary-color);">menu_book</span>
                @endif
            </div>
            <div>
                <h2 class="font-bold text-base text-slate-900 tracking-tight">{{ $institute->name }}</h2>
                <p class="text-xs font-medium text-slate-500">Student Diary Portal</p>
            </div>
        </div>
        <!-- Heading -->
        <div class="mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">Sign In</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Enter your credentials to manage your daily diary.</p>
        </div>
        <!-- Error Message Container -->
        <div id="login-error" class="hidden mb-4 p-3 rounded-xl bg-red-50 border border-red-100 text-xs sm:text-sm text-red-600">
            <div class="flex items-start gap-2">
                <span class="material-symbols-outlined text-base mt-0.5">error</span>
                <p id="login-error-message"></p>
            </div>
        </div>
        <!-- Login Form -->
        <form id="login-form" class="space-y-4">
            <!-- Email -->
            <div class="space-y-1.5">
                <label for="email" class="text-xs sm:text-sm font-semibold text-slate-700">Email Address</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-lg">mail</span>
                    <input id="email" name="email" type="email" autocomplete="email" placeholder="name@example.com" required class="primary-focus w-full h-11 pl-10 pr-4 rounded-xl border border-slate-200 bg-white/50 text-slate-900 placeholder:text-slate-400 text-sm outline-none transition">
                </div>
                <p id="email-error" class="hidden text-xs text-red-600 mt-1"></p>
            </div>
            <!-- Password -->
            <div class="space-y-1.5">
                <div class="flex items-center justify-between">
                    <label for="password" class="text-xs sm:text-sm font-semibold text-slate-700">Password</label>
                </div>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-lg">lock</span>
                    <input id="password" name="password" type="password" autocomplete="current-password" placeholder="••••••••" required class="primary-focus w-full h-11 pl-10 pr-10 rounded-xl border border-slate-200 bg-white/50 text-slate-900 placeholder:text-slate-400 text-sm outline-none transition">
                    <button type="button" id="toggle-password" aria-label="Show password" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700 transition">
                        <span id="password-icon" class="material-symbols-outlined text-lg">visibility</span>
                    </button>
                </div>
                <p id="password-error" class="hidden text-xs text-red-600 mt-1"></p>
            </div>
            <!-- Login Button -->
            <button type="submit" id="login-button" class="w-full h-11 mt-2 rounded-xl text-white font-semibold text-sm flex items-center justify-center gap-2 shadow-lg shadow-emerald-900/10 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-70 disabled:cursor-not-allowed" style="background-color: var(--primary-color);">
                <span id="login-button-text">Sign In</span>
                <span id="login-button-icon" class="material-symbols-outlined text-base">arrow_forward</span>
                <span id="login-spinner" class="hidden material-symbols-outlined animate-spin text-lg">progress_activity</span>
            </button>
        </form>
        <!-- Footer Logos inside card -->
        <div class="flex items-center justify-center gap-3 mt-6 pt-6 border-t border-slate-100 opacity-80">
            @if($instituteLogo)
                <img src="{{ $instituteLogo }}" alt="{{ $institute->name }} logo" class="h-8 w-auto object-contain">
            @endif
            <img src="{{ asset('storage/images/Govt Punjab Logo.png') }}" alt="Govt Punjab Logo" class="h-8 w-auto object-contain">
        </div>

    </div>
</div>
<!-- Identical JavaScript Logic -->
<script>
    const LOGIN_API_URL = "{{ url('/api/v1/login') }}";
    const INSTITUTE_CODE = @json($institute->code);
    const loginForm = document.getElementById('login-form');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const loginButton = document.getElementById('login-button');
    const loginButtonText = document.getElementById('login-button-text');
    const loginButtonIcon = document.getElementById('login-button-icon');
    const loginSpinner = document.getElementById('login-spinner');
    const loginError = document.getElementById('login-error');
    const loginErrorMessage = document.getElementById('login-error-message');
    const emailError = document.getElementById('email-error');
    const passwordError = document.getElementById('password-error');
    document.getElementById('toggle-password').addEventListener('click', function () {
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            document.getElementById('password-icon').textContent = 'visibility_off';
            this.setAttribute('aria-label', 'Hide password');
        } else {
            passwordInput.type = 'password';
            document.getElementById('password-icon').textContent = 'visibility';
            this.setAttribute('aria-label', 'Show password');
        }
    });
    function clearErrors() {
        loginError.classList.add('hidden');
        loginErrorMessage.textContent = '';
        emailError.classList.add('hidden');
        emailError.textContent = '';
        passwordError.classList.add('hidden');
        passwordError.textContent = '';
        emailInput.classList.remove('border-red-400');
        passwordInput.classList.remove('border-red-400');
    }
    function showLoginError(message) {
        loginErrorMessage.textContent = message;
        loginError.classList.remove('hidden');
    }
    function showValidationErrors(errors) {
        if (errors.email && errors.email.length) {
            emailError.textContent = errors.email[0];
            emailError.classList.remove('hidden');
            emailInput.classList.add('border-red-400');
        }
        if (errors.password && errors.password.length) {
            passwordError.textContent = errors.password[0];
            passwordError.classList.remove('hidden');
            passwordInput.classList.add('border-red-400');
        }
    }
    function setLoading(isLoading) {
        loginButton.disabled = isLoading;
        if (isLoading) {
            loginButtonText.textContent = 'Signing in...';
            loginButtonIcon.classList.add('hidden');
            loginSpinner.classList.remove('hidden');
        } else {
            loginButtonText.textContent = 'Sign In';
            loginButtonIcon.classList.remove('hidden');
            loginSpinner.classList.add('hidden');
        }
    }
    function redirectUser(role) {
        switch (role) {
            case 'admin':
                window.location.href = '/admin/dashboard';
                break;
            case 'teacher':
                window.location.href = '/teacher/dashboard';
                break;
            case 'parent':
                window.location.href = '/parent/dashboard';
                break;
            default:
                showLoginError('Your account role is not authorized to access this system.');
                setLoading(false);
        }
    }
    loginForm.addEventListener('submit', async function (event) {
        event.preventDefault();
        clearErrors();
        const email = emailInput.value.trim();
        const password = passwordInput.value;
        if (!email) {
            emailError.textContent = 'Email address is required.';
            emailError.classList.remove('hidden');
            emailInput.classList.add('border-red-400');
            emailInput.focus();
            return;
        }

        if (!password) {
            passwordError.textContent = 'Password is required.';
            passwordError.classList.remove('hidden');
            passwordInput.classList.add('border-red-400');
            passwordInput.focus();
            return;
        }
        setLoading(true);
        try {
            const response = await fetch(LOGIN_API_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    institute_id: INSTITUTE_CODE,
                    email: email,
                    password: password
                })
            });
            const data = await response.json();
            if (response.status === 422) {
                if (data.errors) {
                    showValidationErrors(data.errors);
                } else {
                    showLoginError(data.message || 'Please check your input.');
                }
                setLoading(false);
                return;
            }
            if (response.status === 401) {
                showLoginError(data.message || 'Invalid email or password.');
                setLoading(false);
                return;
            }
            if (response.status === 403) {
                showLoginError(data.message || 'Your account is not allowed to access this system.');
                setLoading(false);
                return;
            }
            if (!response.ok) {
                showLoginError(data.message || 'Something went wrong. Please try again.');
                setLoading(false);
                return;
            }
            const token = data.data?.token || data.token;
            if (token) {
                localStorage.setItem('student_diary_token', token);
            }
            const user = data.data?.user || data.user;
            if (!user) {
                showLoginError('Login succeeded, but user information was not returned.');
                setLoading(false);
                return;
            }
            localStorage.setItem('student_diary_user', JSON.stringify(user));
            localStorage.setItem('student_diary_institute_code', INSTITUTE_CODE);
            redirectUser(user.role);
        } catch (error) {
            console.error('Login error:', error);
            showLoginError('Unable to connect to the server. Please check your connection and try again.');
            setLoading(false);
        }
    });
</script>
</body>
</html>