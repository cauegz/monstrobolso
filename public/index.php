<?php

require_once __DIR__ . '/../autoload.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");

$url = $_SERVER['REQUEST_URI'];

$router = new Roteador();
$router->add("/api/cadastro", "Auth@cadastro");
$router->add("/api/login",    "Auth@login");
$router->add("/api/me",       "Auth@me");
$router->add("/api/logout",   "Auth@logout");
$router->add("/api/teste",    "Npc@createNpc");
$router->add("/api/builder",    "Time@criarTime");
$router->add("/api/produto/criar",  "Loja@criarProduto");
$router->executar($url);
