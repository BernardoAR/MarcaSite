import Vue from "vue";
import Vuex from "vuex";
Vue.use(Vuex);
import Usuario from "./store/usuario";

import { createHelpers } from "vuex-map-fields";
const { getField, updateField } = createHelpers({
    getterType: "getField",
    mutationType: "updateField"
});
export default new Vuex.Store({
    state: {
        possuiErroForm: false,
        usuario: false,
        autenticado: false
    },
    modules: {
        usuarioForm: Usuario
    },
    getters: { getField },

    mutations: {
        updateField,
        atualizaUsuario(state, data) {
            state.usuario = data;
        }
    }
});
