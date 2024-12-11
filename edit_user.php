<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit User - Website ni Baquirin</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style-homepage.css">
</head>

<body>
    <?php include "admin-navigation.php"; ?>

<main>
    <div id="Edit_user">
        <h1>Edit User Information</h1>
        <?php
        require("mysqli_connect.php");

        
        if ((isset($_GET['id']) && is_numeric($_GET['id'])) || (isset($_POST['id']) && is_numeric($_POST['id']))) {
            $id = isset($_GET['id']) ? $_GET['id'] : $_POST['id'];
        } else {
            echo '<p>No valid ID.</p>';
            echo '<ul><li><a href="register-view-users.php">Back to User List</a></li></ul>';
            exit();
        }

        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $fname = trim($_POST['fname']);
            $lname = trim($_POST['lname']);
            $email = trim($_POST['email']);

            
            if (!empty($fname) && !empty($lname) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $stmt = $dbcon->prepare("UPDATE users SET fname = ?, lname = ?, email = ? WHERE user_id = ?");
                $stmt->bind_param("sssi", $fname, $lname, $email, $id);
                $stmt->execute();

                if ($stmt->affected_rows == 1) {
                    echo '<div id="text"><h3>User information updated successfully.</h3></div>';
                } else {
                    echo '<p>Error: Could not update the user or no changes were made.</p>';
                }
                $stmt->close();
            } else {
                echo '<p>Please fill out all fields and provide a valid email address.</p>';
            }
        } else {
            $stmt = $dbcon->prepare("SELECT fname, lname, email FROM users WHERE user_id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows == 1) {
                $stmt->bind_result($fname, $lname, $email);
                $stmt->fetch();

                echo '
                <form action="edit_user.php" method="post">
                    <label for="fname">First Name:</label>
                    <input type="text" name="fname" id="fname" value="' . htmlspecialchars($fname) . '" required>

                    <label for="lname">Last Name:</label>
                    <input type="text" name="lname" id="lname" value="' . htmlspecialchars($lname) . '" required>

                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" value="' . htmlspecialchars($email) . '" required>

                    <input type="hidden" name="id" value="' . $id . '">
                    <input type="submit" value="Save Changes" class="button">
                </form>
                ';
            } else {
                echo '<p>User not found.</p>';
            }
            $stmt->close();
        }

        mysqli_close($dbcon);
        ?>
    </div>
</main>
<?php include 'footer.php'; ?>
</body>
</html>