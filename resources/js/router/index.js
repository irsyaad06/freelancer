import { createRouter, createWebHistory } from "vue-router";

import MainLayout from "../layouts/MainLayout.vue";
import Home from "../pages/Home.vue";
import FreelancerList from "../pages/FreelancerList.vue";
import FreelancerDetail from "../pages/FreelancerDetail.vue";
import RekrutForm from "../pages/RekrutForm.vue";


const routes = [
    {
        path: "/",
        component: MainLayout,
        children: [
            {
                path: "",
                name: "home",
                component: Home,
            },
            {
                path: "jasa/:subcategoryId/freelancer/:freelancerId",
                name: "freelancer.detail",
                component: FreelancerDetail,
            },
            {
                path: "freelancer",
                name: "freelancer.list",
                component: FreelancerList,
            },
            {
                path: "rekrut/jasa/:servicePackageId",
                name: "rekrut",
                component: RekrutForm,
            },
        ],
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
