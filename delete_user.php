<!DOCTYPE html>
<html lang="en">
<head>
    <title>Delete User - Website ni Baquirin</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style-homepage.css">
</head>

<body>
    <?php include "navigation.php" ?>

<main>
    <div id="Delete_user">
        <h1>Deleting Record...</h1>
        <?php
        // Checking for a valid ID number
        if ((isset($_GET["id"]) && is_numeric($_GET["id"]))) {
            require("mysqli_connect.php");
            $id = $_GET["id"];
        } else if ((isset($_POST["id"]) && is_numeric($_POST["id"]))) {
            $id = $_POST["id"];
            require("mysqli_connect.php");
        } else {
            echo '<p>No valid ID.</p>';
            echo '<li><a href="Home.php">Home</a></li>';
            exit();
        }

        require('mysqli_connect.php');
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($_POST['sure'] == 'Yes') {
                $q = "DELETE FROM users WHERE user_id = $id";
                $result = @mysqli_query($dbcon, $q);
                if (mysqli_affected_rows($dbcon) == 1) {
                    echo '<p>Deleted Successfully.</p>';
                    echo '<ul><li><a href="register-view-users.php" class="button">Back to User List</a></li></ul>';
                } else {
                    echo '<p>Error: Could not delete the user.</p>';
                }
            } else {
                echo '<h3>Record was not deleted.</h3>';
                echo '<ul><li><a href="register-view-users.php" class="button">Back to User List</a></li></ul>';
            }
        } else {
            $q = "SELECT CONCAT(fname, ' ', lname) FROM users WHERE user_id = $id";
            $result = @mysqli_query($dbcon, $q);
            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_array($result, MYSQLI_NUM);
                echo "<h3>Are you sure you want to delete $row[0]?</h3>";
                echo '                
                <form action="delete_user.php" method="post">                   
                    <input id="submit-yes" type="submit" name="sure" value="Yes">           
                    <input id="submit-no" type="submit" name="sure" value="No">
                    <input type="hidden" name="id" value="'.$id.'">
                </form>               
                ';
            } else {
                echo '<h3>User unknown.</h3>';
                echo '<li><a href="register.php">Register</a></li>';
            }
        }
        mysqli_close($dbcon);
        ?>
    </div>
</main>
<?php include 'footer.php'?>
</body>
</html>
