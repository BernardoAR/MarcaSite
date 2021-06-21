import { getField, updateField } from "vuex-map-fields";
export default {
    namespaced: true,
    state: {
        id: "",
        logradouro: "",
        numero: "",
        cidade: "",
        uf: "",
        complemento: "",
        cep: ""
    },
    getters: {
        getField
    },
    mutations: {
        updateField
    }
};
