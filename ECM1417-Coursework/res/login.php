
<?php
    session_start(); //start the session 
    require 'connect.php';
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (!(isset($username) && isset($password))){
        echo('Both username and password must be entered.');
    }
    $sql = 'SELECT Password FROM Users WHERE UserName="' . $username . '";';
    $return = mysqli_query($conn, $sql);
    if (mysqli_num_rows($return) == 1) { //one return means that the username in database
        // verify password
        $row = mysqli_fetch_assoc($return);
        if ($row['Password'] = $password) {
            $_SESSION['loggedIn'] = true;
            echo("Logged in successfully");
        } else {
            echo("Incorrect password");
        }
    } else { //username is not in the database (does not exist)
        echo('Username not found: ' . $username);
    }
    mysqli_close($conn);
    header('Location: ../index.php'); //return to index
?>