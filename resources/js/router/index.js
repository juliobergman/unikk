import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

// Website
// import wsMain from "../components/website/main";
// Admin
import Dashboard from "../components/dashboard/container";
// User
import Users from "../components/user/container";
import Account from "../components/user/accountContainer.vue";
import Company from "../components/company/container";
// Charts Retrieve
import Charts from "../components/charts/container";
import chartList from "../components/charts/views/list";
import chartCollection from "../components/charts/views/collection";
import chartView from "../components/charts/views/view";
// Charts Build
import newChart from "../components/charts/new/container";
import newBarChart from "../components/charts/new/bar";
import newLineChart from "../components/charts/new/line";
import newPieChart from "../components/charts/new/pie";
//Contacts
import Contact from "../components/contact/container";
import ContactProfile from "../components/contact/contactProfile";
//Peccs
import Pecc from "../components/pecc/container";
import PeccProfile from "../components/pecc/peccProfile";
//Target
import Target from "../components/target/container";
import TargetProfile from "../components/target/targetProfile";
// Reporting
import Financial from "../components/financial/container";
import FinancialReport from "../components/financial/section/report";

const routes = [
    {
        component: Company,
        name: "company",
        path: "/company",
        meta: { section: "company" }
    },
    {
        component: Account,
        name: "account",
        path: "/account",
        meta: { section: "account" }
    },
    {
        component: Users,
        name: "users",
        path: "/users",
        meta: { section: "users" }
    },
    {
        component: Dashboard,
        name: "dashboard",
        path: "/",
        meta: { section: "dashboard" }
    },
    {
        component: Charts,
        path: "/charts",
        meta: { section: "charts" },
        children: [
            {
                component: chartList,
                name: "charts",
                path: "",
                meta: { section: "charts" }
            },
            {
                component: chartCollection,
                name: "chartCollection",
                path: "collection/:collection",
                meta: { section: "charts" }
            },
            {
                component: chartView,
                name: "chartView",
                path: "collection/:collection/:id",
                meta: { section: "charts" }
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
        path: "/contact",
        meta: { section: "contact" }
    },
    {
        component: ContactProfile,
        name: "contactProfile",
        path: "/contact/:id",
        meta: { section: "contact" }
    },
    {
        component: Pecc,
        name: "pecc",
        path: "/pecc",
        meta: { section: "pecc" }
    },
    {
        component: PeccProfile,
        name: "peccProfile",
        path: "/pecc/:id/:ref?",
        meta: { section: "pecc" }
    },
    {
        component: Target,
        name: "target",
        path: "/target",
        meta: { section: "target" }
    },
    {
        component: TargetProfile,
        name: "targetProfile",
        path: "/target/:id/:ref?",
        meta: { section: "target" }
    },
    {
        component: Financial,
        name: "financial",
        path: "/financial",
        meta: { section: "financial" }
    },
    {
        component: FinancialReport,
        name: "financialReport",
        path: "/financial/report",
        meta: { section: "financial" }
    }
];

export default new VueRouter({
    routes
});
