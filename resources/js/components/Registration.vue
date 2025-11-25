<template>
    <div class="login-container">
        <div class="signup-card">
            <!-- Заголовок -->
            <div class="signup-header">
                <h1 class="signup-title">Registration</h1>
                <p class="signup-subtitle">Create a new account</p>
            </div>

            <!-- Форма -->
            <form @submit.prevent="handleSignup" class="signup-form">
                <!-- Имя -->
                <div class="form-group">
                    <label for="name" class="form-label">Name</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="#718096">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                        <input
                            id="name"
                            v-model="form.name"
                            type="text"
                            class="form-input"
                            placeholder="your name"
                            required
                        >
                    </div>
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="#718096">
                            <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                        </svg>
                        <input
                            id="email"
                            v-model="form.email"
                            type="email"
                            class="form-input"
                            placeholder="your@email.com"
                            required
                        >
                    </div>
                </div>

                <!-- Пароль -->
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="#718096">
                            <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM12 17c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zM15.1 8H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
                        </svg>
                        <input
                            id="password"
                            v-model="form.password"
                            :type="showPassword ? 'text' : 'password'"
                            class="form-input"
                            placeholder="Create a password"
                            required
                            minlength="6"
                        >
                        <button
                            type="button"
                            class="password-toggle"
                            @click="showPassword = !showPassword"
                        >
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="#718096">
                                <path v-if="showPassword" d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2zm4.31-.78l3.15 3.15.02-.16c0-1.66-1.34-3-3-3l-.17.01z"/>
                                <path v-else d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                            </svg>
                        </button>
                    </div>
                    <div v-if="form.password" class="password-strength">
                        <div class="strength-bar" :class="passwordStrength"></div>
                        <span class="strength-text">{{ strengthText }}</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="confirmPassword" class="form-label">Repeat password</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="#718096">
                            <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM12 17c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zM15.1 8H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
                        </svg>
                        <input
                            id="confirmPassword"
                            v-model="form.password_confirmation"
                            :type="showConfirmPassword ? 'text' : 'password'"
                            class="form-input"
                            :class="{ 'error': form.password_confirmation
                            && !passwordsMatch }"
                            placeholder="Repeat password"
                            required
                        >
                        <button
                            type="button"
                            class="password-toggle"
                            @click="showConfirmPassword = !showConfirmPassword"
                        >
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="#718096">
                                <path v-if="showConfirmPassword" d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2zm4.31-.78l3.15 3.15.02-.16c0-1.66-1.34-3-3-3l-.17.01z"/>
                                <path v-else d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                            </svg>
                        </button>
                    </div>
                    <div v-if="form.password_confirmation
                    && !passwordsMatch" class="error-message">
                        The passwords don't match
                    </div>
                </div>

                <!-- Кнопка регистрации -->
                <button
                    type="submit"
                    class="signup-btn"
                    :disabled="isLoading || !isFormValid"
                >
                    <span v-if="isLoading" class="loading-spinner"></span>
                    {{ loading ? 'Registration...' : 'Register' }}
                </button>
            </form>

            <!-- Ссылка на вход -->
            <div class="signup-footer">
                <p>Already have an account?
                    <a href="#" class="login-link" @click.prevent="handleLogin">
                        Login
                    </a>
                </p>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions } from 'vuex';

export default {
    name: 'Registration',
    data() {
        return {
            loading: false,
            showPassword: false,
            showConfirmPassword: false,
            form: {
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
            }
        }
    },
    computed: {
        passwordsMatch() {
            return this.form.password === this.form.password_confirmation
        },

        isFormValid() {
            return (
                this.form.name &&
                this.form.email &&
                this.form.password &&
                this.passwordsMatch
            )
        },

        passwordStrength() {
            if (!this.form.password) return 'weak'

            return this.calculatePasswordStrength(this.form.password)
        },

        strengthText() {
            const texts = {
                weak: 'Слабый',
                medium: 'Средний',
                strong: 'Сильный'
            }
            return texts[this.passwordStrength]
        },

        isLoading() {
            return this.loading;
        }
    },
    methods: {
        ...mapActions('user', {
            userRegistration: 'registration',
        }),

        calculatePasswordStrength(password) {
            let score = 0

            if (password.length >= 8) score++
            if (/[A-Z]/.test(password)) score++
            if (/[0-9]/.test(password)) score++
            if (/[^A-Za-z0-9]/.test(password)) score++

            if (score <= 1) return 'weak'
            if (score <= 3) return 'medium'
            return 'strong'
        },

        async handleSignup() {
            if (!this.isFormValid) return

            this.loading = true;
            this.userRegistration(this.form);
            this.loading = false;
        },

        handleLogin() {
            this.$router.push({
                name: 'Login'
            });
        },
    }
}
</script>

