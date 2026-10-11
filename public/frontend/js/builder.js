const pokemons = document.getElementById("pokemons");

async function carregaPokemons() {
    try {
        const pokeApiGen1 = await fetch("https://pokeapi.co/api/v2/generation/1");
        const pokeApiObjGen1 = await pokeApiGen1.json();

        const pokeApiGen3 = await fetch("https://pokeapi.co/api/v2/generation/3");
        const pokeApiObjGen3 = await pokeApiGen3.json();

        let especies = [...pokeApiObjGen1.pokemon_species, ...pokeApiObjGen3.pokemon_species];

        pokemons.innerHTML = "";

        html = "";
        console.log(especies)
        //para melhorar o desempenho da página, primeiro montamos a string do html e só depois damos o innerHTML
        especies.forEach(especie => {
            let id = especie.url.replace(/\D+/g, "").slice(1);
            const imgUrl = `https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/${id}.png`;
            console.log(id);
            html += `
                <div id="poke-${id}" class="pokemon">
                    <img src="${imgUrl}" loading="lazy"/>
                    <p>${especie.name}</p>
                </div>
            `;
        });
        pokemons.innerHTML = html;
    } catch (error) {
        console.log("erro ao buscar na api: " + error);
        pokemons.innerHTML = "erro";
    }
    
}
carregaPokemons();