<template>
    <v-card
        :max-height="mheight"
        class="overcard pt-4"
        flat
        :outlined="!darkTheme"
    >
        <v-card-text class="pt-0" v-for="(item, idx) in items" :key="idx">
            <spark
                :bus="bus"
                :darkTheme="darkTheme"
                :name="item.name"
                :labels="item.labels"
                :value="item.value"
            ></spark>
            <v-divider v-if="idx < items.length - 1"></v-divider>
        </v-card-text>
    </v-card>
</template>

<script>
import axios from "axios";
import Spark from "./sparkLine";
export default {
    props: ["bus", "darkTheme", "mheight"],
    components: {
        Spark
    },
    data: () => ({
        year: new Date().getFullYear(),
        items: []
    }),
    methods: {
        getSparks() {
            let postData = {
                year: this.year,
                company: localStorage.getItem("company")
            };

            axios
                .post("result/spark", postData)
                .then(response => {
                    if (response.status == 200) {
                        this.items = response.data;
                    }
                })
                .catch(response => {
                    console.error(response);
                });
        }
    },
    created() {
        this.getSparks();
    }
};
</script>

<style scoped>
.overcard {
    display: flex !important;
    flex-direction: column;
    flex-grow: 1;
    overflow: auto;
}
</style>
