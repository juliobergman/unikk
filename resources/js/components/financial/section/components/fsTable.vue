<template>
    <v-card flat rounded class="pa-0">
        <v-card-text class="pa-0">
            <v-data-table
                :loading="!loaded"
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
                    <span @click="showRecords(item, header)">
                        <!-- {{ value }} -->
                        {{ formatAccounting(value) }}
                    </span>
                </template>
            </v-data-table>
            <v-dialog
                v-model="recordsDialog"
                scrollable
                @update:return-value="bus.$emit('recordsDialog:closed')"
                @click:outside.prevent
            >
                <fs-records
                    :bus="bus"
                    :rid="rid"
                    :data="post"
                    :date="date"
                    :lvl="lvl"
                    :name="recordsName"
                    :month="recordsMonth"
                    v-on:reloadTable="reloadTable"
                    v-on:closeReportDialog="closeReportDialog()"
                ></fs-records>
            </v-dialog>
        </v-card-text>
    </v-card>
</template>
<script>
import FsToolbar from "./fsToolbar";
import FsRecords from "./fsRecords";
export default {
    components: {
        FsToolbar,
        FsRecords
    },
    props: ["bus", "rid", "period", "lvl", "search"],
    methods: {
        getReportData() {
            if (!this.period) return;
            if (!this.lvl) return;
            if (!this.rid) return;

            this.loaded = false;

            let postData = {
                year: this.period.year,
                company: localStorage.getItem("company"),
                lvl: this.lvl.data,
                report: this.rid
            };

            axios
                .post("dw/report", postData)
                .then(response => {
                    this.report = response.data;
                    setTimeout(() => {
                        this.loaded = true;
                    }, 100);
                })
                .catch(response => {
                    console.error(response);
                });
        },
        formatAccounting(value) {
            if (isNaN(value) || value === null) {
                return value;
            }
            let val = parseFloat(value);
            let currsym = this.currency_symbol;

            if (val >= 0) {
                return (
                    currsym +
                    " " +
                    val.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,")
                );
            } else {
                let nv = val * -1;
                return (
                    currsym +
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
                // {
                //     text: "Branch",
                //     value: "branch",
                //     currency: false,
                //     sortable: false,
                //     class: "dttit_header",
                //     cellClass: "dttit",
                //     group: ["jan", "q1", "yearly"]
                // },
                {
                    text: "",
                    value: "name",
                    currency: false,
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
        showRecords(item, header) {
            if (header.cellClass != "month") return;
            if (item.row_class == "result-row") return;
            this.date = new Date(
                header.value + "-" + this.period.year
            ).toISOString();
            this.recordsName = item.name;
            this.recordsMonth = header.value;

            let postData = {
                year: this.period.year,
                month: header.value,
                company: localStorage.getItem("company"),
                report: this.rid,
                lvl: this.lvl.data,
                name: item.name
            };

            axios
                .post("fact/records", postData)
                .then(response => {
                    this.post = response.data;
                })
                .catch(response => {
                    console.error(response);
                });
            if (!this.recordsDialog) {
                this.recordsDialog = true;
            }
            return;
        },
        reloadTable($payload) {
            this.getReportData();
            this.showRecords($payload.item, $payload.header);
            console.log($payload);
        },
        closeReportDialog() {
            this.post = undefined;
            this.recordsDialog = false;
            this.date = "";
        }
    },
    data: () => ({
        loaded: true,
        currency_symbol: "$",
        report: undefined,
        recordsDialog: false,
        date: "",
        recordsName: "",
        recordsMonth: "",
        post: undefined,
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
                group: ["q1", "qa", "yearly"]
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
                group: ["q2", "qa", "yearly"]
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
                group: ["q3", "qa", "yearly"]
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
                group: ["q4", "qa", "yearly"]
            },
            {
                text: "Year",
                align: "center",
                value: "yar",
                currency: true,
                sortable: false,
                class: "years_header",
                cellClass: "years",
                group: ["qa", "yearly"]
            }
        ]
    }),
    created() {
        this.getReportData();
    },
    mounted() {
        this.bus.$on("companyChange", this.getReportData);
    },
    watch: {
        period: {
            handler() {
                this.getReportData();
            },
            deep: true
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
