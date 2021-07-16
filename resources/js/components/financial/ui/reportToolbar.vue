<template>
    <v-toolbar flat rounded dense class="v-toolbar__no_pad mb-2">
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
                    {{ period }}
                </v-btn>
            </template>
            <v-list>
                <v-list-item-group
                    v-model="period"
                    color="primary"
                    mandatory
                    @change="$emit('periodChange', period)"
                >
                    <v-list-item
                        v-for="(item, i) in periodButtons"
                        :key="i"
                        :value="item.value"
                    >
                        <v-list-item-content>
                            <v-list-item-title
                                v-text="item.text"
                            ></v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list-item-group>
            </v-list>
        </v-menu>
        <v-menu offset-y v-if="period == 'monthly'">
            <template v-slot:activator="{ on, attrs }">
                <v-btn
                    text
                    tile
                    height="48"
                    color="primary"
                    v-bind="attrs"
                    v-on="on"
                >
                    {{ month }}
                </v-btn>
            </template>
            <v-list>
                <v-list-item-group
                    v-model="month"
                    color="primary"
                    mandatory
                    @change="$emit('monthChange', month)"
                >
                    <v-list-item
                        v-for="(item, i) in monthButtons"
                        :key="i"
                        :value="item.value"
                    >
                        <v-list-item-content>
                            <v-list-item-title
                                v-text="item.text"
                            ></v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list-item-group>
            </v-list>
        </v-menu>
        <v-menu offset-y v-if="period == 'quarterly'">
            <template v-slot:activator="{ on, attrs }">
                <v-btn
                    text
                    tile
                    height="48"
                    color="primary"
                    v-bind="attrs"
                    v-on="on"
                >
                    {{ quarter }}
                </v-btn>
            </template>
            <v-list>
                <v-list-item-group
                    v-model="quarter"
                    color="primary"
                    mandatory
                    @change="$emit('quarterChange', quarter)"
                >
                    <v-list-item
                        v-for="(item, i) in quarterButtons"
                        :key="i"
                        :value="item.value"
                    >
                        <v-list-item-content>
                            <v-list-item-title
                                v-text="item.text"
                            ></v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list-item-group>
            </v-list>
        </v-menu>
        <v-spacer></v-spacer>
        <v-btn
            tile
            text
            height="48"
            color="primary"
            @click="$emit('addReport')"
        >
            <v-icon>
                mdi-content-copy
            </v-icon>
        </v-btn>
        <v-btn
            to="/financial/statement/add"
            tile
            text
            height="48"
            color="primary"
        >
            <v-icon>
                mdi-playlist-plus
            </v-icon>
        </v-btn>
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
                    {{ lvl }}
                </v-btn>
            </template>
            <v-list>
                <v-list-item-group
                    v-model="lvl"
                    color="primary"
                    mandatory
                    @change="$emit('lvlChange', lvl)"
                >
                    <v-list-item
                        v-for="(item, i) in levelButtons"
                        :key="i"
                        :value="item.value"
                    >
                        <v-list-item-content>
                            <v-list-item-title
                                v-text="item.text"
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
    data: () => ({
        period: "yearly",
        month: "jan",
        quarter: "q1",
        lvl: "lvl1",
        periodButtons: [
            { text: "by Month", value: "monthly" },
            { text: "by Quarter", value: "quarterly" },
            { text: "by Year", value: "yearly" }
        ],
        monthButtons: [
            { text: "January", value: "jan" },
            { text: "February", value: "feb" },
            { text: "March", value: "mar" },
            { text: "April", value: "apr" },
            { text: "May", value: "may" },
            { text: "June", value: "jun" },
            { text: "July", value: "jul" },
            { text: "August", value: "aug" },
            { text: "September", value: "sep" },
            { text: "October", value: "oct" },
            { text: "November", value: "nov" },
            { text: "December", value: "dec" }
        ],
        quarterButtons: [
            { text: "First Quarter", value: "q1" },
            { text: "Second Quarter", value: "q2" },
            { text: "Third Quarter", value: "q3" },
            { text: "Four Quarter", value: "q4" }
        ],
        levelButtons: [
            { text: "Level 1", value: "lvl1" },
            { text: "Level 2", value: "lvl2" },
            { text: "Level 3", value: "lvl3" }
        ]
    })
};
</script>

<style>
.v-toolbar__no_pad .v-toolbar__content {
    padding-left: 0 !important;
    padding-right: 0 !important;
}
</style>
