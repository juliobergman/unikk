<template>
    <div class="text-center">
        <v-dialog v-model="dialog" width="375">
            <template v-slot:activator="{ on, attrs }">
                <v-btn small icon v-bind="attrs" v-on="on">
                    <v-icon>
                        mdi-bullseye-arrow
                    </v-icon>
                </v-btn>
            </template>

            <v-card>
                <v-form ref="form" v-model="valid" lazy-validation>
                    <v-toolbar dark dense class="main-gradient">
                        <v-icon class="mr-2">
                            mdi-bullseye-arrow
                        </v-icon>
                        <v-toolbar-title>
                            Add New Target Company
                        </v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-btn
                            @click="dialog = false"
                            icon
                            x-small
                            class="mr-1"
                        >
                            <v-icon>
                                mdi-close
                            </v-icon>
                        </v-btn>
                    </v-toolbar>

                    <v-card-text>
                        <v-text-field
                            v-model="target.name"
                            :rules="rules.required"
                            label="Target Name"
                            required
                        ></v-text-field>
                        <v-autocomplete
                            flat
                            hide-details
                            cache-items
                            :items="countries"
                            item-text="name"
                            item-value="iso2"
                            v-model="target.country"
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

                    <v-divider></v-divider>

                    <v-card-actions>
                        <v-btn
                            block
                            :loading="!loaded"
                            :disabled="!valid"
                            class="main-gradient"
                            dark
                            @click="addTarget()"
                        >
                            <v-icon dark dense class="mr-2">
                                mdi-bullseye-arrow
                            </v-icon>
                            Add
                        </v-btn>
                    </v-card-actions>
                </v-form>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
export default {
    props: ["bus"],
    data: () => ({
        dialog: false,
        loaded: true,
        valid: true,
        countries: [],
        target: {
            name: "Company Name",
            country: "CH",
            currency_id: 2
        },
        rules: {
            required: [v => !!v || "This field is Required"],
            email: [
                // v => !!v || "E-mail is required",
                v => /.+@.+\..+/.test(v) || "E-mail must be valid"
            ],
            phone: [v => /^\+[1-9]\d{10,14}$/.test(v) || "Phone must be valid"]
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
        addTarget() {
            this.loaded = false;
            this.target.type = "target";
            this.target.company_id = localStorage.getItem("company");
            axios
                .post("company/store", this.target)
                .then(response => {
                    if (response.status == 201) {
                        this.loaded = true;
                        this.dialog = false;
                        this.target = {};
                        this.$router.push({
                            name: "targetProfile",
                            params: {
                                id: response.data.company.id,
                                ref: "edit"
                            }
                        });
                    }
                })
                .catch(error => {
                    console.error(error);
                    console.error(error.response);
                });
        }
    },
    created() {
        this.getCountries();
    }
};
</script>

<style></style>
