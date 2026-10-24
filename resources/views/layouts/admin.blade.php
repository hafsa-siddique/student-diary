<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta content="web_dashboard" name="shell-type"/>

    <title>
        @yield('title', ($institute?->name ?? 'Student Diary') . ' - Institute Admin')
    </title>

    <!-- Google Fonts & Material Symbols -->
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <style>
        :root {
            --institute-primary: transparent;
            --institute-secondary: transparent;
        }

        @layer base {
            html, body {
                margin: 0;
                padding: 0;
            }

            body {
                overscroll-behavior: none;
            }

            main > :first-child {
                margin-top: 0 !important;
            }

            main > :last-child {
                margin-bottom: 0 !important;
            }
        }

        ::-webkit-scrollbar {
            display: none;
        }
    </style>

    <script src="https://cdn.tailwindcss.com"></script>

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        /* Institute colors come from API */
                        "primary": "var(--institute-primary)",
                        "secondary": "var(--institute-secondary)",
                        "primary-container": "var(--institute-primary)",
                        "secondary-container": "var(--institute-secondary)",
                        "primary-fixed": "var(--institute-primary)",
                        "primary-fixed-dim": "var(--institute-primary)",
                        "secondary-fixed": "var(--institute-secondary)",
                        "secondary-fixed-dim": "var(--institute-secondary)",
                        "on-primary": "#ffffff",
                        "on-primary-container": "#ffffff",
                        "on-secondary": "#ffffff",
                        "on-secondary-container": "#ffffff",
                        "on-primary-fixed": "#ffffff",
                        "on-primary-fixed-variant": "#ffffff",
                        "on-secondary-fixed": "#ffffff",
                        "on-secondary-fixed-variant": "#ffffff",

                        /* Stitch UI colors */
                        "surface-container-lowest": "#ffffff",
                        "surface-container-highest": "color-mix(in srgb, var(--institute-primary) 5%, white)",
                        "on-error": "#ffffff",
                        "outline": "#707a6f",
                        "on-tertiary-fixed": "#3f0112",
                        "on-surface-variant": "#404940",
                        "surface-container-low": "color-mix(in srgb, var(--institute-primary) 5%, white)",
                        "tertiary-fixed": "#ffd9dd",
                        "surface-container": "color-mix(in srgb, var(--institute-primary) 5%, white)",
                        "inverse-primary": "#8bd79b",
                        "error": "#ba1a1a",
                        "surface-container-high": "color-mix(in srgb, var(--institute-primary) 5%, white)",
                        "on-tertiary-container": "#ffbfc6",
                        "surface": "color-mix(in srgb, var(--institute-primary) 5%, white)",
                        "surface-dim": "#d3ddcd",
                        "on-surface": "#151e14",
                        "on-background": "#151e14",
                        "tertiary-fixed-dim": "#ffb2bb",
                        "inverse-on-surface": "#e9f4e3",
                        "surface-bright": "#f2fdec",
                        "tertiary-container": "#8f3e4c",
                        "inverse-surface": "#293328",
                        "tertiary": "#722736",
                        "surface-tint": "#1f6c3a",
                        "background": "#f2fdec",
                        "on-tertiary": "#ffffff",
                        "surface-variant": "#dbe6d5",
                        "error-container": "#ffdad6",
                        "on-error-container": "#93000a",
                        "outline-variant": "#bfc9bd"
                    },

                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },

                    "spacing": {
                        "gutter-desktop": "1.5rem",
                        "space-sm": "0.5rem",
                        "margin-desktop": "2rem",
                        "space-xl": "2rem",
                        "margin": "1rem",
                        "space-xs": "0.25rem",
                        "space-md": "1rem",
                        "space-lg": "1.5rem",
                        "gutter": "1.25rem"
                    },

                    "fontFamily": {
                        "headline-sm": ["Inter"],
                        "body-lg": ["Inter"],
                        "tabular-numeric": ["Inter"],
                        "headline-md": ["Inter"],
                        "headline-lg": ["Inter"],
                        "label-lg": ["Inter"],
                        "body-sm": ["Inter"],
                        "label-sm": ["Inter"],
                        "display-lg": ["Inter"],
                        "display-lg-mobile": ["Inter"],
                        "label-md": ["Inter"],
                        "body-md": ["Inter"]
                    },

                    "fontSize": {
                        "headline-sm": ["16px", {
                            "lineHeight": "24px",
                            "letterSpacing": "-0.005em",
                            "fontWeight": "600"
                        }],
                        "body-lg": ["16px", {
                            "lineHeight": "24px",
                            "letterSpacing": "0em",
                            "fontWeight": "400"
                        }],
                        "tabular-numeric": ["13px", {
                            "lineHeight": "18px",
                            "letterSpacing": "0.01em",
                            "fontWeight": "500"
                        }],
                        "headline-md": ["20px", {
                            "lineHeight": "28px",
                            "letterSpacing": "-0.01em",
                            "fontWeight": "600"
                        }],
                        "headline-lg": ["24px", {
                            "lineHeight": "32px",
                            "letterSpacing": "-0.015em",
                            "fontWeight": "600"
                        }],
                        "label-lg": ["14px", {
                            "lineHeight": "20px",
                            "letterSpacing": "0em",
                            "fontWeight": "600"
                        }],
                        "body-sm": ["12px", {
                            "lineHeight": "16px",
                            "letterSpacing": "0.01em",
                            "fontWeight": "400"
                        }],
                        "label-sm": ["11px", {
                            "lineHeight": "14px",
                            "letterSpacing": "0.04em",
                            "fontWeight": "600"
                        }],
                        "display-lg": ["32px", {
                            "lineHeight": "40px",
                            "letterSpacing": "-0.02em",
                            "fontWeight": "700"
                        }],
                        "display-lg-mobile": ["26px", {
                            "lineHeight": "34px",
                            "letterSpacing": "-0.015em",
                            "fontWeight": "700"
                        }],
                        "label-md": ["12px", {
                            "lineHeight": "16px",
                            "letterSpacing": "0.02em",
                            "fontWeight": "600"
                        }],
                        "body-md": ["14px", {
                            "lineHeight": "20px",
                            "letterSpacing": "0em",
                            "fontWeight": "400"
                        }]
                    }
                }
            }
        };
    </script>
