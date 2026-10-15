<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#1f1c1c">
    <title>Super Admin Login | Student Diary</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,400,0,0" rel="stylesheet">

    <style>
        * { 
            box-sizing: border-box; 
            font-family: 'Inter', sans-serif; 
        }

        :root {
            --color-primary: #1f1c1c;
            --color-secondary: #C9A227;
            --color-canvas: #F5F7FA;
            --color-card-bg: #292525;
            --color-text-muted: #A1A1AA;
        }

        html, body { 
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100vh; 
            overflow: hidden; /* Disables all scrollbars */
            background-color: var(--color-primary); 
            color: #FFFFFF; 
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        /* Minimalist Background Pattern & Decorative Glow */
        body::before {
            content: "";
            position: absolute;
            width: 600px;
            height: 600px;
            top: -200px;
            left: -200px;
            background: radial-gradient(circle, rgba(201, 162, 39, 0.12) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }

        body::after {
            content: "";
            position: absolute;
            width: 550px;
            height: 550px;
            bottom: -200px;
            right: -200px;
            background: radial-gradient(circle, rgba(201, 162, 39, 0.08) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }

        /* Floating Minimalist Card - Increased Width */
        .card-container {
            position: relative;
            z-index: 1;
            width: 92%;
            max-width: 560px; /* Increased card width */
            background: var(--color-card-bg);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            padding: 36px 48px; /* Balanced padding to keep layout within viewport height */
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6);
        }
        header {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        /* Branding Header inside Card */
        .card-brand {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            text-align: center;
            margin-bottom: 10px;
            gap:16px;
            text-align:left;
        }

        .brand-logo-wrapper {
            width: 45px;
            height: 45px;
            border-radius: 14px;
            background: var(--color-primary);
            border: 1px solid rgba(201, 162, 39, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }

        .brand-logo-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 4px;
            filter: brightness(0) invert(1);
        }
        .brand-text {
            display: flex;
            flex-direction: column;
        }
        .brand-title {
            margin: 0;
            font-size: 20px;
            font-weight: 800;
            color: #FFFFFF;
            letter-spacing: -0.5px;
            line-height: 1.2;
        }

        .access-badge {
            display: inline-flex;
            align-items: center;
            gap: 2px;
            margin-top: 2px;
            margin-bottom: 20px;
            padding: 5px 7px;
            border-radius: 20px;
            background: rgba(201, 162, 39, 0.12);
            border: 1px solid rgba(201, 162, 39, 0.25);
            color: var(--color-secondary);
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .access-badge .material-symbols-rounded {
            font-size: 14px;
        }
        /* Alerts & Messages */
        .error-message {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 18px;
            padding: 10px 12px;
            border: 1px solid #7F1D1D;
            border-radius: 8px;
            background: #450A0A;
            color: #FCA5A5;
            font-size: 11px;
        }

        .success-message {
            margin-bottom: 18px;
            padding: 10px 12px;
            border: 1px solid #14532D;
            border-radius: 8px;
            background: #052E16;
            color: #86EFAC;
            font-size: 11px;
        }

        /* Underline-Style Form Controls */
        .form-group {
            margin-bottom: 22px;
            position: relative;
        }

        .form-label {
            display: block;
            margin-bottom: 4px;
            color: var(--color-text-muted);
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .input-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 6px 0;
            border-bottom: 1.5px solid rgba(255, 255, 255, 0.15);
            background: transparent;
            transition: border-color 0.25s ease;
        }

        .input-wrapper:focus-within {
            border-bottom-color: var(--color-secondary);
        }

        .input-icon {
            color: var(--color-text-muted);
            font-size: 19px;
            transition: color 0.25s ease;
        }

        .input-wrapper:focus-within .input-icon {
            color: var(--color-secondary);
        }

        .input-wrapper input {
            width: 100%;
            min-width: 0;
            padding: 4px 0;
            border: none;
            outline: none;
            background: transparent;
            color: #FFFFFF;
            font-size: 13px;
        }

        .input-wrapper input::placeholder {
            color: rgba(255, 255, 255, 0.25);
        }

        .password-toggle {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 4px;
            border: 0;
            background: transparent;
            color: var(--color-text-muted);
            cursor: pointer;
            transition: color 0.2s;
        }

        .password-toggle:hover {
            color: #FFFFFF;
        }

        .password-toggle .material-symbols-rounded {
            font-size: 19px;
        }

        /* Action Buttons */
        .login-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            margin-top: 28px;
            padding: 13px 20px;
            border: 0;
            border-radius: 12px;
            background: var(--color-secondary);
            color: #1f1c1c;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 4px 20px rgba(201, 162, 39, 0.25);
            transition: all 0.25s ease;
        }

        .login-btn:hover {
            background: #d4ac2b;
            transform: translateY(-1px);
            box-shadow: 0 6px 24px rgba(201, 162, 39, 0.35);
        }

        .login-btn:focus-visible {
            outline: 2px solid var(--color-secondary);
            outline-offset: 3px;
        }

        .copyright {
            margin-top: 24px;
            color: rgba(255, 255, 255, 0.3);
            font-size: 10px;
            text-align: center;
        }

        @media (max-width: 600px) {
            .card-container {
                padding: 28px 24px;
                width: 95%;
            }
        }

    </style>
</head>
<body>

    <!-- Minimalist Card Container -->
    <main class="card-container">

        <!-- Brand Header Section -->
        <header>
            <div class="card-brand">
                <div class="brand-logo-wrapper">
                    <img src="{{ asset('storage/images/student-diary-logo.png') }}" alt="Student Diary Logo">
                </div>
                <div class="brand-text">
                    <h1 class="brand-title">Student Diary</h1>
                </div>
            </div>    
            <div class="access-badge">
                <span class="material-symbols-rounded">admin_panel_settings</span>
                SUPER ADMIN ACCESS
            </div>
        </header>

        <!-- Validation & Error Messages -->
        @if ($errors->any())
            <div role="alert" class="error-message">
                <span class="material-symbols-rounded">error</span>
                <div>{{ $errors->first() }}</div>
            </div>
        @endif

        @if (session('status'))
            <div role="status" class="success-message">{{ session('status') }}</div>
        @endif

        <!-- Login Form -->
        <form id="superAdminLoginForm" method="POST" action="">
            @csrf

            <!-- Email Field -->
            <div class="form-group">
                <label for="email" class="form-label">Email address</label>
                <div class="input-wrapper">
                    <span class="material-symbols-rounded input-icon">mail</span>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="admin@example.com">
                </div>
                @error('email')
                    <p style="margin: 5px 0 0; color: #FCA5A5; font-size: 11px;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Field -->
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <div class="input-wrapper">
                    <span class="material-symbols-rounded input-icon">lock</span>
                    <input id="password" name="password" type="password" required autocomplete="current-password" placeholder="••••••••••••">
                    <button type="button" id="togglePassword" class="password-toggle" aria-label="Show password">
                        <span id="passwordIcon" class="material-symbols-rounded">visibility</span>
                    </button>
                </div>
                @error('password')
                    <p style="margin: 5px 0 0; color: #FCA5A5; font-size: 11px;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" id="loginButton" class="login-btn">
                <span id="loginButtonText">Sign in to dashboard</span>
                <span id="loginButtonIcon" class="material-symbols-rounded">arrow_forward</span>
                <span id="loginSpinner" class="material-symbols-rounded animate-spin hidden">progress_activity</span>
            </button>
        </form>

        <p class="copyright">© {{ date('Y') }} Student Diary. All rights reserved.</p>

    </main>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        const passwordIcon = document.getElementById('passwordIcon');

        togglePassword.addEventListener('click', () => {
            const visible = password.type === 'password';
            password.type = visible ? 'text' : 'password';
            passwordIcon.textContent = visible ? 'visibility_off' : 'visibility';
            togglePassword.setAttribute('aria-label', visible ? 'Hide password' : 'Show password');
        });
        const loginButton = document.getElementById('loginButton');
        const loginButtonText = document.getElementById('loginButtonText');
        const loginButtonIcon = document.getElementById('loginButtonIcon');
        const loginSpinner = document.getElementById('loginSpinner');
        function setLoading(isLoading) {
            loginButton.disabled = isLoading;
            loginButtonText.textContent = isLoading ? 'Signing in...' : 'Sign in to dashboard';
            loginButtonIcon.classList.toggle('hidden', isLoading);
            loginSpinner.classList.toggle('hidden', !isLoading);
        }
        document.getElementById('superAdminLoginForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            const form = this;
            setLoading(true);

            try {
                const response = await fetch('/api/v1/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        email: form.email.value,
                        password: form.password.value
                    })
                });
                const result = await response.json();
                if (!response.ok || !result.status) {
                    let errorContainer = document.querySelector('.error-message');   
                    const errorMessageText = result.message || 'Invalid credentials. Please try again.';
                    if (errorContainer) {
                        errorContainer.querySelector('div').textContent = errorMessageText;
                        errorContainer.classList.remove('hidden'); // Ensure it's visible
                    } else {
                        const form = document.getElementById('superAdminLoginForm');
                        const errorDiv = document.createElement('div');
                        errorDiv.className = 'error-message';
                        errorDiv.innerHTML = `<span class="material-symbols-rounded">error</span><div>${errorMessageText}</div>`;
                        form.parentNode.insertBefore(errorDiv, form);
                    }
                    return;
                }
                if (result.user?.role !== 'super_admin') {
                    alert('Unauthorized access.');
                    return;
                }
                localStorage.setItem('student_diary_token', result.token);
                localStorage.setItem('student_diary_user', JSON.stringify(result.user));
                window.location.href = '/super-admin/dashboard';
            } catch (error) {
                alert('Unable to connect to the server.');
            } finally {
                setLoading(false);
            }
        });
    </script>
</body>
</html>
