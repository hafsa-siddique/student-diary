<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $institute->name }} - Login</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Material Symbols --}}
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Dynamic Institute Theme --}}
    <style>
        :root {
            --primary-color: {{ $primaryColor }};
            --secondary-color: {{ $secondaryColor }};
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        .school-panel {
            position: relative;
            background-image: url('{{ $loginCoverImage }}');
            background-size: cover;
            background-position: center;
        }

        .school-panel::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(
                to bottom,
                color-mix(in srgb, var(--primary-color) 95%, transparent) 0%,
                color-mix(in srgb, var(--primary-color) 60%, var(--secondary-color) 20%) 40%,
                color-mix(in srgb, var(--primary-color) 70%, var(--secondary-color) 25%) 75%,
                color-mix(in srgb, var(--primary-color) 80%, #000000 20%) 100%
                /* rgba(0, 112, 50, 0.8) 0%,
                rgba(8, 134, 65, 0.85) 35%,
                rgba(10, 49, 28, 0.92) 60%,
                rgba(2, 11, 6, 0.98) 100% */
            );
            pointer-events: none;
        }

        .school-panel > * {
            position: relative;
            z-index: 1;
        }

        .primary-bg {
            background-color: var(--primary-color);
        }

        .primary-text {
            color: var(--primary-color);
        }

        .secondary-text {
            color: var(--secondary-color);
        }

        .primary-focus:focus {
            border-color: var(--primary-color);
            background-color: #ffffff;
            box-shadow: 0 0 0 2px var(--secondary-color);
        }
    </style>
</head>

<body class="min-h-screen bg-slate-50">

<div class="min-h-screen w-full flex flex-col lg:flex-row">

    {{-- School Panel --}}
    <section class="school-panel order-2 lg:order-2 relative flex flex-col items-center w-full lg:w-[51%] min-h-[460px] lg:min-h-screen overflow-hidden text-white">

        {{-- Decorative Glow --}}
        <div class="absolute -left-24 top-1/3 w-96 h-96 rounded-full opacity-20 blur-3xl pointer-events-none"
             style="background-color: var(--secondary-color);">
        </div>

        {{-- Content Container --}}
        <div class="relative z-10 min-h-[460px] lg:min-h-screen flex flex-col items-center p-3 sm:p-5 lg:p-8">

            {{-- Top Branding --}}
            <div>
                <div class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/10">
                    <span class="w-1.5 h-1.5 rounded-full animate-pulse"
                          style="background-color: var(--secondary-color);"></span>

                    <span class="text-[10px] sm:text-xs font-medium tracking-wide">
                        Student Diary System / Session 2026-2027
                    </span>
                </div>
            </div>

            {{-- Institute Branding --}}
            <div class="max-w-2xl mt-4 lg:mt-5">
                <div class="flex items-center gap-4">

                    {{-- Institute Logo --}}
                    <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-white flex items-center justify-center shadow-2xl overflow-hidden shrink-0">
                        @if($instituteLogo)
                            <img src="{{ $instituteLogo }}"
                                 alt="{{ $institute->name }} logo"
                                 class="w-full h-full object-contain p-1">
                        @else
                            <span class="material-symbols-outlined text-3xl"
                                  style="color: var(--primary-color);">
                                menu_book
                            </span>
                        @endif
                    </div>

                    {{-- Institute Name --}}
                    <div>
                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold tracking-tight">
                            {{ $institute->name }}
                        </h1>

                        <p class="text-xs sm:text-sm font-semibold uppercase tracking-wider"
                           style="color: var(--secondary-color);">
                            Your Daily Student Diary
                        </p>
                    </div>

                </div>
            </div>

            {{-- Daily Updates Card --}}
            <div class="flex-1 flex items-center">
                <div class="max-w-md w-full rounded-2xl bg-white/20 border border-white/10 p-5 sm:p-6">

                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                             style="background-color: color-mix(in srgb, var(--secondary-color) 18%, transparent);">
                            <span class="material-symbols-outlined"
                                  style="color: var(--secondary-color);">
                                auto_stories
                            </span>
                        </div>

                        <div>
                            <h2 class="font-semibold uppercase tracking-wider"
                                style="color: var(--secondary-color);">
                                Daily Updates
                            </h2>

                            <p class="text-xs font-semibold text-white">
                                Everything in one place
                            </p>
                        </div>
                    </div>

                    <p class="text-sm text-white/70 leading-relaxed">
                        View homework, classwork, instructions, due dates, and diary attachments from your child's teachers.
                    </p>

                </div>
            </div>

            {{-- Footer --}}
            <div class="mt-auto flex flex-col sm:flex-row sm:items-end sm:justify-between gap-5">
                <p class="text-sm sm:text-base text-white/70 italic leading-relaxed">
                    “Keeping parents informed about their child's daily learning.”
                </p>
            </div>

        </div>
    </section>

    {{-- Login Panel --}}
    <section class="w-full lg:w-[49%] order-1 lg:order-1 min-h-screen bg-white flex flex-col px-6 py-8 sm:px-10 sm:py-12 lg:px-16 lg:py-12 overflow-y-auto">

        {{-- Mobile Header --}}
        <div class="lg:hidden flex items-center justify-between pb-6 mb-8 border-b border-slate-100">

            <div class="flex items-center gap-3">

                <div class="w-11 h-11 rounded-xl text-white flex items-center justify-center"
                     style="background-color: var(--primary-color);">

                    @if($instituteLogo)
                        <img src="{{ $instituteLogo }}"
                             alt="{{ $institute->name }} logo"
                             class="w-full h-full object-contain rounded-xl p-1">
                    @else
                        <span class="material-symbols-outlined">
                            menu_book
                        </span>
                    @endif

                </div>

                <div>
                    <h2 class="font-bold text-lg text-slate-900">
                        {{ $institute->name }}
                    </h2>

                    <p class="text-xs text-slate-500">
                        Student Diary Access
                    </p>
                </div>

            </div>
        </div>

        {{-- Login Content --}}
        <div class="w-full max-w-[420px] mx-auto my-auto flex flex-col justify-center">

            {{-- Login Heading --}}
            <div class="mb-8">

                <div class="inline-flex items-center gap-2 text-xs sm:text-sm font-semibold uppercase tracking-wider mb-3"
                     style="color: var(--primary-color);">

                    <span class="material-symbols-outlined text-base">
                        security
                    </span>

                    Secure Institute Login
                </div>

                <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 tracking-tight">
                    Welcome Back
                </h2>

                <p class="mt-3 text-sm sm:text-base text-slate-500 leading-relaxed">
                    Sign in to access your Student Diary.
                </p>

            </div>

            {{-- Error Message --}}
            <div id="login-error" class="hidden mb-5 text-sm text-red-600">

                <div class="flex items-start gap-3">
                    <span class="material-symbols-outlined text-lg">
                        error
                    </span>

                    <p id="login-error-message"></p>
                </div>

            </div>

            {{-- Login Form --}}
            <form id="login-form" class="flex flex-col gap-5">

                {{-- Email --}}
                <div class="flex flex-col gap-2">

                    <label for="email" class="text-sm font-semibold text-slate-900">
                        Email Address
                    </label>

                    <div class="relative">

                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                            mail
                        </span>

                        <input
                            id="email"
                            name="email"
                            type="email"
                            autocomplete="email"
                            placeholder="Enter your email"
                            required
                            class="primary-focus w-full h-12 pl-11 pr-4 rounded-xl border border-slate-200 bg-slate-50 text-slate-900 placeholder:text-slate-400 outline-none transition"
                        >

                    </div>

                    <p id="email-error" class="hidden text-xs text-red-600"></p>
                </div>

                {{-- Password --}}
                <div class="flex flex-col gap-2">

                    <label for="password" class="text-sm font-semibold text-slate-900">
                        Password
                    </label>

                    <div class="relative">

                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                            lock
                        </span>

                        <input
                            id="password"
                            name="password"
                            type="password"
                            autocomplete="current-password"
                            placeholder="Enter your password"
                            required
                            class="primary-focus w-full h-12 pl-11 pr-12 rounded-xl border border-slate-200 bg-slate-50 text-slate-900 placeholder:text-slate-400 outline-none transition"
                        >

                        <button
                            type="button"
                            id="toggle-password"
                            aria-label="Show password"
                            class="absolute right-3 top-1/2 -translate-y-1/2 p-1.5 rounded-lg text-slate-400 hover:text-slate-900 transition"
                        >
                            <span id="password-icon" class="material-symbols-outlined text-xl">
                                visibility
                            </span>
                        </button>

                    </div>

                    <p id="password-error" class="hidden text-xs text-red-600"></p>
                </div>

                {{-- Login Button --}}
                <button
                    type="submit"
                    id="login-button"
                    class="login-button mt-2 w-full min-h-[52px] rounded-xl text-white font-semibold flex items-center justify-center gap-2 shadow-md transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-70 disabled:cursor-not-allowed"
                    style="background-color: var(--primary-color);"
                >
                    <span id="login-button-text">
                        Login to Diary
                    </span>

                    <span id="login-button-icon" class="material-symbols-outlined text-lg">
                        arrow_forward
                    </span>

                    <span id="login-spinner" class="hidden material-symbols-outlined animate-spin text-xl">
                        progress_activity
                    </span>
                </button>

            </form>

            {{-- Footer --}}
            <div class="flex items-center justify-center gap-2 mb-3 mt-3">
                 @if($instituteLogo)
                    <img
                        src="{{ $instituteLogo }}"
                        alt="{{ $institute->name }} logo"
                        class="h-20 w-auto object-contain"
                    >
                @endif
                <img
                    src="{{ asset('storage/images/Govt Punjab Logo.png') }}"
                    alt="Institute Logo"
                    class="h-20 w-auto object-contain">

            </div>

        </div>
    </section>

</div>

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

    // Password visibility
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

    // Clear errors
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

    // General error
    function showLoginError(message) {
        loginErrorMessage.textContent = message;
        loginError.classList.remove('hidden');
    }

    // Validation errors
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

    // Loading state
    function setLoading(isLoading) {
        loginButton.disabled = isLoading;

        if (isLoading) {
            loginButtonText.textContent = 'Signing in...';
            loginButtonIcon.classList.add('hidden');
            loginSpinner.classList.remove('hidden');
        } else {
            loginButtonText.textContent = 'Login to Diary';
            loginButtonIcon.classList.remove('hidden');
            loginSpinner.classList.add('hidden');
        }
    }

    // Role redirect
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

    // Login request
    loginForm.addEventListener('submit', async function (event) {
        event.preventDefault();
        clearErrors();

        const email = emailInput.value.trim();
        const password = passwordInput.value;

        // Basic frontend validation
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

            // Validation
            if (response.status === 422) {
                if (data.errors) {
                    showValidationErrors(data.errors);
                } else {
                    showLoginError(data.message || 'Please check your input.');
                }

                setLoading(false);
                return;
            }

            // Invalid credentials
            if (response.status === 401) {
                showLoginError(data.message || 'Invalid email or password.');
                setLoading(false);
                return;
            }

            // Forbidden / inactive account
            if (response.status === 403) {
                showLoginError(
                    data.message || 'Your account is not allowed to access this system.'
                );

                setLoading(false);
                return;
            }

            // Other server errors
            if (!response.ok) {
                showLoginError(
                    data.message || 'Something went wrong. Please try again.'
                );

                setLoading(false);
                return;
            }

            // Token
            const token = data.data?.token || data.token;

            if (token) {
                localStorage.setItem('student_diary_token', token);
            }

            // User
            const user = data.data?.user || data.user;

            if (!user) {
                showLoginError(
                    'Login succeeded, but user information was not returned.'
                );

                setLoading(false);
                return;
            }

            localStorage.setItem(
                'student_diary_user',
                JSON.stringify(user)
            );
            localStorage.setItem( 'student_diary_institute_code', INSTITUTE_CODE );

            // Redirect
            redirectUser(user.role);

        } catch (error) {
            console.error('Login error:', error);

            showLoginError(
                'Unable to connect to the server. Please check your connection and try again.'
            );

            setLoading(false);
        }
    });
</script>

</body>
</html>
