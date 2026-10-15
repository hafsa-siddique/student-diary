@extends('layouts.super-admin')

@section('content')
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <div class="flex items-center gap-3">
            <a href="{{ url('/super-admin/institutes') }}" class="inline-flex px-3 py-1 items-center justify-center rounded-lg bg-slate text-slate-600 transition hover:bg-white">
                <span class="material-symbols-rounded text-sm">arrow_back</span>
            </a>
            <!-- Logo & Name Header Container -->
            <div class="flex items-center gap-3">
                <div id="headerLogoContainer" class="flex h-20 w-20 items-center justify-center overflow-hidden flex-shrink-0">
                    <img id="instituteHeaderLogo" src="" alt="Institute Logo" class="hidden h-full w-full object-contain">
                    <span id="headerLogoFallback" class="material-symbols-rounded text-3xl text-slate-400">domain</span>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-slate-800" id="instituteNameHeader">Loading Institute...</h1>
                    <p class="mt-0.5 text-xs font-mono text-slate-500">Institute Code: <span id="headerInstituteCode" class="font-semibold text-slate-700">—</span></p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="flex items-center gap-3">
        <!-- View Mode Buttons -->
        <div id="viewModeButtons" class="flex items-center gap-2">
            <button type="button" onclick="openDashboardPreview()" class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-4 py-1 text-sm font-semibold text-slate-700 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md">
                <span class="material-symbols-rounded text-lg text-primary">visibility</span> Preview Dashboard
            </button>
            <button type="button" onclick="enableEditMode()" class="inline-flex items-center gap-1 rounded-lg bg-secondary/85 px-4 py-1 text-sm font-semibold text-primary transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md">
                <span class="material-symbols-rounded text-lg">edit</span> Edit Details
            </button>
            
        </div>

        <!-- Edit Mode Buttons -->
        <div id="editModeButtons" class="hidden flex items-center gap-2">
            <button type="button" onclick="discardChanges()" class="inline-flex items-center gap-1 rounded-lg border border-slate-200 bg-white px-4 py-1 text-sm font-semibold text-primary transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md">
                Discard
            </button>
            <button type="button" onclick="saveAllChanges()" class="inline-flex items-center gap-1 rounded-lg bg-emerald-600 px-4 py-1 text-sm font-semibold text-white transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md hover:bg-emerald-700">
                <span class="material-symbols-rounded text-lg">save</span> Save Changes
            </button>
        </div>
    </div>
</div>

