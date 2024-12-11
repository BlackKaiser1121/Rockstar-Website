<?php
    session_start();
    if (!isset($_SESSION['user_level']) || ($_SESSION['user_level'] != 1)) { // Admin can only access
        header("Location: login.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage Design</title>
    <link rel="stylesheet" href="style-homepage.css">
</head>
<body>
    <?php include "admin-navigation.php"; ?>

    <main>
        <div id="change-password">
            <img src="modify_password.png" alt="rdr1">
        </div>
    </main>

    <?php include 'footer.php'?>
</body>
</html>