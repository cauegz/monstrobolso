<?php

class ControladorNpc extends ControladorGeral{
    public function createNpc(){
        extract($this->receiveJSON());


        //funcionou essa porra
        // $npc = new Npc();
        // /**@var string $nome @var int $tipoNpc */
        // $npc->nome = $nome;
        // $npc->tipoNpc = $tipoNpc;

        // $npc->save();
        // $id = $npc->id;

        $npc2 = Npc::find(1);
        $this->responseJSON([
            "nome" => $npc2->nome,
            "tipoNpc" => $npc2->tipoNpc
        ]);
    }
}