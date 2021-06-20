<template>
    <v-main>
        <!-- Loader -->
        <v-overlay :value="!loaded" opacity="1" color="background">
            <v-progress-circular :size="30" color="primary" indeterminate>
            </v-progress-circular>
        </v-overlay>
        <!-- Toolbar -->
        <v-toolbar class="mb-3 px-1" elevation="2" rounded dense>
            <v-btn @click="back()" icon small>
                <v-icon>mdi-arrow-left</v-icon>
            </v-btn>
            <v-spacer></v-spacer>
            <v-slide-x-reverse-transition>
                <div>
                    <v-btn
                        v-show="edit"
                        :disabled="!valid"
                        @click="destroy()"
                        icon
                        small
                        class="mr-4"
                        color="danger"
                    >
                        <v-icon>mdi-delete</v-icon>
                    </v-btn>
                    <v-btn
                        v-show="edit"
                        :disabled="!valid"
                        @click="update()"
                        icon
                        small
                        class="mr-4"
                    >
                        <v-icon>mdi-content-save</v-icon>
                    </v-btn>
                </div>
            </v-slide-x-reverse-transition>
            <v-btn icon small v-if="!edit" @click="editPecc(true)">
                <v-icon>
                    mdi-pencil
                </v-icon>
            </v-btn>
            <v-btn icon small v-if="edit" @click="editPecc(false)">
                <v-icon>
                    mdi-close
                </v-icon>
            </v-btn>
        </v-toolbar>
        <!-- Card -->
        <v-card class="mt-2 pt-5">
            <v-form v-model="valid" :readonly="!edit">
                <v-container fluid>
                    <v-row>
                        <v-col cols="12" sm="5" md="3">
                            <v-card flat size="100%">
                                <v-img
                                    :aspect-ratio="1 / 1"
                                    :src="pecc.logo"
                                    :alt="pecc.fund"
                                >
                                    <v-card-actions
                                        class="fill-height justify-end align-end"
                                    >
                                        <v-slide-y-reverse-transition>
                                            <v-btn
                                                fab
                                                x-small
                                                v-show="edit"
                                                class="transparent-overlay"
                                                @click="pickAvatar()"
                                            >
                                                <v-icon>
                                                    mdi-upload
                                                </v-icon>
                                            </v-btn>
                                        </v-slide-y-reverse-transition>
                                    </v-card-actions>
                                </v-img>
                            </v-card>
                        </v-col>
                        <v-col cols="12" sm="7" md="9" class="mt-8 mt-sm-0">
                            <v-container fluid class="pa-0 pl-sm-15">
                                <v-row>
                                    <v-col cols="12">
                                        <v-text-field
                                            :rules="rules.required"
                                            :class="
                                                textFieldsClass +
                                                    ' title primary--text'
                                            "
                                            hide-details
                                            label="Fund"
                                            v-model="pecc.fund"
                                            flat
                                        >
                                        </v-text-field>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col cols="12" md="12">
                                        <v-text-field
                                            v-show="pecc.type || edit"
                                            :class="textFieldsClass"
                                            hide-details
                                            label="Type"
                                            v-model="pecc.type"
                                            flat
                                        >
                                        </v-text-field>

                                        <v-text-field
                                            v-show="pecc.sector || edit"
                                            :class="textFieldsClass"
                                            hide-details
                                            label="Sector"
                                            v-model="pecc.sector"
                                            flat
                                        >
                                        </v-text-field>

                                        <v-text-field
                                            v-show="pecc.region || edit"
                                            :class="textFieldsClass"
                                            hide-details
                                            label="Region"
                                            v-model="pecc.region"
                                            flat
                                        >
                                        </v-text-field>

                                        <v-text-field
                                            v-show="pecc.based || edit"
                                            :class="textFieldsClass"
                                            hide-details
                                            label="Based"
                                            v-model="pecc.based"
                                            flat
                                        >
                                        </v-text-field>

                                        <v-text-field
                                            v-show="pecc.main_countries || edit"
                                            :class="textFieldsClass"
                                            hide-details
                                            label="Main Countries"
                                            v-model="pecc.main_countries"
                                            flat
                                        >
                                        </v-text-field>

                                        <v-text-field
                                            v-show="pecc.main_cities || edit"
                                            :class="textFieldsClass"
                                            hide-details
                                            label="Main Cities"
                                            v-model="pecc.main_cities"
                                            flat
                                        >
                                        </v-text-field>

                                        <v-text-field
                                            v-show="pecc.geo_focus || edit"
                                            :class="textFieldsClass"
                                            hide-details
                                            label="Geographical Focus"
                                            v-model="pecc.geo_focus"
                                            flat
                                        >
                                        </v-text-field>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-col>
                    </v-row>

                    <v-row v-show="pecc.notes || edit" class="mt-5">
                        <v-col cols="12">
                            <v-slide-y-transition>
                                <v-textarea
                                    auto-grow
                                    rows="1"
                                    label="Notes"
                                    v-model="pecc.notes"
                                    :class="textFieldsClass"
                                ></v-textarea>
                            </v-slide-y-transition>
                        </v-col>
                    </v-row>

                    <v-file-input
                        v-show="false"
                        id="avatar"
                        name="avatar"
                        ref="avatar"
                        @change="submitAvatar"
                    ></v-file-input>
                </v-container>
            </v-form>
        </v-card>
        <confirm ref="confirm"></confirm>
        <alert ref="alert"></alert>
    </v-main>
