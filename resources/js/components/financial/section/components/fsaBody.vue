<template>
    <v-data-table
        :loading="!loaded"
        :headers="headers"
        :items="items"
        disable-filtering
        disable-pagination
        disable-sort
        hide-default-footer
        calculate-widths
        dense
    >
        <template v-slot:item.amount="{ item }">
            <v-text-field
                :id="'element' + item.oby"
                :name="'element' + item.oby"
                type="number"
                placeholder="0.00"
                hide-details
                dense
                prepend-icon="mdi-currency-usd"
                v-model="values[item.id]"
                @keydown.+.prevent
                @keydown.e.prevent
                @keydown.down.prevent="focus(item.oby, +1)"
                @keydown.up.prevent="focus(item.oby, -1)"
                @keydown.enter.prevent="focus(item.oby, +1)"
            >
            </v-text-field>
        </template>
    </v-data-table>
</template>

<script>
import axios from "axios";
export default {
    props: ["bus"],
    data: () => ({
        loaded: true,
        date: new Date().toISOString().slice(0, 10),
        report: [],
        headers: [
            { text: "Branch", value: "branch", align: "left" },
            { text: "Code", value: "code", align: "left" },
            { text: "Name", value: "name", align: "left" },
            { text: "Amount", value: "amount", align: "center" }
        ],
        items: [],
        values: []
    }),
    methods: {
        focus($foc, $to) {
            let focusItemId = "element" + ($foc + $to);
            let focusItem = document.getElementById(focusItemId);
            focusItem ? focusItem.focus() : null;
        },
        getFields($type) {
            this.loaded = false;
            axios
                .post("code/all", { type: $type })
                .then(response => {
                    this.items = response.data;
                    this.loaded = true;
                })
                .catch(response => {
                    console.error(response);
                });
        },
        setReport($report) {
            this.values = [];
            this.report = $report;
            this.getFields($report.type);
        },
        setDate($date) {
            let lastDay = this.moment($date)
                .endOf("month")
                .format("-DD");
            this.date = $date + lastDay;
        },
        save() {
            this.$emit("loaded", false);

            let year = this.date.substr(0, 4);
            let companyId = localStorage.getItem("company");
            let reportId = this.report.id;
            let reportType = this.report.type;
            let reportTw = this.report.af;

            let data = {
                date: this.date,
                company_id: companyId,
                report_id: reportId,
                facts: this.values
            };

            if (data.facts.length <= 0) {
                return;
            }

            // this.$emit("loaded", true);
            // this.$router.push({
            //     name: "financialStatement"
            // });

            axios
                .post("fact/store", data)
                .then(response => {
                    if (response.status == 200) {
                        this.values = [];
                        axios
                            .post("etl/extract/" + reportType, {
                                year: year,
                                company: companyId,
                                report: reportId
                            })
                            .then(response => {
                                if (response.status == 200) {
                                    let ratioPostData = {
                                        year: year,
                                        company: companyId,
                                        type: reportTw
                                    };

                                    axios
                                        .post(
                                            "etl/extract/ratio",
                                            ratioPostData
                                        )
                                        .then(response => {
                                            if (response.status == 200) {
                                                this.$emit("loaded", true);
                                                this.$router.push({
                                                    name: "financialStatement"
                                                });
                                            }
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
                })
                .catch(response => {
                    console.error(response);
                });
        }
    },
    mounted() {
        this.bus.$on("setReport", this.setReport);
        this.bus.$on("setDate", this.setDate);
        this.bus.$on("saveFacts", this.save);
    }
};
</script>

<style>
.v-data-table__wrapper table tbody tr:hover td {
    background: #e6e9ef;
}
</style>
