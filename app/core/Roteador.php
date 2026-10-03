<?php
class Roteador {
    private $rotas = [];
    /**
     * Adiciona uma rota no parametro do roteador, associando a rota ao modelo padrão - controller@metodo
     * 
     * @param String $url: url do endpoint
     * @param String $handler: qual método de qual classe será executad, modelo: controlador@metodo
     */
    public function add($url, $handler){
         $this->rotas[$url] = [$handler];
    }

    /**
     * Executa a rota com base no que foi definido com o método add(), se a rota 
     * não estiver na classe vai dar 404
     * 
     * @param String $url: endpoint que vai ser executado 
     */
    public function executar($url){
        $rotas = $this->rotas;
        if(!array_key_exists($url, $this->rotas)){
            die("404"); //fazer passar para uma pagina 404
        }
        foreach($rotas as $urlClass => $handler){
            if($urlClass == $url){
                $handler = explode("@", $handler[0]);
                $class = "Controlador" . $handler[0];
                $method = $handler[1];
                if(class_exists($class)){
                    $obj = new $class();
                } else {
                    die("classe nao existe"); //fazer passar para uma pagina 404
                }
                if(method_exists($obj, $method)){
                    $obj->$method();
                } else {
                    die("metodo nao existe"); //fazer passar para uma pagina 404
                }
            }
        }
    }
}