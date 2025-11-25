<template>
    <nav class="navbar">
        <div class="nav-container">
            <!-- Логотип -->
            <div class="nav-brand">
                <router-link to="/" class="logo">
                    <span class="logo-text">{{ appName }}</span>
                </router-link>
            </div>

            <!-- Дополнительные действия -->
            <div v-if="!isAuthenticated" class="nav-actions">
                <button class="login-btn" @click="handleLogin">
                    Login
                </button>
            </div>


            <div v-else class="nav-actions">
                <button class="login-btn" @click="handleLogOut">
                    Exit
                </button>
            </div>
        </div>
    </nav>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';

export default {
    name: 'Navigation',
    data() {
        return {
            appName: window.Laravel.name,
        };
    },
    computed: {
        ...mapGetters('user', ['isAuthenticated'])
    },
    methods: {
        ...mapActions('user', ['logout']),

        handleLogin() {
            this.$router.push({
                name: 'Login'
            });
        },

        handleLogOut() {
            this.logout();
        }
    }
}
</script>

<style scoped>
.navbar {
    background: #ffffff;
    border-bottom: 1px solid #e2e8f0;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 1000;
}

.nav-container {
    max-width: 100%;
    margin: 0 auto;
    padding: 0 2rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 60px;
}

/* Логотип */
.logo {
    text-decoration: none;
    font-size: 1.5rem;
    font-weight: bold;
    color: #2d3748;
}

.logo-text {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Кнопка входа */
.login-btn {
    background: #667eea;
    color: white;
    border: none;
    padding: 0.5rem 1.5rem;
    border-radius: 6px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
}

.login-btn:hover {
    background: #5a6fd8;
    transform: translateY(-1px);
}
</style>
