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

$yourStonks = getYourStonkingItems($myInventory, $myInventoryKeys, $stonkingItems);

// var_dump($yourStonks);
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>



<body>

    <?php if (empty($yourStonks)) : ?>
        <h1>No data to display, try again later.</h1>
    <?php
        return;
    endif; ?>

    <h1>Stonking items that you have:</h1>

    <div class="items">

        <?php foreach ($yourStonks as $item) : ?>
            <div class="item" style="border: 2px solid <?= $item['foregroundColour'] ?>;">

                <h2><?= $item['name'] ?></h2>

                <div class="item__img">
                    <div class="item__amount">
                        <?= $item['quantity'] ?>
                    </div>
                    <img src="<?= $item['iconUrl'] ?>" alt="">
                </div>

                <div class="item__tags">
                    <?php foreach ($item['tags'] as $tag) : ?>
                        <span><?= $tag['name'] ?></span>
                    <?php endforeach; ?>
                </div>

                <p><?= $item['price'] ?> € <span>(<?= number_format($item['price'] * 0.85, 2) ?> €)</span></p>

                <button><a href="https://steamcommunity.com/market/listings/252490/<?= $item['name'] ?>"><i class="fa-brands fa-steam"></i> Community Market</a></button>


            </div>
        <?php endforeach; ?>

    </div>

</body>

</html>