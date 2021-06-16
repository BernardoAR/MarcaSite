require("./bootstrap");

window.Vue = require("vue").default;
// Bootstrap
import { BootstrapVue, IconsPlugin } from "bootstrap-vue";
import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";
// Router
import App from "./view/App.vue";
import VueRouter from "vue-router";
import routes from "./router/router";
import Vue from "vue";
// Usando com o Vue
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.use(VueRouter);
//C onfigurações do Router
const router = new VueRouter({
    mode: "history",
    base: process.env.BASE_URL,
    routes
});

Vue.component("app", require("./view/App.vue").default);

const app = new Vue({
    el: "#app",
    components: { App },
    router
});
