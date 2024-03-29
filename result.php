<?php

require_once("_includes/functions.php");


if (isset($_POST["steamId"])) {
    // Preventing XSS
    $steamId = htmlspecialchars($_POST["steamId"]);
    // Removing whitespaces
    $steamId = trim($steamId);
}


if (!isset($_POST["search"])) {
    echo "You need to click on the submit button.";
    return;
}

if (empty($steamId)) : ?>
    <p>Error: you submitted an empty value</p>
<?php return;
endif;

$myInventory = loadInventory($steamId);

// If Steam profile data collect is unsuccessful
if (!$myInventory) {
    echo "<h1>An error occured while collecting your Steam profile data.</h1>";
    return;
}

$myInventoryKeys = array_keys($myInventory);
$stonkingItems = getStonkingItems();

$yourStonks = getYourStonkingItems($myInventory, $myInventoryKeys, $stonkingItems);

// var_dump($yourStonks);

// Determine how much stonking items the user has
$totalItems = 0;
foreach ($yourStonks as $item) {
    $totalItems += $item["quantity"];
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>You have <?= $totalItems > 0 ? "$totalItems items to sell." : "no valuable item yet." ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/styles.css">
</head>



<body>

    <?php require_once("_includes/header.php"); ?>

    <main>

        <?php if (empty($yourStonks)) : ?>
            <h2>No data to display, try again later.</h2>
        <?php
            return;
        endif; ?>

        <h1>Stonking items that you have</h1>

        <div class="sort">
            <label for="sort">Filter</label>
            <select id="sort">
                <option value="0">Name ASC</option>
                <option value="1">Name DESC</option>
                <option value="2">Price ASC</option>
                <option value="3">Price DESC</option>
            </select>
        </div>

        <div class="items">

            <?php foreach ($yourStonks as $item) : ?>
                <div class="item" style="border: 2px solid <?= $item['foregroundColour'] ?>;">

                    <h2><?= $item['name'] ?></h2>

                    <div class="item__img">
                        <div class="item__amount">
                            x<?= $item['quantity'] ?>
                        </div>
                        <img src="<?= $item['iconUrl'] ?>" alt="<?= $item['name'] ?>">
                    </div>

                    <div class="item__tags">
                        <?php foreach ($item['tags'] as $tag) : ?>
                            <span><?= $tag['name'] ?></span>
                        <?php endforeach; ?>
                    </div>

                    <p><?= $item['price'] ?>€ <span>(<?= number_format($item['price'] * 0.85, 2) ?>€)</span></p>

                    <button><a href="https://steamcommunity.com/market/listings/252490/<?= $item['name'] ?>"><i class="fa-brands fa-steam"></i> Community Market</a></button>


                </div>
            <?php endforeach; ?>

        </div>

    </main>

    <?php require_once("_includes/footer.php"); ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.10.4/gsap.min.js"></script>
    <script src="./assets/js/scripts.js"></script>

</body>

</html>