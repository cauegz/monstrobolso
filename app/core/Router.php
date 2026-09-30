<?php
class Router {
    private $routes = [];
    /**
     * adiciona uma rota no parametro do roteador, associando a rota ao modelo padrão - controller@metodo
     */
    public function add($url, $handler){
         $this->routes[$url] = [$handler];
    }

    public function execute($url){
        $routes = $this->routes;
        if(!array_key_exists($url, $this->routes)){
            die("404"); //fazer passar para uma pagina 404
        }
        foreach($routes as $urlClass => $handler){
            if($urlClass == $url){
                $handler = explode("@", $handler[0]);
                $class = $handler[0] . "Controller";
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