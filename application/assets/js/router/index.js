import Vue from "vue";
import VueRouter from "vue-router";
import Home from "../views/Home";
import IdeaList from "../views/idea/IdeaList";
import IdeaDetail from "../views/idea/IdeaDetail";
import IdeaCreate from "../views/idea/IdeaCreate";
import GiftList from "../views/gift/GiftList";
import GiftDetail from "../views/gift/GiftDetail";
import GiftCreate from "../views/gift/GiftCreate";

Vue.use(VueRouter);

export default new VueRouter({
    mode: "history",
    routes: [
        { path: "/", name: 'home', component: Home },
        { path: "/ideas", name: 'ideaList', component: IdeaList },
        { path: "/ideas/create", name: 'ideaCreate', component: IdeaCreate, props: true },
        { path: "/ideas/:id", name: 'idea', component: IdeaDetail },
        { path: "/gifts", name: 'giftList', component: GiftList },
        { path: "/gifts/create", name: 'giftCreate', component: GiftCreate, props: true },
        { path: "/gifts/:id", name: 'gift', component: GiftDetail },
        { path: "*", redirect: "/" }
    ]
});
