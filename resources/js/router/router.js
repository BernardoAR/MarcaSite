import Login from "../view/Login.vue";
import Cadastro from "../view/Cadastro.vue";
import Home from "../view/App/Home.vue";
import CursoCad from "../view/App/Curso/CursoCad.vue";
import CursoList from "../view/App/Curso/CursoList.vue";
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
    },
    {
        path: "/home",
        name: "home",
        component: Home
    },
    {
        path: "/curso/cad",
        name: "cursoCad",
        component: CursoCad
    },
    {
        path: "/curso/list",
        name: "cursoList",
        component: CursoList
    }
];
export default routes;
