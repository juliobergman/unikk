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
import newPieChart from "../components/charts/new/pie";

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
        path: "/chart-build",
        children: [
            {
                component: newBarChart,
                name: "newbarchart",
                path: "bar",
                children: [
                    {
                        component: newBarChart,
                        name: "barChartUpdate",
                        path: ":id"
                    }
                ]
            },
            {
                component: newLineChart,
                name: "newlinechart",
                path: "line",
                children: [
                    {
                        component: newLineChart,
                        name: "lineChartUpdate",
                        path: ":id"
                    }
                ]
            },
            {
                component: newPieChart,
                name: "newpiechart",
                path: "pie",
                children: [
                    {
                        component: newPieChart,
                        name: "pieChartUpdate",
                        path: ":id"
                    }
                ]
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
