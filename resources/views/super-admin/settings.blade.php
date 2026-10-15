@extends('layouts.super-admin')

@section('content')
<div class="space-y-6">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Platform Settings</h1>
            <p class="text-sm text-slate-500">Manage system-wide configurations, limits, and default branding assets.</p>
        </div>
        <button type="button" onclick="savePlatformSettings(event)" class="inline-flex items-center gap-1 rounded-lg bg-secondary/85 px-4 py-1 text-sm font-semibold text-primary transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md">
            <span class="material-symbols-rounded text-lg">save</span>
            Save Changes
        </button>
    </div>

    <form id="platformSettingsForm" enctype="multipart/form-data" class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <h2 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
                <span class="material-symbols-rounded text-secondary">tune</span>
                System Limits & Rules
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Max Diary Note Characters</label>
                    <input type="number" name="settings[max_diary_length]" id="setting_max_diary_length" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-[#C9A227] focus:ring-1 focus:ring-secondary outline-none" placeholder="2000">
                    <p class="text-xs text-slate-400 mt-1">Maximum allowed characters for classwork and homework notes.</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <h2 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
                <span class="material-symbols-rounded text-secondary">settings_applications</span>
                General Controls
            </h2>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <label class="text-sm font-medium text-slate-700 block">Maintenance Mode</label>
                        <p class="text-xs text-slate-400">Temporarily block users access across the system.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="settings[maintenance_mode]" id="setting_maintenance_mode" value="1" class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-600"></div>
                    </label>
                </div>

                <div class="pt-2 border-t border-slate-100">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Maintenance Notice Message</label>
                    <textarea name="settings[maintenance_message]" id="setting_maintenance_message" rows="3" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-[#C9A227] focus:ring-1 focus:ring-secondary outline-none resize-none" placeholder="System is currently undergoing scheduled maintenance. Please check back shortly."></textarea>
                    <p class="text-xs text-slate-400 mt-1">Message displayed to registered users when maintenance mode is active.</p>
                </div>
                <div class="pt-4 border-t border-slate-100">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Active Login Page Layout</label>
                    <select name="settings[login_layout]" id="setting_login_layout" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-[#C9A227] focus:ring-1 focus:ring-secondary outline-none">
                        <option value="layout_one">Layout One (Split-Screen with Cover Image)</option>
                        <option value="layout_two">Layout Two (Centered Glass Card / Modern Clean)</option>
                    </select>
                    <p class="text-xs text-slate-400 mt-1">Choose which login design is displayed to all institute users.</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <h2 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
                <span class="material-symbols-rounded text-secondary">palette</span>
                Default Theme Colors
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Default Primary Color</label>
                    <div class="flex items-center gap-3">
                        <input type="color" name="settings[default_primary_color]" id="setting_default_primary_color" class="h-10 w-16 rounded border border-slate-300 cursor-pointer p-1">
                        <input type="text" id="setting_default_primary_color_text" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm uppercase bg-slate-50" readonly>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Default Secondary Color</label>
                    <div class="flex items-center gap-3">
                        <input type="color" name="settings[default_secondary_color]" id="setting_default_secondary_color" class="h-10 w-16 rounded border border-slate-300 cursor-pointer p-1">
                        <input type="text" id="setting_default_secondary_color_text" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm uppercase bg-slate-50" readonly>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <h2 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
                <span class="material-symbols-rounded text-secondary">image</span>
                Default Branding Logos & Cover Assets
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-slate-700">Main Logo</label>
                    <div class="flex items-center gap-4">
                        <div class="h-14 w-14 rounded-lg border border-slate-300 bg-slate-50 flex items-center justify-center overflow-hidden shrink-0">
                            <img id="preview_default_main_logo" src="" alt="Preview" class="h-full w-full object-contain hidden">
                            <span id="placeholder_default_main_logo" class="material-symbols-rounded text-slate-400">image</span>
                        </div>
                        <div class="flex-1">
                            <input type="file" name="settings[default_main_logo]" id="setting_default_main_logo" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-1 file:px-2 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100 cursor-pointer" onchange="previewImage(event, 'preview_default_main_logo', 'placeholder_default_main_logo')">
                        </div>
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-slate-700">Small Logo</label>
                    <div class="flex items-center gap-4">
                        <div class="h-14 w-14 rounded-lg border border-slate-300 bg-slate-50 flex items-center justify-center overflow-hidden shrink-0">
                            <img id="preview_default_small_logo" src="" alt="Preview" class="h-full w-full object-contain hidden">
                            <span id="placeholder_default_small_logo" class="material-symbols-rounded text-slate-400">image</span>
                        </div>
                        <div class="flex-1">
                            <input type="file" name="settings[default_small_logo]" id="setting_default_small_logo" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-1 file:px-2 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100 cursor-pointer" onchange="previewImage(event, 'preview_default_small_logo', 'placeholder_default_small_logo')">
                        </div>
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-slate-700">Login Page Logo</label>
                    <div class="flex items-center gap-4">
                        <div class="h-14 w-14 rounded-lg border border-slate-300 bg-slate-50 flex items-center justify-center overflow-hidden shrink-0">
                            <img id="preview_default_login_logo" src="" alt="Preview" class="h-full w-full object-contain hidden">
                            <span id="placeholder_default_login_logo" class="material-symbols-rounded text-slate-400">image</span>
                        </div>
                        <div class="flex-1">
                            <input type="file" name="settings[default_login_logo]" id="setting_default_login_logo" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-1 file:px-2 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100 cursor-pointer" onchange="previewImage(event, 'preview_default_login_logo', 'placeholder_default_login_logo')">
                        </div>
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-slate-700">Favicon</label>
                    <div class="flex items-center gap-4">
                        <div class="h-14 w-14 rounded-lg border border-slate-300 bg-slate-50 flex items-center justify-center overflow-hidden shrink-0">
                            <img id="preview_default_favicon" src="" alt="Preview" class="h-full w-full object-contain hidden">
                            <span id="placeholder_default_favicon" class="material-symbols-rounded text-slate-400">image</span>
                        </div>
                        <div class="flex-1">
                            <input type="file" name="settings[default_favicon]" id="setting_default_favicon" accept="image/x-icon,image/png" class="w-full text-sm text-slate-500 file:mr-4 file:py-1 file:px-2 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100 cursor-pointer" onchange="previewImage(event, 'preview_default_favicon', 'placeholder_default_favicon')">
                        </div>
                    </div>
                </div>
                <div class="md:col-span-2 space-y-2">
                    <label class="block text-sm font-medium text-slate-700">Login Cover Image</label>
                    <div class="flex items-center gap-6">
                        <div class="h-20 w-32 rounded-lg border border-slate-300 bg-slate-50 flex items-center justify-center overflow-hidden shrink-0">
                            <img id="preview_default_login_cover" src="" alt="Preview" class="h-full w-full object-cover hidden">
                            <span id="placeholder_default_login_cover" class="material-symbols-rounded text-slate-400">wallpaper</span>
                        </div>
                        <div class="flex-1">
                            <input type="file" name="settings[default_login_cover]" id="setting_default_login_cover" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-1 file:px-2 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100 cursor-pointer" onchange="previewImage(event, 'preview_default_login_cover', 'placeholder_default_login_cover')">
                            <p class="text-xs text-slate-400 mt-1">Background banner image for the split-screen login page.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div id="toastNotification" class="fixed bottom-5 right-5 z-50 hidden transform translate-y-2 opacity-0 transition-all duration-300 flex items-center gap-3 bg-slate-900 text-white px-5 py-3 rounded-xl shadow-2xl border border-slate-700">
    <span id="toastIcon" class="material-symbols-rounded text-emerald-400 text-xl">check_circle</span>
    <p id="toastMessage" class="text-sm font-medium">Settings Saved successfully!</p>
</div>
<script>
document.addEventListener('DOMContentLoaded', () => {
    loadPlatformSettings();
    ['primary', 'secondary'].forEach(type => {
        const colorInput = document.getElementById(`setting_default_${type}_color`);
        const textInput = document.getElementById(`setting_default_${type}_color_text`);
        if (colorInput && textInput) {
            colorInput.addEventListener('input', (e) => textInput.value = e.target.value);
        }
    });
});

function previewImage(event, previewId, placeholderId) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById(previewId);
            const placeholder = document.getElementById(placeholderId);
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            if (placeholder) placeholder.classList.add('hidden');
        }
        reader.readAsDataURL(file);
    }
}

