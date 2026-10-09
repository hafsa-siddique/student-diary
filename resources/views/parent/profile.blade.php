@extends('layouts.parent')

@section('title', 'Parent Profile')

@section('content')

<div class="space-y-6">
    <div class="flex items-center justify-between gap-4 flex-wrap">
        <div class="mt-4">
            <h1 class="text-2xl font-bold text-on-surface">Parent Profile</h1>
            <p class="mt-1 text-sm text-on-surface-variant">Manage your personal information.</p>
        </div>
    </div>

<div class="bg-surface-container-lowest rounded-xl shadow-sm p-6">
    <div class="flex items-center gap-5 flex-wrap">
        <div class="relative">
            <img id="profileImage" src="" alt="Profile"
                class="w-24 h-24 rounded-full object-cover border-4 border-surface-container hidden">

            <div id="profilePlaceholder"
                class="w-24 h-24 rounded-full bg-primary text-white flex items-center justify-center text-3xl font-bold">
                P
            </div>

            <span id="profileStatusDot"
                class="absolute bottom-1 right-1 w-5 h-5 rounded-full bg-secondary border-4 border-white">
            </span>
        </div>

        <div class="flex-1 min-w-[220px]">
            <div class="flex items-center justify-between flex-wrap">
                <h2 id="parentName" class="text-xl font-bold text-on-surface">—</h2>

                <span id="parentStatus"
                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-secondary/10 text-secondary text-xs font-semibold">
                    <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                    Active
                </span>
            </div>

            <p class="mt-1 text-sm text-on-surface-variant">Institute Parent</p>

            <div class="mt-3 flex flex-wrap gap-x-5 gap-y-2 text-sm text-on-surface-variant">
                <span class="inline-flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[18px]">mail</span>
                    <span id="parentEmail">—</span>
                </span>

                <span class="inline-flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[18px]">phone</span>
                    <span id="parentPhone">—</span>
                </span>
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
            <div>
                <p class="text-xs text-on-surface-variant">Full Name</p>
                <p id="infoName" class="mt-1 font-semibold text-on-surface">—</p>
            </div>

            <div>
                <p class="text-xs text-on-surface-variant">Email</p>
                <p id="infoEmail" class="mt-1 font-semibold text-on-surface break-all">—</p>
            </div>

            <div>
                <p class="text-xs text-on-surface-variant">Phone</p>
                <p id="infoPhone" class="mt-1 font-semibold text-on-surface">—</p>
            </div>

            <div>
                <p class="text-xs text-on-surface-variant">Relationship</p>
                <p id="infoRelationship" class="mt-1 font-semibold text-on-surface">—</p>
            </div>

            <div>
                <p class="text-xs text-on-surface-variant">Role</p>
                <p class="mt-1 font-semibold text-on-surface">Institute Parent</p>
            </div>

            <div>
                <p class="text-xs text-on-surface-variant">Status</p>
                <p id="infoStatus" class="mt-1 font-semibold text-on-surface">—</p>
            </div>

            <div>
                <p class="text-xs text-on-surface-variant">Joined</p>
                <p id="infoJoined" class="mt-1 font-semibold text-on-surface">—</p>
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

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <div>
                <p class="text-xs text-on-surface-variant">Last Login</p>
                <p id="lastLogin" class="mt-1 font-semibold text-on-surface">—</p>
            </div>

            <div>
                <p class="text-xs text-on-surface-variant">Account Status</p>
                <p id="accountStatus" class="mt-1 font-semibold text-on-surface">—</p>
            </div>

            <div class="md:col-span-2 flex items-center gap-12">
                <div>
                    <p class="text-sm font-semibold text-on-surface">Password</p>
                    <p id="passwordChanged" class="mt-1 text-xs text-on-surface-variant">
                        Password information
                    </p>
                </div>

                <button onclick="openChangePasswordModal()"
                    class="text-sm font-semibold text-primary hover:underline">
                    Change
                </button>
            </div>
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
            class="w-full px-3 py-2.5 rounded-lg border border-outline-variant bg-surface-container-lowest text-sm focus:outline-none focus:ring-2 focus:ring-primary/20"
            placeholder="Enter current password">

        <button type="button"
            onclick="verifyCurrentPassword()"
            class="w-full mt-5 px-4 py-2.5 rounded-lg bg-primary text-white text-sm font-semibold hover:opacity-90">
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
                class="w-full px-3 py-2.5 rounded-lg border border-outline-variant bg-surface-container-lowest text-sm focus:outline-none focus:ring-2 focus:ring-primary/20"
                placeholder="Enter new password">
        </div>

        <div>
            <label class="block text-sm font-medium text-on-surface mb-2">
                Confirm Password
            </label>

            <input id="confirmPassword"
                type="password"
                class="w-full px-3 py-2.5 rounded-lg border border-outline-variant bg-surface-container-lowest text-sm focus:outline-none focus:ring-2 focus:ring-primary/20"
                placeholder="Confirm new password">
        </div>

        <div class="flex justify-end gap-3 mt-5">
            <button type="button"
                onclick="closeChangePasswordModal()"
                class="px-4 py-2.5 rounded-lg border border-outline-variant text-sm font-semibold">
                Cancel
            </button>

            <button type="button"
                onclick="updatePassword()"
                class="px-4 py-2.5 rounded-lg bg-primary text-white text-sm font-semibold hover:opacity-90">
                Update Password
            </button>
        </div>
    </div>

