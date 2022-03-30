<?php session_start(); //start the session ?>
<!DOCTYPE html>
<html>
<head>
    <title> ECM1417 Tetris - Index </Title>
    <link rel='stylesheet' href='./res/pagestyle.css'>
    <?php
    // INSERT INTO Users VALUES (username, firstName, lastName, password, display);
   
    require "res/connect.php";
    //if // data is all valid then
    if ($_POST['display'] == 'yes'){
        $should_display = 1; // should display
    } else {
        $should_display = 0; // should not display
    }
    
    $sql = "INSERT INTO Users VALUES ('";
    $sql .= $_POST['username'] . "', '";
    $sql .= $_POST['firstName'] . "', '";
    $sql .= $_POST['lastName'] . "', '";
    $sql .= $_POST['password'] . "', '";
    $sql .= $should_display . "');";
    if (mysqli_query($conn, $sql) ) {
        echo "New task added successfully";
      } else {
        echo "Error: ". mysqli_error($conn);
      }
    mysqli_close($conn);
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
        <!-- Rest of code -->

        Welcome to Tetris.
<!--
The landing page (index.php) must display the welcome message ’Welcome to Tetris’ if the user is
logged in followed by a button with the content ’Click here to play’ that contains a hyperlink to the
tetris.php page. Alternatively, if the user isn’t logged in the landging page should provide a login
form with input boxes for username and password followed by a paragraph with the content ”Don’t
have a user account? Register now” where the Register now text has a hyperlink to register.php.
The username field should have a placeholder of ’username’. The login form or welcome message
must be in a div with a grey (hexcode c7c7c7) background and 5px box-shadow and the box must
be centred.
-->
    </div>

</body>
</html>