<?php
require_once __DIR__ . '/../Autoload.php';

$url = $_SERVER['REQUEST_URI'];

$router = new Roteador();
$router->add("/teste", "Geral@teste");

$router->executar($url);
