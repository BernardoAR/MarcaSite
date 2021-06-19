import { getField, updateField } from "vuex-map-fields";
export default {
    namespaced: true,
    state: {
        id: null,
        email: "",
        empresa: "",
        cargo: null,
        nome: "",
        senha: "",
        confSenha: "",
        dadosUsuarioForm: {
            id: "",
            cpf: "",
            empresa: "",
            tipoUsuario: null
        }
    },
    getters: {
        getField
    },
    mutations: {
        updateField
    }
};
