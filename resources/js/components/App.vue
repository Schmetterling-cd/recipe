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
import {mapActions} from "vuex";

export default {
    name: "App",
    components: {Navigation},
    methods: {
        ...mapActions('user', {
            user: 'getUser',
        }),
    },

    beforeMount() {
        this.user();
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
