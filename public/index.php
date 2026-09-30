<?php
require_once __DIR__ . '/../Autoload.php';

$url = $_SERVER['REQUEST_URI'];

$router = new Router();
$router->add("/teste", "General@teste");

$router->execute($url);