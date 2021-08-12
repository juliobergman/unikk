<template>
    <v-toolbar flat rounded dense class="v-toolbar__no_pad mb-2">
        <v-menu offset-y>
            <template v-slot:activator="{ on, attrs }">
                <v-btn text tile height="48" v-bind="attrs" v-on="on">
                    {{ reportData.name }}
                </v-btn>
            </template>
            <v-list>
                <v-list-item-group v-model="reportData" mandatory>
                    <v-list-item
                        v-for="(item, i) in reportMenu"
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
        <!-- Add Btn -->
        <fs-add-btn :bus="bus" :report="report"></fs-add-btn>
        <!-- Year Menu -->
        <v-menu offset-y>
            <template v-slot:activator="{ on, attrs }">
                <v-btn text tile height="48" v-bind="attrs" v-on="on">
                    {{ year }}
                </v-btn>
            </template>
            <v-list>
                <v-list-item-group
                    v-model="year"
                    mandatory
                    @change="bus.$emit('year:change', year)"
                >
                    <v-list-item
                        v-for="(item, i) in yearButtons"
                        :key="i"
                        :value="item.year"
                    >
                        <v-list-item-content>
                            <v-list-item-title
                                v-text="item.year"
                            ></v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list-item-group>
            </v-list>
        </v-menu>
    </v-toolbar>
</template>

<script>
import fsAddBtn from "./fsAddBtn";
export default {
    components: { fsAddBtn },
    props: ["bus", "report", "period"],
    data: () => ({
        year: undefined,
        yearButtons: [],
        reportMenu: []
    }),
    computed: {
        reportData: {
            get() {
                return this.report;
            },
            set(val) {
                this.bus.$emit("report:update", val);
            }
        }
    },
    methods: {
        getReportMenu() {
            axios
                .post("report/all")
                .then(response => {
                    this.reportMenu = response.data;
                })
                .catch(response => {
                    console.error(response);
                });
        },
        getYears() {
            axios
                .get("date/years")
                .then(response => {
                    this.yearButtons = response.data;
                })
                .catch(response => {
                    console.error(response);
                });
        }
    },
    created() {
        this.getReportMenu();
        this.getYears();
        this.year = this.period.year;
    }
};
</script>

<style></style>
