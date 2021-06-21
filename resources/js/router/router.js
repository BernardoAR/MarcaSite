import Login from "../view/Login.vue";
import Cadastro from "../view/Cadastro.vue";
import Home from "../view/App/Home.vue";
import CursoCad from "../view/App/Curso/CursoCad.vue";
import CursoList from "../view/App/Curso/CursoList.vue";
import InscricaoCad from "../view/App/Inscricao/InscricaoCad.vue";
import InscricaoList from "../view/App/Inscricao/InscricaoList.vue";
import UsuarioCad from "../view/App/Usuario/UsuarioCad.vue";
import UsuarioList from "../view/App/Usuario/UsuarioList.vue";
const routes = [
    {
        path: "/",
        component: Login,
        meta: { precisaLogin: false }
    },
    {
        path: "/login",
        component: Login,
        meta: { precisaLogin: false }
    },
    {
        path: "/cadastro",
        component: Cadastro,
        meta: { precisaLogin: true }
    },
    {
        path: "/home",
        component: Home,
        meta: { precisaLogin: true }
    },
    {
        path: "/curso/cad",
        component: CursoCad,
        meta: { precisaLogin: true }
    },
    {
        path: "/curso/edit/:id",
        component: CursoCad,
        meta: { precisaLogin: true }
    },
    {
        path: "/curso/list",
        component: CursoList,
        meta: { precisaLogin: true }
    },
    {
        path: "/inscricao/cad",
        component: InscricaoCad,
        meta: { precisaLogin: true }
    },
    {
        path: "/inscricao/edit/:id",
        component: InscricaoCad,
        meta: { precisaLogin: true }
    },
    {
        path: "/inscricao/list",
        component: InscricaoList,
        meta: { precisaLogin: true }
    },
    {
        path: "/usuario/cad",
        component: UsuarioCad,
        meta: { precisaLogin: true }
    },
    {
        path: "/usuario/edit/:id",
        component: UsuarioCad,
        meta: { precisaLogin: true }
    },
    {
        path: "/usuario/list",
        component: UsuarioList,
        meta: { precisaLogin: true }
    }
];
export default routes;