<!-- Main Details Layout Container -->
<div id="instituteDetailContainer" class="grid grid-cols-1 gap-6 xl:grid-cols-3">
    
    <!-- Left Column: Institute Info & Full Configurations -->
    <div class="space-y-6 mb-6 xl:col-span-2">
        
        <!-- Card 1: Institute Information -->
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="font-bold text-slate-800 border-b border-slate-100 pb-4 mb-5">Institute Information</h3>
            
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <span class="block text-xs font-medium uppercase tracking-wider text-slate-400 mb-1">Institute Name</span>
                    <p id="view_name" class="text-sm font-semibold text-slate-800">—</p>
                    <input type="text" id="edit_name" class="hidden w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-sm font-semibold text-slate-800 focus:border-primary focus:outline-none">
                </div>
                <div>
                    <span class="block text-xs font-medium uppercase tracking-wider text-slate-400 mb-1">Institute Code</span>
                    <p id="view_code" class="text-sm font-semibold text-slate-800">—</p>
                    <input type="text" id="edit_code" class="hidden w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-sm font-semibold text-slate-800 focus:border-primary focus:outline-none">
                </div>
                <div>
                    <span class="block text-xs font-medium uppercase tracking-wider text-slate-400 mb-1">Contact Email</span>
                    <p id="view_contact_email" class="text-sm font-medium text-slate-700">—</p>
                    <input type="email" id="edit_contact_email" class="hidden w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-sm font-medium text-slate-700 focus:border-primary focus:outline-none">
                </div>
                <div>
                    <span class="block text-xs font-medium uppercase tracking-wider text-slate-400 mb-1">Contact Phone</span>
                    <p id="view_contact_phone" class="text-sm font-medium text-slate-700">—</p>
                    <input type="text" id="edit_contact_phone" class="hidden w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-sm font-medium text-slate-700 focus:border-primary focus:outline-none">
                </div>
                <div>
                    <span class="block text-xs font-medium uppercase tracking-wider text-slate-400 mb-1">Address Location</span>
                    <p id="view_address" class="text-sm font-medium text-slate-700">—</p>
                    <input type="text" id="edit_address" class="hidden w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-sm font-medium text-slate-700 focus:border-primary focus:outline-none">
                </div>
                <div>
                    <span class="block text-xs font-medium uppercase tracking-wider text-slate-400 mb-1">Website URL</span>
                    <p id="view_website" class="text-sm font-medium text-slate-700">—</p>
                    <input type="url" id="edit_website" class="hidden w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-sm font-medium text-slate-700 focus:border-primary focus:outline-none">
                </div>
            </div>
        </div>

        <!-- Card 2: Complete Configurations (All Fields + Palette Pickers) -->
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="font-bold text-slate-800 border-b border-slate-100 pb-4 mb-5">System Configurations & Theme Palette</h3>
            
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <!-- Color Palette Picker: Primary Color -->
                <div class="rounded-xl border border-slate-100 bg-slate-50 p-4 flex items-center justify-between sm:col-span-1">
                    <div>
                        <span class="block text-xs font-medium uppercase tracking-wider text-slate-400">Primary Color</span>
                        <p id="view_primary_color" class="text-sm font-mono font-bold text-slate-800 mt-0.5">—</p>
                    </div>
                    <!-- Right-side color box -->
                    <div id="view_primary_color_box" class="h-10 w-12 rounded-lg border border-slate-200 shadow-sm" style="background-color: #1E3A8A;"></div>
                    <input type="color" id="edit_primary_color" disabled class="hidden h-10 w-12 rounded-lg border border-slate-200 bg-white cursor-pointer disabled:opacity-60 disabled:cursor-not-allowed">
                </div>

                <!-- Color Palette Picker: Secondary Color -->
                <div class="rounded-xl border border-slate-100 bg-slate-50 p-4 flex items-center justify-between sm:col-span-1">
                    <div>
                        <span class="block text-xs font-medium uppercase tracking-wider text-slate-400">Secondary Color</span>
                        <p id="view_secondary_color" class="text-sm font-mono font-bold text-slate-800 mt-0.5">—</p>
                    </div>
                    <!-- Right-side color box -->
                    <div id="view_secondary_color_box" class="h-10 w-12 rounded-lg border border-slate-200 shadow-sm" style="background-color: #C9A227;"></div>
                    <input type="color" id="edit_secondary_color" disabled class="hidden h-10 w-12 rounded-lg border border-slate-200 bg-white cursor-pointer disabled:opacity-60 disabled:cursor-not-allowed">
                </div>
                <div>
                    <span class="block text-xs font-medium uppercase tracking-wider text-slate-400 mb-1">Main Logo</span>
                    <p id="view_main_logo" class="text-sm font-mono text-slate-600 truncate">—</p>
                    <input type="file" id="edit_main_logo" accept="image/*" class="hidden w-full rounded-xl border border-slate-200 bg-white px-3 py-1.5 text-sm text-slate-700 focus:border-primary focus:outline-none file:mr-4 file:py-1 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary file:text-white hover:file:bg-primary/90">
                </div>
                <div>
                    <span class="block text-xs font-medium uppercase tracking-wider text-slate-400 mb-1">Small Logo</span>
                    <p id="view_small_logo" class="text-sm font-mono text-slate-600 truncate">—</p>
                    <input type="file" id="edit_small_logo" accept="image/*" class="hidden w-full rounded-xl border border-slate-200 bg-white px-3 py-1.5 text-sm text-slate-700 focus:border-primary focus:outline-none file:mr-4 file:py-1 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary file:text-white hover:file:bg-primary/90">
                </div>
                <div>
                    <span class="block text-xs font-medium uppercase tracking-wider text-slate-400 mb-1">Login Logo</span>
                    <p id="view_login_logo" class="text-sm font-mono text-slate-600 truncate">—</p>
                    <input type="file" id="edit_login_logo" accept="image/*" class="hidden w-full rounded-xl border border-slate-200 bg-white px-3 py-1.5 text-sm text-slate-700 focus:border-primary focus:outline-none file:mr-4 file:py-1 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary file:text-white hover:file:bg-primary/90">
                </div>
                <div>
                    <span class="block text-xs font-medium uppercase tracking-wider text-slate-400 mb-1">Login Cover Image</span>
                    <p id="view_login_cover_image" class="text-sm font-mono text-slate-600 truncate">—</p>
                    <input type="file" id="edit_login_cover_image" accept="image/*" class="hidden w-full rounded-xl border border-slate-200 bg-white px-3 py-1.5 text-sm text-slate-700 focus:border-primary focus:outline-none file:mr-4 file:py-1 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary file:text-white hover:file:bg-primary/90">
                </div>
                <div class="sm:col-span-2">
                    <span class="block text-xs font-medium uppercase tracking-wider text-slate-400 mb-1">Favicon</span>
                    <p id="view_favicon" class="text-sm font-mono text-slate-600 truncate">—</p>
                    <input type="file" id="edit_favicon" accept="image/*" class="hidden w-full rounded-xl border border-slate-200 bg-white px-3 py-1.5 text-sm text-slate-700 focus:border-primary focus:outline-none file:mr-4 file:py-1 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary file:text-white hover:file:bg-primary/90">
                </div>

                
            </div>
        </div>

    </div>

    <!-- Right Column: Institute Admin Info Card & Account Status Switch -->
    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-4">
                <h3 class="font-bold text-slate-800">Institute Administrator</h3>
                <span id="adminStatusBadge" class="rounded-full px-2.5 py-0.5 text-xs font-semibold bg-slate-100 text-slate-600">—</span>
            </div>
            
            <div class="space-y-4">
                <div>
                    <span class="block text-xs font-medium uppercase tracking-wider text-slate-400 mb-1">Admin Name</span>
                    <p id="view_admin_name" class="text-sm font-bold text-slate-800">—</p>
                    <input type="text" id="edit_admin_name" class="hidden w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-sm font-bold text-slate-800 focus:border-primary focus:outline-none">
                </div>
                <div>
                    <span class="block text-xs font-medium uppercase tracking-wider text-slate-400 mb-1">Admin Email</span>
                    <p id="view_admin_email" class="text-sm font-medium text-slate-700 break-all">—</p>
                    <input type="email" id="edit_admin_email" class="hidden w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-sm font-medium text-slate-700 focus:border-primary focus:outline-none">
                </div>

                <!-- Admin Status Toggle Button -->
                <div class="pt-2">
                    <button type="button" id="toggleAdminStatusBtn" onclick="toggleAdminAccountStatus()" class="w-full flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-4 py-2 text-xs font-semibold text-slate-700 transition hover:bg-slate-100">
                        <span class="material-symbols-rounded text-base" id="toggleAdminIcon">power_settings_new</span>
                        <span id="toggleAdminText">Toggle Admin Status</span>
                    </button>
                </div>
            </div>
        </div>
        <!-- Card: Login Layout Preview & Selection -->
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-4">
                <h3 class="font-bold text-slate-800">Login Page Layout</h3>
                <span id="layoutBadge" class="rounded-full px-2.5 py-0.5 text-xs font-semibold bg-indigo-50 text-indigo-700">Layout One</span>
            </div>
            <div class="space-y-4">
                <!-- View Mode Layout Content -->
                <div id="view_login_layout_container" class="space-y-9">
                    <div>
                        <p id="view_login_layout_name" class="text-sm font-bold text-slate-800">Split-Screen with Cover Image</p>
                        <p class="text-xs text-slate-500 mt-0.5">Active design displayed to institute users on login.</p>
                    </div>
                    <!-- Layout Thumbnail Preview Container -->
                    <div class="rounded-xl border border-slate-200 bg-slate-50 overflow-hidden h-36 flex items-center justify-center relative">
                        <img id="layoutThumbnail" src="" alt="Layout Preview" class="w-full h-full object-cover">
                        <span id="layoutThumbnailPlaceholder" class="material-symbols-rounded text-3xl text-slate-400">web</span>
                    </div>
                </div>
                <!-- Edit Mode Select Dropdown (Hidden by default) -->
                <div id="edit_login_layout_container" class="hidden space-y-2">
                    <label class="block text-xs font-medium uppercase tracking-wider text-slate-400">Select Layout Style</label>
                    <select id="edit_login_layout" class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-sm font-semibold text-slate-800 focus:border-primary focus:outline-none">
                        <option value="">Inherit Global Default</option>
                        <option value="layout_one">Layout One (Split-Screen Cover)</option>
                        <option value="layout_two">Layout Two (Centered Glass Card)</option>
                    </select>
                    <div class="grid grid-cols-2 gap-3">
                        <!-- Layout One Card Option -->
                        <div onclick="selectLayoutOption('layout_one')" id="card_option_layout_one" class="cursor-pointer rounded-xl border-2 border-slate-200 bg-slate-50 p-2.5 transition-all hover:border-primary">
                            <div class="h-28 rounded-lg overflow-hidden border border-slate-200 mb-2 bg-white relative">
                                <img src="/storage/images/Login%20Layout%20One.png" alt="Layout One" class="w-full h-full object-cover">
                            </div>
                            <p class="text-xs font-bold text-slate-800 text-center">Layout One</p>
                            <p class="text-[10px] text-slate-500 text-center">Split-Screen Cover</p>
                        </div>
                        <!-- Layout Two Card Option -->
                        <div onclick="selectLayoutOption('layout_two')" id="card_option_layout_two" class="cursor-pointer rounded-xl border-2 border-slate-200 bg-slate-50 p-2.5 transition-all hover:border-primary">
                            <div class="h-28 rounded-lg overflow-hidden border border-slate-200 mb-2 bg-white relative">
                                <img src="/storage/images/Login%20Layout%20Two.png" alt="Layout Two" class="w-full h-full object-cover">
                            </div>
                            <p class="text-xs font-bold text-slate-800 text-center">Layout Two</p>
                            <p class="text-[10px] text-slate-500 text-center">Centered Glass Card</p>
                        </div>
                    </div>
                    <p class="text-xs text-slate-400">Choose a custom login layout for this specific institute.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Dashboard Preview Modal -->
