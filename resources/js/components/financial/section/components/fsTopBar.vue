<template>
    <v-toolbar flat rounded dense class="v-toolbar__no_pad mb-2">
        <v-menu offset-y>
            <template v-slot:activator="{ on, attrs }">
                <v-btn
                    text
                    tile
                    height="48"
                    v-bind="attrs"
                    v-on="on"
                    v-text="dataPeriod.window.name"
                >
                </v-btn>
            </template>
            <v-list>
                <v-list-item-group v-model="dataWindow" mandatory>
                    <v-list-item
                        v-for="(item, i) in periodButtons"
                        :key="i"
                        :value="item"
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
        <v-menu offset-y v-if="qbtn">
            <template v-slot:activator="{ on, attrs }">
                <v-btn
                    text
                    tile
                    height="48"
                    v-bind="attrs"
                    v-on="on"
                    v-text="dataPeriod.quarter.name"
                >
                </v-btn>
            </template>
            <v-list>
                <v-list-item-group v-model="dataQuarter" mandatory>
                    <v-list-item
                        v-for="(item, i) in quarterButtons"
                        :key="i"
                        :value="item"
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
        <v-menu offset-y v-if="mbtn">
            <template v-slot:activator="{ on, attrs }">
                <v-btn
                    text
                    tile
                    height="48"
                    v-bind="attrs"
                    v-on="on"
                    v-text="dataPeriod.month.name"
                >
                </v-btn>
            </template>
            <v-list>
                <v-list-item-group v-model="dataMonth" mandatory>
                    <v-list-item
                        v-for="(item, i) in monthButtons"
                        :key="i"
                        :value="item"
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
        <v-menu offset-y v-if="false">
            <template v-slot:activator="{ on, attrs }">
                <v-btn text tile height="48" v-bind="attrs" v-on="on">
                    <v-icon>
                        mdi-content-duplicate
                    </v-icon>
                </v-btn>
            </template>
            <v-list>
                <v-list-item-group mandatory>
                    <v-list-item
                        v-for="(item, i) in menuReports"
                        :key="i"
                        :value="item"
                        @click="addReport(item)"
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
        <v-menu offset-y>
            <template v-slot:activator="{ on, attrs }">
                <v-btn
                    text
                    tile
                    height="48"
                    v-bind="attrs"
                    v-on="on"
                    v-text="dataLevel.name"
                >
                </v-btn>
            </template>
            <v-list>
                <v-list-item-group v-model="dataLevel" mandatory>
                    <v-list-item
                        v-for="(item, i) in levelButtons"
                        :key="i"
                        :value="item"
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
    </v-toolbar>
</template>

<script>
export default {
    props: ["bus", "period", "lvl"],
    computed: {
        dataPeriod() {
            return this.period;
        },
        dataWindow: {
            get() {
                return this.period.window;
            },
            set(val) {
                let $newPeriod = this.dataPeriod;
                $newPeriod.window.data = val.data;
                $newPeriod.window.name = val.name;
                this.bus.$emit("period:change", $newPeriod, val.search);
            }
        },
        dataQuarter: {
            get() {
                return this.period.quarter;
            },
            set(val) {
                let $newPeriod = this.dataPeriod;
                $newPeriod.quarter.data = val.data;
                $newPeriod.quarter.name = val.name;
                this.bus.$emit("period:change", $newPeriod, val.search);
            }
        },
        dataMonth: {
            get() {
                return this.period.month;
            },
            set(val) {
                let $newPeriod = this.dataPeriod;
                $newPeriod.month.data = val.data;
                $newPeriod.month.name = val.name;
                this.bus.$emit("period:change", $newPeriod, val.search);
            }
        },
        dataLevel: {
            get() {
                return this.lvl;
            },
            set(val) {
                this.bus.$emit("level:change", val);
            }
        },
        qbtn() {
            return this.dataPeriod.window.data == "quarterly" ? true : false;
        },
        mbtn() {
            return this.dataPeriod.window.data == "monthly" ? true : false;
        }
    },
    data: () => ({
        periodButtons: [
            { data: "yearly", name: "by Year", search: "yearly" },
            { data: "quarterly", name: "by Quarter", search: "qa" },
            { data: "monthly", name: "by Month", search: "jan" }
        ],
        monthButtons: [
            { data: "jan", name: "January", search: "jan" },
            { data: "feb", name: "February", search: "feb" },
            { data: "mar", name: "March", search: "mar" },
            { data: "apr", name: "April", search: "apr" },
            { data: "may", name: "May", search: "may" },
            { data: "jun", name: "June", search: "jun" },
            { data: "jul", name: "July", search: "jul" },
            { data: "aug", name: "August", search: "aug" },
            { data: "sep", name: "September", search: "sep" },
            { data: "oct", name: "October", search: "oct" },
            { data: "nov", name: "November", search: "nov" },
            { data: "dec", name: "December", search: "dec" }
        ],
        quarterButtons: [
            { data: "qa", name: "Only Quarters", search: "qa" },
            { data: "q1", name: "First Quarter", search: "q1" },
            { data: "q2", name: "Second Quarter", search: "q2" },
            { data: "q3", name: "Third Quarter", search: "q3" },
            { data: "q4", name: "Four Quarter", search: "q4" }
        ],
        levelButtons: [
            { data: "lvl1", name: "Level 1" },
            { data: "lvl2", name: "Level 2" },
            { data: "lvl3", name: "Level 3" }
        ]
    }),
    methods: {
        getMenuReports() {
            axios
                .post("report/all")
                .then(response => {
                    if (response.status == 200) {
                        this.menuReports = response.data;
                    }
                })
                .catch(response => {
                    console.error(response);
                });
        }
    },
    created() {
        this.getMenuReports();
    }
};
</script>

<style></style>
