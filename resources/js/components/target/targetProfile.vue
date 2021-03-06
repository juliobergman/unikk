<template>
    <v-main>
        <!-- Loader -->
        <v-overlay :value="!loaded" opacity="1" color="background">
            <v-progress-circular :size="30" color="primary" indeterminate>
            </v-progress-circular>
        </v-overlay>
        <!-- Toolbar -->
        <v-toolbar class="mb-3 px-1" flat rounded dense>
            <v-btn @click="back()" icon small>
                <v-icon>mdi-arrow-left</v-icon>
            </v-btn>
            <v-spacer></v-spacer>
            <v-slide-x-reverse-transition>
                <div>
                    <v-btn
                        v-show="edit"
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
                        @click="acquire()"
                        icon
                        small
                        class="mr-4"
                    >
                        <v-icon>mdi-domain-plus</v-icon>
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
            <v-btn icon small v-if="!edit" @click="editTarget(true)">
                <v-icon>
                    mdi-pencil
                </v-icon>
            </v-btn>
            <v-btn icon small v-if="edit" @click="editTarget(false)">
                <v-icon>
                    mdi-close
                </v-icon>
            </v-btn>
        </v-toolbar>
        <v-divider v-if="!darkTheme"></v-divider>
        <!-- Card -->
        <v-card class="mt-2 pt-5" flat>
            <v-form v-model="valid" :readonly="!edit">
                <v-container fluid>
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
                                        <v-img
                                            v-if="flag"
                                            class="align-self-start mr-auto"
                                            max-width="32px"
                                            :src="flag"
                                        ></v-img>
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
                                            :class="textFieldsClass + ' title'"
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
                                            v-show="company.sector || edit"
                                            :class="textFieldsClass"
                                            hide-details
                                            label="Sector"
                                            v-model="company.sector"
                                            flat
                                        >
                                        </v-text-field>
                                        <v-text-field
                                            v-show="company.phone || edit"
                                            :class="textFieldsClass"
                                            hide-details
                                            label="Phone"
                                            v-model="company.phone"
                                            flat
                                        >
                                        </v-text-field>
                                        <v-text-field
                                            v-show="company.email || edit"
                                            :class="textFieldsClass"
                                            hide-details
                                            label="Email"
                                            v-model="company.email"
                                            flat
                                        >
                                        </v-text-field>
                                        <v-autocomplete
                                            v-show="company.currency_id || edit"
                                            flat
                                            hide-details
                                            :class="textFieldsClass"
                                            cache-items
                                            :items="currencies"
                                            item-text="name"
                                            item-value="id"
                                            v-model="company.currency_id"
                                            label="Currency"
                                        >
                                            <template
                                                v-slot:selection="{ item }"
                                            >
                                                {{ item.name }} ({{
                                                    item.symbol
                                                }})
                                            </template>
                                            <template v-slot:item="{ item }">
                                                <div
                                                    class="d-flex w-100 justify-space-between"
                                                >
                                                    <span>{{ item.name }}</span>

                                                    <span>
                                                        ({{ item.symbol }})
                                                    </span>
                                                </div>
                                            </template>
                                        </v-autocomplete>
                                    </v-col>
                                    <v-col cols="12" md="6">
                                        <v-text-field
                                            v-show="company.region || edit"
                                            :class="textFieldsClass"
                                            hide-details
                                            label="Region"
                                            v-model="company.region"
                                            flat
                                            readonly
                                        >
                                        </v-text-field>

                                        <v-text-field
                                            v-show="company.subregion || edit"
                                            :class="textFieldsClass"
                                            hide-details
                                            label="Sub Region"
                                            v-model="company.subregion"
                                            flat
                                            readonly
                                        >
                                        </v-text-field>

                                        <v-autocomplete
                                            v-show="company.country || edit"
                                            flat
                                            :class="textFieldsClass"
                                            hide-details
                                            cache-items
                                            :items="countries"
                                            item-text="name"
                                            item-value="iso2"
                                            v-model="company.country"
                                            label="Country"
                                        >
                                            <template v-slot:item="{ item }">
                                                <div
                                                    class="d-flex w-100 justify-space-between"
                                                >
                                                    <span>{{ item.name }}</span>

                                                    <span>
                                                        <v-img
                                                            class="align-self-start mr-auto"
                                                            max-height="24px"
                                                            :src="
                                                                'factory/flags/4x3/' +
                                                                    item.iso2 +
                                                                    '.svg'
                                                            "
                                                        ></v-img>
                                                    </span>
                                                </div>
                                            </template>
                                        </v-autocomplete>

                                        <v-text-field
                                            v-show="company.city || edit"
                                            :class="textFieldsClass"
                                            hide-details
                                            label="City"
                                            v-model="company.city"
                                            flat
                                        >
                                        </v-text-field>

                                        <v-text-field
                                            v-show="false"
                                            :class="
                                                textFieldsClass + ' text-wrap'
                                            "
                                            hide-details
                                            label="Address"
                                            v-model="company.address"
                                            flat
                                        >
                                        </v-text-field>

                                        <v-slide-y-transition>
                                            <v-textarea
                                                v-show="company.address || edit"
                                                auto-grow
                                                rows="1"
                                                label="Address"
                                                v-model="company.address"
                                                :class="textFieldsClass"
                                            ></v-textarea>
                                        </v-slide-y-transition>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-col>
                    </v-row>

                    <v-row v-show="company.company_ov || edit" class="mt-5">
                        <v-col cols="12">
                            <v-slide-y-transition>
                                <v-textarea
                                    auto-grow
                                    rows="1"
                                    label="Company Overview"
                                    v-model="company.company_ov"
                                    :class="textFieldsClass"
                                ></v-textarea>
                            </v-slide-y-transition>

                            <v-slide-y-transition>
                                <v-textarea
                                    auto-grow
                                    rows="1"
                                    label="Financial Overview"
                                    v-model="company.financial_ov"
                                    :class="textFieldsClass"
                                ></v-textarea>
                            </v-slide-y-transition>

                            <v-slide-y-transition>
                                <v-textarea
                                    auto-grow
                                    rows="1"
                                    label="Milestones"
                                    v-model="company.milestones"
                                    :class="textFieldsClass"
                                ></v-textarea>
                            </v-slide-y-transition>

                            <v-slide-y-transition>
                                <v-textarea
                                    auto-grow
                                    rows="1"
                                    label="Competitors"
                                    v-model="company.competitors"
                                    :class="textFieldsClass"
                                ></v-textarea>
                            </v-slide-y-transition>

                            <v-slide-y-transition>
                                <v-textarea
                                    auto-grow
                                    rows="1"
                                    label="Goals"
                                    v-model="company.goals"
                                    :class="textFieldsClass"
                                ></v-textarea>
                            </v-slide-y-transition>

                            <v-slide-y-transition>
                                <v-textarea
                                    auto-grow
                                    rows="1"
                                    label="Distrbution Channels"
                                    v-model="company.channels"
                                    :class="textFieldsClass"
                                ></v-textarea>
                            </v-slide-y-transition>

                            <v-slide-y-transition>
                                <v-textarea
                                    auto-grow
                                    rows="1"
                                    label="Challenges"
                                    v-model="company.challenges"
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
        company: {},
        countries: [],
        currencies: [],
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
        darkTheme() {
            return this.$vuetify.theme.dark ? true : false;
        },
        flag() {
            return this.company.country
                ? "factory/flags/4x3/" + this.company.country + ".svg"
                : false;
        },
        textFieldsClass() {
            return this.edit ? "fields" : "fields noborder";
        }
    },
    methods: {
        back() {
            this.$router.push({ name: "target" });
        },
        getTarget() {
            let targetId = this.$route.params.id;
            axios
                .post("target/show", { id: targetId })
                .then(response => {
                    this.company = response.data;
                })
                .catch(response => {
                    console.error(response);
                    // console.error(error);
                    // if (error.response.status == 404) {
                    //     this.$router.push({ name: "target" });
                    // }
                });
        },
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
        getCurrencies() {
            axios
                .get("res/currencies")
                .then(response => {
                    this.currencies = response.data;
                })
                .catch(response => {
                    console.log(response);
                });
        },
        editTarget(action) {
            if (!action) {
                this.getTarget();
            }
            this.edit = action;
        },
        pickLogo() {
            document.getElementById("logo").click();
        },
        submitLogo(e) {
            let formData = new FormData();
            formData.append("company", this.$route.params.id);
            formData.append("logo", e);

            axios
                .post("upload/companylogo", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                        Accept: "application/json"
                    }
                })
                .then(response => {
                    if (response.status == "200") {
                        this.getTarget();
                    }
                })
                .catch(response => {
                    console.log(response.response.data.errors.avatar[0]);
                });
        },
        update() {
            axios
                .put("target/update", this.company)
                .then(response => {
                    console.log(this.company);

                    if (response.status == 200) {
                        this.edit = false;
                    }
                })
                .catch(response => {
                    console.log(response);
                    console.log(response.response);
                });
        },
        acquire() {
            let message =
                "Do you want to acquire " +
                this.company.name +
                " from your Target list?";

            this.$refs.confirm
                .open("Acquire Target", message, { color: "primary" })
                .then(response => {
                    if (response) {
                        axios
                            .put("target/acquire", {
                                id: this.$route.params.id
                            })
                            .then(response => {
                                this.$refs.alert
                                    .open(
                                        "Target Acquired",
                                        "Target Successfully Acquired",
                                        {
                                            color: "primary"
                                        }
                                    )
                                    .then(() => {
                                        this.bus.$emit("companySelect");
                                        this.$router.push({ name: "target" });
                                    });
                            })
                            .catch(response => {
                                console.error(response);
                            });
                    }
                })
                .catch(response => {});
        },
        destroy() {
            let message =
                "Do you really want to DELETE " +
                this.company.name +
                " from your Target list?";
            this.$refs.confirm
                .open("Delete Target", message, { color: "danger" })
                .then(response => {
                    if (response) {
                        axios
                            .delete("target/destroy/" + this.$route.params.id)
                            .then(response => {
                                this.$refs.alert
                                    .open(
                                        "Target Deleted",
                                        "Target Successfully Deleted",
                                        {
                                            color: "primary"
                                        }
                                    )
                                    .then(() => {
                                        this.$router.push({ name: "target" });
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
        this.getCountries();
        this.getCurrencies();
        this.getTarget();
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
