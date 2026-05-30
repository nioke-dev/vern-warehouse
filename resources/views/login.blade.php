<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Welcome Back Vern - Login</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles

        <style>
            /* ===== PAGE LAYOUT ===== */
            .login-page {
                height: 100vh;
                max-height: 100vh;
                overflow: hidden;
                background-color: #EEF2F8;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px 4px 20px 20px;
            }

            .login-container {
                display: flex;
                width: 100%;
                gap: 24px;
                align-items: center;
                justify-content: space-between;
                padding-left: max(0px, calc((100vw - 1100px - 40px) / 2));
            }

            /* ===== LEFT SIDE ===== */
            .left-side {
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
            }

            /* ===== LOGIN CARD ===== */
            .login-card {
                width: 467px;
                position: relative;
                background: linear-gradient(180deg, rgba(47, 120, 238, 0.78) 0%, #FFFFFF 32%, #FFFFFF 100%);
                border-radius: 12px;
                border: none;
                overflow: hidden;
            }

            /* Gradient border using mask technique (supports border-radius) */
            .login-card::before {
                content: '';
                position: absolute;
                inset: 0;
                border-radius: 12px;
                padding: 2px;
                background: linear-gradient(180deg, #D5F1E6 0%, #F3F3F2 50%, #F3F3F2 100%);
                -webkit-mask: 
                    linear-gradient(#fff 0 0) content-box, 
                    linear-gradient(#fff 0 0);
                mask: 
                    linear-gradient(#fff 0 0) content-box, 
                    linear-gradient(#fff 0 0);
                -webkit-mask-composite: xor;
                mask-composite: exclude;
                pointer-events: none;
                z-index: 1;
            }

            /* Logo area */
            .logo-area {
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 32px 20px 20px;
            }

            .vern-logo {
                width: 72px;
                height: 72px;
                object-fit: contain;
                filter: drop-shadow(0 4px 12px rgba(0, 0, 0, 0.12));
            }

            /* White form area */
            .card-body {
                padding: 4px 28px 28px;
            }

            .card-title {
                font-size: 22px;
                font-weight: 700;
                color: #292D32;
                text-align: center;
                margin-bottom: 4px;
            }

            .card-subtitle {
                font-size: 13px;
                font-weight: 400;
                color: #6A7686;
                text-align: center;
                margin-bottom: 20px;
            }

            /* ===== ERROR BOX ===== */
            .error-box {
                background: #FEF2F2;
                border: 1px solid #FECACA;
                color: #DC2626;
                padding: 10px 14px;
                border-radius: 10px;
                font-size: 13px;
                margin-bottom: 16px;
            }

            /* ===== FORM ===== */
            .login-form {
                display: flex;
                flex-direction: column;
            }

            .form-group {
                margin-bottom: 14px;
            }

            .form-label {
                display: block;
                font-size: 13px;
                font-weight: 600;
                color: #292D32;
                margin-bottom: 6px;
            }

            .input-wrapper {
                position: relative;
                display: flex;
                align-items: center;
            }

            .input-icon {
                position: absolute;
                left: 12px;
                display: flex;
                align-items: center;
                pointer-events: none;
                z-index: 1;
            }

            .login-input {
                width: 100%;
                height: 44px;
                padding: 0 12px 0 40px;
                border: 1.5px solid #E8E8E8;
                border-radius: 10px;
                font-size: 13px;
                font-weight: 500;
                color: #292D32;
                background: #FAFAFA;
                transition: all 200ms ease;
                outline: none;
            }

            .login-input:focus {
                border-color: #1053D5;
                background: #fff;
                box-shadow: 0 0 0 3px rgba(16, 83, 213, 0.06);
            }

            .login-input::placeholder {
                color: #A0AEC0;
                font-weight: 400;
            }

            .login-input:disabled {
                opacity: 0.6;
                cursor: not-allowed;
            }

            .password-toggle {
                position: absolute;
                right: 12px;
                display: flex;
                align-items: center;
                background: none;
                border: none;
                cursor: pointer;
                padding: 4px;
                border-radius: 6px;
                transition: background 200ms;
            }

            .password-toggle:hover {
                background: rgba(0, 0, 0, 0.04);
            }

            /* ===== FORM OPTIONS ===== */
            .form-options {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 18px;
            }

            .checkbox-label {
                display: flex;
                align-items: center;
                gap: 6px;
                font-size: 12px;
                color: #6A7686;
                cursor: pointer;
            }

            .checkbox-input {
                width: 15px;
                height: 15px;
                accent-color: #1053D5;
                border-radius: 3px;
                cursor: pointer;
            }

            .forgot-link {
                font-size: 12px;
                font-weight: 600;
                color: #292D32;
                text-decoration: none;
            }

            .forgot-link:hover {
                text-decoration: underline;
            }

            /* ===== SIGN IN BUTTON ===== */
            .btn-signin {
                width: 100%;
                height: 44px;
                border: none;
                border-radius: 10px;
                font-size: 14px;
                font-weight: 600;
                color: white;
                cursor: pointer;
                background: linear-gradient(135deg, #1A6FFF 0%, #1053D5 100%);
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                transition: all 200ms ease;
            }

            .btn-signin:hover:not(:disabled) {
                background: linear-gradient(135deg, #0D5CE8 0%, #0A3A89 100%);
                transform: translateY(-1px);
                box-shadow: 0 4px 16px rgba(16, 83, 213, 0.3);
            }

            .btn-signin:active:not(:disabled) {
                transform: translateY(0);
            }

            .btn-signin:disabled {
                opacity: 0.7;
                cursor: not-allowed;
            }

            .spinner {
                width: 18px;
                height: 18px;
                border: 2px solid white;
                border-top: 2px solid transparent;
                border-radius: 50%;
                animation: spin 0.8s linear infinite;
            }

            @keyframes spin {
                to { transform: rotate(360deg); }
            }

            /* ===== CREATE ACCOUNT ===== */
            .create-account {
                text-align: center;
                font-size: 12px;
                color: #6A7686;
                margin: 0;
                margin-top: 20px;
            }

            .create-link {
                font-weight: 600;
                color: #10B981;
                text-decoration: none;
            }

            .create-link:hover {
                text-decoration: underline;
            }

            /* ===== RIGHT SIDE ===== */
            .right-side {
                flex: 1;
                display: flex;
                align-items: center;
                justify-content: flex-end;
                min-height: 0;
                height: 100%;
                max-height: calc(100vh - 40px);
            }

            .right-panel-image {
                width: 100%;
                max-width: 560px;
                max-height: calc(100vh - 40px);
                border-radius: 16px;
                object-fit: contain;
                box-shadow: none;
            }

            /* ===== RESPONSIVE ===== */
            @media (max-width: 1024px) {
                .login-container {
                    flex-direction: column;
                    padding-left: 0;
                    justify-content: center;
                }

                .right-side {
                    display: none;
                }

                .left-side {
                    width: 100%;
                }

                .login-card {
                    width: 100%;
                    max-width: 467px;
                }
            }
        </style>
    </head>
    <body class="font-['Plus_Jakarta_Sans']">
        <main class="login-page" x-data="{
            form: {
                email: '',
                password: ''
            },
            showPassword: false,
            loading: false,
            errorMessage: '',
            saveAccount: false,
            async handleLogin() {
                this.loading = true;
                this.errorMessage = '';
                
                try {
                    const response = await fetch('{{ route('login') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(this.form)
                    });
                    
                    const contentType = response.headers.get('content-type');
                    if (contentType && contentType.includes('application/json')) {
                        const data = await response.json();
                        if (response.ok) {
                            window.location.href = data.redirect || '/dashboard';
                        } else {
                            this.errorMessage = data.message || 'Email atau password salah. Silakan coba lagi.';
                        }
                    } else {
                        const text = await response.text();
                        console.error('Server error response:', text);
                        
                        let exceptionMessage = '';
                        const match = text.match(/<title>(.*?)<\/title>/i);
                        if (match && match[1]) {
                            exceptionMessage = ': ' + match[1].trim();
                        }
                        this.errorMessage = `Error Server (${response.status})${exceptionMessage}. Silakan periksa log.`;
                    }
                } catch (error) {
                    console.error('Login connection error:', error);
                    this.errorMessage = 'Tidak dapat terhubung ke server: ' + error.message;
                } finally {
                    this.loading = false;
                }
            }
        }">
            <div class="login-container">
                <!-- LEFT SIDE: Login Card -->
                <div class="left-side">
                    <div class="login-card">
                        <!-- Logo area -->
                        <div class="logo-area">
                            <a href="{{ route('home') }}" wire:navigate>
                                <img 
                                    src="{{ asset('assets/images/logos/vern-logo.png') }}" 
                                    class="vern-logo" 
                                    alt="Vern Logo"
                                >
                            </a>
                        </div>

                        <!-- Form Content -->
                        <div class="card-body">
                            <h1 class="card-title">Welcome Back Vern</h1>
                            <p class="card-subtitle">Welcome back! Please enter your details.</p>

                            <!-- Error Message -->
                            <div x-show="errorMessage" x-text="errorMessage" class="error-box" style="display: none;"></div>

                            <form @submit.prevent="handleLogin" class="login-form">
                                <!-- Email Field -->
                                <div class="form-group">
                                    <label class="form-label">Email</label>
                                    <div class="input-wrapper">
                                        <span class="input-icon">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="1.5">
                                                <path d="M17 20.5H7C4 20.5 2 19 2 15.5V8.5C2 5 4 3.5 7 3.5H17C20 3.5 22 5 22 8.5V15.5C22 19 20 20.5 17 20.5Z" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M17 9L13.87 11.5C12.84 12.32 11.15 12.32 10.12 11.5L7 9" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </span>
                                        <input
                                            x-model="form.email"
                                            type="email"
                                            class="login-input"
                                            placeholder="Enter your email"
                                            required
                                            :disabled="loading"
                                        >
                                    </div>
                                </div>

                                <!-- Password Field -->
                                <div class="form-group">
                                    <label class="form-label">Password</label>
                                    <div class="input-wrapper">
                                        <span class="input-icon">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="1.5">
                                                <path d="M6 10V8C6 4.69 7 2 12 2C17 2 18 4.69 18 8V10" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M17 22H7C3 22 2 21 2 17V15C2 11 3 10 7 10H17C21 10 22 11 22 15V17C22 21 21 22 17 22Z" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M15.9965 16H16.0054" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                                <path d="M11.9955 16H12.0045" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                                <path d="M7.99451 16H8.00349" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                            </svg>
                                        </span>
                                        <input
                                            x-model="form.password"
                                            :type="showPassword ? 'text' : 'password'"
                                            class="login-input"
                                            placeholder="Enter your password"
                                            required
                                            :disabled="loading"
                                        >
                                        <button
                                            @click="showPassword = !showPassword"
                                            type="button"
                                            class="password-toggle"
                                            :disabled="loading"
                                        >
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="1.5">
                                                <path d="M15.58 12C15.58 13.98 13.98 15.58 12 15.58C10.02 15.58 8.42 13.98 8.42 12C8.42 10.02 10.02 8.42 12 8.42C13.98 8.42 15.58 10.02 15.58 12Z" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M12 20.27C15.53 20.27 18.82 18.19 21.11 14.59C22.01 13.18 22.01 10.81 21.11 9.4C18.82 5.8 15.53 3.72 12 3.72C8.47 3.72 5.18 5.8 2.89 9.4C1.99 10.81 1.99 13.18 2.89 14.59C5.18 18.19 8.47 20.27 12 20.27Z" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <!-- Save Account + Forgot Password -->
                                <div class="form-options">
                                    <label class="checkbox-label">
                                        <input type="checkbox" x-model="saveAccount" class="checkbox-input">
                                        <span>Save account</span>
                                    </label>
                                    <a href="#" class="forgot-link">Forgot Password</a>
                                </div>

                                <!-- Sign In Button -->
                                <button
                                    type="submit"
                                    class="btn-signin"
                                    :disabled="loading"
                                >
                                    <div x-show="loading" class="spinner" style="display: none;"></div>
                                    <span x-text="loading ? 'Signing In...' : 'Sign In'">Sign In</span>
                                </button>
                            </form>

                            <!-- Create Account Link -->
                            <p class="create-account">
                                Don't have an account? <a href="#" class="create-link">Create now</a>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- RIGHT SIDE: Full image panel -->
                <div class="right-side">
                    <img
                        src="{{ asset('assets/images/backgrounds/dashboard-preview.png') }}"
                        class="right-panel-image"
                        alt="Dashboard Preview"
                    >
                </div>
            </div>
        </main>
        @livewireScripts
    </body>
</html>
