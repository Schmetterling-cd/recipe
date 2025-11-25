<template>
    <div class="login-container">
        <div class="verification-card">
            <div class="verification-icon">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22 6C22 4.9 21.1 4 20 4H4C2.9 4 2 4.9 2 6V18C2 19.1 2.9 20 4 20H20C21.1 20 22 19.1 22 18V6ZM20 6L12 11L4 6H20ZM20 18H4V8L12 13L20 8V18Z" fill="currentColor"/>
                </svg>
            </div>

            <h1 class="verification-title">Confirm your email</h1>

            <p class="verification-message">
                We have sent an email with a confirmation link to the email
                <strong class="email-address">{{ userEmail }}</strong>.
                Please check your email and follow the link in the email.
            </p>

            <div class="verification-actions">
                <button @click="handleCheckVerification" class="check-button">
                    I confirmed my emaill
                </button>
            </div>

            <div class="verification-help">
                <h3 class="help-title">Didn't receive the letter?</h3>
                <ul class="help-list">
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
.verification-card {
    background: white;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    max-width: 480px;
    width: 100%;
    text-align: center;
}

.verification-icon {
    color: #667eea;
    margin-bottom: 24px;
}

.verification-title {
    font-size: 28px;
    font-weight: 700;
    color: #1a202c;
    margin-bottom: 16px;
    line-height: 1.2;
}

.verification-message {
    color: #4a5568;
    font-size: 16px;
    line-height: 1.6;
    margin-bottom: 32px;
}

.email-address {
    color: #667eea;
    background-color: #f7fafc;
    padding: 2px 6px;
    border-radius: 4px;
    font-family: monospace;
}

.verification-actions {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-bottom: 32px;
}

.check-button {
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

.check-button:hover {
    background: #667eea;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
}

.verification-help {
    text-align: left;
    background: #f7fafc;
    padding: 20px;
    border-radius: 8px;
    border-left: 4px solid #667eea;
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

@media (max-width: 480px) {
    .verification-card {
        padding: 24px;
        margin: 0 10px;
    }

    .verification-title {
        font-size: 24px;
    }

    .verification-actions {
        flex-direction: column;
    }

    .verification-help {
        padding: 16px;
    }
}

.verification-card {
    animation: fadeInUp 0.6s ease;
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
