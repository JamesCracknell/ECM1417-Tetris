<!DOCTYPE html>
<html>
<head>
    <link rel='stylesheet' href='./res/pagestyle.css'>
    <title> ECM1417 Tetris - Tetris Game </Title>
<style>
    #startButton {
        border:gray;
        padding: 14px 40px;
        font-size: 20px;
        border-radius: 8px;
        color: gray;
        position: absolute;
        top: 50%;
        left: 43%;
        text-align: center;
        cursor:pointer;
    }
    #startButton:hover {
        color:black;
    }
    #L {background-color: #ff7f00;}
    #Z {background-color: #ff0000;}
    #S {background-color: #00ff00;}
    #T {background-color: #800080;}
    #O {background-color: #ffff00;}
    #I {background-color: #00ffff;}

    div.piece{
        position: absolute;
    }
    div.block {
        position: absolute;
        width: 30px;
        height: 30px;
    }

</style>
</head>


<body onload='setUpPage()'>
    <ul class='menu'>
        <li name='home' style='float:left'><a href='index.php'>Home</a></li>
        <li name='tetris' style='float:right'><a href='tetris.php'>Play Tetris</a></li>
        <li name='leaderboard' style='float:right'><a href='leaderboard.php'>Leaderboard</a></li>
    </ul>
    <div class='main'>
        <!-- Rest of code -->
        <div id='game' style='background-color: #c7c7c7; box-shadow: 5px 5px 5px; margin: auto; width: 400px; height: 700px;'>
            <div id='tetris-bg' style='background-image: url("./res/tetris-grid-bg.png"); background-repeat: no-repeat; background-attachment: fixed;
                background-position: center center; width: 400px; height: 700px;'> </div>
        </div>
    </div>

