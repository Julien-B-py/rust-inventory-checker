<?php

function loadInventory(string $steamId): array
{
    // GET and output source code of the website
    $response = file_get_contents("https://steamcommunity.com/id/{$steamId}/inventory/json/252490/2?l=english&count=5000");
    // Decode JSON data into a PHP associative array
    $data = json_decode($response, true);
    // Use array destructuring to assign rgInventory and rgDescriptions from $data to two variables.
    ['rgInventory' => $inventory, 'rgDescriptions' => $descriptions] = $data;

    echo ("Fetching your Rust inventory.");

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
