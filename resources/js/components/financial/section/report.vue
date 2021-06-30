<template>
    <v-main>
        <h5>Financial Report</h5>
        <v-divider></v-divider>
        <v-data-table
            :headers="headers"
            :items="data"
            :single-expand="true"
            :expanded.sync="expanded"
            show-expand
            item-key="id"
        >
            <template v-slot:expanded-item="{ headers, item }">
                <tr>
                    <td class="text-start">
                        <v-btn icon>
                            <v-icon>
                                <mdi-chevron></mdi-chevron>
                            </v-icon>
                        </v-btn>
                    </td>
                    <td class="text-start">{{ item.id }}</td>
                    <td class="text-start">{{ item.name }}</td>
                </tr>
            </template>
        </v-data-table>
    </v-main>
</template>
<script>
// <tr
//     class=""
// ><td class="text-start"><button type="button" class="v-icon notranslate v-data-table__expand-icon v-icon--link mdi mdi-chevron-down theme--light v-data-table__expand-icon--active"></button></td><td class="text-start">1</td><td class="text-start">Income</td></tr>

export default {
    props: ["bus"],
    data: () => ({
        expanded: [],
        headers: [
            { text: "id", value: "id" },
            { text: "name", value: "name" }
        ],
        report: undefined,
        data: undefined
    }),
    methods: {
        getReport() {
            axios
                .get("financial/schema/show/1")
                .then(response => {
                    this.report = response.data;
                    this.data = response.data.data;
                })
                .catch(response => {});
        }
    },
    created() {
        this.getReport();
    }
};
</script>

<style>
/*         <v-container>
            <div v-for="(item, i1) in data" :key="i1">
                <v-row>
                    <v-col cols="1">1</v-col>
                    <v-col>{{ item.name }}</v-col>
                </v-row>
                <div
                    v-if="item.children.length"
                    v-for="(child, i2) in item.children"
                    :key="i2"
                >
                    <v-row>
                        <v-col cols="1">2</v-col>
                        <v-col>{{ child.name }}</v-col>
                    </v-row>
                    <div
                        v-if="child.children.length"
                        v-for="(child2, i3) in child.children"
                        :key="i3"
                    >
                        <v-row>
                            <v-col cols="1">3</v-col>
                            <v-col>{{ child2.name }}</v-col>
                        </v-row>
                    </div>
                </div>
            </div>
        </v-container> */
</style>
