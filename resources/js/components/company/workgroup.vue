<template>
    <v-card flat>
        <v-card-title class="pt-6 pb-2 font-weight-medium">
            <span class="mx-auto">Team</span>
        </v-card-title>
        <v-card-text>
            <v-divider></v-divider>
            <v-container fluid class="pa-0">
                <v-row>
                    <v-col
                        v-for="(member, idx) in memberships"
                        :key="idx"
                        cols="6"
                        md="3"
                    >
                        <v-card
                            flat
                            hover
                            @click="bus.$emit('showUserProfile', member.id)"
                        >
                            <div class="d-flex w-100 py-8">
                                <v-avatar
                                    rounded
                                    class="mx-auto"
                                    width="80%"
                                    height="100%"
                                    max-width="130px"
                                >
                                    <v-img
                                        :aspect-ratio="1 / 1"
                                        :src="member.userdata.profile_pic"
                                    ></v-img>
                                </v-avatar>
                            </div>
                            <v-divider></v-divider>
                            <v-list-item>
                                <v-list-item-content>
                                    <v-list-item-title>
                                        {{ member.name }}
                                    </v-list-item-title>
                                    <v-list-item-subtitle>
                                        {{ member.membership.job_title }}
                                    </v-list-item-subtitle>
                                </v-list-item-content>
                            </v-list-item>
                            <v-divider></v-divider>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-card-text>
    </v-card>
</template>

<script>
export default {
    props: ["bus"],
    components: {},
    data: () => ({
        loaded: true,
        memberships: {}
    }),
    computed: {
        membership() {
            return this.$store.state.membership.membership;
        }
    },
    methods: {
        getMemberships() {
            this.loaded = false;
            if (this.membership) {
                axios
                    .get("membership/users/" + this.membership.company_id)
                    .then(response => {
                        this.memberships = response.data;
                        setTimeout(() => {
                            this.loaded = true;
                        }, 250);
                    })
                    .catch(response => {
                        let errors = JSON.parse(response.request.response);
                        console.log(errors);
                    });
            }
        }
    },
    created() {
        this.getMemberships();
    },
    watch: {
        membership() {
            this.getMemberships();
        }
    }
};
</script>

<style></style>
