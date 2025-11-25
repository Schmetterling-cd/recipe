<template>
    <div class="app-container">
        <Navigation />
        <main class="main-content">
            <router-view></router-view>
        </main>
    </div>
</template>

<script>
import Navigation from "./Navigation.vue";
import RecipeList from "./RecipeList.vue";
import Login from "./Login.vue";
import Registration from "./Registration.vue";
export default {
    name: "App",
    components: {Registration, Login, RecipeList, Navigation},
    mounted() {
        window.addEventListener('show-toast', this.handleShowToast)
    },
    beforeUnmount() {
        window.removeEventListener('show-toast', this.handleShowToast)
    },
    methods: {
        handleShowToast(event) {
            if (this.$refs.toastComponent) {
                this.$refs.toastComponent.addToast(event.detail)
            }
        }
    }
}
</script>

<style scoped>
.app-container {
    min-height: 100vh;
    display: flex;
    flex-direction: column;

    padding: 0 0 0 0;
    margin: 0 0 0 0;
}

.main-content {
    flex: 1;
    margin-top: 60px;
    background: #f7fafc;
    min-height: calc(100vh - 60px);

    display: flex;
    flex-direction: column;
    justify-content: start;
    align-items: center;

    padding: 0 0 0 0;
}
</style>
