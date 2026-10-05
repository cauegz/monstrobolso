<?php
class ControladorAuth extends ControladorGeral{
    public function cadastro(){
        // extract($this->receiveJSON());

        //teste do banco pode apagar
        $pdo = Conexao::getPDO();
        $sql = "select * from efeito";
        $stmt = $pdo->query($sql);
        $this->responseJSON($stmt->fetchAll(PDO::FETCH_ASSOC));

        $npc = Npc::find(1);
    }
}