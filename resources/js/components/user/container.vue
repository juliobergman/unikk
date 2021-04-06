<template>
    <v-main>
        <v-container fluid>
            <v-row>
                <v-col cols="12" md="4">
                    <v-img
                        src="ui/default-user.jpg"
                        lazy-src="ui/default-user.jpg"
                        aspect-ratio="1"
                    >
                        <template v-slot:placeholder>
                            <v-row
                                class="fill-height ma-0"
                                align="center"
                                justify="center"
                            >
                                <v-progress-circular
                                    indeterminate
                                    color="grey lighten-5"
                                ></v-progress-circular>
                            </v-row>
                        </template>
                    </v-img>
                </v-col>
                <v-col cols="12" md="8">
                    {{ currentUser.name }}
                </v-col>
            </v-row>
        </v-container>
    </v-main>
</template>

<script>
export default {
    data: () => ({
        form: {
            username: ""
        }
    }),
    computed: {
        currentUser: {
            get() {
                return this.$store.state.currentUser.user;
            }
        }
    },
    created() {
        this.$store.dispatch("currentUser/getUser");
    }
};
</script>

<style></style>
