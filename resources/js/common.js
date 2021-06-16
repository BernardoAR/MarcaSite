import axios from "axios";

/**
 * JS para configurações comuns que todo o JS pode precisar.
 */
export default {
    data() {
        return {};
    },
    methods: {
        // Método genérico para a chamada de apis
        async chamaApi(metodo, url, dataObj) {
            try {
                return await axios({
                    method: metodo,
                    url: url,
                    data: dataObj
                });
            } catch (e) {
                return e.response;
            }
        },
        info(desc, titulo = "Informação") {
            this.$Notice.info({
                title: titulo,
                desc: desc
            });
        },
        sucesso(desc, titulo = "Sucesso!") {
            this.$Notice.success({
                title: titulo,
                desc: desc
            });
        },
        aviso(desc, titulo = "Ops!") {
            this.$Notice.warning({
                title: titulo,
                desc: desc
            });
        },
        erro(desc, titulo = "Erro!") {
            console.log("Aqui");
            this.$Notice.error({
                title: titulo,
                desc: desc
            });
        },
        swr(
            desc = "Aconteceu algo de errado! Por favor tente de novo.",
            titulo = "Erro!"
        ) {
            this.$Notice.error({
                title: titulo,
                desc: desc
            });
        }
    }
};
