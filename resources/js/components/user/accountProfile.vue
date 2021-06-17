<template>
    <v-card flat class="mt-2 pt-5">
        <v-form v-model="valid" :readonly="!edit">
            <v-container fluid>
                <div
                    class="editBtnPack transparent-overlay d-flex rounded mr-5 mt-10 mr-md-3 mt-md-3"
                    v-if="true"
                >
                    <v-slide-x-reverse-transition>
                        <div v-show="edit">
                            <change-password-dialog></change-password-dialog>
                            <v-btn
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

                    <v-btn icon small v-show="!edit" @click="editProfile(true)">
                        <v-icon>
                            mdi-pencil
                        </v-icon>
                    </v-btn>
                    <v-btn icon small v-show="edit" @click="editProfile(false)">
                        <v-icon>
                            mdi-close
                        </v-icon>
                    </v-btn>
                </div>
                <v-row>
                    <v-col cols="12" sm="5" md="3">
                        <v-card flat color="grey" size="100%">
                            <v-img
                                :aspect-ratio="1 / 1"
                                :src="user.profile_pic"
                                :alt="user.name"
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
                                        label="Name"
                                        v-model="user.name"
                                        flat
                                    >
                                    </v-text-field>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="12" md="12">
                                    <v-text-field
                                        v-show="user.email || edit"
                                        :class="textFieldsClass"
                                        hide-details
                                        label="Email"
                                        v-model="user.email"
                                        :rules="rules.email"
                                        flat
                                    >
                                    </v-text-field>
                                    <v-text-field
                                        v-show="user.phone || edit"
                                        :class="textFieldsClass"
                                        hide-details
                                        label="Phone"
                                        v-model="user.phone"
                                        flat
                                    >
                                    </v-text-field>
                                    <v-text-field
                                        v-show="user.address || edit"
                                        :class="textFieldsClass + ' text-wrap'"
                                        hide-details
                                        label="Address"
                                        v-model="user.address"
                                        flat
                                    >
                                    </v-text-field>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-col>
                </v-row>

                <v-row class="mt-5" v-if="false">
                    <v-col cols="12">
                        <v-slide-y-transition>
                            <v-textarea
                                v-show="user.bio || edit"
                                auto-grow
                                rows="1"
                                label="Info"
                                v-model="user.bio"
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
</template>

<script>
import changePasswordDialog from "../auth/changePasswordDialog";
export default {
    props: ["bus"],
    components: {
        changePasswordDialog
    },
    data: () => ({
        valid: true,
        loaded: true,
        edit: false,
        user: {},
        rules: {
            required: [v => !!v || "This field is Required"],
            role: [v => !!v || "All users must have a role"],
            email: [
                v => !!v || "E-mail is required",
                v => /.+@.+\..+/.test(v) || "E-mail must be valid"
            ],
            password: [v => !!v || "Password is Required"]
        }
    }),
    computed: {
        currentUser() {
            return this.$store.state.user.user;
        },
        membership() {
            return this.$store.state.membership.membership;
        },
        textFieldsClass() {
            return this.edit ? "fields" : "fields noborder";
        }
    },
    methods: {
        getUserData() {
            this.loaded = false;
            if (this.currentUser) {
                axios
                    .get("user/current")
                    .then(response => {
                        this.user = response.data;
                        setTimeout(() => {
                            this.loaded = true;
                        }, 250);
                    })
                    .catch(response => {
                        console.log(response);
                    });
            }
        },
        editProfile(action) {
            if (!action) {
                this.getUserData();
            }
            this.edit = action;
        },
        pickAvatar() {
            document.getElementById("avatar").click();
        },
        submitAvatar(e) {
            let formData = new FormData();
            formData.append("avatar", e);

            axios
                .post("upload/avatar", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                        Accept: "application/json"
                    }
                })
                .then(response => {
                    if (response.status == "200") {
                        this.$store.dispatch("user/getUser");
                    }
                })
                .catch(response => {
                    console.log(response.response.data.errors.avatar[0]);
                });
        },
        update() {
            axios
                .put("user/update", this.user)
                .then(response => {
                    if (response.status == 200) {
                        this.edit = false;
                    }
                })
                .catch(response => {
                    console.log(response);
                    console.log(response.response);
                });
        }
    },
    created() {
        this.getUserData();
    },
    watch: {
        currentUser() {
            this.getUserData();
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
