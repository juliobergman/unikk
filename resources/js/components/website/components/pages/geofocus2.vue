<template>
    <v-container fluid fill-height class="main-container pa-0">
        <earth />
        <div
            class="
        content
        text-subtitle-2 text-md-h4
        white--text
        mt-auto
        mb-16
        mx-auto
        mb-md-16
        mx-0
        pa-5 pa-md-16
      "
        >
            {{ $t("geofocus-2") }}
        </div>
    </v-container>
</template>

<script>
import earth from "./earth.vue";
export default {
    components: { earth }
};
</script>

<style scoped>
.main-container {
    background-color: #000;
}
.main-container .content {
    position: fixed;
    bottom: 20px;
    background: rgba(0, 0, 0, 0.6);
}
@media (min-width: 960px) {
    .main-container .content {
        bottom: 64px;
    }
}
</style>
