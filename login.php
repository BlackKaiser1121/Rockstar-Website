<!doctype html>
<html lang="en">
<head>
    <title>RED</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="style-reglog.css">
</head>
<body>
    <div id="container">

        <div id="header">
            <img src="rockstar-logo-no-border.png" alt="rockstar-logo-no-border">
        </div>

        <div id="content">
        <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                require('mysqli_connect.php'); // Database connection
                
                $errors = [];

                // Validate email
                if (empty($_POST['email'])) {
                    $errors[] = 'Please enter your email address.';
                } else {
                    $e = trim($_POST['email']);
                }

                // Validate password
                if (empty($_POST['psword'])) {
                    $errors[] = 'Please enter your password.';
                } else {
                    $p = trim($_POST['psword']);
                }

                if (empty($errors)) {
                    // Use a prepared statement to avoid SQL injection
                    $stmt = $dbcon->prepare("SELECT user_id, fname, psword, user_level FROM users WHERE email = ?");
                    $stmt->bind_param('s', $e);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows === 1) {
                        $row = $result->fetch_assoc();
                        
                        // Verify the password using password_verify()
                        if (password_verify($p, $row['psword'])) {
                            // Password is correct and hashed
                            session_start();
                            $_SESSION['user_id'] = $row['user_id'];
                            $_SESSION['fname'] = $row['fname'];
                            $_SESSION['user_level'] = (int) $row['user_level'];
                        
                            // Redirect to the appropriate homepage
                            $url = ($_SESSION['user_level'] === 1) ? 'admin-homepage.php' : 'members-homepage.php';
                            header('Location: ' . $url);
                            exit();
                        } elseif ($p === $row['psword']) {
                            // Password is correct but unhashed
                            // Optionally re-hash the password and update the database
                            $hashed_password = password_hash($p, PASSWORD_DEFAULT);
                            $update_stmt = $dbcon->prepare("UPDATE users SET psword = ? WHERE user_id = ?");
                            $update_stmt->bind_param('si', $hashed_password, $row['user_id']);
                            $update_stmt->execute();
                            $update_stmt->close();
                        
                            session_start();
                            $_SESSION['user_id'] = $row['user_id'];
                            $_SESSION['fname'] = $row['fname'];
                            $_SESSION['user_level'] = (int) $row['user_level'];
                        
                            // Redirect to the appropriate homepage
                            $url = ($_SESSION['user_level'] === 1) ? 'admin-homepage.php' : 'members-homepage.php';
                            header('Location: ' . $url);
                            exit();
                        } else {
                            // Password is incorrect
                            echo '<p class="error">Invalid email or password.</p>';
                        }
                        
                    } else {
                        echo '<p class="error">This account does not exist. Please register first.</p>';
                    }

                    $stmt->close();
                    $dbcon->close();
                } else {
                    echo '<p class="error">Please correct the following errors:</p>';
                    foreach ($errors as $msg) {
                        echo "<p>- $msg</p>";
                    }
                }
            }
        ?>
  
            <form action="login.php" method="post">
                <h2>Login</h2>

                <p><label class="label" for="email" style="color: black;">Email Address</label>
                <input type="email" id="email" name="email" size="30" maxlength="50" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>">
                </p>

                <p><label class="label" for="psword" style="color: black;">Password</label>
                <input type="password" id="psword" name="psword" size="30" maxlength="40" value="<?php if (isset($_POST['psword'])) echo $_POST['psword']; ?>">
                </p>

                <p><input type="submit" id="submit" name="submit" value="Login"></p>
            </form>
        </div>

    </div>
</body>
</html>
