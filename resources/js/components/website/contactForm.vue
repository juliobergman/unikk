<template>
    <v-form v-model="valid">
        <v-container class="pa-0">
            <v-row>
                <v-col cols="12">
                    <v-text-field
                        v-model="name"
                        :rules="nameRules"
                        :counter="15"
                        label="Name"
                        required
                        clearable
                    ></v-text-field>
                </v-col>
                <v-col cols="12">
                    <v-text-field
                        v-model="email"
                        :rules="emailRules"
                        label="email"
                        required
                        clearable
                    ></v-text-field>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12">
                    <v-textarea
                        name="input-7-1"
                        label="Message"
                        hint="Type your Message"
                    ></v-textarea>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12 d-flex justify-end">
                    <v-btn
                        :loading="loading"
                        :disabled="loading"
                        color="blue"
                        dark
                        @click="loader = 'loading'"
                    >
                        Send
                        <v-icon class="ml-2" light small right>mdi-send</v-icon>
                    </v-btn>
                </v-col>
            </v-row>
        </v-container>
    </v-form>
</template>

<script>
export default {
    data: () => ({
        valid: false,
        name: "",
        nameRules: [
            v => !!v || "Name is required",
            v => v.length <= 15 || "Name must be less than 15 characters"
        ],
        email: "",
        emailRules: [
            v => !!v || "email is required",
            v => /.+@.+/.test(v) || "email must be valid"
        ]
    })
};
</script>

<style></style>
