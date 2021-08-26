<template>
    <v-card flat :outlined="!darkTheme" v-if="loaded && value">
        <v-card-text class="pa-0">
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
                    <v-container
                        fluid
                        class="pa-0 ma-0 d-flex justify-space-between"
                    >
                        <span class="text-button primary--text text-no-wrap text-truncate">
                            {{ item.name }}
                        </span>

                        <span class="text-button secondary--text ml-2">
                            {{ item.month_name }}
                        </span>
                    </v-container>
                </template>
            </v-select>
        </v-card-text>
        <v-divider class="mt-1 mb-2"></v-divider>
        <v-container fluid class="ma-0" v-if="loaded">
            <v-row no-gutters>
                <v-col cols="6">

                    <v-sparkline
                        :height="sparkline.height"
                        :value="value"
                        :labels="sparkline.labels"
                        :gradient="sparkline.gradient"
                        :smooth="sparkline.radius || false"
                        :padding="sparkline.padding"
                        :line-width="sparkline.width"
                        :stroke-linecap="sparkline.lineCap"
                        :gradient-direction="sparkline.gradientDirection"
                        :fill="sparkline.fill"
                        :type="sparkline.type"
                        :auto-line-width="sparkline.autoLineWidth"
                        auto-draw
                        :auto-draw-duration="sparkline.autoDrawDuration"
                    ></v-sparkline>


                </v-col>
                <v-col cols="6" class="d-flex justify-end">

                <span
                    class="secondary--text result-amount"
                    v-text="res"
                ></span>



                </v-col>
            </v-row>

            </v-row>
        </v-container>
    </v-card>
</template>

<script>
export default {
    props: {
        bus: {},
        darkTheme: {},
        inid: { type: Number, default: 21 }
    },
    data: () => ({
        loaded: true,
        name: "",
        data: undefined,
        results: [],
        sparkline: {
            height: 75,
            autoDrawDuration: 500,
            width: 5,
            radius: 1,
            padding: 1,
            lineCap: "round",
            gradient: ["#5895ff", "#58ffb1"],
            gradientDirection: "top",
            fill: true,
            type: "trend",
            autoLineWidth: true,
            labels: []
        }
    }),
    computed: {
        currency_symbol() {
            return this.$store.state.company.company.currency_symbol;
        },
        res() {
            if(this.data){
                return this.format(this.data.amount, this.data.format);
            } else {
                return false;
            }
        },
        value(){
            if(this.data){
                return this.data.value;
            } else {
                return false;
            }
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
                        this.data = resp.find(e => e.id == this.inid);
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
        this.bus.$on("companyChange", () => {
            this.getResults();
        });
    }
};
</script>

<style scoped>
.result-amount {
    font-size: 1.35rem;
    font-weight: 700;
}
</style>
