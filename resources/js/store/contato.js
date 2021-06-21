import { getField, updateField } from "vuex-map-fields";
export default {
    namespaced: true,
    state: {
        telefone: "",
        celular: ""
    },
    getters: {
        getField
    },
    mutations: {
        updateField
    }
};
