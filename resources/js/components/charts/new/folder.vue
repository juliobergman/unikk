<template>
    <v-card max-width="375">
        <v-form ref="form" v-model="valid" lazy-validation>
            <v-toolbar dark dense class="main-gradient">
                <v-icon class="mr-2">
                    mdi-folder
                </v-icon>
                <v-toolbar-title>
                    Add New Folder
                </v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn
                    @click="bus.$emit('closeFDialog')"
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
                    v-model="folder.name"
                    :rules="rules.required"
                    label="Name"
                    required
                ></v-text-field>
            </v-card-text>

            <v-card-actions>
                <v-btn
                    block
                    :loading="!loaded"
                    :disabled="!valid"
                    class="main-gradient"
                    dark
                    @click="addFolder()"
                >
                    <v-icon dark dense class="mr-2">
                        mdi-folder-plus
                    </v-icon>
                    Add
                </v-btn>
            </v-card-actions>
        </v-form>
    </v-card>
</template>

<script>
export default {
    props: ["bus"],
    data: () => ({
        loaded: false,
        valid: false,
        folder: {
            id: null,
            name: ""
        },
        rules: {
            required: [v => !!v || "This field is Required"]
        }
    }),
    methods: {
        addFolder() {
            this.loaded = false;

            this.folder.company = Number.parseInt(
                localStorage.getItem("company"),
                10
            );

            if (!this.id) {
                axios
                    .post("/chart/collection/store", this.folder)
                    .then(response => {
                        setTimeout(() => {
                            this.$router.push({
                                name: "chartCollection",
                                params: { collection: response.data.id }
                            });
                        }, 500);
                    });
            }

            setTimeout(() => {
                setTimeout(() => {
                    this.bus.$emit("closeFDialog");
                    this.bus.$emit("reloadCollectionList");
                }, 100);
                this.loaded = true;
            }, 200);
        }
    },
    mounted() {
        this.loaded = true;
        this.valid = false;
    }
};
</script>

<style></style>
