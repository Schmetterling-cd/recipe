<template>
    <div class="login-container">
        <div class="forgot-password-card">
            <!-- Иконка -->
            <div class="forgot-password-icon">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 15V17M6 21H18C19.1046 21 20 20.1046 20 19V13C20 11.8954 19.1046 11 18 11H6C4.89543 11 4 11.8954 4 13V19C4 20.1046 4.89543 21 6 21ZM16 11V7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7V11H16Z"
                          stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>

            <!-- Заголовок -->
            <h1 class="forgot-password-title">
                {{ isEmailSent ? 'The letter has been sent' : 'Password recovery' }}
            </h1>

            <!-- Состояние: Форма ввода email -->
            <div v-if="!isEmailSent" class="forgot-password-content">
                <p class="forgot-password-message">
                    Enter the email address you provided during registration. We will send you a link to reset your password.
                </p>

                <form @submit.prevent="handleSubmit" class="forgot-password-form">
                    <div class="form-group">
                        <label for="email" class="form-label">Email address</label>
                        <input
                            id="email"
                            v-model="form.email"
                            type="email"
                            placeholder="your@email.com"
                            :disabled="loading"
                            class="form-input"
                            required
                        >
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
                            Sending...
                        </span>
                        <span v-else>Send link</span>
                    </button>
                </form>

                <div class="back-to-login">
                    <span>Remembered your password?</span>
                    <button @click="handleBackToLogin" class="back-link">Войти в аккаунт</button>
                </div>
            </div>

            <!-- Состояние: Письмо отправлено -->
            <div v-else class="email-sent-content">
                <div class="success-icon">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z"
                              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>

                <p class="email-sent-message">
                    We have sent an email with a link to reset your password to the address
                    <strong class="email-address">{{ form.email }}</strong>.
                    Please check your email and follow the link in the email.
                </p>

                <div class="email-sent-help">
                    <h3 class="help-title">Didn't receive the letter?</h3>
                    <ul class="help-list">
                        <li>Check your spam folder</li>
                        <li>Make sure your email is correct.</li>
                        <li>Please wait a few minutes</li>
                        <li>
                            <button @click="handleSubmit" :disabled="loading" class="resend-link">
                                Resend the letter
                            </button>
                        </li>
                    </ul>
                </div>

                <button @click="handleBackToHome" class="home-button">
                    Return to home page
                </button>
            </div>

            <!-- Сообщение об ошибке -->
            <div v-if="errorMessage" class="error-message">
                {{ errorMessage }}
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions } from 'vuex'

export default {
    name: 'ForgotPassword',

    data() {
        return {
            loading: false,
            isEmailSent: false,
            errorMessage: '',
            form: {
                email: ''
            }
        }
    },

    computed: {
        isFormValid() {
            return this.form.email && this.validateEmail(this.form.email)
        }
    },

    methods: {
        ...mapActions('user', {
            sendResetLink: 'forgotPassword'
        }),

        validateEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        },

        handleSubmit() {
            if (!this.isFormValid) return;

            this.loading = true;
            this.sendResetLink(this.form).then(
                response => {
                    this.isEmailSent = true;
                    this.loading = false;
                }
            );
        },

        handleBackToLogin() {
            this.$router.push({ name: 'Login' });
        },

        handleBackToHome() {
            this.$router.push({ name: 'Home' });
        }
    }
}
</script>

<style scoped>
.forgot-password-card {
    background: white;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    max-width: 480px;
    width: 100%;
    text-align: center;
    animation: fadeInUp 0.6s ease;
}

.forgot-password-icon {
    color: #667eea;
    margin-bottom: 24px;
}

.forgot-password-title {
    font-size: 28px;
    font-weight: 700;
    color: #1a202c;
    margin-bottom: 16px;
    line-height: 1.2;
}

.forgot-password-message,
.email-sent-message {
    color: #4a5568;
    font-size: 16px;
    line-height: 1.6;
    margin-bottom: 32px;
}

.forgot-password-form {
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

.form-input {
    width: 100%;
    padding: 12px 16px;
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

/* Стили для состояния "Письмо отправлено" */
.email-sent-content {
    text-align: center;
}

.success-icon {
    color: #48bb78;
    margin-bottom: 20px;
}

.email-address {
    color: #667eea;
    background-color: #f7fafc;
    padding: 2px 6px;
    border-radius: 4px;
    font-family: monospace;
}

.email-sent-help {
    text-align: left;
    background: #f7fafc;
    padding: 20px;
    border-radius: 8px;
    border-left: 4px solid #667eea;
    margin-bottom: 24px;
}

.help-title {
    font-size: 16px;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 12px;
}

.help-list {
    color: #4a5568;
    font-size: 14px;
    line-height: 1.5;
    list-style-type: none;
    padding: 0;
    margin: 0;
}

.help-list li {
    margin-bottom: 8px;
    position: relative;
    padding-left: 16px;
}

.help-list li:before {
    content: "•";
    color: #667eea;
    font-weight: bold;
    position: absolute;
    left: 0;
}

.resend-link {
    background: none;
    border: none;
    color: #667eea;
    cursor: pointer;
    text-decoration: underline;
    font-size: 14px;
}

.resend-link:hover:not(:disabled) {
    color: #5a67d8;
}

.resend-link:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.home-button {
    width: 100%;
    background: transparent;
    color: #667eea;
    border: 2px solid #667eea;
    padding: 12px 24px;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.home-button:hover {
    background: #667eea;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
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

.button-loading {
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Адаптивность */
@media (max-width: 480px) {
    .forgot-password-card {
        padding: 24px;
        margin: 0 10px;
    }

    .forgot-password-title {
        font-size: 24px;
    }

    .email-sent-help {
        padding: 16px;
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
</style>
