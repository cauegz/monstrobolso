<?php
class ControladorPokemon extends ControladorGeral{
    public function pokemonById(){
        $id = $_GET['id'] ?? null;
            
        if (!filter_var($id, FILTER_VALIDATE_INT) || $id < 1) {
            $this->responseError("ID inválido", 400);
            return;
        }
        return $this->responseJSON(Pokemon::find($id));
    }
}