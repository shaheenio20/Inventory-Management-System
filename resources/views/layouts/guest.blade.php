<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                font-family: 'Inter', sans-serif;
                background: linear-gradient(to left, #020617 0%, #312e81 45%, #0f766e 100%);
                background-attachment: fixed;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                overflow: hidden;
            }

            /* Animated background blobs */
            .bg-blob {
                position: fixed;
                border-radius: 50%;
                filter: blur(80px);
                opacity: 0.15;
                animation: float 8s ease-in-out infinite;
                pointer-events: none;
            }
            .bg-blob-1 {
                width: 400px; height: 400px;
                background: #7c3aed;
                top: -100px; left: -100px;
                animation-delay: 0s;
            }
            .bg-blob-2 {
                width: 300px; height: 300px;
                background: #2563eb;
                bottom: -50px; right: -80px;
                animation-delay: 3s;
            }
            .bg-blob-3 {
                width: 200px; height: 200px;
                background: #7c3aed;
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
                background: rgba(255, 255, 255, 0.05);
                backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.1);
                border-radius: 20px;
                padding: 40px 36px;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
                position: relative;
                z-index: 10;
            }

            .login-title {
                font-size: 2rem;
                font-weight: 800;
                color: #fff;
                margin: 0 0 4px;
                letter-spacing: -0.5px;
            }

            .login-subtitle {
                font-size: 0.875rem;
                color: rgba(255,255,255,0.45);
                margin-bottom: 28px;
            }

            .login-subtitle a {
                color: #a78bfa;
                font-weight: 600;
                text-decoration: none;
                transition: color 0.2s;
            }
            .login-subtitle a:hover { color: #c4b5fd; }

            .input-group {
                margin-bottom: 16px;
            }

            .input-label {
                display: block;
                font-size: 0.8125rem;
                font-weight: 600;
                color: rgba(255,255,255,0.75);
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
                color: rgba(255,255,255,0.3);
                pointer-events: none;
            }

            .input-field {
                width: 100%;
                background: rgba(255,255,255,0.06);
                border: 1px solid rgba(255,255,255,0.1);
                border-radius: 12px;
                padding: 12px 14px 12px 42px;
                color: #fff;
                font-size: 0.9375rem;
                font-family: 'Inter', sans-serif;
                transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
                box-sizing: border-box;
                outline: none;
            }
            .input-field::placeholder { color: rgba(255,255,255,0.25); }
            .input-field:focus {
                border-color: rgba(124,58,237,0.7);
                background: rgba(124,58,237,0.08);
                box-shadow: 0 0 0 3px rgba(124,58,237,0.2);
            }

            .input-error-msg {
                font-size: 0.75rem;
                color: #f87171;
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
                background: rgba(255,255,255,0.08);
            }
            .divider-text {
                font-size: 0.75rem;
                color: rgba(255,255,255,0.3);
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
                color: rgba(255,255,255,0.5);
                cursor: pointer;
            }
            .remember-label input[type="checkbox"] {
                width: 15px; height: 15px;
                accent-color: #7c3aed;
                border-radius: 4px;
                cursor: pointer;
            }
            .forgot-link {
                font-size: 0.8125rem;
                font-weight: 600;
                color: #a78bfa;
                text-decoration: none;
                transition: color 0.2s;
            }
            .forgot-link:hover { color: #c4b5fd; }

            .btn-signin {
                width: 100%;
                padding: 13px;
                background: linear-gradient(to left, #0f172a 0%, #4338ca 45%, #0891b2 100%);
                color: #fff;
                font-size: 0.9375rem;
                font-weight: 700;
                font-family: 'Inter', sans-serif;
                border: none;
                border-radius: 12px;
                cursor: pointer;
                transition: transform 0.15s, box-shadow 0.2s, opacity 0.2s;
                box-shadow: 0 6px 24px rgba(124,58,237,0.45);
                letter-spacing: 0.01em;
            }
            .btn-signin:hover {
                transform: translateY(-1px);
                box-shadow: 0 10px 32px rgba(124,58,237,0.6);
            }
            .btn-signin:active { transform: translateY(0); }

            /* Demo quick login section */
            .demo-section {
                margin-top: 24px;
                border-top: 1px solid rgba(255,255,255,0.06);
                padding-top: 20px;
            }
            .demo-label {
                text-align: center;
                font-size: 0.75rem;
                color: rgba(255,255,255,0.3);
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
                background: transparent;
                transition: all 0.2s;
                letter-spacing: 0.01em;
            }
            .demo-btn:hover { transform: translateY(-2px); }
            .demo-btn:active { transform: translateY(0); }

            .demo-btn-admin {
                color: #a78bfa;
                border-color: rgba(167,139,250,0.35);
            }
            .demo-btn-admin:hover {
                background: rgba(124,58,237,0.15);
                border-color: #a78bfa;
                box-shadow: 0 4px 16px rgba(124,58,237,0.25);
            }

            .demo-btn-manager {
                color: #60a5fa;
                border-color: rgba(96,165,250,0.35);
            }
            .demo-btn-manager:hover {
                background: rgba(37,99,235,0.15);
                border-color: #60a5fa;
                box-shadow: 0 4px 16px rgba(37,99,235,0.25);
            }

            .demo-btn-staff {
                color: #34d399;
                border-color: rgba(52,211,153,0.35);
            }
            .demo-btn-staff:hover {
                background: rgba(5,150,105,0.15);
                border-color: #34d399;
                box-shadow: 0 4px 16px rgba(16,185,129,0.25);
            }

            /* Session status */
            .session-status {
                background: rgba(52,211,153,0.1);
                border: 1px solid rgba(52,211,153,0.25);
                border-radius: 10px;
                padding: 10px 14px;
                font-size: 0.8125rem;
                color: #34d399;
                margin-bottom: 20px;
            }
        </style>
    </head>
    <body>
        <!-- Background blobs -->
        <div class="bg-blob bg-blob-1"></div>
        <div class="bg-blob bg-blob-2"></div>
        <div class="bg-blob bg-blob-3"></div>

        <div class="login-card">
            {{ $slot }}
        </div>

        <script>
            function quickLogin(email, password) {
                const emailInput = document.getElementById('email');
                const passwordInput = document.getElementById('password');
                if (emailInput) emailInput.value = email;
                if (passwordInput) passwordInput.value = password;

                // Brief visual flash on fields
                [emailInput, passwordInput].forEach(el => {
                    if (!el) return;
                    el.style.borderColor = 'rgba(124,58,237,0.8)';
                    el.style.boxShadow = '0 0 0 3px rgba(124,58,237,0.25)';
                    setTimeout(() => {
                        el.style.borderColor = '';
                        el.style.boxShadow = '';
                    }, 800);
                });
            }
        </script>
    </body>
</html>
