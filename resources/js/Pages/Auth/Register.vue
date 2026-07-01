<template>
    <GuestLayout>
        <Head title="Register" />

        <h1 class="login-title">Create account</h1>
        <p class="login-subtitle">
            Already have an account?
            <Link href="/login">Sign in</Link>
        </p>

        <form @submit.prevent="submit">
            <!-- Full Name -->
            <div class="input-group">
                <label for="name" class="input-label">Full name</label>
                <div class="input-wrapper">
                    <span class="input-icon">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </span>
                    <input
                        id="name"
                        class="input-field"
                        type="text"
                        v-model="form.name"
                        placeholder="John Doe"
                        required
                        autofocus
                        autocomplete="name"
                    />
                </div>
                <div v-if="form.errors.name" class="input-error-msg">{{ form.errors.name }}</div>
            </div>

            <!-- Email Address -->
            <div class="input-group">
                <label for="email" class="input-label">Email address</label>
                <div class="input-wrapper">
                    <span class="input-icon">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </span>
                    <input
                        id="email"
                        class="input-field"
                        type="email"
                        v-model="form.email"
                        placeholder="you@company.com"
                        required
                        autocomplete="username"
                    />
                </div>
                <div v-if="form.errors.email" class="input-error-msg">{{ form.errors.email }}</div>
            </div>

            <!-- Password -->
            <div class="input-group">
                <label for="password" class="input-label">Password</label>
                <div class="input-wrapper">
                    <span class="input-icon">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </span>
                    <input
                        id="password"
                        class="input-field"
                        :type="passwordFieldType"
                        v-model="form.password"
                        placeholder="Min. 8 characters"
                        required
                        autocomplete="new-password"
                    />
                    <button type="button" class="password-toggle" @click="togglePassword" tabindex="-1">
                        <svg v-if="passwordFieldType === 'password'" class="eye-icon" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <svg v-else class="eye-icon" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                        </svg>
                    </button>
                </div>
                <div v-if="form.errors.password" class="input-error-msg">{{ form.errors.password }}</div>
            </div>

            <!-- Confirm Password -->
            <div class="input-group" style="margin-bottom: 20px;">
                <label for="password_confirmation" class="input-label">Confirm password</label>
                <div class="input-wrapper">
                    <span class="input-icon">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </span>
                    <input
                        id="password_confirmation"
                        class="input-field"
                        :type="passwordConfirmFieldType"
                        v-model="form.password_confirmation"
                        placeholder="Re-enter your password"
                        required
                        autocomplete="new-password"
                    />
                    <button type="button" class="password-toggle" @click="togglePasswordConfirm" tabindex="-1">
                        <svg v-if="passwordConfirmFieldType === 'password'" class="eye-icon" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <svg v-else class="eye-icon" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                        </svg>
                    </button>
                </div>
                <div v-if="form.errors.password_confirmation" class="input-error-msg">{{ form.errors.password_confirmation }}</div>
            </div>

            <!-- Register Button -->
            <button type="submit" class="btn-signin" :disabled="form.processing">Create account</button>

            
        </form>
    </GuestLayout>
</template>

<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const passwordFieldType = ref('password');
const passwordConfirmFieldType = ref('password');

const togglePassword = () => {
    passwordFieldType.value = passwordFieldType.value === 'password' ? 'text' : 'password';
};

const togglePasswordConfirm = () => {
    passwordConfirmFieldType.value = passwordConfirmFieldType.value === 'password' ? 'text' : 'password';
};

const submit = () => {
    form.post('/register', {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<style scoped>
.password-toggle {
    position: absolute;
    right: 14px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: rgba(255,255,255,0.3);
    cursor: pointer;
    padding: 0;
    transition: color 0.2s;
    display: flex;
    align-items: center;
}
.password-toggle:hover { color: rgba(255,255,255,0.7); }
.input-wrapper:has(~ .password-toggle) .input-field {
    padding-right: 42px;
}
</style>
