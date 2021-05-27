<template>
    <v-card flat class="mt-2 pt-5">
        <v-form :readonly="!edit">
            <v-container fluid>
                <div
                    class="editBtnPack transparent-overlay d-flex rounded mr-5 mt-10 mr-md-3 mt-md-3"
                    v-if="ownership"
                >
                    <v-slide-x-reverse-transition>
                        <div v-show="edit">
                            <v-btn
                                v-if="false"
                                icon
                                small
                                class="mr-4"
                                color="danger"
                            >
                                <v-icon>mdi-delete</v-icon>
                            </v-btn>
                            <v-btn @click="update()" icon small class="mr-4">
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
                                :src="company.logo"
                                :alt="company.name"
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
                                            @click="pickLogo()"
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
                                        :class="
                                            textFieldsClass +
                                                ' title primary--text'
                                        "
                                        hide-details
                                        label="Company Name"
                                        v-model="company.name"
                                        flat
                                    >
                                    </v-text-field>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="12" md="6">
                                    <v-text-field
                                        :class="textFieldsClass"
                                        hide-details
                                        label="Sector"
                                        v-model="company.sector"
                                        flat
                                    >
                                    </v-text-field>
                                    <v-text-field
                                        :class="textFieldsClass"
                                        hide-details
                                        label="Phone"
                                        v-model="company.phone"
                                        flat
                                    >
                                    </v-text-field>
                                    <v-text-field
                                        :class="textFieldsClass"
                                        hide-details
                                        label="Email"
                                        v-model="company.email"
                                        flat
                                    >
                                    </v-text-field>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-text-field
                                        v-if="false"
                                        :class="textFieldsClass"
                                        hide-details
                                        label="Country"
                                        v-model="company.country"
                                        flat
                                    >
                                    </v-text-field>
                                    <v-text-field
                                        :class="textFieldsClass"
                                        hide-details
                                        label="City"
                                        v-model="company.city"
                                        flat
                                    >
                                    </v-text-field>
                                    <v-text-field
                                        :class="textFieldsClass + ' text-wrap'"
                                        hide-details
                                        label="Address"
                                        v-model="company.address"
                                        flat
                                    >
                                    </v-text-field>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-col>
                </v-row>

                <v-row class="mt-5">
                    <v-col cols="12">
                        <v-slide-y-transition>
                            <v-textarea
                                v-show="company.info || edit"
                                auto-grow
                                rows="1"
                                label="Info"
                                v-model="company.info"
                                :class="textFieldsClass"
                            ></v-textarea>
                        </v-slide-y-transition>
                    </v-col>
                </v-row>

                <v-file-input
                    v-show="false"
                    id="logo"
                    name="logo"
                    ref="logo"
                    @change="submitLogo"
                ></v-file-input>
            </v-container>
        </v-form>
    </v-card>
</template>

<script>
export default {
    props: ["bus"],
    data: () => ({
        loaded: true,
        edit: false,
        ownership: false,
        company: {},
        country: {}
    }),
    computed: {
        membership() {
            return this.$store.state.membership.membership;
        },
        textFieldsClass() {
            return this.edit ? "fields" : "fields noborder";
        }
    },
    methods: {
        getCompanyData() {
            this.loaded = false;
            if (this.membership) {
                let cId = this.membership.company_id;
                axios
                    .get("company/" + cId)
                    .then(response => {
                        this.company = response.data;

                        this.ownership =
                            response.data.user_id == this.membership.user_id
                                ? true
                                : false;

                        // this.getCountryData(response.data.country);
                        setTimeout(() => {
                            this.loaded = true;
                        }, 250);
                    })
                    .catch(response => {
                        console.log(response);
                    });
            }
        },
        getCountryData(iso) {
            axios
                .get("http://country:1111/api/country/" + iso)
                .then(response => {
                    this.country = response.data;
                })
                .catch(response => {
                    console.log(response);
                });
        },
        editProfile(action) {
            if (!action) {
                this.getCompanyData();
            }
            this.edit = action;
        },
        pickLogo() {
            document.getElementById("logo").click();
        },
        submitLogo(e) {
            let formData = new FormData();
            formData.append("logo", e);
            formData.append("company", localStorage.getItem("company"));

            axios
                .post("upload/companylogo", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                        Accept: "application/json"
                    }
                })
                .then(response => {
                    if (response.status == "200") {
                        this.getCompanyData();
                    }
                })
                .catch(response => {
                    console.log(response.response.data.errors.avatar[0]);
                });
        },
        update() {
            axios
                .put("company/" + this.company.id, this.company)
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
        if (this.bus) {
            this.bus.$on("companyChange", this.editProfile);
        }
        this.getCompanyData();
    },
    watch: {
        membership() {
            this.getCompanyData();
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
