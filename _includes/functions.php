<?php

/**
 * Return an array containing all items from your Rust inventory.
 *
 * @param string                $steamId Your SteamID64 or custom URL.
 *
 * @return array                $items Your Rust inventory.
 */
function loadInventory(string $steamId): array
{
    // GET and output source code of the website
    $response = file_get_contents("https://steamcommunity.com/id/{$steamId}/inventory/json/252490/2?l=english&count=5000");
    // Decode JSON data into a PHP associative array
    $data = json_decode($response, true);
    // Use array destructuring to assign rgInventory and rgDescriptions from $data to two variables.
    ['rgInventory' => $inventory, 'rgDescriptions' => $descriptions] = $data;

    echo "<p>Fetching your Rust inventory</p>";

    // Create an empty array to store items using this structure : itemiId => count 
    $counts = [];
    // Get column of classids
    $itemIds = array_column($inventory, 'classid');
    // Iterate over itemIds array to get items quantities
    foreach ($itemIds as $itemId) {
        // Initialize count to 0
        $count = 0;
        // Iterate over inventory array
        foreach ($inventory as $item) {
            // If current current item classId is equal to current itemId, get item amount and increment count variable
            if ($item["classid"] === $itemId) {
                $count += intval($item["amount"]);
            }
        }
        // When we are done looping, we push the calculated amount in counts as an associative array with itemId as key
        $counts[$itemId] = $count;
    }

    $items = [];
    // List unique items
    foreach ($descriptions as $description) {

        // Use array destructuring to assign itemId and itemName from $description to two variables.
        ['classid' => $itemId, 'name' => $itemName] = $description;

        $itemCount = $counts[$itemId];

        $items[$itemId] = ["name" => $itemName, "quantity" => $itemCount];
    }

    return $items;
}

/**
 * Return an array containing items currently at their all-time highest value.
 *
 * @return array                $items Currently stonking items.
 */
function getStonkingItems(): array
{
    $response = file_get_contents("https://scmm.app/api/stats/items/allTimeHigh?start=0&count=20&currency=eur");
    echo "<p>Fetching Steam market for stonking items.</p>";
    // Decode JSON data into a PHP associative array
    $data = json_decode($response, true);

    $items = $data["items"];

    return $items;
}

/**
 * Compare your Rust inventory with currently stonking items to check if you have any.
 *
 * @param array                $inventory The Rust inventory to check.
 * @param array                $inventoryKeys Rust inventory keys.
 * @param array                $items Currently stonking items.
 *
 * @return void
 */
function getYourStonkingItems($inventory, $inventoryKeys, $items): void
{
    echo "<p>Stonking items that you have:</p>";
    foreach ($items as $item) {
        $key = array_search($item["name"], array_column($inventory, 'name'));
        if (is_int($key)) {
            $item = $inventory[$inventoryKeys[$key]];
            var_dump($item);
        }
    }
}
