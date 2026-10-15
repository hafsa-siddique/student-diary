
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Dashboard | Student Diary</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Material+Symbols+Rounded" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1f1c1c',
                        secondary: '#C9A227',
                        canvas: '#F5F7FA'
                    },
                    fontFamily: { sans: ['Inter', 'sans-serif'] }
                }
            }
        }
    </script>
    <style>
        body { font-family: Inter, sans-serif; }
        .material-symbols-rounded { font-size: 22px; font-variation-settings: 'FILL' 0, 'wght' 400; }
        .nav-link { position: relative; transition: transform 0.3s ease;}
        .nav-link.active {
            background: rgba(255, 255, 255, 0.185);
            color: #fff;
            font-weight: 600;
        }
        .nav-link:not(.active):hover {
            transform: translateX(4px);
        }
        .nav-link.active::before {
            content: "";
            position: absolute;
            left: 0;
            top: 20%;
            height: 60%;
            width: 4px;
            background: #C9A227;
            border-radius: 0 4px 4px 0;
        }
        .nav-link.active .material-symbols-rounded { font-variation-settings: 'FILL' 1; color: #fff; }
        .sidebar { transition: transform .25s ease; }
        .logo-gold {
            filter: brightness(0) saturate(100%) invert(72%) sepia(55%) saturate(600%) hue-rotate(5deg) brightness(95%);
        }
    </style>
</head>
<body class="bg-canvas text-slate-800">
<div class="min-h-screen">
    <div id="sidebarOverlay" onclick="toggleSidebar()" class="fixed inset-0 z-40 hidden bg-slate-950/40 lg:hidden"></div>

    <aside id="sidebar" class="sidebar fixed inset-y-0 left-0 z-50 flex w-64 -translate-x-full flex-col border-r border-slate-200 bg-primary lg:translate-x-0">
        <div class="mx-4 flex h-16 items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center overflow-hidden rounded-xl border border-[#C9A227]/40 bg-[#1F1C1C]">
                <img src="{{ asset('storage/images/student-diary-logo.png') }}"
                class="h-8 w-8 object-contain logo-gold"
                alt="Student Diary">
                <span class="hidden text-lg font-bold text-[#C9A227]">SD</span>
            </div>
            <div>
                <h1 class="text-base font-bold tracking-tight text-secondary">Student Diary</h1>
            </div>
            <button onclick="toggleSidebar()" class="ml-auto text-slate-300 lg:hidden" aria-label="Close menu">
                <span class="material-symbols-rounded">close</span>
            </button>
        </div>

        <div class="px-4 pt-6">
            <p class="mb-3 px-3 text-[10px] font-bold uppercase tracking-[.18em] text-slate-300">Main Menu</p>
            <nav class="space-y-1">
                <a href="{{ route('super-admin.dashboard') }}" class="nav-link {{ request()->routeIs('super-admin.dashboard') ? 'active' : '' }} flex items-center gap-3 rounded-xl px-3 py-3 text-sm text-white">
                    <span class="material-symbols-rounded">dashboard</span> Dashboard
                </a>
                <a href="{{ url('/super-admin/institutes') }}" class="nav-link {{ request()->is('super-admin/institutes*') ? 'active' : '' }} flex items-center gap-3 rounded-xl px-3 py-3 text-sm text-white">
                    <span class="material-symbols-rounded">domain</span> Institutes
                </a>
                <a href="{{ url('/super-admin/settings') }}" class="nav-link {{ request()->is('super-admin/settings*') ? 'active' : '' }} flex items-center gap-3 rounded-xl px-3 py-3 text-sm text-white">
                    <span class="material-symbols-rounded">tune</span> Platform Settings
                </a>
            </nav>
        </div>

        <div class="mt-auto p-4">
            <div>
                <button onclick="logout()" class="flex w-full items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium text-white hover:text-secondary">
                    <span class="material-symbols-rounded">logout</span> Log Out
                </button>
            </div>
        </div>
    </aside>

    <main class="min-h-screen lg:ml-64">
        <header class="sticky top-0 z-30 flex h-16 items-center justify-between border-b border-slate-200 bg-white/60 px-4 backdrop-blur sm:px-8">
            <div class="flex min-w-0 flex-1 items-center gap-3">
                <button onclick="toggleSidebar()" class="rounded-lg p-2 text-slate-600 hover:bg-slate-100 lg:hidden" aria-label="Open menu">
                    <span class="material-symbols-rounded">menu</span>
                </button>
                <div class="relative w-1/2">
                    <div class="relative">
                        <span class="material-symbols-rounded absolute left-3 top-1/2 -translate-y-1/2 text-[20px] text-slate-400">search</span>
                        <input type="text" id="instituteSearch" autocomplete="off" placeholder="Search by institute name or code..."
                            class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/10">
                    </div>
                    <div id="instituteSearchResults" class="absolute left-0 right-0 top-full z-50 mt-2 hidden max-h-80 overflow-y-auto rounded-xl border border-slate-200 bg-white py-2 shadow-lg"></div>
                </div>
            </div>
            <div class="flex shrink-0 items-center gap-3 sm:gap-4">
                <div class="hidden text-right sm:block">
                    <p id="superAdminName" class="text-sm font-semibold text-slate-800">Super Administrator</p>
                    <p class="text-xs text-slate-500">Platform Owner</p>
                </div>
                <div class="flex h-10 w-10 items-center justify-center border-2 border-[#C9A227] rounded-full bg-white text-sm font-bold text-secondary">
                    SA
                </div>
            </div>
        </header>

        <div class="mx-auto max-w-[1600px] space-y-7 px-4 sm:px-8 sm:pt-4">
            @yield('content')
        </div>
    </main>
</div>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('-translate-x-full');
        document.getElementById('sidebarOverlay').classList.toggle('hidden');
    }

    function logout() {
        localStorage.removeItem('student_diary_token');
        localStorage.removeItem('student_diary_user');
        localStorage.removeItem('student_diary_institute_code');
        window.location.href = "{{ route('super-admin-login') }}";
    }

    document.addEventListener('DOMContentLoaded', () => {
        const user = JSON.parse(localStorage.getItem('student_diary_user') || 'null');
        if (user?.role === 'super_admin') {
            document.getElementById('superAdminName').textContent = user.name || 'Super Administrator';
        }
    });
    const instituteSearch = document.getElementById('instituteSearch');
    const searchResults = document.getElementById('instituteSearchResults');
    let searchTimer;
    instituteSearch.addEventListener('input', () => {
        clearTimeout(searchTimer);
        const search = instituteSearch.value.trim();
        if (search.length < 1) {
            searchResults.classList.add('hidden');
            searchResults.innerHTML = '';
            return;
        }
        searchResults.innerHTML = '<p class="px-4 py-3 text-sm text-slate-500">Searching...</p>';
        searchResults.classList.remove('hidden');
        searchTimer = setTimeout(async () => {
            try {
                const token = localStorage.getItem('student_diary_token');
                const response = await fetch(`/api/v1/super-admin/institutes?search=${encodeURIComponent(search)}`, {
                    headers: { Accept: 'application/json', Authorization: `Bearer ${token}` }
                });
                if (!response.ok) throw new Error('Search failed');
                const result = await response.json();
                const institutes = Array.isArray(result.data) ? result.data : [];
                searchResults.innerHTML = '';
                if (!institutes.length) {
                    searchResults.innerHTML = '<p class="px-4 py-3 text-sm text-slate-500">No institutes found.</p>';
                } else {
                    institutes.forEach(institute => {
                        const link = document.createElement('a');
                        link.href = `/super-admin/institutes/${institute.id}/view`;
                        link.className = 'flex items-center gap-3 px-4 py-3 hover:bg-slate-50 transition';
                        const icon = document.createElement('span');
                        icon.className = 'material-symbols-rounded flex h-10 w-10 items-center justify-center rounded-lg bg-amber-50 text-amber-700';
                        icon.textContent = 'domain';
                        const info = document.createElement('div');
                        info.className = 'min-w-0 flex-1';
                        const name = document.createElement('p');
                        name.className = 'truncate text-sm font-semibold text-slate-800';
                        name.textContent = institute.name;
                        const code = document.createElement('p');
                        code.className = 'text-xs text-slate-500';
                        code.textContent = `Code: ${institute.code}`;
                        info.append(name, code);
                        link.append(icon, info);
                        searchResults.appendChild(link);
                    });
                }
                searchResults.classList.remove('hidden');
            } catch (error) {
                searchResults.innerHTML = '<p class="px-4 py-3 text-sm text-red-600">Unable to search institutes.</p>';
                searchResults.classList.remove('hidden');
            }
        }, 300);
    });
    document.addEventListener('click', event => {
        if (!instituteSearch.contains(event.target) && !searchResults.contains(event.target)) {
            searchResults.classList.add('hidden');
        }
    });
    instituteSearch.addEventListener('keydown', event => {
        if (event.key === 'Escape') searchResults.classList.add('hidden');
    });
</script>
</body>
</html>
