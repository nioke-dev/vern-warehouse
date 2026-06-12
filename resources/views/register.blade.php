<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <link rel="icon" type="image/png" href="{{ asset('assets/images/logos/vern-logo.png') }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Daftar Akun Baru - Vern</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles

        <!-- Alpine.js CDN -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <style>
            /* ===== PAGE LAYOUT ===== */
            .login-page {
                min-height: 100vh;
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

            .left-side {
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
            }

            .login-card {
                width: 467px;
                position: relative;
                background: linear-gradient(180deg, rgba(47, 120, 238, 0.78) 0%, #FFFFFF 32%, #FFFFFF 100%);
                border-radius: 12px;
                border: none;
                overflow: hidden;
            }

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

            .logo-area {
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 32px 20px 16px;
            }

            .vern-logo {
                width: 64px;
                height: 64px;
                object-fit: contain;
                filter: drop-shadow(0 4px 12px rgba(0, 0, 0, 0.12));
            }

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

            .error-box {
                background: #FEF2F2;
                border: 1px solid #FECACA;
                color: #DC2626;
                padding: 10px 14px;
                border-radius: 10px;
                font-size: 13px;
                margin-bottom: 16px;
            }

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
                margin-top: 4px;
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

            .create-account {
                text-align: center;
                font-size: 12px;
                color: #6A7686;
                margin: 0;
                margin-top: 18px;
            }

            .create-link {
                font-weight: 600;
                color: #10B981;
                text-decoration: none;
            }

            .create-link:hover {
                text-decoration: underline;
            }

            .right-side {
                flex: 1;
                display: flex;
                align-items: center;
                justify-content: flex-end;
                min-height: 0;
            }

            .right-panel-image {
                width: 100%;
                max-width: 560px;
                max-height: calc(100vh - 40px);
                border-radius: 16px;
                object-fit: contain;
            }

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
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
            },
            showPassword: false,
            loading: false,
            errorMessage: '',
            async handleRegister() {
                this.errorMessage = '';

                if (this.form.password !== this.form.password_confirmation) {
                    this.errorMessage = 'Konfirmasi kata sandi tidak cocok.';
                    return;
                }
                if (this.form.password.length < 6) {
                    this.errorMessage = 'Kata sandi minimal 6 karakter.';
                    return;
                }

                this.loading = true;
                try {
                    const response = await fetch('{{ route('register') }}', {
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
                        } else if (data.errors) {
                            const first = Object.values(data.errors)[0];
                            this.errorMessage = Array.isArray(first) ? first[0] : first;
                        } else {
                            this.errorMessage = data.message || 'Pendaftaran gagal. Silakan coba lagi.';
                        }
                    } else {
                        const text = await response.text();
                        console.error('Server error response:', text);
                        this.errorMessage = `Kesalahan Server (${response.status}). Silakan periksa log.`;
                    }
                } catch (error) {
                    console.error('Kesalahan koneksi daftar:', error);
                    this.errorMessage = 'Tidak dapat terhubung ke server: ' + error.message;
                } finally {
                    this.loading = false;
                }
            }
        }">
            <div class="login-container">
                <!-- LEFT SIDE: Register Card -->
                <div class="left-side">
                    <div class="login-card">
                        <div class="logo-area">
                            <a href="{{ route('home') }}" wire:navigate>
                                <img
                                    src="{{ asset('assets/images/logos/vern-logo.png') }}"
                                    class="vern-logo"
                                    alt="Vern Logo"
                                >
                            </a>
                        </div>

                        <div class="card-body">
                            <h1 class="card-title">Buat Akun Vern Baru</h1>
                            <p class="card-subtitle">Daftar untuk mulai mengelola gudang Anda sendiri.</p>

                            <div x-show="errorMessage" x-text="errorMessage" class="error-box" style="display: none;"></div>

                            <form @submit.prevent="handleRegister" class="login-form">
                                <!-- Name -->
                                <div class="form-group">
                                    <label class="form-label">Nama Lengkap</label>
                                    <div class="input-wrapper">
                                        <span class="input-icon">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="1.5">
                                                <path d="M12 12a4 4 0 100-8 4 4 0 000 8zM4 20c0-3.3 3.6-6 8-6s8 2.7 8 6" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </span>
                                        <input x-model="form.name" type="text" class="login-input"
                                            placeholder="Masukkan nama Anda" required :disabled="loading">
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="form-group">
                                    <label class="form-label">Email</label>
                                    <div class="input-wrapper">
                                        <span class="input-icon">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="1.5">
                                                <path d="M17 20.5H7C4 20.5 2 19 2 15.5V8.5C2 5 4 3.5 7 3.5H17C20 3.5 22 5 22 8.5V15.5C22 19 20 20.5 17 20.5Z" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M17 9L13.87 11.5C12.84 12.32 11.15 12.32 10.12 11.5L7 9" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </span>
                                        <input x-model="form.email" type="email" class="login-input"
                                            placeholder="Masukkan alamat email Anda" required :disabled="loading">
                                    </div>
                                </div>

                                <!-- Password -->
                                <div class="form-group">
                                    <label class="form-label">Password</label>
                                    <div class="input-wrapper">
                                        <span class="input-icon">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="1.5">
                                                <path d="M6 10V8C6 4.69 7 2 12 2C17 2 18 4.69 18 8V10" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M17 22H7C3 22 2 21 2 17V15C2 11 3 10 7 10H17C21 10 22 11 22 15V17C22 21 21 22 17 22Z" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </span>
                                        <input x-model="form.password" :type="showPassword ? 'text' : 'password'"
                                            class="login-input" placeholder="Minimal 6 karakter" required :disabled="loading">
                                        <button @click="showPassword = !showPassword" type="button" class="password-toggle" :disabled="loading">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="1.5">
                                                <path d="M15.58 12C15.58 13.98 13.98 15.58 12 15.58C10.02 15.58 8.42 13.98 8.42 12C8.42 10.02 10.02 8.42 12 8.42C13.98 8.42 15.58 10.02 15.58 12Z" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M12 20.27C15.53 20.27 18.82 18.19 21.11 14.59C22.01 13.18 22.01 10.81 21.11 9.4C18.82 5.8 15.53 3.72 12 3.72C8.47 3.72 5.18 5.8 2.89 9.4C1.99 10.81 1.99 13.18 2.89 14.59C5.18 18.19 8.47 20.27 12 20.27Z" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <!-- Confirm Password -->
                                <div class="form-group">
                                    <label class="form-label">Konfirmasi Password</label>
                                    <div class="input-wrapper">
                                        <span class="input-icon">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="1.5">
                                                <path d="M6 10V8C6 4.69 7 2 12 2C17 2 18 4.69 18 8V10" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M17 22H7C3 22 2 21 2 17V15C2 11 3 10 7 10H17C21 10 22 11 22 15V17C22 21 21 22 17 22Z" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </span>
                                        <input x-model="form.password_confirmation" :type="showPassword ? 'text' : 'password'"
                                            class="login-input" placeholder="Ulangi kata sandi Anda" required :disabled="loading">
                                    </div>
                                </div>

                                <button type="submit" class="btn-signin" :disabled="loading">
                                    <div x-show="loading" class="spinner" style="display: none;"></div>
                                    <span x-text="loading ? 'Mendaftar...' : 'Daftar'">Daftar</span>
                                </button>
                            </form>

                            <p class="create-account">
                                Sudah punya akun? <a href="{{ route('login') }}" class="create-link">Masuk di sini</a>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- RIGHT SIDE -->
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
