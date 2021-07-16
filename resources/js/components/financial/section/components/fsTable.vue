<template>
    <div>
        <v-data-table
            :loading="!dataLoaded"
            :headers="getHeaders()"
            :items="report"
            :item-class="rowClass"
            item-key="key"
            disable-filtering
            disable-pagination
            disable-sort
            hide-default-footer
            calculate-widths
            class="no-wrap"
            dense
        >
            <template
                v-for="header in headers"
                v-slot:[`item.${header.value}`]="{ item, header, value }"
            >
                <span @click="showRecords(item, header, value)">{{
                    formatAccounting(value)
                }}</span>
            </template>
        </v-data-table>
    </div>
</template>
<script>
import FsToolbar from "./fsToolbar";
export default {
    components: {
        FsToolbar
    },
    props: [
        "bus",
        "rid",
        "year",
        "period",
        "month",
        "quarter",
        "lvl",
        "search"
    ],
    methods: {
        getReportData() {
            this.dataLoaded = false;

            let postData = {
                year: this.year,
                company: localStorage.getItem("company"),
                lvl: this.lvl,
                report: this.rid
            };

            axios
                .post("report/getdata", postData)
                .then(response => {
                    this.report = response.data;
                    setTimeout(() => {
                        this.dataLoaded = true;
                    }, 100);
                })
                .catch(response => {
                    console.error(response);
                });
        },
        formatAccounting(value) {
            if (isNaN(value)) {
                return value;
            }

            if (value >= 0) {
                return (
                    this.currency_symbol +
                    " " +
                    value.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,")
                );
            } else {
                let nv = value * -1;
                return (
                    this.currency_symbol +
                    " (" +
                    nv.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,") +
                    ")"
                );
            }
        },
        getHeaders() {
            let result = this.headers.filter(header => {
                return header.group.includes(this.search);
            });

            result = [
                {
                    text: "",
                    value: "name",
                    currency: true,
                    sortable: false,
                    class: "dttit_header",
                    cellClass: "dttit",
                    group: ["jan", "q1", "yearly"]
                },
                ...result
            ];

            return result;
        },
        rowClass(item) {
            return item.row_class;
        },
        showRecords(item, header, value) {
            if (header.cellClass != "month") {
                return;
            }
            if (item.row_class == "result-row") {
                return;
            }

            console.log("Item", item);
            console.log("Header", header);
            console.log("Value", value);
        }
    },
    data: () => ({
        dataLoaded: true,
        currency_symbol: "$",
        report: undefined,
        selected: [],
        headers: [
            {
                text: "January",
                align: "center",
                value: "jan",
                currency: true,
                sortable: false,
                class: "month_header",
                cellClass: "month",
                group: ["jan", "q1", "yearly"]
            },
            {
                text: "February",
                align: "center",
                value: "feb",
                currency: true,
                sortable: false,
                class: "month_header",
                cellClass: "month",
                group: ["feb", "q1", "yearly"]
            },
            {
                text: "March",
                align: "center",
                value: "mar",
                currency: true,
                sortable: false,
                class: "month_header",
                cellClass: "month",
                group: ["mar", "q1", "yearly"]
            },
            {
                text: "Q1",
                align: "center",
                value: "qr1",
                currency: true,
                sortable: false,
                class: "quart_header",
                cellClass: "quart",
                group: ["q1", "yearly"]
            },
            {
                text: "April",
                align: "center",
                value: "apr",
                currency: true,
                sortable: false,
                class: "month_header",
                cellClass: "month",
                group: ["apr", "q2", "yearly"]
            },
            {
                text: "May",
                align: "center",
                value: "may",
                currency: true,
                sortable: false,
                class: "month_header",
                cellClass: "month",
                group: ["may", "q2", "yearly"]
            },
            {
                text: "June",
                align: "center",
                value: "jun",
                currency: true,
                sortable: false,
                class: "month_header",
                cellClass: "month",
                group: ["jun", "q2", "yearly"]
            },
            {
                text: "Q2",
                align: "center",
                value: "qr2",
                currency: true,
                sortable: false,
                class: "quart_header",
                cellClass: "quart",
                group: ["q2", "yearly"]
            },
            {
                text: "July",
                align: "center",
                value: "jul",
                currency: true,
                sortable: false,
                class: "month_header",
                cellClass: "month",
                group: ["jul", "q3", "yearly"]
            },
            {
                text: "August",
                align: "center",
                value: "aug",
                currency: true,
                sortable: false,
                class: "month_header",
                cellClass: "month",
                group: ["aug", "q3", "yearly"]
            },
            {
                text: "September",
                align: "center",
                value: "sep",
                currency: true,
                sortable: false,
                class: "month_header",
                cellClass: "month",
                group: ["sep", "q3", "yearly"]
            },
            {
                text: "Q3",
                align: "center",
                value: "qr3",
                currency: true,
                sortable: false,
                class: "quart_header",
                cellClass: "quart",
                group: ["q3", "yearly"]
            },
            {
                text: "October",
                align: "center",
                value: "oct",
                currency: true,
                sortable: false,
                class: "month_header",
                cellClass: "month",
                group: ["oct", "q4", "yearly"]
            },
            {
                text: "November",
                align: "center",
                value: "nov",
                currency: true,
                sortable: false,
                class: "month_header",
                cellClass: "month",
                group: ["nov", "q4", "yearly"]
            },
            {
                text: "December",
                align: "center",
                value: "dec",
                currency: true,
                sortable: false,
                class: "month_header",
                cellClass: "month",
                group: ["dec", "q4", "yearly"]
            },
            {
                text: "Q4",
                align: "center",
                value: "qr4",
                currency: true,
                sortable: false,
                class: "quart_header",
                cellClass: "quart",
                group: ["q4", "yearly"]
            },
            {
                text: "Year",
                align: "center",
                value: "year",
                currency: true,
                sortable: false,
                class: "years_header",
                cellClass: "years",
                group: ["yearly"]
            }
        ]
    }),
    created() {
        this.getReportData();
    },
    watch: {
        year() {
            this.getReportData();
        },
        lvl() {
            this.getReportData();
        },
        rid() {
            this.getReportData();
        }
    }
};
</script>

<style scoped></style>
