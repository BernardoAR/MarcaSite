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
        component: Login
    },
    {
        path: "/login",
        component: Login
    },
    {
        path: "/cadastro",
        component: Cadastro
    },
    {
        path: "/home",
        component: Home
    },
    {
        path: "/curso/cad",
        component: CursoCad
    },
    {
        path: "/curso/list",
        component: CursoList
    },
    {
        path: "/inscricao/cad",
        component: InscricaoCad
    },
    {
        path: "/inscricao/list",
        component: InscricaoList
    },
    {
        path: "/usuario/cad",
        component: UsuarioCad
    },
    {
        path: "/usuario/edit/:idP",
        component: UsuarioCad
    },
    {
        path: "/usuario/list",
        component: UsuarioList
    }
];
export default routes;
