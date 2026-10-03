<?php
/**
 * Todos os controladores devem extender essa classe
 */
abstract class ControladorGeral{
    /**
     * Método padrão que printa o JSON na tela, fornecendo os dados pro frontend
     * 
     * @param array $dados: array associativos que vai ser convertido para JSON
     * 
     * @return null só printa os dados na tela
     */
    public function responseJSON($dados){
        if(!$dados){
            $this->responseError("dados inexistentes", 400);
        }
        header('Content-Type: application/json; charset=utf-8');
        http_response_code(200);
        echo json_encode($dados);
        die();
    }

    /**
     * Método que retorna erro em JSON para o frontend
     * 
     * @param string $mensagem: mensagem que será exibida no campo mensagem do JSON
     * @param int $codigo: código http que vai ser passado na requisição, 
     * para checar qual usar, use esse site: https://developer.mozilla.org/pt-BR/docs/Web/HTTP/Reference/Status 
     * 
     * @return null printa o erro em json na tela
     */
    public function responseError($mensagem, $codigo){
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($codigo);
        echo json_encode(["ok" => false, "mensagem" => $mensagem]);
        die();
    }
}