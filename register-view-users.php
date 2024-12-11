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
<?php include 'admin-navigation.php'?>
<body>
    <main class="content">
        <h2>Registered User</h2>
        <p>
            <?php
                require("mysqli_connect.php");
                $q = "SELECT fname, lname, psword,email, DATE_FORMAT(registration_date, '%M %d, %Y') AS regdat, user_id from users";
                $result = @mysqli_query($dbcon, $q);
                if ($result){
                    echo '<table><tr><td><strong>Name</strong></td><td><strong>Email</td><td><strong>Registered
                    Date</strong></td><td colspan="2"><strong>Actions</strong></td></tr>';
                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                        echo '<tr>
                        <td>'.$row['fname'].' '.$row['lname'].'</td>
                        <td>'.$row['email'].'</td>
                        <td>'.$row['regdat'].'</td>
                        <td><a href="edit_user.php?id='.$row['user_id'].'" class="button">Edit </td>
                        <td><a href="delete_user.php?id='.$row['user_id'].'" class="button">Delete</a></td>
                         </tr>';
                        
                    }
                    echo '</table>';
                    mysqli_free_result($result);
                }else{
                    echo '<h2> System Error<h2>
                        <p class="error"> The current users could not be retrieved. Contact the system administration</p>';
                        echo '<p>'. mysqli_error($dbcon);
                }
                mysqli_close($dbcon);
                
                
            ?>           
        </p>     
    </main>
    <?php include 'footer.php'?>  
</body>

</html>




    