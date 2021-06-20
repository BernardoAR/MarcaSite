export default function validacaoValor(valor, validacao, campo) {
    // Verifica se é mínimo ou máximo
    if (
        validacao.startsWith("minLength") ||
        validacao.startsWith("maxLength") ||
        validacao.startsWith("greaterEqual") ||
        validacao.startsWith("lessEqual")
    ) {
        let array = validacao.split(":");
        switch (array[0]) {
            case "minLength":
                return {
                    resultado: array[1].length >= valor,
                    mensagem: `O campo ${campo} necessita de ao menos ${valor} caracteres.`
                };
            case "maxLength":
                return {
                    resultado: array[1].length <= valor,
                    mensagem: `O tamanho máximo do campo "${campo}" é de ${valor} caracteres.`
                };
            case "greaterEqual":
                return {
                    resultado: array[1] >= valor,
                    mensagem: `O valor do campo "${campo}" precisa ser maior ou igual a ${valor}.`
                };
            case "lessEqual":
                return {
                    resultado: array[1] <= valor,
                    mensagem: `O valor do campo "${campo}" precisa ser menor ou igual a ${valor}.`
                };
        }
    }
    switch (validacao) {
        case "required":
            return {
                resultado: valor.trim() != "" && valor != null,
                mensagem: `O campo "${campo}" é obrigatório!`
            };
        case "email":
            let re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return {
                resultado: re.test(valor),
                mensagem: `E-mail inválido`
            };
    }
}
