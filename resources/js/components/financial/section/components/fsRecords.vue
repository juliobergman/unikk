<template>
    <v-card>
        <v-overlay absolute opacity="1" :value="!loaded">
            <v-progress-circular indeterminate></v-progress-circular>
        </v-overlay>
        <v-toolbar flat>
            <v-toolbar-title>
                {{ moment(date).format("MMMM, YYYY") }}
                |
                {{ name }}
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn @click="$emit('closeReportDialog')" icon>
                <v-icon>
                    mdi-close
                </v-icon>
            </v-btn>
        </v-toolbar>
        <v-card-text class="pa-0 h-100">
            <v-data-table
                disable-filtering
                disable-pagination
                hide-default-footer
                calculate-widths
                :headers="headers"
                :items="data"
                item-key="id"
                sort-by="code"
                show-select
                v-model="selected"
            >
                <!-- Formater -->
                <template v-slot:item.amount="{ item, header, value }">
                    {{ formatAccounting(value) }}
                </template>
                <!-- Date -->
                <template v-slot:item.created_at="{ item }">
                    {{ moment(item.created_at).format("DD-MM-YYYY") }}
                </template>
                <!-- Summary -->
                <template slot="body.append">
                    <tr class="border-top">
                        <th></th>
                        <th></th>
                        <th class="body-1 font-weight-medium">Total</th>
                        <th class="body-1 font-weight-medium">{{ total() }}</th>
                        <th></th>
                    </tr>
                </template>
            </v-data-table>
        </v-card-text>
        <v-card-actions>
            <v-btn
                :disabled="bulkDelete"
                :dark="!bulkDelete"
                small
                elevation="0"
                color="danger"
                @click="destroy()"
            >
                <v-icon class="mr-2">
                    mdi-delete
                </v-icon>

                Delete Selected
            </v-btn>
            <v-spacer></v-spacer>
            <v-btn small elevation="0" @click="$emit('closeReportDialog')">
                <v-icon class="mr-2">
                    mdi-close
                </v-icon>

                Close
            </v-btn>
        </v-card-actions>
        <confirm ref="confirm"></confirm>
        <alert ref="alert"></alert>
    </v-card>
</template>

<script>
import confirm from "../../../ui/confirm";
import alert from "../../../ui/alert";
export default {
    props: ["bus", "rid", "rtype", "data", "date", "lvl", "name", "month"],
    components: {
        confirm,
        alert
    },
    data: () => ({
        loaded: true,
        currency_symbol: "$",
        selected: [],
        headers: [
            // { text: "id", value: "id" },
            { text: "Code", value: "code" },
            { text: "Name", value: "name" },
            // {text: "Name", value: "date"},
            { text: "Amount", value: "amount" },
            { text: "Created", value: "created_at" }
            // {
            //     text: "Delete",
            //     value: "delete",
            //     align: "center",
            //     width: 0,
            //     sortable: false
            // }
        ]
    }),
    computed: {
        bulkDelete() {
            return this.selected.length > 0 ? false : true;
        }
    },
    methods: {
        formatAccounting(value) {
            if (isNaN(value)) {
                return value;
            }

            let val = parseFloat(value);

            if (val >= 0) {
                return (
                    this.currency_symbol +
                    " " +
                    val.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,")
                );
            } else {
                let nv = val * -1;
                return (
                    this.currency_symbol +
                    " (" +
                    nv.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,") +
                    ")"
                );
            }
        },
        total() {
            if (!this.data) return;

            let sum = 0;

            this.data.forEach(e => {
                sum += parseFloat(e.amount);
            });

            return this.formatAccounting(sum);
        },
        destroy() {
            let message = "Do you really want to DELETE the selected records?";
            this.$refs.confirm
                .open("Delete Records", message, { color: "danger" })
                .then(response => {
                    if (response) {
                        this.loaded = false;
                        axios
                            .post("fact/destroy/bulk", this.selected)
                            .then(response => {
                                if (response.status == 200) {
                                    this.clear();

                                    axios
                                        .post("etl/extract/" + this.rtype, {
                                            year: this.date.substr(0, 4),
                                            company: localStorage.getItem(
                                                "company"
                                            )
                                        })
                                        .then(response => {
                                            if (response.status == 200) {
                                                this.$refs.alert.open(
                                                    "Records Deleted",
                                                    "Records Successfully Deleted",
                                                    {
                                                        color: "primary"
                                                    }
                                                );
                                                let reloadData = {
                                                    item: {
                                                        row_class: "data-row",
                                                        name: this.name
                                                    },
                                                    header: {
                                                        cellClass: "month",
                                                        value: this.month
                                                    }
                                                };

                                                this.$emit(
                                                    "reloadTable",
                                                    reloadData
                                                );

                                                this.loaded = true;
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
        },
        clear() {
            this.selected = [];
        }
    },
    mounted() {
        this.bus.$on("recordsDialog:closed", this.clear);
    }
};
</script>

<style></style>
