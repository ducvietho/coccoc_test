<?php
require  __DIR__ . '/../bootstrap.php';

use App\Controllers\OrderController;
use App\Utils\Consts;
use App\Services\OrderService;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );
$requestMethod = $_SERVER['REQUEST_METHOD'];
$header = getallheaders();
if (!(($uri[1] === Consts::CART_URI && $requestMethod === Consts::GET_REQUEST) ||
    ($uri[1] === Consts::COEFFICIENT_URI && $requestMethod === Consts::POST_REQUEST) ||
    ($uri[1] === Consts::FEE_URI && $requestMethod === Consts::POST_REQUEST))) {
    exit(header('X-PHP-Response-Code: 404', true, 404));
}

if ($uri[1] === Consts::CART_URI && $header['Authorization'] !== Consts::AUTHORIZATION_USER ||
    (($uri[1] === Consts::COEFFICIENT_URI || $uri[1] === Consts::FEE_URI) && $header['Authorization'] !== Consts::AUTHORIZATION_ADMIN)) {
    exit(header('X-PHP-Response-Code: 401', true, 401));
}

$orderService = new OrderService();
$orderController = new OrderController($orderService, $dbConnection);
$orderController->index($uri);

