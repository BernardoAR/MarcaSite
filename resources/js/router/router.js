import Login from "../view/Login.vue";
import Cadastro from "../view/Cadastro.vue";

const routes = [
    {
        path: "/",
        name: "login",
        component: Login
    },
    {
        path: "/cadastro",
        name: "cadastro",
        component: Cadastro
    }
];
export default routes;
