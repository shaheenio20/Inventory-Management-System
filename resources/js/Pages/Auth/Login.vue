<template>
    <GuestLayout>
        <Head title="Log in" />

        <div v-if="status" class="session-status">{{ status }}</div>
        <div v-if="success" class="session-status">{{ success }}</div>

        <h1 class="login-title">Welcome back</h1>
        <p class="login-subtitle">
            Don't have an account?
            <Link href="/register">Create an account</Link>
        </p>

        <form @submit.prevent="submit">
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
                        autofocus
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
                        type="password"
                        v-model="form.password"
                        placeholder="••••••••"
                        required
                        autocomplete="current-password"
                    />
                </div>
                <div v-if="form.errors.password" class="input-error-msg">{{ form.errors.password }}</div>
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="row-actions">
                <label class="remember-label">
                    <input type="checkbox" v-model="form.remember" id="remember_me">
                    <span>Remember me</span>
                </label>
                <Link v-if="canResetPassword" class="forgot-link" href="/forgot-password">
                    Forgot password?
                </Link>
            </div>

            <!-- Sign In Button -->
            <button type="submit" class="btn-signin" :disabled="form.processing">Sign in</button>
        </form>

        <!-- Demo Quick Login -->
        <div class="demo-section">
            <p class="demo-label">Demo: Quick Login as Admin</p>
            <div class="demo-buttons" style="grid-template-columns: 1fr;">
                <button
                    type="button"
                    class="demo-btn demo-btn-admin"
                    @click="quickLogin('admin@admin.com', 'password')"
                >
                    Admin
                </button>
            </div>
        </div>
    </GuestLayout>
</template>

<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    success: {
        type: String,
    }
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post('/login', {
        onFinish: () => form.reset('password'),
    });
};

const quickLogin = (email, password) => {
    form.email = email;
    form.password = password;
    submit();
};
</script>
