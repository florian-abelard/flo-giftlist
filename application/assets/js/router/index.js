import Vue from "vue";
import VueRouter from "vue-router";
import Home from "../views/Home";
import IdeaList from "../views/IdeaList";
import IdeaCreate from "../views/IdeaCreate";
import IdeaDetail from "../views/IdeaDetail";

Vue.use(VueRouter);

export default new VueRouter({
    mode: "history",
    routes: [
        { path: "/home", component: Home },
        { path: "/idea/list", component: IdeaList },
        { path: "/idea/create", component: IdeaCreate },
        { path: "/idea/:id", component: IdeaDetail },
        { path: "*", redirect: "/home" }
    ]
});