<div id="dashboardPreviewModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-2 sm:p-4">
    <div class="relative w-full max-w-6xl h-[90vh] rounded-2xl bg-[#f2fdec] shadow-2xl overflow-hidden flex flex-col border border-slate-200">
        <!-- Modal Top Control Bar -->
        <div class="flex items-center justify-between border-b border-slate-200 px-6 py-3 bg-white z-20 shrink-0">
            <div class="flex items-center gap-2">
                <span class="material-symbols-rounded text-primary">preview</span>
                <h3 class="font-bold text-slate-800 text-sm">Live Admin Dashboard Theme Preview</h3>
            </div>
            <button type="button" onclick="closeDashboardPreview()" class="rounded-lg p-1 text-slate-400 hover:bg-slate-100 hover:text-slate-700 transition">
                <span class="material-symbols-rounded">close</span>
            </button>
        </div>
        <!-- Simulated Dashboard Viewport Container -->
        <div class="flex-1 flex overflow-hidden relative">
            <!-- Simulated Sidebar -->
            <aside id="previewSidebar" class="w-60 bg-primary z-10 flex flex-col justify-between overflow-y-auto shrink-0 select-none text-white transition-colors duration-300">
                <div class="flex flex-col">
                    <div class="h-16 px-4 flex items-center gap-3 bg-black/10">
                        <img id="previewModalLogo" src="" alt="Institute Logo" class="h-9 w-9 rounded-lg object-contain bg-white shrink-0" style="display: none;">
                        <div id="previewModalIconBox" class="h-9 w-9 rounded-lg bg-white/20 text-white flex items-center justify-center shrink-0">
                            <span class="material-symbols-rounded text-sm">school</span>
                        </div>
                        <div class="flex flex-col min-w-0">
                            <span id="previewModalInstituteName" class="font-bold text-sm truncate tracking-tight text-white">Student Diary</span>
                            <span id="previewModalInstituteCode" class="text-[10px] uppercase tracking-wider opacity-80 mt-0.5">CODE</span>
                        </div>
                    </div>

                    <nav class="p-2 flex flex-col gap-1 text-xs">
                        <div class="px-2 pt-2 pb-1"><span class="uppercase tracking-wider opacity-70 text-[10px]">Overview</span></div>
                        <div class="flex items-center gap-2 px-2 py-2 rounded-lg bg-black/20 font-semibold">
                            <span class="material-symbols-rounded text-[16px]">dashboard</span> Dashboard
                        </div>
                        <div class="px-2 pt-3 pb-1"><span class="uppercase tracking-wider opacity-70 text-[10px]">People</span></div>
                        <div class="flex items-center gap-2 px-2 py-2 rounded-lg opacity-80 hover:bg-black/10">
                            <span class="material-symbols-rounded text-[16px]">school</span> Teachers
                        </div>
                        <div class="flex items-center gap-2 px-2 py-2 rounded-lg opacity-80 hover:bg-black/10">
                            <span class="material-symbols-rounded text-[16px]">group</span> Parents
                        </div>
                        <div class="flex items-center gap-2 px-2 py-2 rounded-lg opacity-80 hover:bg-black/10">
                            <span class="material-symbols-rounded text-[16px]">person</span> Students
                        </div>
                    </nav>
                </div>
                <div class="p-2 bg-black/10">
                    <div class="flex items-center gap-2 px-2 py-2 rounded-lg opacity-80 text-xs">
                        <span class="material-symbols-rounded text-[16px]">account_circle</span> Profile
                    </div>
                </div>
            </aside>

            <!-- Simulated Main Shell -->
            <div class="flex-1 flex flex-col overflow-y-auto">
                <!-- Simulated Top Navbar -->
                <header class="sticky top-0 h-16 bg-white/90 backdrop-blur-md z-10 border-b border-slate-200 px-6 flex items-center justify-between">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-100">
                        <span class="material-symbols-rounded text-[16px] text-slate-600">corporate_fare</span>
                        <span class="text-xs font-semibold text-slate-700" id="previewNavCodeLabel">Institute Code</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="flex flex-col text-left">
                            <span class="text-xs font-bold text-slate-800 text-right">Admin Account</span>
                            <span class="text-[10px] text-slate-500">Active Session Preview</span>
                        </div>
                        <div id="previewUserAvatar" class="w-8 h-8 rounded-full flex bg-white items-center justify-center text-xs font-bold border-2" style="color: var(--preview-primary, #1E3A8A); border-color: var(--preview-primary, #1E3A8A);">A</div>
                    </div>
                </header>
                <!-- Simulated Dashboard Content Body -->
                <main class="p-6 space-y-6">
                    <!-- Title Bar -->
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            <div class="flex items-center gap-2">
                                <h1 class="text-xl font-bold text-slate-800 tracking-tight">Good morning, Admin</h1>
                                <span id="previewActiveBadge" class="text-[10px] font-semibold px-2 py-0.5 rounded-full text-white" style="background-color: #C9A227;">Active</span>
                            </div>
                            <p class="text-xs text-slate-500 mt-0.5">Manage your institute's people and academic setup from one place.</p>
                        </div>
                        <button type="button" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-white text-xs font-semibold shadow-sm" style="background-color: var(--preview-primary, #1E3A8A);">
                            <span class="material-symbols-rounded text-[14px]">person_add</span> + Add Student
                        </button>
                    </div>
                    <!-- 6 Metric Cards Grid -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
                        <div class="bg-white rounded-xl p-3 shadow-sm border border-slate-100 flex flex-col justify-between">
                            <span class="text-[10px] uppercase tracking-wider text-slate-400 font-semibold">Teachers</span>
                            <div class="mt-2"><span class="text-xl font-bold text-slate-800">12</span></div>
                        </div>
                        <div class="bg-white rounded-xl p-3 shadow-sm border border-slate-100 flex flex-col justify-between">
                            <span class="text-[10px] uppercase tracking-wider text-slate-400 font-semibold">Parents</span>
                            <div class="mt-2"><span class="text-xl font-bold text-slate-800">480</span></div>
                        </div>
                        <div class="bg-white rounded-xl p-3 shadow-sm border border-slate-100 flex flex-col justify-between">
                            <span class="text-[10px] uppercase tracking-wider text-slate-400 font-semibold">Students</span>
                            <div class="mt-2"><span class="text-xl font-bold text-slate-800">512</span></div>
                        </div>
                        <div class="bg-white rounded-xl p-3 shadow-sm border border-slate-100 flex flex-col justify-between">
                            <span class="text-[10px] uppercase tracking-wider text-slate-400 font-semibold">Classes</span>
                            <div class="mt-2"><span class="text-xl font-bold text-slate-800">10</span></div>
                        </div>
                        <div class="bg-white rounded-xl p-3 shadow-sm border border-slate-100 flex flex-col justify-between">
                            <span class="text-[10px] uppercase tracking-wider text-slate-400 font-semibold">Session</span>
                            <div class="mt-2"><span class="text-sm font-bold text-slate-800">2026-2027</span></div>
                        </div>
                        <div class="bg-white rounded-xl p-3 shadow-sm border border-slate-100 flex flex-col justify-between">
                            <span class="text-[10px] uppercase tracking-wider text-slate-400 font-semibold">Assignments</span>
                            <div class="mt-2"><span class="text-xl font-bold text-slate-800">34</span></div>
                        </div>
                    </div>

                    <!-- Shortcuts Strip -->
                    <div class="bg-white rounded-xl p-3 shadow-sm border border-slate-100">
                        <span class="text-[10px] uppercase tracking-wider text-slate-400 font-semibold block mb-2">Administrative Shortcuts</span>
                        <div class="grid grid-cols-3 sm:grid-cols-6 gap-2">
                            <div class="p-2 rounded-lg bg-slate-50 text-[11px] font-medium text-slate-700 text-center truncate">Add Teacher</div>
                            <div class="p-2 rounded-lg bg-slate-50 text-[11px] font-medium text-slate-700 text-center truncate">Add Parent</div>
                            <div class="p-2 rounded-lg bg-slate-50 text-[11px] font-medium text-slate-700 text-center truncate">Add Student</div>
                            <div class="p-2 rounded-lg bg-slate-50 text-[11px] font-medium text-slate-700 text-center truncate">Create Class</div>
                            <div class="p-2 rounded-lg bg-slate-50 text-[11px] font-medium text-slate-700 text-center truncate">Add Subject</div>
                            <div class="p-2 rounded-lg bg-slate-50 text-[11px] font-medium text-slate-700 text-center truncate">Assign Teacher</div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</div>

<div id="toastNotification" class="fixed bottom-5 right-5 z-50 hidden transform translate-y-2 opacity-0 transition-all duration-300 flex items-center gap-3 bg-slate-900 text-white px-5 py-3 rounded-xl shadow-2xl border border-slate-700">
    <span id="toastIcon" class="material-symbols-rounded text-emerald-400 text-xl">check_circle</span>
    <p id="toastMessage" class="text-sm font-medium">Saved successfully!</p>
</div>

<script>
const pathSegments = window.location.pathname.split('/');
const instituteId = pathSegments[pathSegments.indexOf('institutes') + 1];
let originalDataCache = {};

document.addEventListener('DOMContentLoaded', fetchInstituteProfileData);

const isActiveStatus = val => [1, true, '1', 'active'].includes(typeof val === 'string' ? val.toLowerCase() : val);

async function fetchInstituteProfileData() {
    const token = localStorage.getItem('student_diary_token');

    try {
        const [instRes, configRes, adminRes] = await Promise.all([
            fetch(`/api/v1/super-admin/institutes/${instituteId}`, { headers: { 'Accept': 'application/json', 'Authorization': `Bearer ${token}` } }),
            // Fixed route to singular /configuration matching your routes file
            fetch(`/api/v1/super-admin/institutes/${instituteId}/configuration`, { headers: { 'Accept': 'application/json', 'Authorization': `Bearer ${token}` } }).catch(() => null),
            fetch(`/api/v1/super-admin/institutes/${instituteId}/admin`, { headers: { 'Accept': 'application/json', 'Authorization': `Bearer ${token}` } }).catch(() => null)
        ]);

        const instJson = await instRes.json();
        const institute = instJson.data ?? {};

        let config = {};
        if (configRes && configRes.ok) {
            const cfgJson = await configRes.json();
            config = cfgJson.data ?? {};
        }

        let admin = {};
        if (adminRes && adminRes.ok) {
            const adminJson = await adminRes.json();
            admin = adminJson.data ?? {};
        }

        originalDataCache = {
            name: institute.name ?? '',
            code: institute.code ?? '',
            contact_email: config.contact_email ?? '',
            contact_phone: config.contact_phone ?? '',
            address: config.address ?? '',
            website: config.website ?? '',
            login_layout: config.login_layout ?? '',
            main_logo: config.main_logo ?? '',
            small_logo: config.small_logo ?? '',
            login_logo: config.login_logo ?? '',
            login_cover_image: config.login_cover_image ?? '',
            favicon: config.favicon ?? '',
            primary_color: config.primary_color ?? '#1E3A8A',
            secondary_color: config.secondary_color ?? '#C9A227',
            admin_name: admin.name ?? '',
            admin_email: admin.email ?? '',
            admin_status: admin.status ?? 1
        };

        renderData(originalDataCache);
        updateAdminStatusUI(isActiveStatus(originalDataCache.admin_status));

    } catch (err) {
        console.error(err);
        alert('Failed to load institute details.');
    }
}

function renderData(data) {
    document.getElementById('instituteNameHeader').textContent = data.name || 'Institute Profile';
    if (document.getElementById('headerInstituteCode')) {
        document.getElementById('headerInstituteCode').textContent = data.code || '—';
    }
    const formatStorageUrl = (path) => {
        if (!path) return '';
        if (path.startsWith('http://') || path.startsWith('https://') || path.startsWith('blob:')) return path;
        const cleanPath = path.replace(/^\/+/, '');
        return cleanPath.startsWith('storage/') ? `/${cleanPath}` : `/storage/${cleanPath}`;
    };

    const headerLogoImg = document.getElementById('instituteHeaderLogo');
    const headerLogoFallback = document.getElementById('headerLogoFallback');
    const logoUrl = formatStorageUrl(data.main_logo || data.login_logo || data.small_logo);

    if (logoUrl) {
        headerLogoImg.src = logoUrl;
        headerLogoImg.classList.remove('hidden');
        if (headerLogoFallback) headerLogoFallback.classList.add('hidden');
    } else {
        headerLogoImg.classList.add('hidden');
        if (headerLogoFallback) headerLogoFallback.classList.remove('hidden');
    }

    const primaryColor = data.primary_color || '#1E3A8A';
    const viewPrimary = document.getElementById('view_primary_color');
    const viewPrimaryBox = document.getElementById('view_primary_color_box');
    const editPrimary = document.getElementById('edit_primary_color');
    
    if (viewPrimary) viewPrimary.textContent = primaryColor;
    if (viewPrimaryBox) viewPrimaryBox.style.backgroundColor = primaryColor;
    if (editPrimary) editPrimary.value = primaryColor;

    const secondaryColor = data.secondary_color || '#C9A227';
    const viewSecondary = document.getElementById('view_secondary_color');
    const viewSecondaryBox = document.getElementById('view_secondary_color_box');
    const editSecondary = document.getElementById('edit_secondary_color');

    if (viewSecondary) viewSecondary.textContent = secondaryColor;
    if (viewSecondaryBox) viewSecondaryBox.style.backgroundColor = secondaryColor;
    if (editSecondary) editSecondary.value = secondaryColor;

    for (const key in data) {
        if (key === 'primary_color' || key === 'secondary_color' || key === 'login_layout') continue;

        const viewEl = document.getElementById(`view_${key}`);
        const editEl = document.getElementById(`edit_${key}`);
        
        if (viewEl) {
            viewEl.textContent = data[key] || '—';
        }
        if (editEl && editEl.type !== 'file') {
            editEl.value = data[key] ?? '';
        }
    }
    // Login Layout Card Rendering
    const layoutNameEl = document.getElementById('view_login_layout_name');
    const layoutBadgeEl = document.getElementById('layoutBadge');
    const editLayoutEl = document.getElementById('edit_login_layout');
    const layoutThumbnail = document.getElementById('layoutThumbnail');
    const layoutThumbnailPlaceholder = document.getElementById('layoutThumbnailPlaceholder');

    const layoutVal = data.login_layout || '';
    if (editLayoutEl) editLayoutEl.value = layoutVal;

    if (layoutVal === 'layout_two') {
        if (layoutNameEl) layoutNameEl.textContent = 'Centered Glass Card / Modern Clean';
        if (layoutBadgeEl) layoutBadgeEl.textContent = 'Layout Two';
        layoutThumbnail.src = '/storage/images/' + encodeURIComponent('Login Layout Two.png');
        layoutThumbnail.classList.remove('hidden');
        layoutThumbnailPlaceholder.classList.add('hidden');
    } else if (layoutVal === 'layout_one') {
        if (layoutNameEl) layoutNameEl.textContent = 'Split-Screen with Cover Image';
        if (layoutBadgeEl) layoutBadgeEl.textContent = 'Layout One';
        layoutThumbnail.src = '/storage/images/' + encodeURIComponent('Login Layout One.png');
        layoutThumbnail.classList.remove('hidden');
        layoutThumbnailPlaceholder.classList.add('hidden');
    } else {
        if (layoutNameEl) layoutNameEl.textContent = 'Global Platform Default';
        if (layoutBadgeEl) layoutBadgeEl.textContent = 'Inherited';
        layoutThumbnail.classList.add('hidden');
        layoutThumbnailPlaceholder.classList.remove('hidden');
    }
}

function enableEditMode() {
    document.querySelectorAll('[id^="view_"]').forEach(el => el.classList.add('hidden'));
    document.querySelectorAll('[id^="edit_"]').forEach(el => el.classList.remove('hidden'));
    document.getElementById('view_login_layout_container').classList.add('hidden');
    document.getElementById('edit_login_layout_container').classList.remove('hidden');
    document.getElementById('edit_primary_color').disabled = false;
    document.getElementById('edit_secondary_color').disabled = false;

    document.getElementById('viewModeButtons').classList.add('hidden');
    document.getElementById('editModeButtons').classList.remove('hidden');
}

function discardChanges() {
    renderData(originalDataCache);
    lockEditMode();
}

function lockEditMode() {
    document.querySelectorAll('[id^="edit_"]').forEach(el => el.classList.add('hidden'));
    document.querySelectorAll('[id^="view_"]').forEach(el => el.classList.remove('hidden'));
    document.getElementById('edit_login_layout_container').classList.add('hidden');
    document.getElementById('view_login_layout_container').classList.remove('hidden');
    document.getElementById('edit_primary_color').disabled = true;
    document.getElementById('edit_secondary_color').disabled = true;

    document.getElementById('editModeButtons').classList.add('hidden');
    document.getElementById('viewModeButtons').classList.remove('hidden');
}

async function saveAllChanges() {
    const token = localStorage.getItem('student_diary_token');

    const institutePayload = {
        name: document.getElementById('edit_name').value,
        code: document.getElementById('edit_code').value,
    };

    const configFormData = new FormData();
    configFormData.append('_method', 'PUT');
    configFormData.append('contact_email', document.getElementById('edit_contact_email').value);
    configFormData.append('contact_phone', document.getElementById('edit_contact_phone').value);
    configFormData.append('address', document.getElementById('edit_address').value);
    configFormData.append('website', document.getElementById('edit_website').value);
    configFormData.append('primary_color', document.getElementById('edit_primary_color').value);
    configFormData.append('secondary_color', document.getElementById('edit_secondary_color').value);
    configFormData.append('login_layout', document.getElementById('edit_login_layout').value);

    const mainLogoFile = document.getElementById('edit_main_logo').files[0];
    if (mainLogoFile) configFormData.append('main_logo', mainLogoFile);
    const smallLogoFile = document.getElementById('edit_small_logo').files[0];
    if (smallLogoFile) configFormData.append('small_logo', smallLogoFile);
    const loginLogoFile = document.getElementById('edit_login_logo').files[0];
    if (loginLogoFile) configFormData.append('login_logo', loginLogoFile);
    const loginCoverFile = document.getElementById('edit_login_cover_image').files[0];
    if (loginCoverFile) configFormData.append('login_cover_image', loginCoverFile);
    const faviconFile = document.getElementById('edit_favicon').files[0];
    if (faviconFile) configFormData.append('favicon', faviconFile);

    const adminPayload = {
        name: document.getElementById('edit_admin_name').value,
        email: document.getElementById('edit_admin_email').value,
    };

    try {
        const [res1, res2, res3] = await Promise.all([
            fetch(`/api/v1/super-admin/institutes/${instituteId}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'Authorization': `Bearer ${token}` },
                body: JSON.stringify(institutePayload)
            }),
            // Fixed route to singular /configuration with PUT method and FormData
            fetch(`/api/v1/super-admin/institutes/${instituteId}/configuration`, {
                method: 'POST',
                headers: { 'Accept': 'application/json', 'Authorization': `Bearer ${token}` },
                body: configFormData
            }),
            fetch(`/api/v1/super-admin/institutes/${instituteId}/admin`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'Authorization': `Bearer ${token}` },
                body: JSON.stringify(adminPayload)
            })
        ]);

        if (!res1.ok || !res2.ok || !res3.ok) throw new Error('Failed to update records.');

        showToast('Institute information and configurations saved successfully.');
        lockEditMode();
        fetchInstituteProfileData();
    } catch (error) {
        showToast(error.message || 'Error occurred while saving modifications.', true);
    }
}

function updateAdminStatusUI(isActive) {
    const badge = document.getElementById('adminStatusBadge');
    badge.className = `rounded-full px-2.5 py-0.5 text-xs font-semibold ${isActive ? 'bg-emerald-50 text-emerald-700' : 'bg-orange-50 text-orange-700'}`;
    badge.textContent = isActive ? 'Active' : 'Inactive';

    document.getElementById('toggleAdminText').textContent = isActive ? 'Deactivate Admin' : 'Activate Admin';
    document.getElementById('toggleAdminIcon').textContent = isActive ? 'person_off' : 'how_to_reg';
}

async function toggleAdminAccountStatus() {
    const token = localStorage.getItem('student_diary_token');
    try {
        const response = await fetch(`/api/v1/super-admin/institutes/${instituteId}/admin/status`, {
            method: 'PATCH',
            headers: { 'Accept': 'application/json', 'Authorization': `Bearer ${token}` }
        });
        const result = await response.json();
        if (!response.ok || !result.status) throw new Error(result.message);
        updateAdminStatusUI(isActiveStatus(result.data.status));
    } catch (error) {
        alert(error.message || 'Unable to update admin account status.');
    }
}

function selectLayoutOption(layoutValue) {
    const selectEl = document.getElementById('edit_login_layout');
    if (selectEl) selectEl.value = layoutValue;
    const cardOne = document.getElementById('card_option_layout_one');
    const cardTwo = document.getElementById('card_option_layout_two');
    if (layoutValue === 'layout_one') {
        cardOne.className = "cursor-pointer rounded-xl border-2 border-primary bg-primary/5 p-2.5 transition-all shadow-sm";
        cardTwo.className = "cursor-pointer rounded-xl border-2 border-slate-200 bg-slate-50 p-2.5 transition-all hover:border-primary";
    } else if (layoutValue === 'layout_two') {
        cardTwo.className = "cursor-pointer rounded-xl border-2 border-primary bg-primary/5 p-2.5 transition-all shadow-sm";
        cardOne.className = "cursor-pointer rounded-xl border-2 border-slate-200 bg-slate-50 p-2.5 transition-all hover:border-primary";
    }
}

function openDashboardPreview() {
    const modal = document.getElementById('dashboardPreviewModal');
    const sidebar = document.getElementById('previewSidebar');
    const badge = document.getElementById('previewActiveBadge');
    const nameEl = document.getElementById('previewModalInstituteName');
    const codeEl = document.getElementById('previewModalInstituteCode');
    const navCodeLabel = document.getElementById('previewNavCodeLabel');
    const logoImg = document.getElementById('previewModalLogo');
    const iconBox = document.getElementById('previewModalIconBox');

    const primary = originalDataCache.primary_color || '#1E3A8A';
    const secondary = originalDataCache.secondary_color || '#C9A227';

    sidebar.style.backgroundColor = primary;
    badge.style.backgroundColor = secondary;
    document.documentElement.style.setProperty('--preview-primary', primary);

    nameEl.textContent = originalDataCache.name || 'Student Diary';
    codeEl.textContent = originalDataCache.code || 'CODE';
    navCodeLabel.textContent = `${originalDataCache.name || 'Institute'} (${originalDataCache.code || '—'})`;

    const logoUrl = originalDataCache.main_logo || originalDataCache.login_logo || originalDataCache.small_logo;
    if (logoUrl) {
        const cleanPath = logoUrl.replace(/^\/+/, '');
        const formattedUrl = cleanPath.startsWith('http') ? cleanPath : (cleanPath.startsWith('storage/') ? `/${cleanPath}` : `/storage/${cleanPath}`);
        
        logoImg.src = formattedUrl;
        logoImg.style.display = 'block';
        iconBox.style.display = 'none';
    } else {
        logoImg.style.display = 'none';
        iconBox.style.display = 'flex';
    }

    modal.classList.remove('hidden');
}

function closeDashboardPreview() {
    document.getElementById('dashboardPreviewModal').classList.add('hidden');
}
function showToast(message, isError = false) {
    const toast = document.getElementById('toastNotification');
    const msgEl = document.getElementById('toastMessage');
    const iconEl = document.getElementById('toastIcon');

    msgEl.textContent = message;
    if (isError) {
        iconEl.textContent = 'error';
        iconEl.className = 'material-symbols-rounded text-red-400 text-xl';
        toast.className = 'fixed bottom-5 right-5 z-50 transform translate-y-0 opacity-100 transition-all duration-300 flex items-center gap-3 bg-slate-900 text-white px-5 py-3 rounded-xl shadow-2xl border border-red-500/50';
    } else {
        iconEl.textContent = 'check_circle';
        iconEl.className = 'material-symbols-rounded text-emerald-400 text-xl';
        toast.className = 'fixed bottom-5 right-5 z-50 transform translate-y-0 opacity-100 transition-all duration-300 flex items-center gap-3 bg-slate-900 text-white px-5 py-3 rounded-xl shadow-2xl border border-slate-700';
    }

    // Auto-hide after 3.5 seconds
    setTimeout(() => {
        toast.className = 'fixed bottom-5 right-5 z-50 hidden transform translate-y-2 opacity-0 transition-all duration-300 flex items-center gap-3 bg-slate-900 text-white px-5 py-3 rounded-xl shadow-2xl border border-slate-700';
    }, 3500);
}
</script>
@endsection