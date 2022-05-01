<?php

/**
 * Return an array containing all items from your Rust inventory.
 *
 * @param string                $steamId Your SteamID64 or custom URL.
 *
 * @return array                $items Your Rust inventory.
 */
function loadInventory(string $steamId): array|bool
{
    // echo "<p>Fetching your Rust inventory</p>";
    if (intval($steamId) === 0) {
        // If custom URL given
        // GET and output source code of the website
        // Decode JSON data into a PHP associative array
        $response = file_get_contents("https://steamcommunity.com/id/{$steamId}/inventory/json/252490/2?l=english&count=5000");
    } else {
        // If SteamID64 given
        // GET and output source code of the website
        // Decode JSON data into a PHP associative array
        $response = file_get_contents("https://steamcommunity.com/profiles/{$steamId}/inventory/json/252490/2?l=english&count=5000");
    }

    $data = json_decode($response, true);

    // If an error occured while trying to get Steam profile data
    if ($data['success'] === false) {
        return false;
    }

    // Use array destructuring to assign rgInventory and rgDescriptions from $data to two variables.
    ['rgInventory' => $inventory, 'rgDescriptions' => $descriptions] = $data;

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

        // Use array destructuring to assign itemId, itemName and itemTags from $description to 3 variables.
        ['classid' => $itemId, 'name' => $itemName, 'tags' => $itemTags] = $description;

        $itemCount = $counts[$itemId];

        $items[$itemId] = ["name" => $itemName, "quantity" => $itemCount, "tags" => $itemTags];
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
    // echo "<p>Fetching Steam market for stonking items.</p>";
    // GET and output source code of the website
    $response = file_get_contents("https://scmm.app/api/stats/items/allTimeHigh?start=0&count=20&currency=eur");
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
 * @return array                $yourStonks Your stonking items.
 */
function getYourStonkingItems($inventory, $inventoryKeys, $items): array
{
    $itemNames = array_column($inventory, 'name');
    $yourStonks =  [];

    // Iterate over stonking items array to find mathces
    foreach ($items as $item) {
        $key = array_search($item["name"], $itemNames);
        // If there is a match
        if (is_int($key)) {
            $stonkingItem = $inventory[$inventoryKeys[$key]];
            $stonkingItem['price'] = number_format($item['buyNowPrice'] / 100, 2);
            $stonkingItem['backgroundColour'] = $item['backgroundColour'];
            $stonkingItem['foregroundColour'] = $item['foregroundColour'];
            $stonkingItem['iconUrl'] = $item['iconUrl'];
            array_push($yourStonks, $stonkingItem);
        }
    }
    return $yourStonks;
}
