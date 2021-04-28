<template>
    <v-main>
        <v-data-table
            @click:row="goToCollection"
            :headers="headers"
            :items="collection"
            item-key="id"
            :loading="!loaded"
            class="elevation-2"
            :footer-props="{
                showFirstLastPage: true,
                itemsPerPageOptions: [10]
            }"
        ></v-data-table>
    </v-main>
</template>

<script>
export default {
    props: ["bus"],
    data: () => ({
        loaded: false,
        headers: [
            { text: "Name", value: "name" },
            { text: "Date", value: "created_at" }
        ],
        collection: []
    }),
    methods: {
        getCollections() {
            axios
                .get("chart/collections/" + this.company)
                .then(response => {
                    console.log(response.data);
                    this.collection = response.data;
                    this.loaded = true;
                })
                .catch(response => {});
        },
        goToCollection(collection) {
            console.log(collection.id);
            this.$router.push({
                name: "chartCollection",
                params: { id: collection.id }
            });
        },
        convertDate(date) {
            let dateData, dateObject, dateReadable;
            dateData = "07-21-14"; //For example
            dateObject = new Date(Date.parse(dateData));
            dateReadable = dateObject.toDateString();
        }
    },
    computed: {
        company() {
            return this.$store.state.membership.company;
        }
    },
    created() {
        this.getCollections();
    },
    mounted() {
        this.bus.$on("companyChange", this.getCollections);
    },
    watch: {
        company() {
            this.getCollections();
        }
    }
};
</script>

<style></style>
