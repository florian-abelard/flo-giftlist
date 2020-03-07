import Vue from "vue";
import VueRouter from "vue-router";
import Home from "../views/Home";
import IdeaList from "../views/IdeaList";

Vue.use(VueRouter);

export default new VueRouter({
    mode: "history",
    routes: [
        { path: "/home", component: Home },
        { path: "/idea/list", component: IdeaList },
        { path: "*", redirect: "/home" }
    ]
});
