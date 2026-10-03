<?php
class Roteador {
    private $rotas = [];
    /**
     * Adiciona uma rota no parametro do roteador, associando a rota ao modelo padrão - controller@metodo
     * 
     * @param string $url: url do endpoint
     * @param string $handler: qual método de qual classe será executad, modelo: controlador@metodo
     */
    public function add($url, $handler){
         $this->rotas[$url] = [$handler];
    }

    /**
     * Executa a rota com base no que foi definido com o método add(), se a rota 
     * não estiver na classe vai dar 404
     * 
     * @param string $url: endpoint que vai ser executado 
     */
    public function executar($url){
        $rotas = $this->rotas;
        if(!array_key_exists($url, $this->rotas)){
            $this->erro404();
        }
        foreach($rotas as $urlClass => $handler){
            if($urlClass == $url){
                $handler = explode("@", $handler[0]);
                $class = "Controlador" . $handler[0];
                $method = $handler[1];
                if(class_exists($class)){
                    $obj = new $class();
                } else {
                    $this->erro404("classe não existe");
                }
                if(method_exists($obj, $method)){
                    $obj->$method();
                } else {
                    $this->erro404("método não existe");
                }
            }
        }
    }

    /**
     * Passa um JSON com 404
     * 
     * @param string $mensagem: mensagem que vai junto com o 404 (util 
     * para debug quando passar classe ou metodo errado);
     */
    private function erro404($mensagem = "404"){
        header('Content-Type: application/json; charset=utf-8');
        http_response_code(404);
        echo json_encode(["ok" => false, "mensagem" => $mensagem]);
        die();
    }
}