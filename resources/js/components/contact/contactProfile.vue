<template>
    <v-main>
        <!-- Loader -->
        <v-overlay :value="!loaded" opacity="1" color="background">
            <v-progress-circular :size="30" color="primary" indeterminate>
            </v-progress-circular>
        </v-overlay>
        <!-- Toolbar -->
        <v-toolbar flat rounded dense class="v-toolbar__no_pad mb-2">
            <v-btn text tile height="48" @click="back()">
                <v-icon>mdi-arrow-left</v-icon>
            </v-btn>
            <v-spacer></v-spacer>
            <v-slide-x-reverse-transition>
                <div>
                    <v-btn
                        text
                        tile
                        height="48"
                        v-show="edit"
                        :disabled="!valid"
                        @click="destroy()"
                        color="danger"
                    >
                        <v-icon>mdi-delete</v-icon>
                    </v-btn>
                    <v-btn
                        text
                        tile
                        height="48"
                        v-show="edit"
                        :disabled="!valid"
                        @click="update()"
                    >
                        <v-icon>mdi-content-save</v-icon>
                    </v-btn>
                </div>
            </v-slide-x-reverse-transition>
            <v-btn
                text
                tile
                height="48"
                v-if="!edit"
                @click="editContact(true)"
            >
                <v-icon>
                    mdi-pencil
                </v-icon>
            </v-btn>
            <v-btn
                text
                tile
                height="48"
                v-if="edit"
                @click="editContact(false)"
            >
                <v-icon>
                    mdi-close
                </v-icon>
            </v-btn>
        </v-toolbar>

        <v-divider></v-divider>

        <!-- Card -->
        <v-card flat>
            <v-form v-model="valid" :readonly="!edit">
                <v-container fluid>
                    <v-row>
                        <v-col cols="12" sm="5" md="3">
                            <v-card flat size="100%">
                                <v-img
                                    :aspect-ratio="1 / 1"
                                    :src="contact.profile_pic"
                                    :alt="contact.name"
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
                            <v-card flat class="mt-1">
                                <v-card-actions
                                    class="d-flex justify-center px-0"
                                >
                                    <v-btn-toggle class="w-100 mx-0">
                                        <v-btn
                                            :disabled="edit"
                                            :color="
                                                this.$vuetify.theme.dark
                                                    ? ''
                                                    : 'primary'
                                            "
                                            elevation="0"
                                            class="w-50 v-btn--active"
                                        >
                                            <v-icon class="white--text">
                                                mdi-email
                                            </v-icon>
                                        </v-btn>

                                        <v-btn
                                            :disabled="edit || !contact.phone"
                                            :color="
                                                this.$vuetify.theme.dark
                                                    ? ''
                                                    : 'primary'
                                            "
                                            @click="call()"
                                            elevation="0"
                                            class="w-50 v-btn--active"
                                        >
                                            <v-icon class="white--text">
                                                mdi-phone
                                            </v-icon>
                                        </v-btn>
                                    </v-btn-toggle>
                                </v-card-actions>
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
                                            v-model="contact.name"
                                            flat
                                        >
                                        </v-text-field>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col cols="12" md="12">
                                        <v-text-field
                                            v-show="contact.company || edit"
                                            :class="textFieldsClass"
                                            hide-details
                                            label="Company"
                                            v-model="contact.company"
                                            flat
                                        >
                                        </v-text-field>
                                        <v-text-field
                                            v-show="contact.email || edit"
                                            :class="textFieldsClass"
                                            hide-details
                                            label="Email"
                                            v-model="contact.email"
                                            :rules="rules.email"
                                            flat
                                        >
                                        </v-text-field>
                                        <v-text-field
                                            v-show="contact.phone || edit"
                                            :class="textFieldsClass"
                                            hide-details
                                            label="Phone"
                                            v-model="contact.phone"
                                            :rules="rules.phone"
                                            flat
                                            @click="call()"
                                        >
                                        </v-text-field>
                                        <v-text-field
                                            v-show="contact.address || edit"
                                            :class="
                                                textFieldsClass + ' text-wrap'
                                            "
                                            hide-details
                                            label="Address"
                                            v-model="contact.address"
                                            flat
                                        >
                                        </v-text-field>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-col>
                    </v-row>

                    <v-row v-show="contact.notes || edit" class="mt-5">
                        <v-col cols="12">
                            <v-slide-y-transition>
                                <v-textarea
                                    auto-grow
                                    rows="1"
                                    label="Notes"
                                    v-model="contact.notes"
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
import axios from "axios";
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
        contact: {},
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
            this.$router.push({ name: "contact" });
        },
        getContact() {
            // this.loaded = false;
            let contactId = this.$route.params.id;
            axios
                .post("contact/show", { id: contactId })
                .then(response => {
                    this.contact = response.data;
                    // this.loaded = true;
                })
                .catch(response => {
                    console.error(response);
                });
        },
        editContact(action) {
            if (!action) {
                this.getContact();
            }
            this.edit = action;
        },
        call() {
            if (!this.edit) {
                let message = "Do you want to Call " + this.contact.name;
                this.$refs.confirm
                    .open("Call...", message, { color: "primary" })
                    .then(response => {
                        if (response) {
                            let phoneNumber = "tel:" + this.contact.phone;
                            window.location.href = phoneNumber;
                        }
                    })
                    .catch(response => {});
            }
        },
        pickAvatar() {
            document.getElementById("avatar").click();
        },
        submitAvatar(e) {
            let formData = new FormData();
            formData.append("id", this.$route.params.id);
            formData.append("avatar", e);

            axios
                .post("upload/contact", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                        Accept: "application/json"
                    }
                })
                .then(response => {
                    if (response.status == "200") {
                        this.getContact();
                    }
                })
                .catch(response => {
                    console.log(response.response.data.errors.avatar[0]);
                });
        },
        update() {
            axios
                .put("contact/update", this.contact)
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
                this.contact.name +
                " from your contact list?";
            this.$refs.confirm
                .open("Delete Contact", message, { color: "danger" })
                .then(response => {
                    if (response) {
                        axios
                            .delete("contact/destroy/" + this.$route.params.id)
                            .then(response => {
                                this.$refs.alert
                                    .open(
                                        "Contact Deleted",
                                        "Contact Successfully Deleted",
                                        {
                                            color: "primary"
                                        }
                                    )
                                    .then(() => {
                                        this.$router.push({ name: "contact" });
                                    });
                            })
                            .catch(response => {
                                console.error(response);
                            });
                    }
                })
                .catch(response => {
                    console.error(response);
                });
        }
    },
    created() {
        this.getContact();
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
