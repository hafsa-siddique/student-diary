@extends('layouts.admin')

@section('title', 'Admin Profile')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between gap-4 flex-wrap">
        <div>
            <h1 class="text-2xl font-bold text-on-surface">Admin Profile</h1>
            <p class="mt-1 text-sm text-on-surface-variant">Manage your personal and institute information.</p>
        </div>
    </div>

    <div class="bg-surface-container-lowest rounded-xl shadow-sm p-6">
        <div class="flex items-center gap-5 flex-wrap">
            <div class="relative">
                <img id="profileImage" src="" alt="Profile"
                    class="w-24 h-24 rounded-full object-cover border-4 border-surface-container hidden">
                <div id="profilePlaceholder" class="w-24 h-24 rounded-full bg-primary text-white flex items-center justify-center text-3xl font-bold">A</div>
                <span id="profileStatusDot" class="absolute bottom-1 right-1 w-5 h-5 rounded-full bg-secondary border-4 border-white"></span>
            </div>

            <div class="flex-1 min-w-[220px]">
                <div class="flex items-center gap-3 flex-wrap">
                    <h2 id="adminName" class="text-xl font-bold text-on-surface">—</h2>
                    <span id="adminStatus" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-secondary/10 text-secondary text-xs font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span> Active
                    </span>
                </div>
                <p class="mt-1 text-sm text-on-surface-variant">Institute Administrator</p>
                <div class="mt-3 flex flex-wrap gap-x-5 gap-y-2 text-sm text-on-surface-variant">
                    <span class="inline-flex items-center gap-1.5"><span class="material-symbols-outlined text-[18px]">mail</span><span id="adminEmail">—</span></span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <div class="bg-surface-container-lowest rounded-xl shadow-sm p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-lg bg-primary/10 text-primary flex items-center justify-center">
                    <span class="material-symbols-outlined">person</span>
                </div>
                <div>
                    <h3 class="font-bold text-on-surface">Personal Information</h3>
                    <p class="text-xs text-on-surface-variant">Your account details</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div><p class="text-xs text-on-surface-variant">Full Name</p><p id="infoName" class="mt-1 font-semibold text-on-surface">—</p></div>
                <div><p class="text-xs text-on-surface-variant">Email</p><p id="infoEmail" class="mt-1 font-semibold text-on-surface break-all">—</p></div>
                <div><p class="text-xs text-on-surface-variant">Phone</p><p id="infoPhone" class="mt-1 font-semibold text-on-surface">—</p></div>
                <div><p class="text-xs text-on-surface-variant">Role</p><p class="mt-1 font-semibold text-on-surface">Institute Administrator</p></div>
                <div><p class="text-xs text-on-surface-variant">Status</p><p id="infoStatus" class="mt-1 font-semibold text-on-surface">—</p></div>
                <div><p class="text-xs text-on-surface-variant">Joined</p><p id="infoJoined" class="mt-1 font-semibold text-on-surface">—</p></div>
            </div>
        </div>

        <div class="bg-surface-container-lowest rounded-xl shadow-sm p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-lg bg-secondary/10 text-primary flex items-center justify-center">
                    <span class="material-symbols-outlined">domain</span>
                </div>
                <div>
                    <h3 class="font-bold text-on-surface">Institute Information</h3>
                    <p class="text-xs text-on-surface-variant">Your institute details</p>
                </div>
            </div>

            <div class="flex items-center gap-4 mb-6">
                <img id="instituteLogo" src="" alt="Institute Logo" class="w-14 h-14 rounded-lg object-contain border border-outline-variant hidden">
                <div id="instituteLogoPlaceholder" class="w-14 h-14 rounded-lg bg-primary text-white flex items-center justify-center">
                    <span class="material-symbols-outlined">school</span>
                </div>
                <div>
                    <h4 id="instituteName" class="font-bold text-on-surface">—</h4>
                    <p id="instituteCode" class="text-sm text-on-surface-variant">—</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div><p class="text-xs text-on-surface-variant">Email</p><p id="instituteEmail" class="mt-1 font-semibold text-on-surface break-all">—</p></div>
                <div><p class="text-xs text-on-surface-variant">Phone</p><p id="institutePhone" class="mt-1 font-semibold text-on-surface">—</p></div>
                <div><p class="text-xs text-on-surface-variant">Address</p><p id="instituteAddress" class="mt-1 font-semibold text-on-surface">—</p></div>
                <div><p class="text-xs text-on-surface-variant">Website</p><p id="instituteWebsite" class="mt-1 font-semibold text-on-surface break-all">—</p></div>
            </div>
        </div>
    </div>

    <div class="bg-surface-container-lowest rounded-xl shadow-sm p-6">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 rounded-lg bg-primary/10 text-primary flex items-center justify-center">
                <span class="material-symbols-outlined">security</span>
            </div>
            <div>
                <h3 class="font-bold text-on-surface">Account Security</h3>
                <p class="text-xs text-on-surface-variant">Manage your account security</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div class="flex items-center justify-between gap-4 md:border-r md:border-outline-variant md:pr-5">
                <div>
                    <p class="text-sm font-semibold text-on-surface">Password</p>
                    <p id="passwordChanged" class="mt-1 text-xs text-on-surface-variant">Password information</p>
                </div>
                <button onclick="openChangePasswordModal()" class="text-sm font-semibold text-primary hover:underline">Change</button>
            </div>
            <div>
                <p class="text-xs text-on-surface-variant">Last Login</p>
                <p id="lastLogin" class="mt-1 font-semibold text-on-surface">—</p>
            </div>
            <div>
                <p class="text-xs text-on-surface-variant">Account Status</p>
                <p id="accountStatus" class="mt-1 font-semibold text-on-surface">—</p>
            </div>
        </div>
    </div>
