<?php
class ControladorLoja extends ControladorGeral{

    public function criarCategoria(){
        $categoria = new Categoria();
        $categoria->tipo = "l1";
        $categoria->save();
        $this->responseJSON(Categoria::all());
    }    

    public function criarLoja (){
        $loja = new Loja();

        $loja->nome = "l1";
        $loja->id_categoria = 1;

        $loja->save();
        $this->responseJSON(Loja::all());
    }
    public function criarProduto(){
        $produto = new Produto();

        $produto->nome = "banana";
        $produto->preco = 5;
        $produto->estoque = 200;
        $produto->categoria_id = 1;
        $produto->id_item_pokeapi = 1;
        $produto-save();

        $this->responseJSON(Produto::all());

    }
    public function realizaVenda(){
        $itensCompra = new ItensCompra();
        $venda = new Venda();
        
    }
}