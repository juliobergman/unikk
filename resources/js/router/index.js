import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

import User from "../components/user/container";
import Dashboard from "../components/dashboard/container";
import Contact from "../components/contact/container";
import Charts from "../components/charts/container";
import viewChart from "../components/charts/view";
import newChart from "../components/charts/new/container";
import newBarChart from "../components/charts/new/bar";
import newLineChart from "../components/charts/new/line";

const routes = [
    {
        component: User,
        name: "userprofile",
        path: "/user/:id"
    },
    {
        component: Dashboard,
        name: "dashboard",
        path: "/dashboard"
    },
    {
        component: Charts,
        name: "charts",
        path: "/charts",
        children: [
            {
                component: viewChart,
                name: "viewChart",
                path: "view/:id"
            }
        ]
    },
    {
        component: newChart,
        name: "newchart",
        path: "/chart-new",
        children: [
            {
                component: newBarChart,
                name: "newbarchart",
                path: "/bar",
                children: [
                    {
                        component: newBarChart,
                        name: "updatebarchart",
                        path: ":id"
                    }
                ]
            },
            {
                component: newLineChart,
                name: "newlinechart",
                path: "/line"
            }
        ]
    },
    {
        component: Contact,
        name: "contact",
        path: "/contact"
    }
];

export default new VueRouter({
    routes // Short for routes: routes
});
