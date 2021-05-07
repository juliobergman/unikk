<template>
    <header>
        <v-img
            src="storage/buildings-1.jpg"
            class="p-0"
            style="background-position: fixed;"
        >
            <template v-slot:default>
                <v-row
                    class="fill-height ma-0 bc-gradient"
                    align="center"
                    justify="space-around"
                >
                    <v-card
                        dark
                        color="transparent"
                        flat
                        class="order-1 order-md-0"
                    >
                        <icon-logo v-if="false" :fill="iconColor"></icon-logo>

                        <v-card-title>Unikk Ventures AG</v-card-title>

                        <v-card-text
                            class="welcome-card-text white--text mt-3"
                            style="opacity: 0.8;"
                        >
                            c/o TREUFIN Reuter AG, Zugerstrasse 76b, 6340 Baar,
                            Switzerland
                        </v-card-text>
                        <v-card-text style="font-weight: bold;">
                            info@unikk.com
                        </v-card-text>
                    </v-card>

                    <v-card
                        class="order-0 order-md-1"
                        color="transparent"
                        rounded="0"
                        elevation="0"
                        dark
                    >
                        <v-card-title>Contact Us</v-card-title>
                        <v-card-text>
                            <v-card color="transparent" dark flat class="pa-3">
                                <contact-form></contact-form>
                            </v-card>
                        </v-card-text>
                    </v-card>
                </v-row>
            </template>
        </v-img>
    </header>
</template>

<script>
import IconLogo from "../ui/icons/logo";
import contactForm from "./contactForm";
export default {
    components: {
        IconLogo,
        contactForm
    },
    data: () => ({
        iconColor: "white"
    })
};
</script>

<style scoped>
.bc-gradient {
    background: linear-gradient(
        to right,
        rgba(58, 72, 104, 0.7) 0%,
        rgba(96, 108, 136, 0.7) 100%
    );
}

/* v-image__image v-image__image--cover */
/* to top left, rgba(37, 45, 65,0.5), rgba(63, 71, 89,0.5) */
</style>
