<?php
function carregar($classe) {
    $dir = scandir(__DIR__ . '/src/');
    foreach ($dir as $item) {
        if ($item !== '.' && $item !== '..') {
            $caminho = __DIR__ . "/src//$classe.php";
            if($item === $classe . '.php') {
                require_once $caminho;
                return;
            }else{
                if(is_dir(__DIR__ . "/src/$item")) {
                    $subdir = scandir(__DIR__ . "/src/$item");
                    foreach ($subdir as $subitem) {
                        if ($subitem !== '.' && $subitem !== '..') {
                            $subcaminho = __DIR__ . "/src/$item/$classe.php";
                            if($subitem === $classe . '.php') {
                                require_once $subcaminho;
                                return;
                            }
                        }
                    }
                }
            }
            
        }
    }
}
spl_autoload_register('carregar');