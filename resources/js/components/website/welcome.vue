<template>
    <header>
        <v-img
            height="100vh"
            src="storage/buildings-2.jpg"
            class="p-0"
            style="background-position: fixed;"
        >
            <template v-slot:default>
                <v-row
                    class="fill-height ma-0 bc-gradient"
                    align="center"
                    justify="space-around"
                >
                    <v-spacer class="d-none d-md-flex"></v-spacer>

                    <v-card
                        color="transparent"
                        flat
                        max-width="375px"
                        min-width="250px"
                        width="75vw"
                    >
                        <icon-logo :fill="iconColor"></icon-logo>

                        <v-card-text
                            class="welcome-card-text title white--text mt-3 pa-0"
                            style="opacity: 0.8;"
                        >
                            Lorem ipsum dolor sit amet, consectetur adipiscing
                            elit. Fusce magna risus, blandit faucibus mauris
                            vitae, fermentum blandit ante.
                        </v-card-text>
                        <v-card-actions class="pa-0 mt-5">
                            <v-btn block elevation="0" color="white">
                                Do Something
                            </v-btn>
                        </v-card-actions>
                    </v-card>

                    <v-spacer class="d-none d-md-flex"></v-spacer>

                    <v-card
                        color="transparent"
                        class="d-none d-md-flex w-50 pa-0 ma-0 align-self-end"
                        rounded="0"
                        max-height="90vh"
                        elevation="0"
                    >
                        <v-img
                            position="center top"
                            max-height="100vh"
                            src="storage/home-page-dude.png"
                        ></v-img>
                    </v-card>
                    <v-btn
                        icon
                        dark
                        class="mx-auto align-self-end mb-5"
                        absolute
                    >
                        <v-icon>
                            mdi-chevron-down
                        </v-icon>
                    </v-btn>
                </v-row>
            </template>
        </v-img>
    </header>
</template>

<script>
import IconLogo from "../ui/icons/logo";
export default {
    components: {
        IconLogo
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
