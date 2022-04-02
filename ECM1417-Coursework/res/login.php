
<?php
    require "res/connect.php";
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (!(isset($username) && isset($ $password))){
        exit("Both username and password must be entered.");
    }
    $sql = 'SELECT Password FROM Users WHERE Username="' . $username;
    $return = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 1) { //one return means that the username in database
        // verify password
        $row = mysqli_fetch_assoc($return);
        if ($row['Password'] = $password) {
            $_SESSION["loggedIn"] = true;
        }
    } else { //username is not in the database (does not exist)
        echo("Username not found: " . $username);
    }
    mysqli_close($conn);
?>