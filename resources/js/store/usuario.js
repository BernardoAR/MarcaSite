import { getField, updateField } from "vuex-map-fields";
export default {
    namespaced: true,
    state: {
        id: null,
        email: "",
        tipo: null,
        nome: "",
        senha: "",
        confSenha: "",
        dadosUsuario: {
            cpf: "",
            empresa: "",
            profissao: null
        }
    },
    getters: {
        getField
    },
    mutations: {
        updateField
    }
};