</template>

<script>
import confirm from "../ui/confirm";
import alert from "../ui/alert";
export default {
    props: ["bus"],
    components: {
        confirm,
        alert
    },
    data: () => ({
        valid: true,
        loaded: true,
        edit: false,
        pecc: {},
        rules: {
            required: [v => !!v || "This field is Required"],
            email: [
                v =>
                    !v ||
                    /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) ||
                    "E-mail must be valid"
            ],
            phone: [v => /^\+[1-9]\d{10,14}$/.test(v) || "Phone must be valid"]
        }
    }),
    computed: {
        textFieldsClass() {
            return this.edit ? "fields" : "fields noborder";
        }
    },
    methods: {
        back() {
            this.$router.push({ name: "pecc" });
        },
        getPecc() {
            let peccId = this.$route.params.id;
            axios
                .post("pecc/show", { id: peccId })
                .then(response => {
                    this.pecc = response.data;
                })
                .catch(error => {
                    console.error(error);
                    if (error.response.status == 404) {
                        this.$router.push({ name: "pecc" });
                    }
                });
        },
        editPecc(action) {
            if (!action) {
                this.getPecc();
            }
            this.edit = action;
        },
        pickAvatar() {
            document.getElementById("avatar").click();
        },
        submitAvatar(e) {
            let formData = new FormData();
            formData.append("id", this.$route.params.id);
            formData.append("avatar", e);

            axios
                .post("upload/pecc", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                        Accept: "application/json"
                    }
                })
                .then(response => {
                    if (response.status == "200") {
                        this.getPecc();
                    }
                })
                .catch(response => {
                    console.log(response.response.data.errors.avatar[0]);
                });
        },
        update() {
            axios
                .put("pecc/update", this.pecc)
                .then(response => {
                    if (response.status == 200) {
                        this.edit = false;
                    }
                })
                .catch(response => {
                    console.log(response);
                    console.log(response.response);
                });
        },
        destroy() {
            let message =
                "Do you really want to DELETE " +
                this.pecc.fund +
                " from your PECC list?";
            this.$refs.confirm
                .open("Delete PECC", message, { color: "danger" })
                .then(response => {
                    if (response) {
                        axios
                            .delete("pecc/destroy/" + this.$route.params.id)
                            .then(response => {
                                this.$refs.alert
                                    .open(
                                        "PECC Deleted",
                                        "PECC Successfully Deleted",
                                        {
                                            color: "primary"
                                        }
                                    )
                                    .then(() => {
                                        this.$router.push({ name: "pecc" });
                                    });
                            })
                            .catch(response => {
                                console.error(response);
                            });
                    }
                })
                .catch(response => {});
        }
    },
    created() {
        this.getPecc();
        if (this.$route.params.ref === "edit") {
            this.edit = true;
        }
    }
};
</script>

<style scoped>
.fields {
    margin-bottom: 20px;
}
/* .fields >>> .v-input__slot::before {
    border-color: rgba(53, 59, 68, 0.3) !important;
} */
.noborder >>> .v-input__slot::before {
    border-style: none !important;
}
.editBtnPack {
    z-index: 1;
    position: absolute;
    top: 0;
    right: 0;
}
</style>
