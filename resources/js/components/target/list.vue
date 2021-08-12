<template>
    <div>
        <!-- Tools -->
        <v-toolbar flat rounded dense>
            <v-text-field
                solo
                flat
                background-color="transparent"
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
                        <new-target-dialog></new-target-dialog>
                    </div>
                </template>
                <span>Add New Terget Company</span>
            </v-tooltip>
        </v-toolbar>

        <v-divider></v-divider>

        <!-- Table -->
        <v-data-table
            @click:row="showTarget"
            :headers="headers"
            :items="targets"
            :items-per-page="itemsperpage"
            :search="search"
            item-key="id"
            :loading="!loaded"
            :footer-props="{
                showFirstLastPage: true,
                itemsPerPageOptions: [10]
            }"
        >
        </v-data-table>
    </div>
</template>

<script>
import newTargetDialog from "./newTargetDialog";
export default {
    props: ["bus"],
    components: {
        newTargetDialog
    },
    data: () => ({
        loaded: true,
        search: "",
        itemsperpage: 10,
        headers: [
            {
                text: "Name",
                value: "name",
                align: "left"
            },
            { text: "City", value: "company_data.city" },
            { text: "Country", value: "company_data.country" }
        ],
        targets: []
    }),
    methods: {
        getTargets() {
            this.loaded = false;
            axios
                .get("target/list/" + localStorage.getItem("company"))
                .then(response => {
                    this.targets = response.data;
                    this.loaded = true;
                })
                .catch(response => {
                    console.error(response);
                });
        },
        showTarget(target) {
            this.$router.push({
                name: "targetProfile",
                params: { id: target.id }
            });
        }
    },
    created() {
        this.getTargets();
    },
    mounted() {
        this.bus.$on("companyChange", this.getTargets);
    }
};
</script>

<style scoped>
.contacts .datatable thead th.column.sortable i {
    display: none;
}
</style>
