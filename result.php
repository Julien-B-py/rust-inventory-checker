<?php

// declare(strict_types=1);

// require_once("vendor/autoload.php");

// $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
// $dotenv->load();

require_once("_includes/functions.php");

// $steamId = $_ENV['STEAM_ID'];

// Preventing XSS
$steamId = htmlspecialchars($_POST["steamId"]);

// Add trim

if (!isset($_POST["search"])) {
    echo "You need to click on the submit button.";
    return;
}

if (empty($steamId)) : ?>
    <p>Error: you submitted an empty value</p>
<?php return;
endif;

$myInventory = loadInventory($steamId);
$myInventoryKeys = array_keys($myInventory);
$stonkingItems = getStonkingItems();

$yourStonks = getYourStonkingItems($myInventory, $myInventoryKeys, $stonkingItems); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <div class="items">

        <?php foreach ($yourStonks as $item) : ?>
            <div class="item" style="background-color:<?= $item['backgroundColour'] ?>;">

                <h2 style="color:<?= $item['foregroundColour'] ?>;"><?= $item['name'] ?></h2>
                <img src="<?= $item['iconUrl'] ?>" alt="">
                <p><?= $item['price'] ?>€</p>
                <p>You have <?= $item['quantity'] ?></p>

            </div>
        <?php endforeach; ?>

    </div>

</body>

</html>