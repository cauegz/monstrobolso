<?php

require_once __DIR__ . '/../autoload.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$router = new Roteador();
$router->add("/api/cadastro", "Auth@cadastro");
$router->add("/api/login",    "Auth@login");
$router->add("/api/me",       "Auth@me");
$router->add("/api/logout",   "Auth@logout");
$router->add("/api/teste",    "Npc@createNpc");
$router->add("/api/builder",    "Time@criarTime");
$router->add("/api/treinador/time",    "Time@time");
$router->add("/api/pokemon",    "Pokemon@pokemonById");


$router->executar($url);
