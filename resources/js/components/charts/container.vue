<template>
    <transition name="fade" mode="out-in">
        <router-view></router-view>
    </transition>
</template>

<script>
export default {
    mounted() {
        if (this.$route.name == "charts") {
            this.$router.push({ name: "chartList" });
        }
    }
};
</script>

<style scoped>
.fade-enter,
.fade-leave-to {
    opacity: 0;
    /* transform: translateX(200vw); */
}
.fade-enter-active,
.fade-leave-active {
    transition: all 0.4s ease;
}
</style>
