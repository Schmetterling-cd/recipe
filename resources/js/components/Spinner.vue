<template>
    <div class="loading-state">
        <div class="spinner"></div>
    </div>
</template>

<script>
export default {
    name: "Loader"
}
</script>

<style scoped>
.loading-state {
    text-align: center;
    padding: 4rem 2rem;
    color: #718096;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.spinner {
    border: 3px solid #f3f3f3;
    border-top: 3px solid #667eea;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 1s linear infinite;
    margin-bottom: 1rem;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.loading-state p {
    margin: 0;
    font-size: 1.125rem;
}
</style>
