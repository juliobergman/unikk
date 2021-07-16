<template>
    <div>
        <v-card-text v-text="title" class="title pb-0"> </v-card-text>
        <v-card-text v-text="subtitle" class="subtitle-1 pt-0"> </v-card-text>
        <v-card-text v-show="showInfo" v-text="info" class="subtitle-2 pt-0">
        </v-card-text>
    </div>
</template>

<script>
import axios from "axios";
export default {
    props: ["bus", "report"],
    data: () => ({
        loaded: true,
        title: "",
        subtitle: "",
        info: "",
        showInfo: false
    }),
    methods: {
        getInfo() {
            this.loaded = false;

            let postData = {
                id: this.report
            };

            axios
                .post("report/getinfo", postData)
                .then(response => {
                    this.title = response.data.title;
                    this.subtitle = response.data.subtitle;
                    this.info = response.data.info;

                    setTimeout(() => {
                        this.loaded = true;
                    }, 100);
                })
                .catch(response => {});
        }
    },
    created() {
        this.getInfo();
    }
};
</script>

<style></style>
