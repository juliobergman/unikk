<template>
    <v-dialog v-model="dialog" max-width="375">
        <template v-slot:activator="{ on, attrs }">
            <v-btn icon small class="mr-4" v-bind="attrs" v-on="on">
                <v-icon>mdi-cog</v-icon>
            </v-btn>
        </template>

        <v-card>
            <v-card-title>
                Settings
            </v-card-title>

            <v-card-text>
                <v-text-field
                    v-for="(item, idx) in settings"
                    :key="item.id"
                    :rules="rules.required"
                    :label="item.name"
                    v-model="item.value"
                    required
                ></v-text-field>
            </v-card-text>

            <v-divider></v-divider>

            <v-card-text>
                <v-btn
                    block
                    text
                    :loading="!loaded"
                    :disabled="!valid"
                    @click="save()"
                >
                    <v-icon dense class="mr-2">
                        mdi-content-save
                    </v-icon>
                    Save
                </v-btn>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script>
import axios from "axios";
export default {
    data: () => ({
        loaded: false,
        dialog: false,
        valid: true,
        settings: [],
        rules: {
            required: [v => !!v || "This field is Required"]
        }
    }),
    methods: {
        getSettings() {
            this.loaded = false;
            axios
                .post("/settings/get", {
                    company_id: localStorage.getItem("company")
                })
                .then(response => {
                    if (response.status == 200) {
                        this.settings = response.data;
                        this.loaded = true;
                    }
                })
                .catch(response => {
                    console.error(response);
                    console.error(response.message);
                });
        },
        save() {
            this.loaded = false;
            axios
                .put("/settings/update", this.settings)
                .then(response => {
                    console.log(response.status, response.data);
                    if (response.status == 200) {
                        this.dialog = false;
                        this.getSettings();
                        this.loaded = true;
                    }
                })
                .catch(response => {
                    console.error(response);
                    console.error(response.message);
                });
        }
    },
    created() {
        this.getSettings();
    }
};
</script>

<style></style>