<script>
    /* - Starts when "start the game" button clicked
     - new piece appears (score incremented by one) at top at start of game
     or when previous piece touches bottom of board of other block.
     - game stops when piece touches top of board
     - left and right arrow used to control as it falls

            blocks
     - pieces are square block div elements with class set to block
     - block id gives background colour of piece
     - tetris background must align with blocks
    
            data structures
     - 10x20 2D array of strings for grid
            - each string starts empty
            - string then comtrains id of div in that position
     - associative array for shape of game pieces
            - keys will be id of div variables
            - values will contain coordinates of squares that make up relevent type of game pieve
                • ”L” => [ [1,1],[1,2],[1,3],[2,3] ]
                • ”Z” => [ [1,1],[2,1],[2,2],[2,3] ]
                • ”S” => [ [1,2],[2,1],[2,2],[3,1] ]
                • ”T” => [ [1,1],[2,1],[2,2],[3,1] ]
                • ”O” => [ [1,1],[1,2],[2,1],[2,2] ]
                • ”I” => [ [1,1],[1,2],[1,3],[1,4] ]
    
            game
     - randomly select piece and assign variable currentBlock to it
     - check if start coordianates for currentblock at top of grid are empty
            if any are not empty, game end and submit current points in post rquest to leaderboard.php
            if all relevent are empty, coordinates on sgrid should be updates with letter of game piece defined by key of current block
     - "block" div elements should be created on webpage to display addition of currentBlock to top of grid
     - if left or right arrow key pressef then block should be moved within bounds of grid and without overlapping
     update block div elemtns using translate(x,y) css attributes
     - after one sec or when down key pressed
            - check if coordinates below currentBlock are occupied
            - if empty
                - move down cooridnates of current block by one on vertical axis, update div elements position
            - if not empty
                - div blocks should be set with div position attribute
                - program should check if any row is complete
                    - if so remove the row and move down all rows above
                        - mopve down in array, reposition block divs to show update positomns
    - return to step 1
    
    # maybe add music.


     */

    // define variables
    const gamePieces = { // associative array of game pieces
        // note this follows the given spec
        'L' : [[1,1],[1,2],[1,3],[2,3]], //orange
        'Z' : [[1,1],[2,1],[2,2],[2,3]], //red
        'S' : [[1,2],[2,1],[2,2],[3,1]], //green
        'T' : [[1,1],[2,1],[2,2],[3,1]], //purple
        'O' : [[1,1],[1,2],[2,1],[2,2]], //yellow
        'I' : [[1,1],[1,2],[1,3],[1,4]] //cyan
    }

    const gamePiecesAdjusted = {
        'L' : [[0,0],[0,1],[0,2],[1,2]], //orange
        'Z' : [[0,0],[1,0],[1,1],[1,2]], //red
        'S' : [[0,1],[1,0],[1,1],[2,0]], //green
        'T' : [[0,0],[1,0],[1,1],[2,0]], //purple
        'O' : [[0,0],[0,1],[1,0],[1,1]], //yellow
        'I' : [[0,0],[0,1],[0,2],[0,3]] //cyan 
    }
    var gamePieceNames = ['L', 'Z', 'S', 'T', 'O', 'I'];
    var currentPieceID = 0;
    var tetrisGrid = new Array(10) ;// 2D array for tetris grid
    for (var i = 0; i < tetrisGrid.length; i++) { // column x row
        tetrisGrid[i] = new Array(20);
    }
    var currentBlock; // holds the currently playing game piece
    var currentCoords = new Array(4); // holds the current coordinates
    for (var i = 0; i < 4; i++) {
        currentCoords[i] = new Array(2);
    }
    var downInterval //timer
    var userScore
    // main code

    document.addEventListener('keydown', logKey);
    
    function logKey(e){
        // detects if a keypress is made
        switch(e.code) {
            case 'ArrowLeft':
                moveBlock('left');
                break;
            case 'ArrowRight':
                moveBlock('right');
                break;
            case 'ArrowDown':
                moveBlock('down');
                break;
        } 
    }       

    function setUpPage(){ // starts on load
        var startButton = document.createElement('button')
        startButton.setAttribute('type', 'button');
        startButton.setAttribute('id', 'startButton');
        startButton.innerText = 'Start the Game';
        startButton.setAttribute('onclick', 'startGame()'); //when clicked
        document.getElementsByClassName('main')[0].appendChild(startButton);
    }

    function startGame(){ // when start button clicked
        document.getElementById('startButton').remove();
        // select new game piece
        playTile();
        
    }

    function playTile(){
        userScore +=1 //add one point to score
        clearInterval(downInterval); 
        currentBlock = getNextBlockID();
        currentPieceID+=1
        for (var i = 0; i < 4; i++) { // check if starting space is emptys
            if (checkIfEmpty(getStartingBlockCoords(currentBlock)[i])){
                // the space is not clear
                // TODO
                //  game should end and the current points submitted to the server in a post request to leaderboard.php
                alert("game should end now")
            }
        }
        var tetrisPiece = document.createElement('div') // group of blocks makes piece.
        tetrisPiece.setAttribute('class', 'tetris-piece')
        tetrisPiece.setAttribute('id', currentPieceID)
        document.getElementById('game').appendChild(tetrisPiece);
        createBlock(currentBlock, tetrisPiece)
        downInterval = setInterval(moveDown, 1000) //if 1s goes by, moves piece down automatically
    }

    function getNextBlockID(){ //gets next game piece ID, either when game starts or previous peice finishes
        return gamePieceNames[Math.floor((Math.random()*6))]; // random number between 1 and 6
    }

    function getStartingBlockCoords(nextBlockID){
        var currentBlockCoords
        for (var key in gamePiecesAdjusted) {
            if (key == nextBlockID) {
                currentBlockCoords = gamePiecesAdjusted[key]; //-1 to 0 index
            }
        }
        return currentBlockCoords;
    }

    
    function checkIfEmpty(coordinates){
        if(tetrisGrid[coordinates[0]][coordinates[1]] != null){
            return true //space is not empty
        } else {
            return false 
        }
    }

    function createBlock(blockID, piece){
        for (var i = 0; i < 4; i++) {
            // to do test
            tetrisGrid[getStartingBlockCoords(blockID)[i][0]][getStartingBlockCoords(blockID)[i][1]]=currentBlock;
            // end of to do
            var block = document.createElement('div');
            block.setAttribute('class', 'block');
            block.setAttribute('id', blockID);
            var horizontalPosition = 263;
            block.style.left = horizontalPosition + 'px';
            var verticalPosition = 643;
            block.style.bottom = verticalPosition + 'px';
            block.style.transform = 'translate('+(30*getStartingBlockCoords(blockID)[i][0]-30)+'px, '+(30*getStartingBlockCoords(blockID)[i][1]-30)+'px)';
            currentCoords[i][0]=getStartingBlockCoords(blockID)[i][0];
            currentCoords[i][1]=getStartingBlockCoords(blockID)[i][1];
            piece.appendChild(block);
        }
    }

    function moveBlock(direction){ // moves block based on user input
        var xtranslation = 0 //left = -1
        var ytranslation = 0 //down = +1
        switch(direction){
            case 'left':
                xtranslation = -1;
                break;
            case 'right':
                xtranslation = 1;
                break;
            case 'down':
                clearInterval(downInterval); //reset downInterval
                downInterval = setInterval(moveDown, 1000)
                ytranslation = 1;
                break;
        }
        if (!(checkObstructions(xtranslation, ytranslation))) { //no obstructions
            for (var j = 0; j < 4; j++) { tetrisGrid[currentCoords[j][0]][currentCoords[j][1]] = null; } //clear current piece from grid
            for (var i = 0; i < 4; i++) { //update grid
                currentCoords[i][0] += xtranslation;
                currentCoords[i][1] += ytranslation;
                var currentPiece = document.getElementById(currentPieceID);
                var blockToMove = currentPiece.children[i];
                blockToMove.style.transform = 'translate('+(30*currentCoords[i][0]-30)+'px, '+(30*currentCoords[i][1]-30)+'px)';
                tetrisGrid[currentCoords[i][0]][currentCoords[i][1]] = currentBlock; //place piece in new place
            }
        }
    }

    function checkObstructions(xtranslation, ytranslation){ //check if move is valid
        // if out of bounds
        var obstructed = false;
        for (var i = 0; i < 4; i++) {
            if (!(((currentCoords[i][0] + xtranslation) < 0) || ((currentCoords[i][0] + xtranslation) > 9) || (currentCoords[i][1] + ytranslation) > 19)) {
                // if spot to move to is empty
                for (var j = 0; j < 4; j++) { tetrisGrid[currentCoords[j][0]][currentCoords[j][1]] = null; } //clear current piece from grid
                if ((tetrisGrid[currentCoords[i][0] + xtranslation][currentCoords[i][1] + ytranslation]!= null)) { // TO DO TEST WITH OTHER PIECES
                    obstructed = true;
                    if (([currentCoords[i][1] + ytranslation]!= null)){ //it has hit a piece
                        for (var j = 0; j < 4; j++) { tetrisGrid[currentCoords[j][0]][currentCoords[j][1]] = currentBlock; } //replace block
                        playTile()
                    }
                }
                for (var j = 0; j < 4; j++) { tetrisGrid[currentCoords[j][0]][currentCoords[j][1]] = currentBlock; } //return current piece to grid
                
            } else {  
                obstructed = true;
                if ((currentCoords[i][1] + ytranslation) > 19){ //bottom of grid
                    playTile()
                }
            }
        }
        return obstructed;
    }

    function moveDown(){ //move down when 1 second has passed
        moveBlock('down');
    }
</script>

</body>
</html>