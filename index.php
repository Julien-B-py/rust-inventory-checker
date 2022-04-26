<?php

declare(strict_types=1);

require_once('vendor/autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

require_once "functions.php";

$steamId = $_ENV['STEAM_ID'];

$myInventory = loadInventory($steamId);

var_dump($myInventory);
