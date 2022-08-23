<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rust Inventory Checker</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/styles.css">
</head>

<body>

    <?php require_once("_includes/header.php"); ?>

    <main>

        <form action="/result.php" method="POST">
            <h1>Check your Steam inventory</h1>
            <label for="steamId">SteamID64 or custom URL</label>
            <input type="text" id="steamId" name="steamId" required>
            <input type="submit" name="search" value="Search">
        </form>

    </main>

    <?php require_once("_includes/footer.php"); ?>

</body>

</html>