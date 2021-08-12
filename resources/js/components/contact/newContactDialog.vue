<template>
    <div class="text-center">
        <v-dialog v-model="dialog" width="500">
            <template v-slot:activator="{ on, attrs }">
                <v-btn small icon v-bind="attrs" v-on="on">
                    <v-icon>
                        mdi-account-plus
                    </v-icon>
                </v-btn>
            </template>

            <v-card>
                <v-form ref="form" v-model="valid" lazy-validation>
                    <v-toolbar flat dense>
                        <v-icon class="mr-2">
                            mdi-account-plus
                        </v-icon>
                        <v-toolbar-title>
                            Add New Contact
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
                            v-model="contact.name"
                            :rules="rules.required"
                            label="Name"
                            required
                        ></v-text-field>
                        <v-text-field
                            v-model="contact.email"
                            label="Email"
                            :rules="rules.email"
                            required
                        ></v-text-field>
                        <v-text-field
                            v-model="contact.phone"
                            :rules="rules.phone"
                            label="Phone"
                            required
                            hint="eg. +1234567891234"
                        ></v-text-field>
                    </v-card-text>

                    <v-card-actions>
                        <v-btn
                            text
                            block
                            :loading="!loaded"
                            :disabled="!valid"
                            @click="addContact()"
                        >
                            <v-icon dark dense class="mr-2">
                                mdi-account-plus
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
        contact: {},
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
        addContact() {
            this.loaded = false;
            axios
                .post("contact/store", this.contact)
                .then(response => {
                    if (response.status == 201) {
                        this.loaded = true;
                        this.dialog = false;
                        this.contact = {};
                        this.$router.push({
                            name: "contactProfile",
                            params: { id: response.data.id }
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
