<template>
    <v-dialog @click:outside="reset()" v-model="dialog" width="375">
        <v-form ref="form" v-model="valid" lazy-validation>
            <v-card v-if="dialog">
                <v-progress-linear
                    v-if="!loaded"
                    indeterminate
                ></v-progress-linear>
                <v-toolbar flat dense>
                    <v-icon class="mr-2">
                        mdi-domain-plus
                    </v-icon>
                    <v-toolbar-title>
                        Add New Company
                    </v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-btn @click="dialog = false" icon x-small class="mr-1">
                        <v-icon>
                            mdi-close
                        </v-icon>
                    </v-btn>
                </v-toolbar>

                <v-card-text>
                    <v-text-field
                        v-model="company.name"
                        :rules="rules.required"
                        label="Name"
                        required
                    ></v-text-field>

                    <v-autocomplete
                        flat
                        hide-details
                        cache-items
                        :items="countries"
                        item-text="name"
                        item-value="iso2"
                        v-model="company.country"
                        label="Country"
                    >
                        <template v-slot:item="{ item }">
                            <div class="d-flex w-100 justify-space-between">
                                <span>{{ item.name }}</span>

                                <span>
                                    <v-img
                                        class="align-self-start mr-auto"
                                        max-height="24px"
                                        :src="
                                            '/factory/flags/4x3/' +
                                                item.iso2 +
                                                '.svg'
                                        "
                                    ></v-img>
                                </span>
                            </div>
                        </template>
                    </v-autocomplete>
                </v-card-text>

                <v-card-text>
                    <v-btn
                        block
                        text
                        :loading="!loaded"
                        :disabled="!valid"
                        @click="addCompany()"
                    >
                        <v-icon dense class="mr-2">
                            mdi-domain-plus
                        </v-icon>
                        Add
                    </v-btn>
                </v-card-text>
            </v-card>
        </v-form>
    </v-dialog>
</template>

<script>
export default {
    props: ["bus"],
    data: () => ({
        loaded: false,
        dialog: false,
        valid: true,
        countries: [],
        company: {
            name: "Company Name",
            country: "CH",
            currency_id: 2
        },
        rules: {
            required: [v => !!v || "This field is Required"]
        }
    }),
    methods: {
        getCountries() {
            axios
                .get("res/countries")
                .then(response => {
                    this.countries = response.data;
                })
                .catch(response => {
                    console.log(response);
                });
        },
        reset() {
            this.dialog = false;
            this.company.name = "";
        },
        showDialog() {
            this.dialog = true;
        },
        addCompany() {
            this.loaded = false;
            axios
                .post("/company/store", this.company)
                .then(response => {
                    if ((response.status = 201)) {
                        this.$store.commit(
                            "membership/setMembershipId",
                            response.data.membership.id
                        );
                        this.$emit("companyChange");
                        this.dialog = false;
                        this.$router.push({ name: "company" });
                    }
                })
                .catch(response => {
                    console.log(response);
                    console.log(response.data);
                });

            setTimeout(() => {
                this.loaded = true;
            }, 200);
        }
    },
    created() {
        this.getCountries();
        if (this.bus) {
            this.bus.$on("newCompany", this.showDialog);
        }
    },
    mounted() {
        this.loaded = true;
        this.valid = true;
    }
};
</script>

<style scoped></style>
