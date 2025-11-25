<template>
    <div class="login-container">
        <div class="login-card">
            <!-- Заголовок -->
            <div class="login-header">
                <h1 class="login-title">Login</h1>
                <p class="login-subtitle">Enter your credentials</p>
            </div>

            <!-- Форма -->
            <form @submit.prevent="handleLogin" class="login-form">
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
                    <div class="password-label-wrapper">
                        <label for="password" class="form-label">Password</label>
                        <a href="#" class="forgot-link" @click.prevent="handleForgotPassword">
                            Forgot your password?
                        </a>
                    </div>
                    <div class="input-wrapper">
                        <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="#718096">
                            <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM12 17c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zM15.1 8H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
                        </svg>
                        <input
                            id="password"
                            v-model="form.password"
                            :type="showPassword ? 'text' : 'password'"
                            class="form-input"
                            placeholder="Enter your password"
                            required
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
                </div>

                <!-- Кнопка входа -->
                <button
                    type="submit"
                    class="login-btn"
                    :disabled="isLoading"
                >
                    <span v-if="isLoading" class="loading-spinner"></span>
                    {{ isLoading ? 'Entrance...' : 'Login' }}
                </button>
            </form>

            <!-- Ссылка на регистрацию -->
            <div class="login-footer">
                <p>Don't have an account yet?
                    <a href="#" class="signup-link" @click.prevent="handleSignup">
                        Register
                    </a>
                </p>
            </div>
        </div>
    </div>
</template>

<script>
import {mapActions} from "vuex";

export default {
    name: 'LoginForm',
    data() {
        return {
            loading: false,
            showPassword: false,
            form: {
                email: '',
                password: ''
            }
        }
    },
    computed: {
        isLoading() {
            return this.loading;
        }
    },
    methods: {
        ...mapActions('user', {
            userLogin: 'login',
        }),

        handleLogin() {
            this.loading = true;
            this.userLogin(this.form);
            this.loading = false;
        },

        handleForgotPassword() {
            this.$router.push({
                name: 'ForgotPassword'
            });
        },

        handleSignup() {
            this.$router.push({
                name: 'Registration'
            });
        },

    }
}
</script>

<style scoped>
.login-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    padding: 3rem;
    width: 100%;
    max-width: 440px;
    border: 1px solid #e2e8f0;
}

.login-header {
    text-align: center;
    margin-bottom: 2rem;
}

.login-title {
    font-size: 2rem;
    font-weight: 700;
    color: #2d3748;
    margin: 0 0 0.5rem 0;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.login-subtitle {
    color: #718096;
    margin: 0;
    font-size: 1rem;
}

.login-form {
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

.password-label-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.forgot-link {
    color: #667eea;
    text-decoration: none;
    font-size: 0.875rem;
    transition: color 0.2s ease;
}

.forgot-link:hover {
    color: #5a6fd8;
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

.checkbox-input:checked + .checkbox-custom {
    background: #667eea;
    border-color: #667eea;
}

.checkbox-input:checked + .checkbox-custom::after {
    content: '✓';
    color: white;
    font-size: 0.75rem;
    font-weight: bold;
}

.login-btn {
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

.login-btn:hover:not(:disabled) {
    transform: translateY(-1px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
}

.login-btn:disabled {
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

.divider span {
    padding: 0 1rem;
}

.login-footer {
    text-align: center;
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid #e2e8f0;
    color: #718096;
    font-size: 0.875rem;
}

.signup-link {
    color: #667eea;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.2s ease;
}

.signup-link:hover {
    color: #5a6fd8;
}

/* Адаптивность */
@media (max-width: 480px) {
    .login-container {
        padding: 1rem;
    }

    .login-card {
        padding: 2rem 1.5rem;
    }

    .login-title {
        font-size: 1.75rem;
    }
}
</style>
