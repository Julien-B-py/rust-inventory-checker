<?php

declare(strict_types=1);

require_once("vendor/autoload.php");

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

require_once("_includes/functions.php");

$steamId = $_ENV['STEAM_ID'];

$myInventory = loadInventory($steamId);
$myInventoryKeys = array_keys($myInventory);
$stonkingItems = getStonkingItems();

getYourStonkingItems($myInventory, $myInventoryKeys, $stonkingItems);
