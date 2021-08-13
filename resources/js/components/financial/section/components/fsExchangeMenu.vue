<template>
    <v-menu offset-y offset-x :close-on-content-click="false">
        <template v-slot:activator="{ on, attrs }">
            <v-btn tile text height="48" v-bind="attrs" v-on="on">
                <v-icon>
                    mdi-autorenew
                </v-icon>
            </v-btn>
        </template>

        <v-card>
            <v-card-title>Exchange Rate</v-card-title>
            <v-card-text>
                <v-autocomplete
                    flat
                    hide-details
                    cache-items
                    :items="currencies"
                    item-text="name"
                    item-value="symbol"
                    v-model="xchange.currency"
                    label="Currency"
                >
                    <template v-slot:selection="{ item }">
                        {{ item.name }} ({{ item.symbol }})
                    </template>
                    <template v-slot:item="{ item }">
                        <div class="d-flex w-100 justify-space-between">
                            <span>{{ item.name }}</span>

                            <span> ({{ item.symbol }}) </span>
                        </div>
                    </template>
                </v-autocomplete>
            </v-card-text>
            <v-card-text>
                <v-text-field
                    type="number"
                    :rules="rules.required"
                    hide-details
                    label="Exchange Rate"
                    v-model="xchange.rate"
                    flat
                    required
                >
                </v-text-field>
            </v-card-text>
            <v-card-actions>
                <v-btn :disabled="!valid" block text @click="exchange()">
                    <v-icon dense class="mr-2">
                        mdi-autorenew
                    </v-icon>
                    Exchange
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-menu>
</template>

<script>
export default {
    props: ["bus"],
    data: () => ({
        xchange: {
            rate: null,
            currency: ""
        },
        currencies: [],
        rules: {
            required: [v => !!v || "This field is Required"]
        }
    }),
    computed: {
        valid() {
            if (!this.xchange.rate || !this.xchange.currency) {
                return false;
            } else {
                return true;
            }
        }
    },
    methods: {
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
        exchange() {
            localStorage.setItem("xchange", JSON.stringify(this.xchange));
            this.bus.$emit("currency:exchange", this.xchange);
        }
    },
    created() {
        this.getCurrencies();
        if (localStorage.xchange) {
            this.xchange = JSON.parse(localStorage.getItem("xchange"));
        }
    }
};
</script>

<style></style>
