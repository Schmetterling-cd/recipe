<template>
    <div class="login-container">
        <div class="common-card">
            <div class="common-icon">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15 7L13 5M13 5L11 7M13 5V11M9 17H7M7 17L5 15M7 17L9 19M12 12H12.01M17 7H19M19 7L21 9M19 7L17 5"
                          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
                          stroke="currentColor" stroke-width="2"/>
                </svg>
            </div>

            <h1 class="common-title">Reset password</h1>

            <p class="common-message">
                Enter a new password for your account.
            </p>

            <form @submit.prevent="handleSubmit" class="common-form">
                <div class="common-form-group">
                    <label for="password" class="common-label">New Password</label>
                    <div class="password-input-container">
                        <input
                            id="password"
                            v-model="form.password"
                            :type="showPassword ? 'text' : 'password'"
                            placeholder="Enter a new password"
                            :disabled="loading"
                            class="common-input"
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

                <div class="common-form-group">
                    <label for="password_confirmation" class="common-label">Confirm password</label>
                    <div class="password-input-container">
                        <input
                            id="password_confirmation"
                            v-model="form.password_confirmation"
                            :type="showConfirmPassword ? 'text' : 'password'"
                            placeholder="Repeat the new password"
                            :disabled="loading"
                            class="common-input"
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
                    class="common-button-primary"
                >
                    <span v-if="loading" class="common-button-loading">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Update...
                    </span>
                    <span v-else>Update password</span>
                </button>
            </form>

            <div class="common-back-link">
                <span>Remembered your password?</span>
                <button @click="handleBackToLogin" class="common-back-link-button">Log in to your account</button>
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
.password-input-container {
    position: relative;
    display: flex;
    align-items: center;
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

@media (max-width: 480px) {
    .password-strength {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }
    .strength-text {
        text-align: left;
    }
}
</style>
