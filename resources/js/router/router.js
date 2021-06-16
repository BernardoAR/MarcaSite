import Home from "../view/Home.vue";
import Hello from "../view/Hello.vue";
import Example from "../view/Example.vue";

const routes = [
    {
        path: "/",
        name: "home",
        component: Home
    },
    {
        path: "/hello",
        name: "hello",
        component: Hello
    },
    {
        path: "/example",
        name: "example",
        component: Example
    }
];
export default routes;
