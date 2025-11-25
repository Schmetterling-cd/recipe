<template>
    <div class="toast-container">
        <transition-group name="toast" tag="div" class="toast-list">
            <div
                v-for="toast in toasts"
                :key="toast.id"
                :class="['toast', `toast--${toast.type}`]"
                @click="removeToast(toast.id)"
            >
                <div class="toast-icon">
                    <svg v-if="toast.type === 'success'" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                    </svg>
                    <svg v-else-if="toast.type === 'error'" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                    </svg>
                    <svg v-else-if="toast.type === 'warning'" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/>
                    </svg>
                    <svg v-else width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                    </svg>
                </div>
                <div class="toast-content">
                    <div class="toast-title">{{ toast.title }}</div>
                    <div v-if="toast.message" class="toast-message">{{ toast.message }}</div>
                </div>
                <button class="toast-close" @click.stop="removeToast(toast.id)">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                    </svg>
                </button>
            </div>
        </transition-group>
    </div>
</template>

<script>
export default {
    name: 'Toast',
    data() {
        return {
            toasts: []
        }
    },
    methods: {
        addToast(toast) {
            const id = Date.now() + Math.random()
            const newToast = {
                id,
                type: toast.type || 'info',
                title: toast.title,
                message: toast.message,
                duration: toast.duration || 5000
            }

            this.toasts.push(newToast)

            // Автоматическое удаление
            if (newToast.duration > 0) {
                setTimeout(() => {
                    this.removeToast(id)
                }, newToast.duration)
            }
        },

        removeToast(id) {
            this.toasts = this.toasts.filter(toast => toast.id !== id)
        },

        clearAll() {
            this.toasts = []
        }
    }
}
</script>

<style scoped>
.toast-container {
    position: fixed;
    top: 80px;
    right: 20px;
    z-index: 9999;
    pointer-events: none;
}

.toast-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    pointer-events: auto;
}

.toast {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    background: white;
    border-radius: 8px;
    padding: 1rem;
    min-width: 300px;
    max-width: 400px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    border-left: 4px solid #e2e8f0;
    cursor: pointer;
    transition: all 0.3s ease;
    animation: slideIn 0.3s ease;
}

.toast:hover {
    transform: translateX(-4px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
}

.toast--success {
    border-left-color: #38a169;
}

.toast--error {
    border-left-color: #e53e3e;
}

.toast--warning {
    border-left-color: #d69e2e;
}

.toast--info {
    border-left-color: #3182ce;
}

.toast-icon {
    flex-shrink: 0;
    margin-top: 2px;
}

.toast--success .toast-icon {
    color: #38a169;
}

.toast--error .toast-icon {
    color: #e53e3e;
}

.toast--warning .toast-icon {
    color: #d69e2e;
}

.toast--info .toast-icon {
    color: #3182ce;
}

.toast-content {
    flex: 1;
    min-width: 0;
}

.toast-title {
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 0.25rem;
    font-size: 0.875rem;
}

.toast-message {
    color: #718096;
    font-size: 0.75rem;
    line-height: 1.4;
    word-wrap: break-word;
}

.toast-close {
    flex-shrink: 0;
    background: none;
    border: none;
    padding: 0.25rem;
    border-radius: 4px;
    cursor: pointer;
    color: #a0aec0;
    transition: all 0.2s ease;
    margin-top: -2px;
}

.toast-close:hover {
    background: #f7fafc;
    color: #718096;
}

/* Анимации */
.toast-enter-active,
.toast-leave-active {
    transition: all 0.3s ease;
}

.toast-enter-from {
    opacity: 0;
    transform: translateX(100%);
}

.toast-leave-to {
    opacity: 0;
    transform: translateX(100%);
}

.toast-move {
    transition: transform 0.3s ease;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(100%);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Адаптивность */
@media (max-width: 768px) {
    .toast-container {
        top: 70px;
        right: 10px;
        left: 10px;
    }

    .toast {
        min-width: auto;
        max-width: none;
    }
}
</style>
