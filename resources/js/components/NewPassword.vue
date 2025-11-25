<template>
    <div class="login-container">
        <div class="reset-password-card">
            <!-- Иконка -->
            <div class="reset-password-icon">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15 7L13 5M13 5L11 7M13 5V11M9 17H7M7 17L5 15M7 17L9 19M12 12H12.01M17 7H19M19 7L21 9M19 7L17 5"
                          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
                          stroke="currentColor" stroke-width="2"/>
                </svg>
            </div>

            <!-- Заголовок -->
            <h1 class="reset-password-title">Reset password</h1>

            <!-- Сообщение -->
            <p class="reset-password-message">
                Enter a new password for your account.
            </p>

            <!-- Форма -->
            <form @submit.prevent="handleSubmit" class="reset-password-form">
                <!-- Поле нового пароля -->
                <div class="form-group">
                    <label for="password" class="form-label">New Password</label>
                    <div class="password-input-container">
                        <input
                            id="password"
                            v-model="form.password"
                            :type="showPassword ? 'text' : 'password'"
                            placeholder="Enter a new password"
                            :disabled="loading"
                            class="form-input"
                            required
                        >
                        <button
                            type="button"
                            class="password-toggle"
                            @click="showPassword = !showPassword"
                        >
                            <svg v-if="showPassword" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2 2L22 22M9.88 9.88C9.234 10.525 8.8 11.414 8.8 12.4C8.8 14.16 10.24 15.6 12 15.6C12.986 15.6 13.875 15.166 14.52 14.52M6.72 6.72C4.552 8.224 3.2 10.744 3.2 12.4C3.2 16.48 7.52 20.8 12 20.8C13.656 20.8 16.176 19.448 17.68 17.28M10.648 5.352C11.216 5.248 11.8 5.2 12.4 5.2C16.88 5.2 21.2 9.52 21.2 14C21.2 14.6 21.152 15.184 21.048 15.752"
                                      stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <svg v-else width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 12C1 12 5 4 12 4C19 4 23 12 23 12C23 12 19 20 12 20C5 20 1 12 1 12Z"
                                      stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z"
                                      stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Индикатор сложности пароля -->
                    <div v-if="form.password" class="password-strength">
                        <div class="strength-bar">
                            <div
                                class="strength-fill"
                                :class="passwordStrength"
                                :style="{ width: strengthPercentage + '%' }"
                            ></div>
                        </div>
                        <span class="strength-text">{{ strengthText }}</span>
                    </div>
                </div>

                <!-- Поле подтверждения пароля -->
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm password</label>
                    <div class="password-input-container">
                        <input
                            id="password_confirmation"
                            v-model="form.password_confirmation"
                            :type="showConfirmPassword ? 'text' : 'password'"
                            placeholder="Repeat the new password"
                            :disabled="loading"
                            class="form-input"
                            :class="{ 'error': form.password_confirmation && !passwordsMatch }"
                            required
                        >
                        <button
                            type="button"
                            class="password-toggle"
                            @click="showConfirmPassword = !showConfirmPassword"
                        >
                            <svg v-if="showConfirmPassword" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2 2L22 22M9.88 9.88C9.234 10.525 8.8 11.414 8.8 12.4C8.8 14.16 10.24 15.6 12 15.6C12.986 15.6 13.875 15.166 14.52 14.52M6.72 6.72C4.552 8.224 3.2 10.744 3.2 12.4C3.2 16.48 7.52 20.8 12 20.8C13.656 20.8 16.176 19.448 17.68 17.28M10.648 5.352C11.216 5.248 11.8 5.2 12.4 5.2C16.88 5.2 21.2 9.52 21.2 14C21.2 14.6 21.152 15.184 21.048 15.752"
                                      stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <svg v-else width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 12C1 12 5 4 12 4C19 4 23 12 23 12C23 12 19 20 12 20C5 20 1 12 1 12Z"
                                      stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z"
                                      stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>

                    <div v-if="form.password_confirmation && !passwordsMatch" class="error-message-small">
                        The passwords don't match
                    </div>
                </div>

                <button
                    type="submit"
                    :disabled="loading || !isFormValid"
                    class="submit-button"
                >
                    <span v-if="loading" class="button-loading">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Update...
                    </span>
                    <span v-else>Update password</span>
                </button>
            </form>

            <!-- Ссылка на вход -->
            <div class="back-to-login">
                <span>Remembered your password?</span>
                <button @click="handleBackToLogin" class="back-link">Log in to your account</button>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions } from 'vuex'

