<template>
    <div class="login-container">
        <div class="common-card">
            <div class="common-icon">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22 6C22 4.9 21.1 4 20 4H4C2.9 4 2 4.9 2 6V18C2 19.1 2.9 20 4 20H20C21.1 20 22 19.1 22 18V6ZM20 6L12 11L4 6H20ZM20 18H4V8L12 13L20 8V18Z" fill="currentColor"/>
                </svg>
            </div>

            <h1 class="common-title">Confirm your email</h1>

            <p class="common-message">
                We have sent an email with a confirmation link to the email
                <strong class="common-email-address">{{ userEmail }}</strong>.
                Please check your email and follow the link in the email.
            </p>

            <div class="verification-actions">
                <button @click="handleCheckVerification" class="common-button-secondary">
                    I confirmed my email
                </button>
            </div>

            <div class="common-help-section">
                <h3 class="common-help-title">Didn't receive the letter?</h3>
                <ul class="common-help-list">
                    <li>Check your spam folder</li>
                    <li>Please make sure your email is correct: <strong>{{ email }}</strong></li>
                    <li>Please wait a few minutes - the email may take a while to arrive.</li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'EmailVerification',
    computed: {
        userEmail() {
            return this.$route.params.email;
        }
    },
    methods: {
        handleCheckVerification() {
            this.$router.push('/');
        }
    }
}
</script>

<style scoped>
.verification-actions {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-bottom: 32px;
}
</style>
