<template>
    <v-main>
        <v-toolbar class="mb-3" rounded elevation="2" dense>
            <v-toolbar-title>Charts </v-toolbar-title>
            <!-- Left Side Finish -->
            <v-spacer></v-spacer>
            <!-- Right Side Start -->
            <v-tooltip bottom>
                <template v-slot:activator="{ on, attrs }">
                    <v-btn
                        icon
                        @click="newCollection()"
                        v-bind="attrs"
                        v-on="on"
                    >
                        <v-icon>
                            mdi-folder-plus-outline
                        </v-icon>
                    </v-btn>
                </template>
                <span>Add New Folder</span>
            </v-tooltip>
        </v-toolbar>

        <v-data-table
            @click:row="goToCollection"
            :headers="headers"
            :items="collection"
            item-key="id"
            :loading="!loaded"
            class="row-pointer elevation-2"
            :footer-props="{
                showFirstLastPage: true,
                itemsPerPageOptions: [10]
            }"
        >
            <template v-slot:item.created_at="{ item }">
                {{ moment(item.created_at).format("DD-MM-YYYY") }}
            </template>
        </v-data-table>
    </v-main>
</template>

<script>
export default {
    props: ["bus"],
    data: () => ({
        loaded: false,
        headers: [
            { text: "Name", value: "name" },
            {
                text: "Date",
                value: "created_at",
                align: "center"
            }
        ],
        collection: []
    }),
    methods: {
        getCollections() {
            if (this.company) {
                axios
                    .get("chart/collections/" + this.company)
                    .then(response => {
                        this.collection = response.data;
                        this.loaded = true;
                    })
                    .catch(response => {});
            }
        },
        goToCollection(collection) {
            this.$router.push({
                name: "chartCollection",
                params: { collection: collection.id }
            });
        },
        convertDate(date) {
            let dateData, dateObject, dateReadable;
            dateData = "07-21-14"; //For example
            dateObject = new Date(Date.parse(dateData));
            dateReadable = dateObject.toDateString();
        },
        newCollection() {
            this.bus.$emit("showFDialog");
        }
    },
    computed: {
        company() {
            return this.$store.state.membership.company_id;
        }
    },
    created() {
        this.getCollections();
    },
    mounted() {
        this.bus.$on("companyChange", this.getCollections);
        this.bus.$on("closeDialog", this.getCollections);
        this.bus.$on("reloadCollectionList", this.getCollections);
    }
};
</script>
<style>
.row-pointer > .v-data-table__wrapper > table > tbody > tr :hover {
    cursor: pointer;
}
</style>