</head>

<body class="bg-surface font-body-md text-on-surface antialiased">
    <!-- Impersonation Mode Banner -->
    <div id="impersonationBanner" class="hidden fixed top-0 left-0 right-0 z-50 bg-black px-4 py-2 text-white shadow-md transition-all">
        <div class="container mx-auto flex flex-wrap items-center justify-between gap-2 text-sm font-medium">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined">warning</span>
                <span>You are now in <strong>Impersonation Mode (Admin View)</strong>.</span>
            </div>
            <button type="button" onclick="exitImpersonationMode()" class="flex items-center gap-1 rounded-lg bg-white px-3 py-1 font-semibold text-black transition">
                <span class="material-symbols-outlined text-base">logout</span>
                Exit & Return to Super Admin
            </button>
        </div>
    </div>
    <div id="admin-sidebar-backdrop" class="fixed inset-0 bg-black/40 z-40 hidden lg:hidden"></div>

    <!-- Sidebar Navigation -->
    <aside id="admin-sidebar" class="fixed left-0 top-0 h-screen w-60 bg-primary z-50 flex flex-col justify-between overflow-y-auto shadow-[0_1px_8px_rgba(0,0,0,0.08)] -translate-x-full transition-transform duration-200 lg:translate-x-0">
        <div class="flex flex-col">
            <div class="h-16 px-space-md flex items-center gap-space-sm bg-black/10">
                <!-- Institute Logo -->
                <img
                    id="admin-institute-logo"
                    src=""
                    alt="Institute Logo"
                    class="h-9 w-9 rounded-lg object-contain bg-white shrink-0"
                    style="display: none;"
                >

                <!-- Default School Icon -->
                <div
                    id="admin-institute-icon"
                    class="h-9 w-9 rounded-lg bg-secondary-fixed text-primary flex items-center justify-center shrink-0"
                >
                    <span class="material-symbols-outlined">school</span>
                </div>

                <!-- Institute Name -->
                <div class="flex flex-col min-w-0">
                    <span id="admin-sidebar-institute-name" class="font-headline-sm text-headline-sm text-white truncate tracking-tight">
                        Student Diary
                    </span>
                    <span id="admin-institute-name-badge" class="font-label-sm text-label-sm uppercase tracking-wider text-secondary py-0.5 rounded w-max mt-0.5">
                        Institute Name
                    </span>
                </div>
            </div>

            <nav class="px-space-xs py-space-sm flex flex-col gap-1" data-active-classes="bg-primary text-on-primary relative before:content-[''] before:absolute before:left-0 before:top-0 before:bottom-0 before:w-1 before:bg-secondary-fixed font-semibold">
                <div class="px-space-sm pt-space-xs pb-1">
                    <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-primary-container/80">Overview</span>
                </div>

                <a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-primary-container hover:bg-primary hover:text-on-primary transition-colors hover:brightness-110" data-path="dashboard" data-spa-link href="/admin/dashboard">
                    <span class="material-symbols-outlined text-[20px]">dashboard</span>
                    <span class="font-body-md text-body-md">Dashboard</span>
                </a>
                <a onclick="openAnnouncementModal(); return false;" class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-primary-container hover:bg-primary hover:text-on-primary transition-colors hover:brightness-110" data-spa-link href="">
                    <span class="material-symbols-outlined text-[20px]">campaign</span>
                    <span class="font-body-md text-body-md">Publish Announcement</span>
                </a>
                <div class="px-space-sm pt-space-md pb-1">
                    <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-primary-container/80">People</span>
                </div>

                <a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-primary-container hover:bg-primary hover:text-on-primary transition-colors hover:brightness-110" data-path="teachers" data-spa-link href="/admin/teachers">
                    <span class="material-symbols-outlined text-[20px]">school</span>
                    <span class="font-body-md text-body-md">Teachers</span>
                </a>

                <a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-primary-container hover:bg-primary hover:text-on-primary transition-colors hover:brightness-110" data-path="parents" data-spa-link href="/admin/parents">
                    <span class="material-symbols-outlined text-[20px]">group</span>
                    <span class="font-body-md text-body-md">Parents</span>
                </a>

                <a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-primary-container hover:bg-primary hover:text-on-primary transition-colors hover:brightness-110" data-path="students" data-spa-link href="/admin/students">
                    <span class="material-symbols-outlined text-[20px]">person</span>
                    <span class="font-body-md text-body-md">Students</span>
                </a>

                <div class="px-space-sm pt-space-md pb-1">
                    <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-primary-container/80">Academic Setup</span>
                </div>

                <a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-primary-container hover:bg-primary hover:text-on-primary transition-colors hover:brightness-110" data-path="classes" data-spa-link href="/admin/classes">
                    <span class="material-symbols-outlined text-[20px]">domain</span>
                    <span class="font-body-md text-body-md">Classes</span>
                </a>

                <a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-primary-container hover:bg-primary hover:text-on-primary transition-colors hover:brightness-110" data-path="subjects" data-spa-link href="/admin/subjects">
                    <span class="material-symbols-outlined text-[20px]">menu_book</span>
                    <span class="font-body-md text-body-md">Subjects</span>
                </a>

                {{-- <a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-primary-container hover:bg-primary hover:text-on-primary transition-colors hover:brightness-110"" data-path="academic-sessions" href="/admin/academic-sessions">
                    <span class="material-symbols-outlined text-[20px]">calendar_month</span>
                    <span class="font-body-md text-body-md">Academic Sessions</span>
                </a> --}}

                <div class="px-space-sm pt-space-md pb-1">
                    <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-primary-container/80">Academic Management</span>
                </div>

                <a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-primary-container hover:bg-primary hover:text-on-primary transition-colors hover:brightness-110" data-path="student-enrollments" data-spa-link href="/admin/student-enrollments">
                    <span class="material-symbols-outlined text-[20px]">person_add</span>
                    <span class="font-body-md text-body-md">Student Enrollments</span>
                </a>

                <a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-primary-container hover:bg-primary hover:text-on-primary transition-colors hover:brightness-110" data-path="teacher-assignments" data-spa-link href="/admin/teacher-assignments">
                    <span class="material-symbols-outlined text-[20px]">assignment</span>
                    <span class="font-body-md text-body-md">Teacher Assignments</span>
                </a>
            </nav>
        </div>

        <div class="px-space-xs py-space-sm bg-primary flex flex-col gap-1">
            <div class="px-space-sm pt-space-xs pb-1">
                <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-primary-container/80">Account</span>
            </div>

            <a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-primary-container hover:bg-primary hover:text-on-primary transition-colors hover:brightness-110" data-path="profile" data-spa-link href="/admin/profile">
                <span class="material-symbols-outlined text-[20px]">account_circle</span>
                <span class="font-body-md text-body-md">Profile</span>
            </a>

            <button type="button" id="admin-logout" class="w-full text-left flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-primary-container hover:bg-primary hover:text-on-primary transition-colors hover:brightness-110" data-path="logout">
                <span class="material-symbols-outlined text-[20px]">logout</span>
                <span class="font-body-md text-body-md">Logout</span>
            </button>
        </div>
    </aside> 
    <!-- Main Content Shell -->
    <div class="lg:pl-60 min-h-screen flex flex-col">
        <!-- Top Navbar -->
        <header class="fixed top-0 left-0 lg:left-60 right-0 h-16 bg-surface-container-lowest/90 backdrop-blur-xl z-40 shadow-[0_1px_8px_rgba(0,0,0,0.04)] px-4 lg:px-margin-desktop flex items-center justify-between">
            <div class="flex items-center gap-space-md min-w-0">
                <button type="button" id="admin-menu-toggle" class="lg:hidden p-2 rounded-lg hover:bg-surface-container" aria-label="Open navigation">
                    <span class="material-symbols-outlined">menu</span>
                </button>

                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-surface-container-low text-primary">
                    <span class="material-symbols-outlined text-[18px]">corporate_fare</span>
                    <span class="font-label-lg text-label-lg font-semibold">
                        <span id="admin-institute-name">Institute Code</span>
                    </span>
                    <span class="font-label-sm text-label-sm bg-surface-container px-2 py-0.5 rounded-full text-on-surface-variant font-tabular-numeric">
                        <span id="admin-institute-code">—</span>
                    </span>
                </div>
            </div>

            <div class="flex items-center gap-space-lg">
                <div class="flex items-center gap-space-sm pl-space-sm cursor-pointer">
                    <div class="hidden md:flex flex-col text-left">
                        <span class="font-label-md text-label-md text-on-surface text-right leading-tight font-semibold">
                            <span id="admin-user-name">Admin</span>
                        </span>
                        <span id="admin-last-login" class="font-label-sm text-label-sm text-on-surface-variant leading-tight">Last login: Loading...</span>
                    </div>
                    <div id="admin-user-avatar" class="w-8 h-8 rounded-full bg-white text-primary border-2 border-[var(--institute-primary)] flex items-center justify-center text-xs font-bold">A</div>
                </div>
            </div>
        </header>
        <!-- Announcement Modal -->
        <div id="announcementModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4">
            <div class="w-full max-w-lg rounded-2xl bg-white p-6 shadow-2xl border border-slate-200 text-slate-800">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-4">
                    <h3 class="font-bold text-slate-800 text-sm flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-[20px]">campaign</span>
                        Publish Daily Announcement
                    </h3>
                    <button type="button" onclick="closeAnnouncementModal()" class="text-slate-400 hover:text-slate-600">
                        <span class="material-symbols-outlined text-[20px]">close</span>
                    </button>
                </div>

                <form onsubmit="publishAnnouncement(event)" class="space-y-4">
                    <div>
                        <textarea id="admin_announcement_msg" required rows="4" placeholder="Today's Announcement" class="w-full rounded-xl border border-slate-200 p-3.5 text-sm text-slate-800 outline-none focus:border-primary focus:ring-2 focus:ring-primary/10"></textarea>
                    </div>
                    
                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" onclick="closeAnnouncementModal()" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50">Cancel</button>
                        <button type="submit" class="px-4 py-2 rounded-xl bg-primary text-xs font-semibold text-white hover:brightness-110">Publish for Today</button>
                    </div>
                </form>
            </div>
        </div>
        <main id="spaContent" class="w-full pt-20 lg:pt-16 px-4 lg:px-margin-desktop pb-8 lg:pb-margin-desktop flex-1">
            @yield('content')
        </main>
    </div>

    <script>
    (() => {
        const tokenKey = 'student_diary_token';
        const userKey = 'student_diary_user';
        const instituteCodeKey = 'student_diary_institute_code';
        const token = localStorage.getItem(tokenKey);
        const storedUser = localStorage.getItem(userKey);
        const instituteCode = localStorage.getItem(instituteCodeKey);

        if (!token) {
            window.location.replace(
                instituteCode
                    ? `/login/${encodeURIComponent(instituteCode)}`
                    : '/'
            );
            return;
        }

        const sidebar = document.getElementById('admin-sidebar');
        const backdrop = document.getElementById('admin-sidebar-backdrop');
        const menuButton = document.getElementById('admin-menu-toggle');

        const closeMenu = () => {
            sidebar?.classList.add('-translate-x-full');
            backdrop?.classList.add('hidden');
        };

        menuButton?.addEventListener('click', () => {
            sidebar?.classList.remove('-translate-x-full');
            backdrop?.classList.remove('hidden');
        });

        backdrop?.addEventListener('click', closeMenu);

        sidebar?.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', closeMenu);
        });

        try {
            const user = storedUser ? JSON.parse(storedUser) : {};
            const name = user.name || user.data?.name || 'Admin';

            const userName = document.getElementById('admin-user-name');

            if (userName) {
                userName.textContent = name;
            }

            const userAvatar = document.getElementById('admin-user-avatar');

            if (userAvatar) {
                userAvatar.textContent =
                    name.trim().charAt(0).toUpperCase() || 'A';
            }

            const lastLoginElement =
                document.getElementById('admin-last-login');

            const lastLogin =
                user.last_login_at || user.data?.last_login_at;

            if (lastLoginElement) {
                if (!lastLogin) {
                    lastLoginElement.textContent = 'First login';
                } else {
                    const loginDate = new Date(lastLogin);
                    const now = new Date();
                    const diffMs = now.getTime() - loginDate.getTime();
                    const diffMinutes = Math.floor(diffMs / 60000);
                    const diffHours = Math.floor(diffMs / 3600000);
                    const diffDays = Math.floor(diffMs / 86400000);

                    let text;

                    if (diffMinutes < 1) {
                        text = 'just now';
                    } else if (diffMinutes < 60) {
                        text = `${diffMinutes} minute${diffMinutes === 1 ? '' : 's'} ago`;
                    } else if (diffHours < 24) {
                        text = `${diffHours} hour${diffHours === 1 ? '' : 's'} ago`;
                    } else if (diffDays === 1) {
                        text = `Yesterday at ${loginDate.toLocaleTimeString([], {
                            hour: '2-digit',
                            minute: '2-digit'
                        })}`;
                    } else {
                        text = loginDate.toLocaleString([], {
                            day: '2-digit',
                            month: 'short',
                            year: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                    }

                    lastLoginElement.textContent = `Last login: ${text}`;
                }
            }

            const institute =
                user.institute || user.data?.institute || {};

            const instituteName =
                document.getElementById('admin-institute-name');

            if (instituteName && institute.name) {
                instituteName.textContent = institute.name;
            }

            const instituteCodeElement =
                document.getElementById('admin-institute-code');

            if (instituteCodeElement && institute.code) {
                instituteCodeElement.textContent = institute.code;
            }

            const sidebarInstituteName =
                document.getElementById('admin-sidebar-institute-name');

            if (sidebarInstituteName && institute.name) {
                sidebarInstituteName.textContent = institute.name;
            }
        } catch (error) {
            console.warn(
                'Could not read stored user details.',
                error
            );
        }

        async function loadInstituteConfiguration() {
            try {
                const response = await fetch(
                    '/api/v1/admin/configuration',
                    {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': `Bearer ${token}`
                        }
                    }
                );

                if (response.status === 401) {
                    localStorage.removeItem(tokenKey);
                    localStorage.removeItem(userKey);
                    localStorage.removeItem(instituteCodeKey);

                    window.location.replace(
                        instituteCode
                            ? `/login/${encodeURIComponent(instituteCode)}`
                            : '/'
                    );

                    return;
                }

                if (!response.ok) {
                    throw new Error(
                        `Configuration request failed with status ${response.status}`
                    );
                }

                const result = await response.json();

                if (!result.status || !result.data) {
                    throw new Error(
                        'Institute configuration not found.'
                    );
                }

                const configuration = result.data;

                const instituteNameBadge =
                    document.getElementById('admin-institute-name-badge');

                if (instituteNameBadge && configuration.institute?.name) {
                    instituteNameBadge.textContent =
                        configuration.institute.name;
                }

                const instituteCodeElement =
                    document.getElementById('admin-institute-code');

                if (instituteCodeElement && configuration.institute?.code) {
                    instituteCodeElement.textContent =
                        configuration.institute.code;
                }

                /*
                |--------------------------------------------------------------------------
                | Database Colors
                |--------------------------------------------------------------------------
                */
                const primaryColor = configuration.primary_color;
                const secondaryColor = configuration.secondary_color;

                if (!primaryColor || !secondaryColor) {
                    throw new Error(
                        'Institute primary and secondary colors are missing from configuration.'
                    );
                }

                document.documentElement.style.setProperty(
                    '--institute-primary',
                    primaryColor
                );

                document.documentElement.style.setProperty(
                    '--institute-secondary',
                    secondaryColor
                );

                /*
                |--------------------------------------------------------------------------
                | Database Logo
                |--------------------------------------------------------------------------
                */
                if (configuration.main_logo) {
                    const logo =
                        document.getElementById('admin-institute-logo');

                    if (logo) {
                        logo.src = '/storage/' + configuration.main_logo;
                        logo.style.display = 'block';
                    }

                    const icon =
                        document.getElementById('admin-institute-icon');

                    if (icon) {
                        icon.style.display = 'none';
                    }
                }

                /*
                |--------------------------------------------------------------------------
                | Browser Title
                |--------------------------------------------------------------------------
                */
                const instituteName =
                    document.getElementById('admin-institute-name');

                if (
                    instituteName &&
                    instituteName.textContent.trim()
                ) {
                    document.title =
                        instituteName.textContent.trim() +
                        ' - Institute Admin';
                }
            } catch (error) {
                console.error(
                    'Failed to load institute configuration:',
                    error
                );
            }
        }

        // Load configuration
        loadInstituteConfiguration();

        // Logout
        document.getElementById('admin-logout')?.addEventListener(
            'click',
            async () => {
                const button = document.getElementById('admin-logout');

                button.disabled = true;

                try {
                    await fetch(
                        '/api/v1/logout',
                        {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'Authorization': `Bearer ${token}`
                            }
                        }
                    );
                } catch (error) {
                    // Token will still be cleared below.
                } finally {
                    localStorage.removeItem(tokenKey);
                    localStorage.removeItem(userKey);

                    window.location.replace(
                        instituteCode
                            ? `/login/${encodeURIComponent(instituteCode)}`
                            : '/'
                    );
                }
            }
        );

        const spaContent = document.getElementById('spaContent');
        let spaLoading = false;

        function normalizePath(path) {
            return path.replace(/\/+$/, '') || '/';
        }

        function updateActiveSidebar(url = window.location.href) {
            const currentPath = normalizePath(
                new URL(url, window.location.origin).pathname
            );

            sidebar?.querySelectorAll('a[data-spa-link]').forEach(link => {
                const linkPath = normalizePath(
                    new URL(link.href, window.location.origin).pathname
                );

                const active = currentPath === linkPath;

                link.classList.toggle('bg-primary', active);
                link.classList.toggle('text-on-primary', active);
                link.classList.toggle(
                    'text-on-primary-container',
                    !active
                );
                link.classList.toggle('relative', active);
                link.classList.toggle('font-semibold', active);
                link.classList.toggle("before:content-['']", active);
                link.classList.toggle('before:absolute', active);
                link.classList.toggle('before:left-0', active);
                link.classList.toggle('before:top-0', active);
                link.classList.toggle('before:bottom-0', active);
                link.classList.toggle('before:w-1', active);
                link.classList.toggle(
                    'before:bg-secondary-fixed',
                    active
                );
                link.setAttribute(
                    'aria-current',
                    active ? 'page' : 'false'
                );
            });
        }

        async function navigateSPA(url, pushState = true) {
            if (spaLoading) return;

            try {
                if (typeof window.dashboardCleanup === 'function') {
                    window.dashboardCleanup();
                }

                spaLoading = true;
                spaContent.classList.add(
                    'opacity-50',
                    'pointer-events-none'
                );

                const response = await fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'text/html'
                    }
                });

                if (!response.ok) {
                    window.location.href = url;
                    return;
                }

                const html = await response.text();
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newContent = doc.getElementById('spaContent');

                if (!newContent) {
                    window.location.href = url;
                    return;
                }

                spaContent.innerHTML = newContent.innerHTML;

                if (pushState) {
                    history.pushState({}, '', url);
                }

                document.title = doc.title;
                executePageScripts(spaContent);
                updateActiveSidebar(url);
                closeMenu();

                window.scrollTo({
                    top: 0,
                    behavior: 'instant'
                });
            } catch (error) {
                console.error('SPA navigation failed:', error);
                window.location.href = url;
            } finally {
                spaLoading = false;
                spaContent.classList.remove(
                    'opacity-50',
                    'pointer-events-none'
                );
            }
        }

        function executePageScripts(container) {
            container.querySelectorAll('script').forEach(oldScript => {
                const newScript = document.createElement('script');

                Array.from(oldScript.attributes).forEach(attribute => {
                    newScript.setAttribute(
                        attribute.name,
                        attribute.value
                    );
                });

                newScript.textContent = oldScript.textContent;
                oldScript.replaceWith(newScript);
            });
        }

        document.addEventListener('click', event => {
            const link = event.target.closest('a[data-spa-link]');

            if (!link) return;

            if (
                event.ctrlKey ||
                event.metaKey ||
                event.shiftKey ||
                event.altKey ||
                link.target === '_blank'
            ) {
                return;
            }

            const url = new URL(link.href, window.location.origin);

            if (url.origin !== window.location.origin) return;

            event.preventDefault();
            navigateSPA(url.href);
        });

        window.addEventListener('popstate', () => {
            navigateSPA(window.location.href, false);
        });

        updateActiveSidebar();
    })();
    document.addEventListener('DOMContentLoaded', () => {
        const isImpersonating = localStorage.getItem('is_impersonating');
        const banner = document.getElementById('impersonationBanner');
        const header = document.querySelector('header');
        const sidebar = document.getElementById('admin-sidebar');
        const mainContent = document.getElementById('spaContent');
        if (isImpersonating === 'true' && banner) {
            banner.classList.remove('hidden');
            if (header) header.style.top = '41px'; 
            if (sidebar) sidebar.style.top = '41px';
            if (sidebar) sidebar.style.height = 'calc(100vh - 41px)';
            if (mainContent) mainContent.style.paddingTop = '95px';
        }
    });
    function exitImpersonationMode() {
        const backupToken = localStorage.getItem('backup_super_admin_token');

        if (backupToken) {
            localStorage.setItem('student_diary_token', backupToken);
            localStorage.removeItem('backup_super_admin_token');
            localStorage.removeItem('is_impersonating');

            setTimeout(() => {
                window.location.href = '/super-admin/institutes'; 
            }, 300);
        } else {
            alert('Super admin backup session missing.');
            window.location.href = '/login';
        }
    }
    function openAnnouncementModal() {
        const msgBox = document.getElementById('admin_announcement_msg');
        if (msgBox) msgBox.value = '';
        const modal = document.getElementById('announcementModal');
        if (modal) modal.classList.remove('hidden');
    }

    function closeAnnouncementModal() {
        const modal = document.getElementById('announcementModal');
        if (modal) modal.classList.add('hidden');
    }

    async function publishAnnouncement(e) {
        e.preventDefault();
        const messageInput = document.getElementById('admin_announcement_msg');
        if (!messageInput) return;
        
        const message = messageInput.value;
        const token = localStorage.getItem('student_diary_token');

        try {
            const response = await fetch('/api/v1/admin/announcements', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify({ message })
            });
            
            const result = await response.json();
            
            if (!response.ok) {
                throw new Error(result.message || 'Failed to publish announcement.');
            }
            closeAnnouncementModal();
            
        } catch (err) {
            alert(err.message);
        }
    }
    </script>
</body>
</html>