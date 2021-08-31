<template>
    <v-main id="container">
        <v-img
            height="100vh"
            src="storage/web/welcome.jpg"
            class="black p-0"
            style="background-position: fixed"
        >
            <v-container
                fluid
                fill-height
                class="justify-center align-content-center align-center"
            >
                <v-card
                    color="transparent"
                    flat
                    max-width="375px"
                    min-width="250px"
                    width="75vw"
                >
                    <icon-logo :fill="iconColor"></icon-logo>

                    <v-card-text
                        class="welcome-card-text title white--text text-center mt-3 pa-0"
                        style="opacity: 0.8"
                    >
                        {{ $t("slogan") }}
                    </v-card-text>
                </v-card>
            </v-container>
        </v-img>
    </v-main>
</template>

<script>
import IconLogo from "../ui/icons/logo.vue";
export default {
    components: {
        IconLogo
    },
    data: () => ({
        iconColor: "white"
    }),
    methods: {},
    created() {}
};
</script>

<style scoped>
.bc-gradient {
    background: linear-gradient(
        -45deg,
        rgba(0, 0, 0, 0.2) 0%,
        rgba(0, 0, 0, 0.7) 100%
    );
}

/* v-image__image v-image__image--cover */
/* to top left, rgba(37, 45, 65,0.5), rgba(63, 71, 89,0.5) */
</style>
