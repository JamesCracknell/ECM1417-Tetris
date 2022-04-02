<?php session_start(); //start the session ?>
<!DOCTYPE html>
<html>
<head>
    <title> ECM1417 Tetris - Index </Title>
    <link rel='stylesheet' href='./res/pagestyle.css'>
    <?php
    // INSERT INTO Users VALUES (username, firstName, lastName, password, display);
   
    require "res/connect.php";
    
    // get data
    $username = $_POST['username'];
    $first_name = $_POST['firstName'];
    $last_name = $_POST['lastName'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirmpassword'];
    $valid_input = true;
    $in_db_username = "";

    // check data valid
    if (!(isset($username) && isset($first_name) && isset($last_name) && isset($password) && isset($confirm_password) && isset($_POST['display']))) {
        $valid_input = false;
        echo 'Not all data has been filled';
    }
    if (!preg_match('^[a-zA-Z -]*$', $first_name) || !preg_match('^[a-zA-Z -]*$', $last_name)) {
        $valid_input=false;
        echo 'Names must only contain letters, whitespace or -';
    }
    if (!($password == $confirm_password)){
        $valid_input=false;
        echo 'Passwords do not match';
    }
    $in_db_username = (mysqli_query($conn, "SELECT * FROM Users WHERE username = '" . $username));
    if ($in_db_username != "") {
        $valid_input=false;
        echo 'Username is not unique';
    }

    if ($_POST['display'] == 'yes'){ //stored as int in database
        $should_display = 1; // should display
    } else {
        $should_display = 0; // should not display
    }
    
    // add to database
    if ($valid_input = true){ // if the data was valid
        $sql = "INSERT INTO Users VALUES ('";
        $sql .= $_POST['username'] . "', '";
        $sql .= $_POST['firstName'] . "', '";
        $sql .= $_POST['lastName'] . "', '";
        $sql .= $_POST['password'] . "', '";
        $sql .= $should_display . "');";
        if (mysqli_query($conn, $sql) ) {
            echo "New user added to to db successfully";
          } else {
            echo "Error: ". mysqli_error($conn);
          }
    }
    mysqli_close($conn);

    // TODO - if error add button or force try again?
    // TODO - Appearnace 
    ?>
<style>
</style>
</head>
<body>
    <ul class='menu'>
        <li name='home' style='float:left'><a href='index.php'>Home</a></li>
        <li name='tetris' style='float:right'><a href='tetris.php'>Play Tetris</a></li>
        <li name='leaderboard' style='float:right'><a href='leaderboard.php'>Leaderboard</a></li>
    </ul>
    <div class='main'>
        <div id='login'>
            <?php
                if (!(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)){
            ?>  
            <div class='login-form' style='background-color: #c7c7c7; box-shadow: 5px 5px 5px; align-items: center'>
                <form id='login_form' action='/res/login.php' method='post'>
                <label for='username'>Username:<label><br>
                <input type='text' id='username' name='username' placeholder='username'><br>
                <label for='password'>Password:<label><br>
                <input type='password' id='password' name='password'><br>
                <input type='submit' value='Login'><br>    
                </form>
                <p> Don't have a user account? <a href = 'register.php'> Register Now </a> </p>
            </div>
            <?php } else { ?>
                        <!-- if user is logged in -->
            <!-- if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) { show all -->
                <h1> Welcome to Tetris </h1>
            <a href="tetris.php"><button type="button" class="play_button">Click here to play</button></a>
            <php } ?>
            
        </div>
    </div>

</body>
</html>