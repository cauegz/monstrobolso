class Pokemon{
    #id;
    #nome;
    #urlImagem;
    #pokeApi;

    constructor(id, nome, urlImagem, pokeApi) {
        this.id = id;
        this.nome = nome;
        this.urlImagem = urlImagem;
        this.pokeApi = pokeApi;
    }
}

export default Pokemon;