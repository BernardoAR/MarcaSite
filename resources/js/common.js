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
        async chamaApi(metodo, url, dataObj, outros = {}) {
            try {
                return await axios({
                    method: metodo,
                    url: url,
                    data: dataObj,
                    ...outros
                });
            } catch (e) {
                return e.response;
            }
        },
        formatCPF(cpf) {
            let x = this.regexCPF(cpf);
            let p4 = x[4] ? `-${x[4]}` : "";
            let p3 = x[3] ? `.${x[3]}` : "";
            let p2 = x[2] ? `.${x[2]}` : "";
            return `${x[1]}${p2}${p3}${p4}`;
        },
        regexCPF(cpf) {
            return String(cpf)
                .replace(/\D/g, "")
                .match(/(\d{0,3})(\d{0,3})(\d{0,3})(\d{0,2})/);
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