export default {
    name: 'ResetPassword',

    data() {
        return {
            loading: false,
            showPassword: false,
            showConfirmPassword: false,

            form: {
                password: '',
                password_confirmation: '',
                token: '',
                email: ''
            }
        }
    },

    computed: {
        passwordsMatch() {
            return this.form.password === this.form.password_confirmation
        },

        isFormValid() {
            return (
                this.form.password &&
                this.form.password_confirmation &&
                this.passwordsMatch &&
                this.passwordStrength !== 'weak'
            )
        },

        passwordStrength() {
            if (!this.form.password) return 'weak'
            return this.calculatePasswordStrength(this.form.password)
        },

        strengthText() {
            const texts = {
                weak: 'Weak',
                medium: 'Average',
                strong: 'Strong'
            }
            return texts[this.passwordStrength]
        },

        strengthPercentage() {
            const percentages = {
                weak: 33,
                medium: 66,
                strong: 100
            }
            return percentages[this.passwordStrength]
        }
    },

    methods: {
        ...mapActions('user', {
            resetPassword: 'resetPassword'
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

        async handleSubmit() {
            if (!this.isFormValid) return;

            this.resetPassword(this.form);
        },

        handleBackToLogin() {
            this.$router.push({ name: 'Login' })
        }
    },

    mounted() {
        this.form.email = this.$route.query.email;
        this.form.token = this.$route.params.token;
    }
}
</script>

<style scoped>
.reset-password-card {
    background: white;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    max-width: 480px;
    width: 100%;
    text-align: center;
    animation: fadeInUp 0.6s ease;
}

.reset-password-icon {
    color: #667eea;
    margin-bottom: 24px;
}

.reset-password-title {
    font-size: 28px;
    font-weight: 700;
    color: #1a202c;
    margin-bottom: 16px;
    line-height: 1.2;
}

.reset-password-message {
    color: #4a5568;
    font-size: 16px;
    line-height: 1.6;
    margin-bottom: 32px;
}

.reset-password-form {
    text-align: left;
}

.form-group {
    margin-bottom: 24px;
}

.form-label {
    display: block;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 8px;
    font-size: 14px;
}

.password-input-container {
    position: relative;
    display: flex;
    align-items: center;
}

.form-input {
    width: 100%;
    padding: 12px 16px;
    padding-right: 50px;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 16px;
    transition: all 0.3s ease;
    box-sizing: border-box;
}

.form-input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.form-input:disabled {
    background-color: #f7fafc;
    cursor: not-allowed;
}

.form-input.error {
    border-color: #f56565;
}

.password-toggle {
    position: absolute;
    right: 12px;
    background: none;
    border: none;
    color: #a0aec0;
    cursor: pointer;
    padding: 4px;
    border-radius: 4px;
    transition: color 0.3s ease;
}

.password-toggle:hover {
    color: #667eea;
}

/* Индикатор сложности пароля */
.password-strength {
    margin-top: 8px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.strength-bar {
    flex: 1;
    height: 6px;
    background: #e2e8f0;
    border-radius: 3px;
    overflow: hidden;
}

.strength-fill {
    height: 100%;
    border-radius: 3px;
    transition: all 0.3s ease;
}

.strength-fill.weak {
    background: #f56565;
}

.strength-fill.medium {
    background: #ed8936;
}

.strength-fill.strong {
    background: #48bb78;
}

.strength-text {
    font-size: 12px;
    color: #718096;
    font-weight: 600;
    min-width: 60px;
    text-align: right;
}

.error-message-small {
    color: #f56565;
    font-size: 12px;
    margin-top: 4px;
}

.submit-button {
    width: 100%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 14px 24px;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 24px;
}

.submit-button:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
}

.submit-button:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none;
}

.back-to-login {
    text-align: center;
    color: #4a5568;
    font-size: 14px;
}

.back-link {
    background: none;
    border: none;
    color: #667eea;
    cursor: pointer;
    text-decoration: underline;
    margin-left: 4px;
    font-size: 14px;
}

.back-link:hover {
    color: #5a67d8;
}

.error-message {
    background: #fed7d7;
    color: #c53030;
    padding: 12px 16px;
    border-radius: 8px;
    font-size: 14px;
    margin-top: 16px;
    text-align: center;
}

.success-message {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    background: #c6f6d5;
    color: #22543d;
    padding: 12px 16px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    margin-top: 16px;
    animation: slideIn 0.3s ease;
}

.success-message svg {
    color: #38a169;
}

.button-loading {
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Адаптивность */
@media (max-width: 480px) {
    .reset-password-card {
        padding: 24px;
        margin: 0 10px;
    }

    .reset-password-title {
        font-size: 24px;
    }

    .password-strength {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }

    .strength-text {
        text-align: left;
    }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
