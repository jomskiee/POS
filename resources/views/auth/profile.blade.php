<!-- Profile Modal -->
@if(request('modal') === 'profile')
<div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center lg:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="relative inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full max-w-md mx-auto">
            <!-- Modal Header -->
            <div class="bg-white px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Profile Settings</h3>
                    <a href="{{ url()->current() }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <x-heroicon-o-x-mark class="w-6 h-6" />
                    </a>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="bg-white px-6 py-6">
                <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <!-- Name Field -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name', auth()->user()->name) }}"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('name') border-red-300 @enderror"
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address Field -->
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                    <textarea id="address"
                              name="address"
                              rows="3"
                              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('address') border-red-300 @enderror"
                              placeholder="Enter your address">{{ old('address', auth()->user()->getProfile()?->address ?? '') }}</textarea>
                    @error('address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Stall Name Field (Brokers Only) -->
                @if(auth()->user()->isBroker())
                <div>
                    <label for="stall_name" class="block text-sm font-medium text-gray-700">Stall Name</label>
                    <input type="text"
                           id="stall_name"
                           name="stall_name"
                           value="{{ old('stall_name', auth()->user()->getProfile()?->stall_name ?? '') }}"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('stall_name') border-red-300 @enderror"
                           placeholder="Enter your stall name"
                           required>
                    @error('stall_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                @endif

                <!-- Email Field (Read-only) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <div class="mt-1 block w-full px-3 py-2 border border-gray-200 bg-gray-50 rounded-md text-sm text-gray-600">
                        {{ auth()->user()->email }}
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Email cannot be changed</p>
                </div>

                <!-- Password Update Radio Button -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password Options</label>
                    <div class="space-y-2">
                        <label class="flex items-center cursor-pointer">
                            <input type="radio"
                                   name="password_option"
                                   value="keep"
                                   {{ old('password_option', 'keep') === 'keep' ? 'checked' : '' }}
                                   class="password-option mr-2 w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                                   onchange="togglePasswordFields()">
                            <span class="text-sm text-gray-700">Keep current password</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio"
                                   name="password_option"
                                   value="change"
                                   {{ old('password_option', 'keep') === 'change' ? 'checked' : '' }}
                                   class="password-option mr-2 w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                                   onchange="togglePasswordFields()">
                            <span class="text-sm text-gray-700">Change password</span>
                        </label>
                    </div>
                </div>

                <!-- Current Password Field (Hidden by default) -->
                <div id="current_password_field" class="hidden">
                    <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                    <input type="password"
                           id="current_password"
                           name="current_password"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('current_password') border-red-300 @enderror"
                           placeholder="Enter current password">
                    @error('current_password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- New Password Field (Hidden by default) -->
                <div id="new_password_field" class="hidden">
                    <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                    <input type="password"
                           id="password"
                           name="password"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('password') border-red-300 @enderror"
                           placeholder="Enter new password">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password Field (Hidden by default) -->
                <div id="confirm_password_field" class="hidden">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                    <input type="password"
                           id="password_confirmation"
                           name="password_confirmation"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                           placeholder="Confirm new password">
                </div>

                    <!-- Modal Footer -->
                    <div class="flex flex-col sm:flex-row items-center justify-end space-y-3 sm:space-y-0 sm:space-x-3 pt-4">
                        <a href="{{ url()->current() }}"
                           class="w-full sm:w-auto px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 text-center">
                            Cancel
                        </a>
                        <button type="submit"
                                class="w-full sm:w-auto px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Update Profile
                        </button>
                    </div>
                </form>


            </div>
        </div>
    </div>
</div>
@endif

<script>
function togglePasswordFields() {
    const passwordOption = document.querySelector('input[name="password_option"]:checked').value;
    const currentPasswordField = document.getElementById('current_password_field');
    const newPasswordField = document.getElementById('new_password_field');
    const confirmPasswordField = document.getElementById('confirm_password_field');

    if (passwordOption === 'change') {
        currentPasswordField.classList.remove('hidden');
        newPasswordField.classList.remove('hidden');
        confirmPasswordField.classList.remove('hidden');

        // Make password fields required
        document.getElementById('current_password').required = true;
        document.getElementById('password').required = true;
        document.getElementById('password_confirmation').required = true;
    } else {
        currentPasswordField.classList.add('hidden');
        newPasswordField.classList.add('hidden');
        confirmPasswordField.classList.add('hidden');

        // Remove required attribute and clear values
        document.getElementById('current_password').required = false;
        document.getElementById('password').required = false;
        document.getElementById('password_confirmation').required = false;
        document.getElementById('current_password').value = '';
        document.getElementById('password').value = '';
        document.getElementById('password_confirmation').value = '';
    }
}

// Initialize password fields on page load
document.addEventListener('DOMContentLoaded', function() {
    togglePasswordFields();
});
</script>
