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
        { path: "/", name: 'home', component: Home },
        { path: "/idea/list", name: 'ideaList', component: IdeaList },
        { 
            path: "/idea/create", 
            name: 'ideaCreate', 
            component: IdeaCreate,
            props: true
        },
        { path: "/idea/:id", name: 'idea', component: IdeaDetail },
        { path: "*", redirect: "/" }
    ]
});
