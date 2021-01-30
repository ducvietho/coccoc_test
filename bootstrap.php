<?php

require __DIR__ . '/vendor/autoload.php';

use App\Database\DatabaseConnect;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$dbConnection = (new DatabaseConnect())->getConnection();

