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
                // if button is pressed
                if($_SERVER['REQUEST_METHOD'] == 'POST'){
                    $errors = array();
                    // is name != null?
                    if(empty($_POST['fname'])){
                        $errors[] = 'Please enter your first name.';
                    }else{
                        $fn = trim($_POST['fname']);
                    }
                    // ln and e != null?

                    if(empty($_POST['lname'])){
                        $errors[] = 'Please enter your last name.';
                    }else{
                        $ln = trim($_POST['lname']);
                    }

                    if(empty($_POST['email'])){
                        $errors[] = 'Please enter your email.';
                    }else{
                        $e = trim($_POST['email']);
                    }


                    if(!empty($_POST['psword1'])){
                        if($_POST['psword1'] != $_POST['psword2']){
                            $errors[] = 'Your passwords do not match.';
                        }else{
                            $p = trim($_POST['psword1']);
                        }
                    }else{
                        $errors[] = 'Please enter your password.';
                    }
                    
                    //lahat ng textbox ay may laman.
                    if(empty($errors)) {
                        $hashed_password = password_hash($p, PASSWORD_DEFAULT);
                        // Register the user in the database...
                        require ('mysqli_connect.php'); // Connect to the db.
                        // Make the query:
                        $q = "INSERT INTO users (fname, lname, email, psword, registration_date) VALUES ('$fn', '$ln', '$e', '$hashed_password', NOW())";		//this password ($p) is NOT encrypted. find a way to secure this password
                        $result = @mysqli_query ($dbcon, $q); // Run the query.
                        if ($result) { // If it ran OK.
                            header ("Location: register_thanks.php"); 
                        exit();	
                        } else { // If it did not run OK.
                            //Public message:
                            echo '<h2>System Error</h2>
                            <p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>'; 
                            // Debugging message:
                            echo '<p>' . mysqli_error($dbcon) . '</p>';
                        }
                        mysqli_close($dbcon); // Close the database connection.
                        // Include the footer and quit the script:
                        include ('footer.php');
                        exit();
                    }else{
                        echo '<h2>Error!</h2>
                        <p class="error">The following error(s) occured:<br/>
                        ';
                        foreach($errors as $msg){
                            echo "- $msg<br/>";
                        }
                        echo '</p><h4>Please try again.</h4><br/><br/>';
                    
                    }
                }
                
                
            ?>
            <form action="register_page.php" method="post">
                <h2>Create an Account</h2>
                <p><label class="label" for"fname" style="color: black;">First Name </label>
                <input type="text" id="fname" name="fname" size="30" maxlength="40" value="<?php if(isset($_POST['fname']))  echo $_POST['fname']?>">
                </p>
        
                <p><label class="label" for"lname" style="color: black;">Last Name </label>
                <input type="text" id="lname" name="lname" size="30" maxlength="40" value="<?php if(isset($_POST['lname']))  echo $_POST['lname']?>">
                </p>
        
                <p><label class="label" for"email" style="color: black;">Email Address </label>
                <input type="email" id="email" name="email" size="30" maxlength="50" value="<?php if(isset($_POST['email']))  echo $_POST['email']?>">
                </p>
        
                <p><label class="label" for"psword1" style="color: black;">Password </label>
                <input type="password" id="psword1" name="psword1" size="30" maxlength="40" value="<?php if(isset($_POST['psword1']))  echo $_POST['psword1']?>">
                </p>

                <p><label class="label" for"psword2" style="color: black;">Confirm Password </label>
                <input type="password" id="psword2" name="psword2" size="30" maxlength="40" value="<?php if(isset($_POST['psword2']))  echo $_POST['psword2']?>">
                </p>

                <p><input type="submit" id="submit" name="submit" value="Register"</p>
            </form>
        </div>

    </div>
    
</body>

</html>