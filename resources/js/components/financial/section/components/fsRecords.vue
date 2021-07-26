<template>
    <v-card>
        <v-toolbar flat color="primary" dark>
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
                sort-by="code"
            >
                <!-- Formater -->
                <template v-slot:item.amount="{ item, header, value }">
                    {{ formatAccounting(value) }}
                </template>
                <!-- Date -->
                <template v-slot:item.created_at="{ item }">
                    {{ moment(item.created_at).format("DD-MM-YYYY") }}
                </template>
                <!-- Tools -->
                <template v-slot:item.delete="{ item }">
                    <v-icon small @click="destroy(item)">
                        mdi-delete
                    </v-icon>
                </template>
                <!-- Summary -->
                <template slot="body.append">
                    <tr class="border-top">
                        <th></th>
                        <th class="body-1 font-weight-medium">Total</th>
                        <th class="body-1 font-weight-medium">{{ total() }}</th>
                        <th></th>
                        <th></th>
                    </tr>
                </template>
            </v-data-table>
        </v-card-text>
        <confirm ref="confirm"></confirm>
        <alert ref="alert"></alert>
    </v-card>
</template>

<script>
import confirm from "../../../ui/confirm";
import alert from "../../../ui/alert";
export default {
    props: ["bus", "data", "date", "lvl", "name", "month"],
    components: {
        confirm,
        alert
    },
    data: () => ({
        currency_symbol: "$",
        headers: [
            // { text: "id", value: "id" },
            { text: "Code", value: "code" },
            { text: "Name", value: "name" },
            // {text: "Name", value: "date"},
            { text: "Amount", value: "amount" },
            { text: "Created", value: "created_at" },
            {
                text: "Delete",
                value: "delete",
                align: "center",
                sortable: false
            }
        ]
    }),
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
        destroy(item) {
            let message = "Do you really want to DELETE this Record?";
            this.$refs.confirm
                .open("Delete Record", message, { color: "danger" })
                .then(response => {
                    if (response) {
                        axios
                            .delete("fact/destroy/" + item.id)
                            .then(response => {
                                if (response.status == 200) {
                                    this.$refs.alert.open(
                                        "Record Deleted",
                                        "Record Successfully Deleted",
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

                                    this.$emit("reloadTable", reloadData);
                                }
                            })
                            .catch(response => {
                                console.error(response);
                            });
                    }
                })
                .catch(response => {});
        }
    }
};
</script>

<style></style>
