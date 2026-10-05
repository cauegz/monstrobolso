<?php
require_once __DIR__ . '/../Autoload.php';

$url = $_SERVER['REQUEST_URI'];

$router = new Roteador();
$router->add("/api/cadastro", "Auth@cadastro");

$router->executar($url);
