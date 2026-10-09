<?php

require_once __DIR__ . '/../Autoload.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");

$url = $_SERVER['REQUEST_URI'];

$router = new Roteador();
$router->add("/api/cadastro", "Auth@cadastro");
$router->add("/api/login",    "Auth@login");
$router->add("/api/me",       "Auth@me");
$router->add("/api/logout",   "Auth@logout");
$router->add("/api/teste",    "Npc@createNpc");

$router->executar($url);
