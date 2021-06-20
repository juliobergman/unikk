<template>
    <div>
        <!-- Loader -->
        <v-overlay :value="!loaded" opacity="1" color="background">
            <v-progress-circular :size="30" color="primary" indeterminate>
            </v-progress-circular>
        </v-overlay>
        <!-- Tools -->
        <v-toolbar class="mb-3" elevation="2" flat rounded dense>
            <v-text-field
                flat
                solo
                v-model="search"
                append-icon="mdi-magnify"
                label="Search"
                single-line
                hide-details
                clearable
            ></v-text-field>

            <v-tooltip bottom>
                <template v-slot:activator="{ on, attrs }">
                    <div v-bind="attrs" v-on="on">
                        <new-pecc-dialog></new-pecc-dialog>
                    </div>
                </template>
                <span>Add New Contact</span>
            </v-tooltip>
        </v-toolbar>

        <!-- Table -->
        <v-data-table
            @click:row="showPecc"
            :headers="headers"
            :items="pecc"
            :items-per-page="itemsperpage"
            :search="search"
            item-key="id"
            :loading="!loaded"
            class="elevation-2"
            :footer-props="{
                showFirstLastPage: true,
                itemsPerPageOptions: [10]
            }"
        >
        </v-data-table>
    </div>
</template>

<script>
import newPeccDialog from "./newPeccDialog";
export default {
    props: ["bus"],
    components: {
        newPeccDialog
    },
    data: () => ({
        loaded: true,
        search: "",
        itemsperpage: 10,
        headers: [
            {
                text: "Fund",
                value: "fund",
                align: "left"
            },
            { text: "Type", value: "type" },
            { text: "Region", value: "region" },
            { text: "Based", value: "based" }
        ],
        pecc: []
    }),
    methods: {
        getPecc() {
            this.loaded = false;
            axios
                .get("pecc/list")
                .then(response => {
                    this.pecc = response.data;
                    this.loaded = true;
                })
                .catch(response => {
                    console.error(response);
                });
        },
        showPecc(pecc) {
            this.$router.push({
                name: "peccProfile",
                params: { id: pecc.id }
            });
        }
    },
    created() {
        this.getPecc();
    }
};
</script>

<style scoped>
.contacts .datatable thead th.column.sortable i {
    display: none;
}
</style>
