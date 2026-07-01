<template>
    <div class="guest-layout-wrapper">
        <!-- Background blobs -->
        <div class="bg-blob bg-blob-1"></div>
        <div class="bg-blob bg-blob-2"></div>
        <div class="bg-blob bg-blob-3"></div>

        <div class="login-card">
            <slot />
        </div>
    </div>
</template>

<script setup>
</script>

<style>
.guest-layout-wrapper {
    font-family: 'Inter', sans-serif;
    background-color: #ffffff;
    background-image: radial-gradient(#e2e8f0 1px, transparent 1px);
    background-size: 24px 24px;
    background-attachment: fixed;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    position: relative;
}

/* Animated background blobs */
.bg-blob {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
    opacity: 0.4;
    animation: float 8s ease-in-out infinite;
    pointer-events: none;
    z-index: 0;
}
.bg-blob-1 {
    width: 400px; height: 400px;
    background: #e0e7ff;
    top: -100px; left: -100px;
    animation-delay: 0s;
}
.bg-blob-2 {
    width: 300px; height: 300px;
    background: #dbeafe;
    bottom: -50px; right: -80px;
    animation-delay: 3s;
}
.bg-blob-3 {
    width: 200px; height: 200px;
    background: #fae8ff;
    bottom: 100px; left: 200px;
    animation-delay: 5s;
}
@keyframes float {
    0%, 100% { transform: translateY(0px) scale(1); }
    50% { transform: translateY(-30px) scale(1.05); }
}

.login-card {
    width: 100%;
    max-width: 420px;
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 1);
    border-radius: 20px;
    padding: 40px 36px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.05), 0 0 40px rgba(0, 0, 0, 0.02);
    position: relative;
    z-index: 10;
}

.login-title {
    font-size: 2rem;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 4px;
    letter-spacing: -0.5px;
}

.login-subtitle {
    font-size: 0.875rem;
    color: #64748b;
    margin-bottom: 28px;
}

.login-subtitle a {
    color: #4f46e5;
    font-weight: 600;
    text-decoration: none;
    transition: color 0.2s;
}
.login-subtitle a:hover { color: #4338ca; }

.input-group {
    margin-bottom: 16px;
}

.input-label {
    display: block;
    font-size: 0.8125rem;
    font-weight: 600;
    color: #475569;
    margin-bottom: 6px;
    letter-spacing: 0.02em;
}

.input-wrapper {
    position: relative;
}

.input-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    pointer-events: none;
}

.input-field {
    width: 100%;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 12px 14px 12px 42px;
    color: #0f172a;
    font-size: 0.9375rem;
    font-family: 'Inter', sans-serif;
    transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
    box-sizing: border-box;
    outline: none;
}
.input-field::placeholder { color: #94a3b8; }
.input-field:focus {
    border-color: #4f46e5;
    background: #ffffff;
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
}

.input-error-msg {
    font-size: 0.75rem;
    color: #ef4444;
    margin-top: 5px;
}

.divider {
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 20px 0;
}
.divider-line {
    flex: 1;
    height: 1px;
    background: #e2e8f0;
}
.divider-text {
    font-size: 0.75rem;
    color: #94a3b8;
    white-space: nowrap;
}

.row-actions {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin: 16px 0 20px;
}
.remember-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.8125rem;
    color: #64748b;
    cursor: pointer;
}
.remember-label input[type="checkbox"] {
    width: 15px; height: 15px;
    accent-color: #4f46e5;
    border-radius: 4px;
    cursor: pointer;
    border: 1px solid #cbd5e1;
}
.forgot-link {
    font-size: 0.8125rem;
    font-weight: 600;
    color: #4f46e5;
    text-decoration: none;
    transition: color 0.2s;
}
.forgot-link:hover { color: #4338ca; }

.btn-signin {
    width: 100%;
    padding: 13px;
    background: linear-gradient(to right, #4f46e5 0%, #0ea5e9 100%);
    color: #fff;
    font-size: 0.9375rem;
    font-weight: 700;
    font-family: 'Inter', sans-serif;
    border: none;
    border-radius: 12px;
    cursor: pointer;
    transition: transform 0.15s, box-shadow 0.2s, opacity 0.2s;
    box-shadow: 0 6px 20px rgba(79, 70, 229, 0.3);
    letter-spacing: 0.01em;
}
.btn-signin:hover {
    transform: translateY(-1px);
    box-shadow: 0 8px 25px rgba(79, 70, 229, 0.4);
}
.btn-signin:active { transform: translateY(0); }

/* Demo quick login section */
.demo-section {
    margin-top: 24px;
    border-top: 1px solid #e2e8f0;
    padding-top: 20px;
}
.demo-label {
    text-align: center;
    font-size: 0.75rem;
    color: #94a3b8;
    margin-bottom: 12px;
    letter-spacing: 0.04em;
    text-transform: uppercase;
}
.demo-buttons {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 10px;
}
.demo-btn {
    padding: 10px 8px;
    border-radius: 10px;
    font-size: 0.8125rem;
    font-weight: 700;
    font-family: 'Inter', sans-serif;
    cursor: pointer;
    border: 1.5px solid;
    background: #ffffff;
    transition: all 0.2s;
    letter-spacing: 0.01em;
}
.demo-btn:hover { transform: translateY(-2px); }
.demo-btn:active { transform: translateY(0); }

.demo-btn-admin {
    color: #4f46e5;
    border-color: rgba(79, 70, 229, 0.2);
}
.demo-btn-admin:hover {
    background: rgba(79, 70, 229, 0.05);
    border-color: #4f46e5;
    box-shadow: 0 4px 12px rgba(79, 70, 229, 0.1);
}

.demo-btn-manager {
    color: #0ea5e9;
    border-color: rgba(14, 165, 233, 0.2);
}
.demo-btn-manager:hover {
    background: rgba(14, 165, 233, 0.05);
    border-color: #0ea5e9;
    box-shadow: 0 4px 12px rgba(14, 165, 233, 0.1);
}

.demo-btn-staff {
    color: #10b981;
    border-color: rgba(16, 185, 129, 0.2);
}
.demo-btn-staff:hover {
    background: rgba(16, 185, 129, 0.05);
    border-color: #10b981;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.1);
}

/* Session status */
.session-status {
    background: rgba(16, 185, 129, 0.1);
    border: 1px solid rgba(16, 185, 129, 0.2);
    border-radius: 10px;
    padding: 10px 14px;
    font-size: 0.8125rem;
    color: #059669;
    margin-bottom: 20px;
}
</style>
