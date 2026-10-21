
export default class Api {
    static url = "http://localhost:8080/api";

    // Método geral para fazer requisições
    static async requisicao(endpoint, opcoes = {}) {
        const resposta = await fetch(`${this.url}${endpoint}`, {
            ...opcoes, //spread syntax, copia as propriedades do objeto opcoes para o objeto de configuração do fetch
            headers: {
                ...(opcoes.body ? { "Content-Type": "application/json" } : {}), //Se opcoes.body existir, adiciona o cabeçalho se não existir adiciona um objeto vazio.
                ...opcoes.headers
            },
            // Mantém os cookies da sessão nas requisições.
            credentials: "include" 
        });

        if (!resposta.ok) {
            throw new Error(`erro na API: ${resposta.status}`);
        }

        return await resposta.json();
    }

 
    static async enviarTime(time) {
        return await this.requisicao("/builder", {
            method: "POST",
            body: JSON.stringify({
                pokemon: time.pokemon
            })
        });
    }


    static async buscarPokemon(id) {
        return await this.requisicao(`/pokemon?id=${id}`);
    }

    static async buscarTime(id) {
        return await this.requisicao(`/treinador/time?id=${id}`);
    }
}


