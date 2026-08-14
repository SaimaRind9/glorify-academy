<x-guest-layout>

    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-800">
            Create Your Account
        </h2>

        <p class="mt-2 text-sm text-gray-600">
            Registration is available only for authorized teachers and parents.
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}" id="registerForm">
        @csrf

        {{-- Role Selection --}}
        <div>
            <x-input-label for="role" :value="__('Register As')" />

            <select
                id="role"
                name="role"
                required
                class="block mt-1 w-full rounded-md border-gray-300 shadow-sm
                       focus:border-indigo-500 focus:ring-indigo-500"
            >
                <option value="">Select account type</option>

                <option value="teacher"
                    {{ old('role') === 'teacher' ? 'selected' : '' }}>
                    Teacher
                </option>

                <option value="parent"
                    {{ old('role') === 'parent' ? 'selected' : '' }}>
                    Parent
                </option>
            </select>

            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        {{-- Name --}}
        <div class="mt-4">
            <x-input-label
                for="name"
                id="nameLabel"
                :value="__('Name')"
            />

            <x-text-input
                id="name"
                class="block mt-1 w-full"
                type="text"
                name="name"
                :value="old('name')"
                required
                autofocus
                autocomplete="name"
            />

            <p id="teacherNameHelp"
               class="hidden mt-1 text-xs text-gray-500">
                Your official teacher name will be taken from academy records.
            </p>

            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        {{-- Email --}}
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />

            <x-text-input
                id="email"
                class="block mt-1 w-full"
                type="email"
                name="email"
                :value="old('email')"
                required
                autocomplete="username"
            />

            <p id="teacherEmailHelp"
               class="hidden mt-1 text-xs text-gray-500">
                Enter the same email saved in your teacher profile.
            </p>

            <p id="parentEmailHelp"
               class="hidden mt-1 text-xs text-gray-500">
                Enter the email you will use for parent login.
            </p>

            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Parent Student Verification Fields --}}
        <div id="parentFields" class="hidden">

            {{-- Student ID --}}
            <div class="mt-4">
                <x-input-label
                    for="student_registration_id"
                    :value="__('Student ID')"
                />

                <x-text-input
                    id="student_registration_id"
                    class="block mt-1 w-full"
                    type="text"
                    name="student_registration_id"
                    :value="old('student_registration_id')"
                    autocomplete="off"
                />

                <p class="mt-1 text-xs text-gray-500">
                    Enter the Student ID provided by Glorify Academy.
                </p>

                <x-input-error
                    :messages="$errors->get('student_registration_id')"
                    class="mt-2"
                />
            </div>

            {{-- Student Name --}}
            <div class="mt-4">
                <x-input-label
                    for="student_name"
                    :value="__('Student Name')"
                />

                <x-text-input
                    id="student_name"
                    class="block mt-1 w-full"
                    type="text"
                    name="student_name"
                    :value="old('student_name')"
                    autocomplete="off"
                />

                <p class="mt-1 text-xs text-gray-500">
                    Student name must match academy records.
                </p>

                <x-input-error
                    :messages="$errors->get('student_name')"
                    class="mt-2"
                />
            </div>
        </div>

        {{-- Password --}}
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input
                id="password"
                class="block mt-1 w-full"
                type="password"
                name="password"
                required
                autocomplete="new-password"
            />

            <x-input-error
                :messages="$errors->get('password')"
                class="mt-2"
            />
        </div>

        {{-- Confirm Password --}}
        <div class="mt-4">
            <x-input-label
                for="password_confirmation"
                :value="__('Confirm Password')"
            />

            <x-text-input
                id="password_confirmation"
                class="block mt-1 w-full"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
            />

            <x-input-error
                :messages="$errors->get('password_confirmation')"
                class="mt-2"
            />
        </div>

        {{-- Login and Register --}}
        <div class="flex items-center justify-end mt-6">

            <a
                class="underline text-sm text-gray-600 hover:text-gray-900
                       rounded-md focus:outline-none focus:ring-2
                       focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('login') }}"
            >
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const roleSelect = document.getElementById('role');
            const parentFields = document.getElementById('parentFields');

            const studentIdInput =
                document.getElementById('student_registration_id');

            const studentNameInput =
                document.getElementById('student_name');

            const nameLabel =
                document.getElementById('nameLabel');

            const teacherNameHelp =
                document.getElementById('teacherNameHelp');

            const teacherEmailHelp =
                document.getElementById('teacherEmailHelp');

            const parentEmailHelp =
                document.getElementById('parentEmailHelp');

            function updateRegistrationFields() {

                const selectedRole = roleSelect.value;

                if (selectedRole === 'parent') {

                    parentFields.classList.remove('hidden');

                    studentIdInput.required = true;
                    studentNameInput.required = true;

                    nameLabel.textContent = 'Parent Name';

                    teacherNameHelp.classList.add('hidden');
                    teacherEmailHelp.classList.add('hidden');
                    parentEmailHelp.classList.remove('hidden');

                } else if (selectedRole === 'teacher') {

                    parentFields.classList.add('hidden');

                    studentIdInput.required = false;
                    studentNameInput.required = false;

                    nameLabel.textContent = 'Teacher Name';

                    teacherNameHelp.classList.remove('hidden');
                    teacherEmailHelp.classList.remove('hidden');
                    parentEmailHelp.classList.add('hidden');

                } else {

                    parentFields.classList.add('hidden');

                    studentIdInput.required = false;
                    studentNameInput.required = false;

                    nameLabel.textContent = 'Name';

                    teacherNameHelp.classList.add('hidden');
                    teacherEmailHelp.classList.add('hidden');
                    parentEmailHelp.classList.add('hidden');
                }
            }

            roleSelect.addEventListener(
                'change',
                updateRegistrationFields
            );

            updateRegistrationFields();
        });
    </script>

</x-guest-layout>