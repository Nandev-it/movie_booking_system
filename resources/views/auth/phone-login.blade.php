{{-- resources/views/auth/phone-login.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login — CineBook</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="min-h-screen flex items-center justify-center" style="background:#111113;">

    <div x-data="{
        step: 1,
        phone: '',
        otp: '',
        loading: false,
        error: '',
        success: '',
        devOtp: '',
        countdown: 0,
        timer: null,

        startCountdown() {
            this.countdown = 60;
            clearInterval(this.timer);
            this.timer = setInterval(() => {
                this.countdown--;
                if (this.countdown <= 0) clearInterval(this.timer);
            }, 1000);
        },

        async sendOtp() {
            this.error = '';
            this.success = '';

            if (!this.phone || this.phone.trim() === '') {
                this.error = 'Please enter your phone number.';
                return;
            }

            if (this.phone.length < 8) {
                this.error = 'Phone number is too short.';
                return;
            }

            this.loading = true;

            try {
                const res = await fetch('{{ route('phone.otp.send') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                    },
                    body: JSON.stringify({ phone: this.phone.trim() })
                });

                const data = await res.json();

                if (data.success) {
                    this.step = 2;
                    this.devOtp = data.otp ?? '';
                    this.success = 'OTP sent to +855' + this.phone;
                    this.startCountdown();
                } else {
                    this.error = data.message ?? 'Failed to send OTP.';
                }
            } catch (e) {
                this.error = 'Network error. Please check your connection.';
            }

            this.loading = false;
        },

        async verifyOtp() {
            this.error = '';

            if (!this.otp || this.otp.toString().length !== 6) {
                this.error = 'Please enter the 6-digit OTP.';
                return;
            }

            this.loading = true;

            try {
                const res = await fetch('{{ route('phone.otp.verify') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                    },
                    body: JSON.stringify({
                        phone: this.phone.trim(),
                        otp: this.otp.toString()
                    })
                });

                const data = await res.json();

                if (data.success) {
                    this.success = 'Login successful! Redirecting...';
                    setTimeout(() => window.location.href = data.redirect, 1200);
                } else {
                    this.error = data.message ?? 'Invalid OTP.';
                }
            } catch (e) {
                this.error = 'Network error. Please check your connection.';
            }

            this.loading = false;
        },

        fillOtp() {
            this.otp = String(this.devOtp);
        },

        resetToStep1() {
            this.step = 1;
            this.otp = '';
            this.error = '';
            this.success = '';
            this.devOtp = '';
            clearInterval(this.timer);
            this.countdown = 0;
        }

    }" class="w-full max-w-sm mx-4">

        <div class="rounded-3xl p-8" style="background:#1c1c1e; border: 0.5px solid #2e2e32;">

            {{-- Logo --}}
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl mb-4"
                    style="background:#1e1b2e;">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#7c6fe0" stroke-width="2">
                        <path d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/>
                    </svg>
                </div>
                <h1 class="text-white text-xl font-semibold">CineBook</h1>
                <p class="text-sm mt-1" style="color:#666;">Sign in with your phone number</p>
            </div>

            {{-- Step Indicator --}}
            <div class="flex items-center gap-2 mb-8">
                <div class="flex-1 h-1 rounded-full transition-all duration-500"
                    :style="step >= 1 ? 'background:#7c6fe0' : 'background:#2a2a2e'"></div>
                <div class="flex-1 h-1 rounded-full transition-all duration-500"
                    :style="step >= 2 ? 'background:#7c6fe0' : 'background:#2a2a2e'"></div>
            </div>

            {{-- Error Alert --}}
            <div x-show="error"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-1"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="mb-4 px-4 py-3 rounded-xl text-sm flex items-start gap-2"
                style="background:#2a1a1a; color:#f87171; border: 0.5px solid #3f1f1f;">
                <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span x-text="error"></span>
            </div>

            {{-- Success Alert --}}
            <div x-show="success"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-1"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="mb-4 px-4 py-3 rounded-xl text-sm flex items-start gap-2"
                style="background:#1a2a1a; color:#4ade80; border: 0.5px solid #1f3f1f;">
                <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span x-text="success"></span>
            </div>

            {{-- STEP 1: Phone --}}
            <div x-show="step === 1"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-x-4"
                x-transition:enter-end="opacity-100 translate-x-0">

                <label class="block text-sm mb-2" style="color:#888;">Phone Number</label>

                <div class="flex items-center gap-2 rounded-xl px-4 py-3 mb-6"
                    style="background:#2a2a2e; border: 0.5px solid #3a3a3e;">
                    <span class="text-sm flex-shrink-0" style="color:#aaa;">🇰🇭 +855</span>
                    <div style="width:0.5px; height:16px; background:#3a3a3e;"></div>
                    <input
                        type="tel"
                        x-model="phone"
                        @keydown.enter="sendOtp()"
                        placeholder="90 123 456"
                        class="bg-transparent outline-none text-white text-sm flex-1 w-full"
                        maxlength="10"
                        inputmode="numeric"
                    />
                </div>

                <button
                    @click="sendOtp()"
                    :disabled="loading"
                    class="w-full py-3 rounded-xl text-white text-sm font-medium transition-all duration-200 flex items-center justify-center gap-2"
                    :style="loading ? 'background:#3b3b3e; cursor:not-allowed;' : 'background:#5b4fcf;'">
                    <template x-if="!loading">
                        <span>Send OTP</span>
                    </template>
                    <template x-if="loading">
                        <span class="flex items-center gap-2">
                            <svg class="animate-spin w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 12a9 9 0 11-6.219-8.56"/>
                            </svg>
                            Sending...
                        </span>
                    </template>
                </button>

            </div>

            {{-- STEP 2: OTP --}}
            <div x-show="step === 2"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-x-4"
                x-transition:enter-end="opacity-100 translate-x-0">

                <p class="text-sm mb-5" style="color:#888;">
                    OTP sent to
                    <span class="text-white font-medium" x-text="'+855' + phone"></span>
                    <button @click="resetToStep1()" class="ml-2 text-xs underline" style="color:#7c6fe0;">
                        Change
                    </button>
                </p>

                {{-- Dev OTP box — remove in production --}}
                <div x-show="devOtp"
                    @click="fillOtp()"
                    class="mb-5 px-4 py-3 rounded-xl text-sm cursor-pointer select-none"
                    style="background:#1e1b2e; border: 0.5px solid #3b2f6e;">
                    <p class="text-xs mb-1" style="color:#666;">
                        ⚡ Dev mode — tap to auto-fill OTP:
                    </p>
                    <p class="font-mono text-2xl font-semibold tracking-widest" style="color:#a89df0;" x-text="devOtp"></p>
                </div>

                <label class="block text-sm mb-2" style="color:#888;">Enter 6-digit OTP</label>
                <input
                    type="tel"
                    x-model="otp"
                    @keydown.enter="verifyOtp()"
                    placeholder="______"
                    maxlength="6"
                    inputmode="numeric"
                    class="w-full rounded-xl px-4 py-4 text-white text-center text-2xl font-mono outline-none mb-5"
                    style="background:#2a2a2e; border: 0.5px solid #3a3a3e; letter-spacing: 0.6em;"
                />

                <button
                    @click="verifyOtp()"
                    :disabled="loading"
                    class="w-full py-3 rounded-xl text-white text-sm font-medium transition-all duration-200 mb-4"
                    :style="loading ? 'background:#3b3b3e; cursor:not-allowed;' : 'background:#5b4fcf;'">
                    <template x-if="!loading">
                        <span>Verify & Login</span>
                    </template>
                    <template x-if="loading">
                        <span class="flex items-center justify-center gap-2">
                            <svg class="animate-spin w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 12a9 9 0 11-6.219-8.56"/>
                            </svg>
                            Verifying...
                        </span>
                    </template>
                </button>

                {{-- Resend countdown --}}
                <div class="text-center text-sm" style="color:#666;">
                    <span x-show="countdown > 0">
                        Resend in <span style="color:#a89df0;" x-text="countdown"></span>s
                    </span>
                    <button
                        x-show="countdown === 0"
                        @click="sendOtp()"
                        class="transition-colors duration-200"
                        style="color:#7c6fe0;">
                        Resend OTP
                    </button>
                </div>

            </div>

            {{-- Divider --}}
            <div class="flex items-center gap-3 my-6">
                <div class="flex-1 h-px" style="background:#2e2e32;"></div>
                <span class="text-xs" style="color:#444;">or</span>
                <div class="flex-1 h-px" style="background:#2e2e32;"></div>
            </div>

            {{-- Footer links --}}
            <div class="flex items-center justify-between">
                <a href="{{ url('/login') }}" class="text-xs transition-colors duration-200" style="color:#555;">
                    Login with email
                </a>
                <a href="{{ url('/register') }}" class="text-xs transition-colors duration-200" style="color:#555;">
                    Create account
                </a>
            </div>

        </div>
    </div>

</body>
</html>
