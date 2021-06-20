/**
 * Método utilizado para validação
 * @author Bernardo Alves Roballo
 */
export default function validacaoValor(valor, validacao, campo) {
    let valor1 = valor[campo];
    // Verifica se é mínimo ou máximo
    if (
        validacao.startsWith("minLength") ||
        validacao.startsWith("maxLength") ||
        validacao.startsWith("greaterEqual") ||
        validacao.startsWith("lessEqual") ||
        validacao.startsWith("match")
    ) {
        let array = validacao.split(":");
        switch (array[0]) {
            case "minLength":
                console.log(array[1]);
                console.log(valor1.length);
                return {
                    resultado: array[1] <= valor1.length,
                    mensagem: `O campo ${campo} necessita de ao menos ${array[1]} caracteres.`
                };
            case "maxLength":
                return {
                    resultado: array[1] >= valor1.length,
                    mensagem: `O tamanho máximo do campo "${campo}" é de ${array[1]} caracteres.`
                };
            case "greaterEqual":
                return {
                    resultado: array[1] >= valor1,
                    mensagem: `O valor do campo "${campo}" precisa ser maior ou igual a ${array[1]}.`
                };
            case "lessEqual":
                return {
                    resultado: array[1] <= valor,
                    mensagem: `O valor do campo "${campo}" precisa ser menor ou igual a ${array[1]}.`
                };
            case "match":
                let valor2 = valor[array[1]];
                return {
                    resultado: valor1 == valor2,
                    mensagem: `O valor do campo "${array[1]}" precisa ser igual a ${campo}.`
                };
        }
    }
    switch (validacao) {
        case "required":
            return {
                resultado: valor1 != null && valor1 != "",
                mensagem: `O campo "${campo}" é obrigatório!`
            };
        case "email":
            let re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return {
                resultado: re.test(valor1),
                mensagem: `E-mail inválido`
            };
    }
}