</div>

<div id="changePasswordModal"
    class="fixed inset-0 z-50 hidden bg-black/50 items-center justify-center p-4">

    <div class="w-full max-w-md bg-surface-container-lowest rounded-xl shadow-xl p-6">

        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-bold text-on-surface">Change Password</h3>
                <p class="text-xs text-on-surface-variant mt-1">
                    Update your account password securely.
                </p>
            </div>

            <button type="button"
                onclick="closeChangePasswordModal()"
                class="text-on-surface-variant hover:text-on-surface">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <div id="currentPasswordStep">
            <label class="block text-sm font-medium text-on-surface mb-2">
                Current Password
            </label>

            <input id="currentPassword"
                type="password"
                class="w-full px-3 py-2.5 rounded-lg border border-outline-variant
                       bg-surface-container-lowest text-sm focus:outline-none
                       focus:ring-2 focus:ring-primary/20"
                placeholder="Enter current password">

            <button type="button"
                onclick="verifyCurrentPassword()"
                class="w-full mt-5 px-4 py-2.5 rounded-lg bg-primary
                       text-white text-sm font-semibold hover:opacity-90">
                Continue
            </button>
        </div>

        <div id="newPasswordStep" class="hidden">

            <div class="mb-4 p-3 rounded-lg bg-secondary/10 text-sm text-secondary">
                Current password verified. Enter your new password.
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-on-surface mb-2">
                    New Password
                </label>

                <input id="newPassword"
                    type="password"
                    class="w-full px-3 py-2.5 rounded-lg border border-outline-variant
                           bg-surface-container-lowest text-sm focus:outline-none
                           focus:ring-2 focus:ring-primary/20"
                    placeholder="Enter new password">
            </div>

            <div>
                <label class="block text-sm font-medium text-on-surface mb-2">
                    Confirm Password
                </label>

                <input id="confirmPassword"
                    type="password"
                    class="w-full px-3 py-2.5 rounded-lg border border-outline-variant
                           bg-surface-container-lowest text-sm focus:outline-none
                           focus:ring-2 focus:ring-primary/20"
                    placeholder="Confirm new password">
            </div>

            <div class="flex justify-end gap-3 mt-5">
                <button type="button"
                    onclick="closeChangePasswordModal()"
                    class="px-4 py-2.5 rounded-lg border border-outline-variant
                           text-sm font-semibold">
                    Cancel
                </button>

                <button type="button"
                    onclick="updatePassword()"
                    class="px-4 py-2.5 rounded-lg bg-primary text-white
                           text-sm font-semibold hover:opacity-90">
                    Update Password
                </button>
            </div>
        </div>

    </div>
</div>

<script>
const token = localStorage.getItem('student_diary_token');
const profileUrl = '/api/v1/admin/profile';

async function loadProfile() {
    try {
        const response = await fetch(profileUrl, {
            headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
        });
        const result = await response.json();
        if (!response.ok || !result.status) throw new Error(result.message || 'Failed to load profile.');
        renderProfile(result.data);
    } catch (error) {
        console.error(error);
        showToast(error.message, 'error');
    }
}

