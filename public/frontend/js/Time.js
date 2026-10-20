class Time {
    #pokemon;

    constructor() {
        this.#pokemon = new Array(6).fill(null);
    }

    get pokemon() {
        return this.#pokemon;
    }

    adicionarPokemon(posicao, idPokemon) {
        this.#pokemon[posicao - 1] = idPokemon;
    }

    obterTime() {
        
    }

    estaCompleto() {
        
    }

    static async carregarTime(idTreinador) {
        //pega o time do usuário logado atualmente
        const promiseBanco = await fetch(`http://localhost:8080/api/treinador/time`);
        const timeBanco = await promiseBanco.json();
        var index = 1;
        for(const pokemon of timeBanco){
            if(!pokemon){
                index++;
                continue;
            }
            //codigo porco tem um jeito melhor de fazer isso nao sei como
            const div = document.getElementById(`pokemon-${index}`);

            const promisePokeBanco = await fetch(`http://localhost:8080/api/pokemon?id=${pokemon.pokemon}`);
            const pokeBanco = await promisePokeBanco.json();

            const promisePoke = await fetch(`https://pokeapi.co/api/v2/pokemon/${pokeBanco.pokeApi}`);
            const pokeSelecionado = await promisePoke.json();

            const imgUrl = pokeSelecionado.sprites.front_default;

            div.innerHTML += `<p>${pokeSelecionado.name.charAt(0).toUpperCase() + pokeSelecionado.name.slice(1)}</p><img src=${imgUrl} />`; 
            // retorna o nome do pokemon com a primeira letra maiúscula e a imagem do dele

            // time[index-1] = pokeSelecionado.id;
            objTime.adicionarPokemon(index, pokeSelecionado.id);
            index++;
        }
        console.log(objTime)
        return objTime;
    }
}

export default Time;