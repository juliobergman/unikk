<template>
    <div class="text-center">
        <v-dialog v-model="dialog" width="375">
            <template v-slot:activator="{ on, attrs }">
                <v-btn small icon v-bind="attrs" v-on="on">
                    <v-icon>
                        mdi-earth-plus
                    </v-icon>
                </v-btn>
            </template>

            <v-card>
                <v-form ref="form" v-model="valid" lazy-validation>
                    <v-toolbar dark dense class="main-gradient">
                        <v-icon class="mr-2">
                            mdi-earth-plus
                        </v-icon>
                        <v-toolbar-title>
                            Add New PECC
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
                            v-model="pecc.fund"
                            :rules="rules.required"
                            label="Fund Name"
                            required
                        ></v-text-field>
                    </v-card-text>

                    <v-divider></v-divider>

                    <v-card-actions>
                        <v-btn
                            block
                            :loading="!loaded"
                            :disabled="!valid"
                            class="main-gradient"
                            dark
                            @click="addPecc()"
                        >
                            <v-icon dark dense class="mr-2">
                                mdi-earth-plus
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
        pecc: {},
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
        addPecc() {
            this.loaded = false;
            axios
                .post("pecc/store", this.pecc)
                .then(response => {
                    if (response.status == 201) {
                        this.loaded = true;
                        this.dialog = false;
                        this.pecc = {};
                        this.$router.push({
                            name: "peccProfile",
                            params: {
                                id: response.data.id,
                                ref: "edit"
                            }
                        });
                    }
                })
                .catch(response => {
                    console.error(response);
                });
        }
    }
};
</script>

<style></style>
