<?php

function loadInventory(string $steamId)
{
    // GET and output source code of the website
    $response = file_get_contents("https://steamcommunity.com/id/{$steamId}/inventory/json/252490/2?l=english&count=5000");
    // Decode JSON data into a PHP associative array
    $data = json_decode($response, true);
    // Use array destructuring to assign rgInventory and rgDescriptions from $data to two variables.
    ['rgInventory' => $inventory, 'rgDescriptions' => $descriptions] = $data;

    echo ("Fetching your Rust inventory.");

    $counts = [];

    $itemIds = array_column($inventory, 'classid');

    foreach ($itemIds as $itemId) {
        $count = 0;
        foreach ($inventory as $item) {
            if ($item["classid"] === $itemId) {
                $count += intval($item["amount"]);
            }
        }
        $counts[$itemId] = $count;
    }


    // List unique items
    foreach ($descriptions as $description) {

        $itemId = $description["classid"];
        $itemName = $description["name"];
        $itemCount = $counts[$itemId];

        var_dump([$itemId, $itemName, $itemCount]);
    }
}
