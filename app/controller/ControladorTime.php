<?php
class ControladorTime extends ControladorGeral{
    /**
     * Cria um time recebendo um json com os ids dos pokemon que o usuário escolheu
     * Espera o seguinte POST
     * {
     *     "pokemon": [
     *          -- id1,
     *          -- id2, etc...
     *      ]
     * }
     */
    public function criarTime(){
        $pokemon = $this->receiveJSON()['pokemon'];
        $this->responseJSON($pokemon);
    }
}