async function loadPlatformSettings() {
    const token = localStorage.getItem('student_diary_token');
    try {
        const response = await fetch('/api/v1/settings', {
            headers: { 'Accept': 'application/json', 'Authorization': `Bearer ${token}` }
        });
        if (!response.ok) throw new Error('Failed to load settings.');

        const result = await response.json();
        const settings = result.data || {};

        for (const [key, value] of Object.entries(settings)) {
            const field = document.getElementById(`setting_${key}`);
            if (field) {
                if (field.type === 'checkbox') {
                    field.checked = value == '1' || value === true;
                } else if (field.type !== 'file') {
                    field.value = value;
                    if (field.type === 'color') {
                        const textSync = document.getElementById(`setting_${key}_text`);
                        if (textSync) textSync.value = value;
                    }
                }
            }

            if (['default_main_logo', 'default_small_logo', 'default_login_logo', 'default_favicon', 'default_login_cover'].includes(key) && value) {
                const preview = document.getElementById(`preview_${key}`);
                const placeholder = document.getElementById(`placeholder_${key}`);
                if (preview) {
                    preview.src = value.startsWith('/storage/') ? value : '/storage/' + value;
                    preview.classList.remove('hidden');
                    if (placeholder) placeholder.classList.add('hidden');
                }
            }
        }
    } catch (error) {
        if (typeof showToast === 'function') showToast(error.message, true);
    }
}

async function savePlatformSettings(e) {
    e.preventDefault();
    const token = localStorage.getItem('student_diary_token');
    const form = document.getElementById('platformSettingsForm');
    const formData = new FormData(form);

    const maintenanceToggle = document.getElementById('setting_maintenance_mode');
    formData.set('settings[maintenance_mode]', maintenanceToggle.checked ? '1' : '0');

    try {
        const response = await fetch('/api/v1/settings', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: formData
        });

        const result = await response.json();
        if (!response.ok) throw new Error(result.message || 'Failed to update settings.');

        if (typeof showToast === 'function') {
            showToast('Platform settings and assets updated successfully!');
        } else {
            alert('Platform settings and assets updated successfully!');
        }
        loadPlatformSettings();
    } catch (error) {
        if (typeof showToast === 'function') {
            showToast(error.message, true);
        } else {
            alert(error.message);
        }
    }
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

    setTimeout(() => {
        toast.className = 'fixed bottom-5 right-5 z-50 hidden transform translate-y-2 opacity-0 transition-all duration-300 flex items-center gap-3 bg-slate-900 text-white px-5 py-3 rounded-xl shadow-2xl border border-slate-700';
    }, 3500);
}
</script>
@endsection