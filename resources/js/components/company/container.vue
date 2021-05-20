<template>
    <v-main>
        <v-card class="mb-4">
            <v-row no-gutters class="pa-5">
                <v-col align-self="start" cols="12" md="3">
                    <v-avatar class="profile" color="grey" size="100%" rounded>
                        <v-img
                            :aspect-ratio="1 / 1"
                            :src="company.logo"
                            :alt="company.name"
                        ></v-img>
                    </v-avatar>
                </v-col>
                <v-col class="ml-0 ml-md-4">
                    <v-list>
                        <v-list-item>
                            <v-list-item-content>
                                <v-list-item-title>
                                    {{ company.name }}
                                </v-list-item-title>
                                <v-list-item-subtitle>
                                    <v-list-item-avatar size="20">
                                        <v-img
                                            :src="
                                                'https://flagcdn.com/w160/' +
                                                    company.country +
                                                    '.png'
                                            "
                                        >
                                        </v-img>
                                    </v-list-item-avatar>

                                    {{ company.city }}
                                </v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                    <v-list dense>
                        <v-list-item>
                            <v-list-item-content>
                                <v-list-item-subtitle>
                                    {{ company.address }}
                                </v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-content>
                                <v-list-item-subtitle>
                                    {{ company.phone }}
                                </v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-content>
                                <v-list-item-subtitle>
                                    {{ company.email }}
                                </v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-content>
                                <v-list-item-subtitle>
                                    {{ company.website }}
                                </v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                </v-col>
            </v-row>
            <v-card-text>{{ company.info }}</v-card-text>
        </v-card>

        <work-group></work-group>
    </v-main>
</template>

<script>
import WorkGroup from "./workgroup";
export default {
    props: ["bus"],
    components: {
        WorkGroup
    },
    data: () => ({
        loaded: true,
        company: {}
    }),
    computed: {
        membership() {
            return this.$store.state.membership.membership;
        }
    },
    methods: {
        getCompanyData() {
            this.loaded = false;
            if (this.membership) {
                let cId = this.membership.company_id;
                axios
                    .get("company/" + cId)
                    .then(response => {
                        this.company = response.data;
                        setTimeout(() => {
                            this.loaded = true;
                        }, 250);
                    })
                    .catch(response => {
                        console.log(response);
                    });
            }
        }
    },
    created() {
        this.getCompanyData();
    },
    watch: {
        membership() {
            this.getCompanyData();
        }
    }
};
</script>

<style></style>
