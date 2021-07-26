<template>
    <v-toolbar flat dense class="v-toolbar__no_pad mb-2">
        <v-menu offset-y>
            <template v-slot:activator="{ on, attrs }">
                <v-btn
                    text
                    tile
                    height="48"
                    color="primary"
                    v-bind="attrs"
                    v-on="on"
                >
                    {{ report.name }}
                </v-btn>
            </template>
            <v-list>
                <v-list-item-group v-model="report" color="primary" mandatory>
                    <v-list-item
                        v-for="(item, i) in reportMenu"
                        :key="i"
                        :value="item"
                        @click="$emit('changeReport', item)"
                    >
                        <v-list-item-content>
                            <v-list-item-title
                                v-text="item.name"
                            ></v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list-item-group>
            </v-list>
        </v-menu>
        <v-spacer></v-spacer>
        <!-- Year Menu -->
        <v-menu offset-y>
            <template v-slot:activator="{ on, attrs }">
                <v-btn
                    text
                    tile
                    height="48"
                    color="primary"
                    v-bind="attrs"
                    v-on="on"
                >
                    {{ year }}
                </v-btn>
            </template>
            <v-list>
                <v-list-item-group
                    v-model="year"
                    color="primary"
                    mandatory
                    @change="$emit('changeYear', year)"
                >
                    <v-list-item
                        v-for="(item, i) in yearButtons"
                        :key="i"
                        :value="item"
                    >
                        <v-list-item-content>
                            <v-list-item-title
                                v-text="item"
                            ></v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list-item-group>
            </v-list>
        </v-menu>
        <v-btn
            small
            tile
            text
            height="48"
            width="48"
            color="primary"
            @click="bus.$emit('closeReport', index)"
        >
            <v-icon small>
                mdi-close
            </v-icon>
        </v-btn>
    </v-toolbar>
</template>

<script>
export default {
    props: ["bus", "index", "setreport"],
    data: () => ({
        year: new Date().getFullYear(),
        yearButtons: [2020, 2021, 2022, 2023, 2024, 2025, 2026],
        reportMenu: [],
        report: []
    }),
    methods: {
        getReportMenu() {
            axios
                .get("report/all/income")
                .then(response => {
                    this.reportMenu = response.data;
                    if (this.setreport) {
                        this.report = this.setreport;
                    }
                })
                .then(response => {
                    if (!this.setreport) {
                        this.report = response.data[0];
                        this.$emit("changeReport", this.report);
                    }
                })
                .catch(response => {
                    console.error(response);
                });
        }
    },
    created() {
        this.getReportMenu();
    }
};
</script>

<style>
.v-toolbar__no_pad .v-toolbar__content {
    padding-left: 0 !important;
    padding-right: 0 !important;
}
</style>
