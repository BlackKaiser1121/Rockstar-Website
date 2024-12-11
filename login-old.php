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
                require('mysqli_connect.php');
                if(empty($_POST['email'])){
                    echo '<p class="error">Please input your email address.</p>';
                }else{
                    $e = trim($_POST['email']);
                }

                if(empty($_POST['psword'])){
                    echo '<p class="error">Please input your password.</p>';
                }else{
                    $p = trim($_POST['psword']);
                }

                if ($e && $p){
                    $q = "SELECT user_id, fname, user_level FROM users WHERE (email = '$e' AND psword = '$psword');";
                    $result = @mysqli_query($dbcon, $q);

                    if(@mysqli_num_rows($result) == 1){
                        session_start();
                        $_SESSION = mysqli_fetch_array($result, MYSQLI_ASSOC);
                        $_SESSION['user_level'] = (int) $_SESSION['user_level'];
                        $url = ($_SESSION['user_level'] === 1) ? 'admin-homepage.php' : 'members-homepage.php';
                        header('Location: '.$url);
                        exit();
                        mysqli_free_result($result);
                        mysqli_close($dbcon);
                    }else{
                        echo '<p class="error">This account does not exist. Please register first.</p>';
                    }
                }else{
                    echo '<p class="error"> Please try again.</p>';
                }
            }
        ?>
  
            <form action="login.php" method="post">
                <h2>Login</h2>
                
                
        
                <p><label class="label" for"email" style="color: black;">Email Address </label>
                <input type="email" id="email" name="email" size="12" maxlength="" value="<?php if(isset($_POST['email']))  echo $_POST['email']?>">
                </p>
        
                <p><label class="label" for"psword" style="color: black;">Password </label>
                <input type="password" id="psword" name="psword" size="30" maxlength="40" value="<?php if(isset($_POST['psword']))  echo $_POST['psword']?>">
                </p>


                <p><input type="submit" id="submit" name="submit" value="Login"</p>
            </form>
        </div>

    </div>
    
</body>

</html>