<style scoped>
.signup-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    padding: 3rem;
    width: 100%;
    max-width: 440px;
    border: 1px solid #e2e8f0;
}

.signup-header {
    text-align: center;
    margin-bottom: 2rem;
}

.signup-title {
    font-size: 2rem;
    font-weight: 700;
    color: #2d3748;
    margin: 0 0 0.5rem 0;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.signup-subtitle {
    color: #718096;
    margin: 0;
    font-size: 1rem;
}

.signup-form {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-label {
    font-weight: 500;
    color: #4a5568;
    font-size: 0.875rem;
}

.input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.input-icon {
    position: absolute;
    left: 1rem;
    z-index: 1;
}

.form-input {
    width: 100%;
    padding: 0.75rem 1rem 0.75rem 3rem;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.2s ease;
    background: white;
    color: #2d3748;
}

.form-input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.form-input.error {
    border-color: #e53e3e;
}

.form-input::placeholder {
    color: #a0aec0;
}

.password-toggle {
    position: absolute;
    right: 1rem;
    background: none;
    border: none;
    cursor: pointer;
    padding: 0.25rem;
    border-radius: 4px;
    transition: background-color 0.2s ease;
}

.password-toggle:hover {
    background: #f7fafc;
}

.password-strength {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-top: 0.5rem;
}

.strength-bar {
    flex: 1;
    height: 4px;
    border-radius: 2px;
    background: #e2e8f0;
    overflow: hidden;
}

.strength-bar::after {
    content: '';
    display: block;
    height: 100%;
    border-radius: 2px;
    transition: all 0.3s ease;
}

.strength-bar.weak::after {
    width: 33%;
    background: #e53e3e;
}

.strength-bar.medium::after {
    width: 66%;
    background: #d69e2e;
}

.strength-bar.strong::after {
    width: 100%;
    background: #38a169;
}

.strength-text {
    font-size: 0.75rem;
    color: #718096;
    min-width: 50px;
}

.error-message {
    color: #e53e3e;
    font-size: 0.75rem;
    margin-top: 0.25rem;
}

.signup-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 1rem;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    height: 3rem;
}

.signup-btn:hover:not(:disabled) {
    transform: translateY(-1px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
}

.signup-btn:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none;
}

.loading-spinner {
    width: 1.25rem;
    height: 1.25rem;
    border: 2px solid transparent;
    border-top: 2px solid white;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.divider {
    display: flex;
    align-items: center;
    text-align: center;
    color: #a0aec0;
    font-size: 0.875rem;
}

.divider::before,
.divider::after {
    content: '';
    flex: 1;
    border-bottom: 1px solid #e2e8f0;
}

.divider span {
    padding: 0 1rem;
}

.social-signup {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.social-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    padding: 0.75rem;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    background: white;
    color: #4a5568;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
}

.social-btn:hover {
    background: #f7fafc;
    border-color: #cbd5e0;
}

.google-btn {
    border-color: #e2e8f0;
}

.signup-footer {
    text-align: center;
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid #e2e8f0;
    color: #718096;
    font-size: 0.875rem;
}

.login-link {
    color: #667eea;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.2s ease;
}

.login-link:hover {
    color: #5a6fd8;
}

/* Адаптивность */
@media (max-width: 480px) {
    .signup-container {
        padding: 1rem;
    }

    .signup-card {
        padding: 2rem 1.5rem;
    }

    .signup-title {
        font-size: 1.75rem;
    }
}
</style>