</div>

</div>

<script>
(async () => {
    const token = localStorage.getItem('student_diary_token');
    const profileUrl = '/api/v1/parent/profile';

    if (!token) {
        window.location.href = '/';
        return;
    }

    async function loadProfile() {
        try {
            const response = await fetch(profileUrl, {
                headers: {
                    Authorization: `Bearer ${token}`,
                    Accept: 'application/json'
                }
            });

            const result = await response.json();
            console.log('Profile API response:', result);

            if (!response.ok || !result.status) {
                throw new Error(result.message || 'Failed to load profile.');
            }

            renderProfile(result.data);
        } catch (error) {
            console.error(error);
            showToast(error.message, 'error');
        }
    }

    function renderProfile(data) {
        const parent = data.admin ?? data.user ?? {};
        const profile = data.profile ?? {};

        setText('parentName', parent.name);
        setText('parentEmail', parent.email);
        setText('parentPhone', parent.phone);

        setText('infoName', parent.name);
        setText('infoEmail', parent.email);
        setText('infoPhone', parent.phone);
        setText('infoRelationship', parent.relationship ?? profile.relationship);
        setText('infoStatus', parent.status ? 'Active' : 'Inactive');
        setText('infoJoined', formatDate(parent.joined_at ?? parent.created_at));
        setText('accountStatus', parent.status ? 'Active' : 'Inactive');

        document.getElementById('parentStatus').innerHTML = parent.status
            ? '<span class="w-1.5 h-1.5 rounded-full bg-secondary"></span> Active'
            : '<span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Inactive';

        const statusDot = document.getElementById('profileStatusDot');
        statusDot.classList.toggle('bg-secondary', Boolean(parent.status));
        statusDot.classList.toggle('bg-red-500', !parent.status);

        if (parent.profile_picture) {
            document.getElementById('profileImage').src = parent.profile_picture;
            document.getElementById('profileImage').classList.remove('hidden');
            document.getElementById('profilePlaceholder').classList.add('hidden');
        } else {
            document.getElementById('profilePlaceholder').textContent =
                (parent.name || 'P').charAt(0).toUpperCase();
        }

        setText(
            'lastLogin',
            parent.last_login ? formatDateTime(parent.last_login) : 'Not available'
        );

        document.getElementById('passwordChanged').textContent =
            parent.password_changed_at
                ? `Last changed: ${formatDateTime(parent.password_changed_at)}`
                : 'Password information unavailable';
    }

    function setText(id, value) {
        document.getElementById(id).textContent = value || '—';
    }

    function formatDate(date) {
        if (!date) return '—';

        return new Date(date).toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        });
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
        const password = document.getElementById('currentPassword').value.trim();

        if (!password) {
            showToast('Please enter your current password.', 'error');
            return;
        }

        try {
            const response = await fetch('/api/v1/parent/password/verify', {
                method: 'POST',
                headers: {
                    Authorization: `Bearer ${token}`,
                    Accept: 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    current_password: password
                })
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
            const response = await fetch('/api/v1/parent/password', {
                method: 'PUT',
                headers: {
                    Authorization: `Bearer ${token}`,
                    Accept: 'application/json',
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

    window.openChangePasswordModal = openChangePasswordModal;
    window.closeChangePasswordModal = closeChangePasswordModal;
    window.verifyCurrentPassword = verifyCurrentPassword;
    window.updatePassword = updatePassword;

    await loadProfile();
})();
</script>

@endsection
