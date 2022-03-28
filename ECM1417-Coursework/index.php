<!DOCTYPE html>
<html>
<head>
    <title> ECM1417 Tetris - Index </Title>
<style>
    ul.menu {
        list-style-type: none;
        background-color: blue;
        overflow: hidden;
        margin: 0;
        padding: 0;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
    }

    ul.menu li a{
        float: left;
        font-family: Arial;
        font-weight: bold;
        font-size: 12px;
    }
    ul.menu li home{
        float: right;
    }

    ul.menu li a{
        display: block;
		width:2cm;
		height:0.7cm;
		padding-top: 10px;
        padding-left: 20px;
		color:white;
		text-decoration:none;
    }

    body {
        background-image: url("/res/tetris.png");
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-position: center;
        background-size: 95%;
    }

</style>
</head>

<body>
    <ul class="menu">
        <li name="home" style="float:left"><a href="index.php">Home</a></li>
        <li name="tetris" style="float:right"><a href="tetris.php">Play Tetris</a></li>
        <li name="leaderboard" style="float:right"><a href="leaderboard.php">Leaderboard</a></li>
    </ul>
    <div class="main">
        <!-- Rest of code -->
<?php
/* shared navbar menu at the top of the page
1. Home - name=”home”
2. Play Tetris - name=”tetris”
3. Leaderboard - name=”leaderboard”

The navbar items must use the Arial font in bold with fontsize 12px. The Home item should be
aligned on the left and the Play Tetris and Leaderboard items on the right. The navbar background
colour must be ’blue’.
Each webpage must then contain the rest of the content for the webpage in a div with class
attribute value of ”main”. The main div will have a background image, this must be the Tetris
image (tetris.png) provided on ELE, set at 95% width of the main container and in a fixed position
in the centre, vertically and horizonally.

*/

/*
The landing page (index.php) must display the welcome message ’Welcome to Tetris’ if the user is
logged in followed by a button with the content ’Click here to play’ that contains a hyperlink to the
tetris.php page. Alternatively, if the user isn’t logged in the landging page should provide a login
form with input boxes for username and password followed by a paragraph with the content ”Don’t
have a user account? Register now” where the Register now text has a hyperlink to register.php.
The username field should have a placeholder of ’username’. The login form or welcome message
must be in a div with a grey (hexcode c7c7c7) background and 5px box-shadow and the box must
be centred.
*/


?>

</body>
</html>