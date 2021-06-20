import axios from "axios";
import validacaoValor from "./validacao";
/**
 * JS para configurações comuns que todo o JS pode precisar.
 */
export default {
    data() {
        return {};
    },
    methods: {
        // Método para transformar o obj em formData
        objToFormData(dataObj) {
            let formData = new FormData();
            for (let i in dataObj) {
                formData.append(`${i}`, dataObj[i]);
            }
            return formData;
        },
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
        validacao(valores, validacao) {
            let erros = [];
            Object.entries(validacao).map(function(obj) {
                let split = obj[1].split("|");
                for (let i in split) {
                    let erro = validacaoValor(valores, split[i], obj[0]);
                    // Verifica se retornou o valor, se retornou, já manda a mensagem
                    if (!erro.resultado) {
                        erros.push(erro.mensagem);
                        break;
                    }
                }
            });
            return erros;
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
        aviso(desc, titulo = "Aviso!") {
            this.$Notice.warning({
                title: titulo,
                desc: desc
            });
        },
        erro(desc, titulo = "Erro!") {
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
