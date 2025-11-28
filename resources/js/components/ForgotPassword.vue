<template>
    <div class="login-container">
        <div class="common-card">
            <div class="common-icon">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 15V17M6 21H18C19.1046 21 20 20.1046 20 19V13C20 11.8954 19.1046 11 18 11H6C4.89543 11 4 11.8954 4 13V19C4 20.1046 4.89543 21 6 21ZM16 11V7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7V11H16Z"
                          stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>

            <h1 class="common-title">
                {{ isEmailSent ? 'The letter has been sent' : 'Password recovery' }}
            </h1>

            <div v-if="!isEmailSent" class="forgot-password-content">
                <p class="common-message">
                    Enter the email address you provided during registration. We will send you a link to reset your password.
                </p>

                <form @submit.prevent="handleSubmit" class="common-form">
                    <div class="common-form-group">
                        <label for="email" class="common-label">Email address</label>
                        <input
                            id="email"
                            v-model="form.email"
                            type="email"
                            placeholder="your@email.com"
                            :disabled="loading"
                            class="common-input"
                            required
                        >
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
                            Sending...
                        </span>
                        <span v-else>Send link</span>
                    </button>
                </form>

                <div class="common-back-link">
                    <span>Remembered your password?</span>
                    <button @click="handleBackToLogin" class="common-back-link-button">Log in</button>
                </div>
            </div>

            <div v-else class="email-sent-content">
                <div class="common-icon-success">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z"
                              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>

                <p class="common-message">
                    We have sent an email with a link to reset your password to the address
                    <strong class="common-email-address">{{ form.email }}</strong>.
                    Please check your email and follow the link in the email.
                </p>

                <div class="common-help-section">
                    <h3 class="common-help-title">Didn't receive the letter?</h3>
                    <ul class="common-help-list">
                        <li>Check your spam folder</li>
                        <li>Make sure your email is correct.</li>
                        <li>Please wait a few minutes</li>
                        <li>
                            <button @click="handleSubmit" :disabled="loading" class="common-back-link-button">
                                Resend the letter
                            </button>
                        </li>
                    </ul>
                </div>

                <button @click="handleBackToHome" class="common-button-secondary">
                    Return to home page
                </button>
            </div>

            <div v-if="errorMessage" class="common-error-message">
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
.forgot-password-content,
.email-sent-content {
    text-align: center;
}

.common-button-primary {
    width: 100%!important;
}
</style>
