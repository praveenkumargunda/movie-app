<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Logout logic
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['logout'])) {
    $_SESSION = array();
    session_destroy();
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Page</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="welcome-page">
    <header>
        <h1>Welcome to Our Movie App!</h1>
        <form method="post">
            <input type="submit" name="logout" value="Logout">
        </form>
        <form action="mylist.php">
            <input type="submit" value="My List">
        </form>
        <form action="welcome.php" class="back-button">
            <input type="submit" value="Back">
        </form>
    </header>
    <div class="main">
        <div class="welcome-container">
            <h2>Welcome!</h2>
            <form action="search.php" method="get">
                <input type="text" name="query" placeholder="Search for a movie...">
                <input type="submit" value="Search">
            </form>
        </div>
    </div>
</body>
</html>
