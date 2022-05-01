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

    <form action="/result.php" method="POST">
        <h1>Check your Steam inventory</h1>
        <label for="steamId">SteamID64 or custom URL</label>
        <input type="text" id="steamId" name="steamId" required>
        <input type="submit" name="search" value="Search">
    </form>

</body>

</html>