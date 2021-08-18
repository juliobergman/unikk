<template>
    <v-card flat :outlined="!darkTheme">
        <v-card-text class="pl-2 pt-1 pb-0" v-if="loaded">
            <v-select
                solo
                flat
                append-icon=""
                v-model="data"
                :items="results"
                item-text="name"
                item-value="id"
                hide-details
                return-object
            >
                <template v-slot:selection="{ item }">
                    <span class="text-button primary--text w-100">
                        {{ item.name }}
                    </span>
                </template>
            </v-select>
        </v-card-text>
        <v-divider class="mt-1 mb-2"></v-divider>
        <v-card-text class="d-flex pt-2" v-if="loaded">
            <span
                class="ml-auto secondary--text result-amount"
                v-text="res"
            ></span>
        </v-card-text>
    </v-card>
</template>

<script>
export default {
    props: {
        bus: {},
        darkTheme: {},
        resid: { type: Number, default: 21 }
    },
    data: () => ({
        loaded: true,
        name: "",
        data: undefined,
        results: []
    }),
    computed: {
        currency_symbol() {
            return this.$store.state.company.company.currency_symbol;
        },
        res() {
            return this.format(this.data.amount, this.data.format);
        }
    },
    methods: {
        format(value, format) {
            let tappend = "";
            let input = value;

            if (input === null) {
                return "";
            }
            if (isNaN(input)) {
                return input;
            }

            if (value > 999) {
                input = value / 1000;
                tappend = "k";
            }

            if (format == "number") {
                return parseFloat(input) + tappend;
            }

            if (format == "percentage") {
                return parseFloat(input) + tappend + "%";
            }
            if (format == "currency") {
                let val = parseFloat(input);
                let currsym = this.currency_symbol;

                if (val >= 0) {
                    return (
                        currsym +
                        " " +
                        val.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,") +
                        tappend
                    );
                } else {
                    let nv = val * -1;
                    return (
                        currsym +
                        " (" +
                        nv.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,") +
                        tappend +
                        ")"
                    );
                }
            }
        },
        getResults() {
            this.loaded = false;
            let postData = {
                year: new Date().getFullYear(),
                company: localStorage.getItem("company")
            };

            axios
                .post("result/data", postData)
                .then(response => {
                    if (response.status == 200) {
                        let resp = response.data;
                        this.data = resp.find(e => e.id == this.resid);

                        this.results = response.data;

                        this.loaded = true;
                    }
                })
                .catch(response => {
                    console.error(response);
                });
        }
    },
    created() {
        this.getResults();
    }
};
</script>

<style scoped>
.result-amount {
    font-size: 1.35rem;
    font-weight: 700;
    margin-top: 4px;
}
</style>
