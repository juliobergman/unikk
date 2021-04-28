<template>
    <router-view :bus="bus"></router-view>
</template>

<script>
export default {
    props: ["bus"],
    mounted() {
        if (this.$route.name == "charts") {
            this.$router.push({ name: "chartList" });
        }
    }
};
</script>
