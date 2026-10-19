//verifica se o usuário está logado
import verificarSessao from "./verificarSessao.js";
await verificarSessao();

//PopUp
const btnSelecionarPoke = document.querySelectorAll('.btn-selecionar-poke');
const selecionarPoke = document.getElementById("selecionar-poke");
const fechaModal = document.getElementById("fecha-modal");

const time = new Array(6);
let pokemonEquipe;

const esperarSegundos = seg => new Promise(resolve => setTimeout(resolve, seg*1000));

btnSelecionarPoke.forEach(botao =>{
    botao.addEventListener("click", ()=>{
        selecionarPoke.showModal();
        carregaPokemons();
        pokemonEquipe = botao.dataset.poke;
    })
})

fechaModal.addEventListener("click", ()=>{
    selecionarPoke.close();
});

selecionarPoke.addEventListener("click", async (event)=>{
    if(event.target.classList.contains('btn-opcao')){
        const div = document.getElementById(`pokemon-${pokemonEquipe}`);

        const idSelecionado = event.target.value;
        const promisePoke = await fetch(`https://pokeapi.co/api/v2/pokemon/${idSelecionado}`);
        const pokeSelecionado = await promisePoke.json();

        const imgUrl = pokeSelecionado.sprites.front_default;

        div.innerHTML += `<p>${pokeSelecionado.name.charAt(0).toUpperCase() + pokeSelecionado.name.slice(1)}</p><img src=${imgUrl} />`; 
        // retorna o nome do pokemon com a primeira letra maiúscula e a imagem do dele

        time[pokemonEquipe-1] = pokeSelecionado.id;
        //-1 porque o array começa do 0 e a posição do pokemon na equipe começa do 1

        selecionarPoke.close();
    }
})

const pokemons = document.getElementById("pokemons");
async function carregaPokemons() {
    try {
        const pokeApiGen1 = await fetch("https://pokeapi.co/api/v2/generation/1");
        const pokeApiObjGen1 = await pokeApiGen1.json();

        const pokeApiGen3 = await fetch("https://pokeapi.co/api/v2/generation/3");
        const pokeApiObjGen3 = await pokeApiGen3.json();

        let especies = [...pokeApiObjGen1.pokemon_species, ...pokeApiObjGen3.pokemon_species];

        await esperarSegundos(1);
        pokemons.innerHTML = "";

        let html = "";
        //para melhorar o desempenho da página, primeiro montamos a string do html e só depois damos o innerHTML
        especies.forEach(especie => {
            //pega todos os números da url e tira o primeiro  (que é o 2 da v2)
            let id = especie.url.replace(/\D+/g, "").slice(1);
            const imgUrl = `https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/${id}.png`;
            html += `
                <div id="poke-${id}" class="pokemon">
                    <img src="${imgUrl}" loading="lazy"/>
                    <p>${especie.name}</p>
                    <button class="btn-opcao" value="${id}">escolher</button>
                </div>
            `;
        });
        pokemons.innerHTML = html;
    } catch (error) {
        console.log("erro ao buscar na api: " + error);
        pokemons.innerHTML = "erro";
    }
}

async function enviar() {
    try{
        const payload = {
            "pokemon": time
        }
        const jsonData = JSON.stringify(payload);
        console.log(payload);
        console.log(jsonData);

        const response = await fetch("http://localhost:8080/api/builder", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            credentials: 'include',
            body: jsonData
        });

        const result = await response.json();
        console.log(result);

        // window.location.href = "/frontend/pages/index.html";
    }catch(error){
        console.log("erro ao enviar para a api: " + error);
    }
}
document.getElementById("enviar").addEventListener("click", enviar);
