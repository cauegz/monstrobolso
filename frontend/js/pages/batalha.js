import verificarSessao from "../services/verificarSessao.js";
let usuario = await verificarSessao();

async function carregaTime(){
    try{
        const promiseTime = await fetch(`/api/treinador/time`);
        const time = await promiseTime.json();

        //consultar o pokemon especifico e retornar hp
        const pokemonUser = await fetch(`/api/pokemon?id=${time[0].pokemon}`);
        const pokeUser = await pokemonUser.json();

        //pega da api e poe na tela
        console.log(pokeUser)
        const pokeApi = await fetch(`https://pokeapi.co/api/v2/pokemon/${pokeUser.pokeApi}`);
        const pokemon = await pokeApi.json();
        document.getElementById('pokeSelecionado').innerHTML = `<img src=${pokemon.sprites.back_default} />`;
        document.getElementById('pokeNome').innerHTML = `<p>${pokemon.name}</p>`;

        console.log(pokeUser.hp);
        document.getElementById('hp').innerHTML = `<p>HP: ${pokeUser.hp}</p>`;
    }catch(error){
        console.log("erro ao carregar poke primario: " + error);
    }
}

carregaTime();