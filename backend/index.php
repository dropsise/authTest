<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: GET, POST');

// INCLURE LE ROUTER
require_once './controllers/Router.php';

// // DEMARER LE ROUTER
$router = new Router();
$router->routeReq();

