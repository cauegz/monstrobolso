<?php

class ControladorNpc extends ControladorGeral{
    public function createNpc(){
        // extract($this->receiveJSON());


        $npc = new Npc();
        /**@var string $nome @var int $tipoNpc */
        $npc->nome = "nome";
        $npc->tipoNpc = 1;

        $npc->save();
        $id = $npc->id;
        // var_dump($npc);
        $this->responseJSON(Npc::all());
    }
}