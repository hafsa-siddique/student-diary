<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#172554">
    <title>Super Admin Login | Student Diary</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,400,0,0" rel="stylesheet">

    <style>
        * { box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { margin: 0; background: #F8FAFC; color: #0F172A; }
        .login-layout { min-height: 100vh; }

        .auth-panel {
            position: fixed; top: 0; right: 0; width: 50%; height: 100vh;
            min-height: 100vh; padding: 40px 4% 5px; display: flex;
            flex-direction: column; justify-content: space-between; overflow-y: auto;
            overflow-x: hidden; isolation: isolate; color: #FFFFFF;
            background: linear-gradient(135deg, #172554 0%, #1E3A8A 55%, #2563EB 100%);
        }
        .auth-panel::before {
            content: ""; position: absolute; inset: 0; z-index: -1;
            background-image: linear-gradient(#FFFFFF0A 1px, transparent 1px), linear-gradient(90deg, #FFFFFF0A 1px, transparent 1px);
            background-size: 40px 40px; pointer-events: none;
        }
        .auth-panel::after {
            content: ""; position: absolute; width: 420px; height: 420px;
            right: -180px; top: 15%; z-index: -1; border: 1px solid #FFFFFF25;
            border-radius: 50%; box-shadow: 0 0 0 45px #FFFFFF08, 0 0 0 90px #FFFFFF05;
            pointer-events: none;
        }
        .brand-header, .brand-content, .brand-footer { position: relative; z-index: 1; }
        .brand-header { display: flex; align-items: center; gap: 13px; }
        .brand-logo {
            width: 50px; height: 50px; flex-shrink: 0; display: flex;
            align-items: center; justify-content: center; overflow: hidden;
            border: 1px solid #FFFFFF35; border-radius: 15px;
            background: #172554; color: #FFFFFF;
        }
        .brand-logo img { width: 100%; height: 100%; object-fit: contain; padding: 5px; filter: brightness(0) invert(1); }
        .brand-name { margin: 0; color: #FFFFFF; font-size: 19px; font-weight: 800; letter-spacing: -.4px; }
        .brand-caption { margin: 5px 0 0; color: #BFDBFE; font-size: 10px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; }
        .brand-content { max-width: 520px; margin: auto 0; padding: 55px 0; }
        .brand-badge {
            display: inline-flex; align-items: center; gap: 9px; margin-bottom: 27px;
            padding: 10px 15px; border: 1px solid #FFFFFF25; border-radius: 30px;
            background: #FFFFFF12; color: #DBEAFE; font-size: 12px; font-weight: 500;
        }
        .brand-badge .material-symbols-rounded { font-size: 18px; }
        .brand-title { margin: 0; color: #FFFFFF; font-size: clamp(36px, 3.5vw, 53px); font-weight: 800; line-height: 1.17; letter-spacing: -1.8px; }
        .brand-title span { color: #93C5FD; }
        .brand-description { max-width: 440px; margin: 23px 0 0; color: #DBEAFE; font-size: 14px; line-height: 1.9; }
        .feature-list { display: grid; gap: 23px; margin-top: 42px; }
        .feature { display: flex; align-items: center; gap: 15px; }
        .feature-icon {
            display: flex; align-items: center; justify-content: center;
            width: 45px; height: 45px; flex-shrink: 0;
            border: 1px solid #FFFFFF20; border-radius: 13px;
            background: #FFFFFF12; color: #FFFFFF;
        }
        .feature-icon .material-symbols-rounded { font-size: 22px; }
        .feature-title { margin: 0; color: #FFFFFF; font-size: 13px; font-weight: 700; }
        .feature-description { margin: 5px 0 0; color: #BFDBFE; font-size: 11px; line-height: 1.6; }
        .brand-footer {
            display: flex; align-items: center; justify-content: space-between;
            gap: 12px; padding-top: 22px; border-top: 1px solid #FFFFFF25;
            color: #BFDBFE; font-size: 11px;
        }
        .online-status { display: inline-flex; align-items: center; gap: 7px; }
        .status-dot { width: 7px; height: 7px; border-radius: 50%; background: #4ADE80; box-shadow: 0 0 10px #4ADE8060; }

        .form-panel {
            margin-left: 0; width: 50%; min-height: 100vh; padding: 45px 9%;
            display: flex; align-items: center; justify-content: center; background: #F8FAFC;
        }
        .login-container { width: 100%; max-width: 410px; }
        .mobile-brand { display: none; align-items: center; gap: 12px; margin-bottom: 38px; }
        .mobile-logo {
            display: flex; align-items: center; justify-content: center;
            width: 45px; height: 45px; border-radius: 13px;
            background: #172554; color: #FFFFFF; font-size: 17px; font-weight: 800;
        }
        .mobile-logo img { width: 100%; height: 100%; padding: 5px; object-fit: contain; filter: brightness(0) invert(1); }
        .mobile-brand h3 { margin: 0; color: #0F172A; font-size: 16px; font-weight: 800; }
        .mobile-brand p { margin: 4px 0 0; color: #64748B; font-size: 11px; }
        .access-label {
            display: inline-flex; align-items: center; gap: 8px; padding: 8px 12px;
            border: 1px solid #DBEAFE; border-radius: 8px; background: #EFF6FF;
            color: #1D4ED8; font-size: 10px; font-weight: 800; letter-spacing: 1px;
        }
        .access-label .material-symbols-rounded { font-size: 17px; }
        .form-heading { margin: 23px 0 0; color: #0F172A; font-size: 34px; font-weight: 800; letter-spacing: -1.2px; }
        .form-subheading { margin: 12px 0 30px; color: #64748B; font-size: 13px; line-height: 1.8; }
        .error-message {
            display: flex; gap: 10px; margin-bottom: 20px; padding: 13px;
            border: 1px solid #FECACA; border-radius: 10px;
            background: #FEF2F2; color: #B91C1C; font-size: 12px; line-height: 1.6;
        }
        .success-message { margin-bottom: 20px; padding: 13px; border: 1px solid #BBF7D0; border-radius: 10px; background: #F0FDF4; color: #15803D; font-size: 12px; }
        .form-group { margin-bottom: 21px; }
        .form-label { display: block; margin-bottom: 9px; color: #334155; font-size: 12px; font-weight: 700; }
        .input-wrapper {
            display: flex; align-items: center; gap: 12px; padding: 0 14px;
            border: 1px solid #CBD5E1; border-radius: 11px; background: #FFFFFF;
            transition: border-color .2s, box-shadow .2s;
        }
        .input-wrapper:focus-within { border-color: #2563EB; box-shadow: 0 0 0 3px #2563EB18; }
        .input-icon { color: #94A3B8; font-size: 20px; }
        .input-wrapper input {
            width: 100%; min-width: 0; padding: 14px 0; border: 0; outline: none;
            background: transparent; color: #0F172A; font-size: 12px;
        }
        .input-wrapper input::placeholder { color: #94A3B8; }
        .password-toggle { display: flex; padding: 4px; border: 0; background: transparent; color: #94A3B8; cursor: pointer; }
        .password-toggle:hover { color: #1D4ED8; }
        .password-toggle .material-symbols-rounded { font-size: 20px; }
        .form-options { display: flex; align-items: center; justify-content: space-between; gap: 10px; margin: 5px 0 24px; }
        .login-btn {
            display: flex; align-items: center; justify-content: center; gap: 10px;
            width: 100%; padding: 15px 18px; border: 0; border-radius: 11px;
            background: linear-gradient(100deg, #2563EB, #1D4ED8);
            box-shadow: 0 6px 16px #2563EB25; color: #FFFFFF;
            font-size: 12px; font-weight: 700; cursor: pointer;
            transition: transform .2s, box-shadow .2s, background .2s;
        }
        .login-btn:hover { transform: translateY(-1px); background: #1D4ED8; box-shadow: 0 9px 22px #2563EB35; }
        .login-btn:focus-visible { outline: 3px solid #93C5FD; outline-offset: 3px; }
        .copyright { margin-top: 28px; color: #94A3B8; font-size: 10px; text-align: center; }
        .mobile-login-brand { display: none; }
        .mobile-login-brand-name { margin: 0; color: #0F172A; font-size: 17px; font-weight: 800; }
        .mobile-login-brand-caption { margin: 5px 0 0; color: #64748B; font-size: 10px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; }
        @media (max-width: 1023px) {
            .login-layout {
                display: flex;
                flex-direction: column;
                min-height: 100vh;
                background: linear-gradient(135deg, #172554 0%, #1E3A8A 55%, #2563EB 100%);
            }

            .auth-panel {
                display: none;
            }

            .form-panel {
                display: flex;
                width: 100%;
                min-height: 100vh;
                margin: 0;
                padding: 24px 20px;
                align-items: center;
                justify-content: center;
                background: transparent;
            }

            .login-container {
                width: 100%;
                max-width: 430px;
                margin: auto;
                padding: 25px 22px;
                background: #FFFFFF;
                border-radius: 20px;
                box-shadow: 0 20px 50px #0F172A35;
            }

            .mobile-login-brand {
                display: flex;
                align-items: center;
                gap: 12px;
                margin-bottom: 28px;
            }

            .mobile-login-brand .brand-logo {
                width: 46px;
                height: 46px;
                border-color: #DBEAFE;
            }

            .mobile-brand,
            .access-label,
            .form-heading,
            .form-subheading {
                display: none;
            }
        }

        @media (max-width: 480px) {
            .form-panel {
                padding: 20px 16px;
            }
            .login-container {
                padding: 24px 20px;
            }
            .form-group {
                margin-bottom: 18px;
            }
            .form-options {
                align-items: flex-start;
            }
            .copyright {
                margin-top: 22px;
            }
        }

    </style>
</head>
<body>
    <main class="login-layout">
        <section class="auth-panel">
            <header class="brand-header">
                <div class="brand-logo">
                    <img src="{{ asset('storage/images/student-diary-logo.png') }}" alt="Student Diary Logo">
                </div>
                <div>
                    <p class="brand-name">Student Diary</p>
                    <p class="brand-caption">Platform Administration</p>
                </div>
            </header>

            <div class="brand-content">
                <h1 class="brand-title">One platform.<br><span>Every institute.</span></h1>
                <p class="brand-description">Manage institutions, oversee platform activity, and keep every school connected through one secure administration portal.</p>
                <div class="feature-list">
                    <div class="feature">
                        <div class="feature-icon"><span class="material-symbols-rounded">domain</span></div>
                        <div>
                            <p class="feature-title">Institute management</p>
                            <p class="feature-description">Manage institutions from one place</p>
                        </div>
                    </div>
                    <div class="feature">
                        <div class="feature-icon"><span class="material-symbols-rounded">shield_lock</span></div>
                        <div>
                            <p class="feature-title">Secure administration</p>
                            <p class="feature-description">Protected access for platform administrators</p>
                        </div>
                    </div>
                    <div class="feature">
                        <div class="feature-icon"><span class="material-symbols-rounded">settings_suggest</span></div>
                        <div>
                            <p class="feature-title">Centralized control</p>
                            <p class="feature-description">Manage platform-wide settings and access</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="form-panel">
            <div class="login-container">
                <div class="mobile-brand">
                    <div class="mobile-logo">
                        <img src="{{ asset('storage/images/student-diary-logo.png') }}" alt="Student Diary Logo">
                    </div>
                    <div>
                        <h3>Student Diary</h3>
                        <p>Platform Administration</p>
                    </div>
                </div>
                <header class="mobile-login-brand">
                    <div class="brand-logo">
                        <img src="{{ asset('storage/images/student-diary-logo.png') }}" alt="Student Diary Logo">
                    </div>
                    <div>
                        <p class="mobile-login-brand-name">Student Diary</p>
                        <p class="mobile-login-brand-caption">Platform Administration</p>
                    </div>
                </header>
                <div class="access-label">
                    <span class="material-symbols-rounded">admin_panel_settings</span>
                    SUPER ADMIN ACCESS
                </div>

                <h2 class="form-heading">Welcome back</h2>
                <p class="form-subheading">Sign in to your administrator account to continue to the platform dashboard.</p>

                @if ($errors->any())
                    <div role="alert" class="error-message">
                        <span class="material-symbols-rounded">error</span>
                        <div>{{ $errors->first() }}</div>
                    </div>
                @endif

                @if (session('status'))
                    <div role="status" class="success-message">{{ session('status') }}</div>
                @endif

                <form id="superAdminLoginForm" method="POST" action="">
                    @csrf
                    <div class="form-group">
                        <label for="email" class="form-label">Email address</label>
                        <div class="input-wrapper">
                            <span class="material-symbols-rounded input-icon">mail</span>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="admin@example.com">
                        </div>
                        @error('email')
                            <p style="margin:7px 0 0;color:#B91C1C;font-size:11px">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-wrapper">
                            <span class="material-symbols-rounded input-icon">lock</span>
                            <input id="password" name="password" type="password" required autocomplete="current-password" placeholder="Enter your password">
                            <button type="button" id="togglePassword" class="password-toggle" aria-label="Show password">
                                <span id="passwordIcon" class="material-symbols-rounded">visibility</span>
                            </button>
                        </div>
                        @error('password')
                            <p style="margin:7px 0 0;color:#B91C1C;font-size:11px">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" id="loginButton" class="login-btn">
                        <span id="loginButtonText">Sign in to dashboard</span>
                        <span id="loginButtonIcon" class="material-symbols-rounded">arrow_forward</span>
                        <span id="loginSpinner" class="material-symbols-rounded animate-spin hidden">progress_activity</span>
                    </button>
                </form>

                <p class="copyright">© {{ date('Y') }} Student Diary. All rights reserved.</p>
            </div>
        </section>
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
                    alert(result.message || 'Login failed.');
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
