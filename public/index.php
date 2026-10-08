<?php

require_once __DIR__ . '/../Autoload.php';

header("Access-Control-Allow-Origin: http://127.0.0.1:3000");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

// Responde ao preflight do navegador
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$url = $_SERVER['REQUEST_URI'];

$router = new Roteador();
$router->add("/api/cadastro", "Auth@cadastro");
$router->add("/api/login",    "Auth@login");
$router->add("/api/me",       "Auth@me");
$router->add("/api/logout",   "Auth@logout");
$router->add("/api/teste",    "Npc@createNpc");

$router->executar($url);
