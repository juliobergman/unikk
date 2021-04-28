<template>
    <v-main>
        <v-data-table
            @click:row="goToCollection"
            hide-default-footer
            :headers="headers"
            :items="collection"
            item-key="id"
            :loading="!loaded"
            class="elevation-2"
        ></v-data-table>
    </v-main>
</template>

<script>
export default {
    props: [],
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
                .get("chart/collections/" + 1)
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
        }
    },
    computed: {},
    created() {
        this.getCollections();
    }
};
</script>

<style></style>
