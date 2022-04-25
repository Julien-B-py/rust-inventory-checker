<?php

function loadInventory(string $steamId)
{
    $data = json_decode(file_get_contents("https://steamcommunity.com/id/{$steamId}/inventory/json/252490/2?l=english&count=5000"), true);
    $inventory = $data["rgInventory"];
    $descriptions = $data["rgDescriptions"];
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
