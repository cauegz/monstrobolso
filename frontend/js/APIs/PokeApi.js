export default class PokeAPI{
    static URL = "https://pokeapi.co/api/v2";

    static async buscarPokemon(id) {
        const response = await fetch(
            `${this.URL}/pokemon/${id}`
        );

        if (!response.ok) {
            throw new Error("Erro ao buscar Pokémon.");
        }

        return await response.json();
    }

    static async buscarGeracao(numero) {
        const response = await fetch(
            `${this.URL}/generation/${numero}`
        );

        if (!response.ok) {
            throw new Error("Erro ao buscar geração.");
        }

        return await response.json();
    }

    static async buscarGeracoesIniciais() {
        const [gen1, gen3] = await Promise.all([ //.all pra fazer duas promisses em paralelo
            this.buscarGeracao(1),
            this.buscarGeracao(3)
        ]);

        return [
            ...gen1.pokemon_species,
            ...gen3.pokemon_species
        ];
    }
}

