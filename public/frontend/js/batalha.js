import verificarSessao from "./verificarSessao.js";
import Time from "./Time.js";
import batalhaView from "./batalhaView.js"

async function iniciarBatalha(){
    try{
        const usuario = await verificarSessao();
        if(!usuario) return
        const objTime = await Time.carregarTime(usuario.treinador);
        new batalhaView(objTime);
    }catch(error){
        console.log(error);
    }

}
iniciarBatalha();
/*
async function carregaTime(){
    try{
        const promiseTime = await fetch(`http://localhost:8080/api/treinador/time`);
        const time = await promiseTime.json();

        //consultar o pokemon especifico e retornar hp
        const pokemonUser = await fetch(`http://localhost:8080/api/pokemon?id=${time[0].pokemon}`);
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
*/