function renderProfile(data) {
    const admin = data.admin ?? {};
    const institute = data.institute ?? {};
    const config = data.configuration ?? {};

    setText('adminName', admin.name);
    setText('adminEmail', admin.email);
    setText('infoName', admin.name);
    setText('infoEmail', admin.email);
    setText('infoPhone', admin.phone);
    setText('infoStatus', admin.status ? 'Active' : 'Inactive');
    setText('infoJoined', formatDate(admin.joined_at));
    setText('instituteName', institute.name);
    setText('instituteCode', institute.code);
    setText('instituteEmail', institute.email);
    setText('institutePhone', institute.phone);
    setText('instituteAddress', institute.address);
    setText('instituteWebsite', institute.website);
    setText('accountStatus', admin.status ? 'Active' : 'Inactive');

    document.getElementById('adminStatus').innerHTML = admin.status
        ? '<span class="w-1.5 h-1.5 rounded-full bg-secondary"></span> Active'
        : '<span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Inactive';

    if (admin.profile_picture) {
        document.getElementById('profileImage').src = admin.profile_picture;
        document.getElementById('profileImage').classList.remove('hidden');
        document.getElementById('profilePlaceholder').classList.add('hidden');
    } else {
        document.getElementById('profilePlaceholder').textContent = (admin.name || 'A').charAt(0).toUpperCase();
    }

    if (config.main_logo) {
        document.getElementById('instituteLogo').src = config.main_logo;
        document.getElementById('instituteLogo').classList.remove('hidden');
        document.getElementById('instituteLogoPlaceholder').classList.add('hidden');
    }

    
    document.getElementById('lastLogin').textContent = admin.last_login ? formatDateTime(admin.last_login) : 'Not available';
    document.getElementById('passwordChanged').textContent = admin.password_changed_at
        ? `Last changed: ${formatDateTime(admin.password_changed_at)}` : 'Password information unavailable';
}

function setText(id, value) {
    document.getElementById(id).textContent = value || '—';
}

function formatDate(date) {
    if (!date) return '—';
    return new Date(date).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
}

function formatDateTime(date) {
    if (!date) return '—';
    return new Date(date).toLocaleString('en-GB', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        hour12: true
    });
}



function openChangePasswordModal() {
    const modal = document.getElementById('changePasswordModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.getElementById('currentPasswordStep').classList.remove('hidden');
    document.getElementById('newPasswordStep').classList.add('hidden');
    document.getElementById('currentPassword').value = '';
    document.getElementById('newPassword').value = '';
    document.getElementById('confirmPassword').value = '';
}

function closeChangePasswordModal() {
    const modal = document.getElementById('changePasswordModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

function showToast(message, type = 'success') {
    const toast = document.createElement('div');

    toast.className = `
        fixed top-5 right-5 z-[100] px-4 py-3 rounded-lg
        text-sm font-medium shadow-lg text-white
        ${type === 'error' ? 'bg-red-600' : 'bg-green-600'}
    `;

    toast.textContent = message;
    document.body.appendChild(toast);

    setTimeout(() => toast.remove(), 3000);
}

async function verifyCurrentPassword() {
    console.log('Continue clicked');
    const password = document.getElementById('currentPassword').value;
    console.log('Password entered:', !!password);


    if (!password) {
        showToast('Please enter your current password.', 'error');
        return;
    }

    try {
        const response = await fetch('/api/v1/admin/password/verify', {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ current_password: password })
        });

        const result = await response.json();

        if (!response.ok || !result.status) {
            throw new Error(result.message || 'Current password is incorrect.');
        }

        document.getElementById('currentPasswordStep').classList.add('hidden');
        document.getElementById('newPasswordStep').classList.remove('hidden');
    } catch (error) {
        showToast(error.message, 'error');
    }
}

async function updatePassword() {
    const currentPassword = document.getElementById('currentPassword').value;
    const newPassword = document.getElementById('newPassword').value;
    const confirmPassword = document.getElementById('confirmPassword').value;

    if (!newPassword || !confirmPassword) {
        showToast('Please fill in both password fields.', 'error');
        return;
    }

    if (newPassword !== confirmPassword) {
        showToast('New password and confirm password do not match.', 'error');
        return;
    }

    try {
        const response = await fetch('/api/v1/admin/password', {
            method: 'PUT',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                current_password: currentPassword,
                password: newPassword,
                password_confirmation: confirmPassword
            })
        });

        const result = await response.json();

        if (!response.ok) {
            const message = result.message ||
                Object.values(result.errors || {}).flat()[0] ||
                'Failed to update password.';

            throw new Error(message);
        }

        showToast(result.message || 'Password updated successfully.', 'success');
        closeChangePasswordModal();
    } catch (error) {
        console.error(error);
        showToast(error.message, 'error');
    }
}

loadProfile(); 

</script>
@endsection