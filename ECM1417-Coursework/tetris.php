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

    #game{
        background-color: #c7c7c7;
        box-shadow: 5px 5px 5px;
        background-position: center center;
        size: auto;
        margin: 0 auto;
        margin-top: 50px;
        width: 400px;
        height: 650px;
    }
    #tetris-bg{
        background-image: url("./res/tetris-grid-bg.png");
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-position: center center;
        size: auto;
        margin:auto;
        width: 95%;
        height: 700px;
    }
    div.piece{
        position: absolute;
    }
    div.block {
        left: 41.6vw;
        top: 6vw;
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
        <div id='game'>
            <div id='tetris-bg'></div>
        </div>
    </div>

<script>

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
    var userScore = 0
    var gameOver = false
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
                <?php "Hello I am a test" ?>
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
        if (!gameOver){
            userScore +=1 //add one point to score
            clearInterval(downInterval); 
            currentBlock = getNextBlockID();
            currentPieceID+=1;
            for (var i = 0; i < 4; i++) { // check if starting space is emptys
                if (checkIfEmpty(getStartingBlockCoords(currentBlock)[i]) && !gameOver){
                    gameOver = true;
                    clearInterval(downInterval); //reset downInterval
                    postLeaderboardScore(); //game ended
                }
            }
            var tetrisPiece = document.createElement('div') // group of blocks makes piece.
            tetrisPiece.setAttribute('class', 'tetris-piece')
            tetrisPiece.setAttribute('id', currentPieceID)
            document.getElementById('game').appendChild(tetrisPiece);
            createBlock(currentBlock, tetrisPiece)
            downInterval = setInterval(moveDown, 1000) //if 1s goes by, moves piece down automatically
        }

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
            tetrisGrid[getStartingBlockCoords(blockID)[i][0]][getStartingBlockCoords(blockID)[i][1]]=currentBlock;
            var block = document.createElement('div');
            block.setAttribute('class', "block " + "C"+getStartingBlockCoords(blockID)[i][0]+"R"+getStartingBlockCoords(blockID)[i][1]);
            block.setAttribute('id', blockID); //this is the colour
            //var horizontalPosition = 263;
            //block.style.left = horizontalPosition + 'px';
            //var verticalPosition = 643;
            //block.style.bottom = verticalPosition + 'px';
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
                blockToMove.setAttribute('class', "block " + "C"+currentCoords[i][0]+"R"+currentCoords[i][1]);
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
                if ((tetrisGrid[currentCoords[i][0] + xtranslation][currentCoords[i][1] + ytranslation]!= null)) {
                    obstructed = true;
                    if (([currentCoords[i][1] + ytranslation]!= null)){ //it has hit a piece
                        for (var j = 0; j < 4; j++) { tetrisGrid[currentCoords[j][0]][currentCoords[j][1]] = currentBlock; } //replace block
                        rowComplete(); // check if a row is complete
                        playTile()
                    }
                }
                for (var j = 0; j < 4; j++) { tetrisGrid[currentCoords[j][0]][currentCoords[j][1]] = currentBlock; } //return current piece to grid
                
            } else {  
                obstructed = true;
                if ((currentCoords[i][1] + ytranslation) > 19){ //bottom of grid
                    rowComplete(); // check if a row is complete
                    playTile()
                }
            }
        }
        return obstructed;
    }

    function moveDown(){ //move down when 1 second has passed
        moveBlock('down');
    }

    function rowComplete(){ //checks if a row in the grid is complete
        var rowComplete;
        for (var j = 0; j < 20; j++){ //for row
            rowComplete=true;
            for (var i = 0; i < 10; i++){ //for column
                if(tetrisGrid[i][j] == null){ //if a square is empty
                    rowComplete = false;
                }
            }
            if (rowComplete == true){
                emptyRow(j);
                break;
            }
        }
    } 

    function emptyRow(rowToEmpty){
        for (var i = 0; i < 20; i++){
            if (i = rowToEmpty){
                for (var j = 0; j < 10; j++){
                    tetrisGrid[j][i] = null //empty the row in the grid
                    blockToRemove = ('class', 'block ' + 'C'+j+'R'+i);
                    document.getElementsByClassName(blockToRemove)[0].remove();
                }
                startNumber = i-1
                for (var k = startNumber; k > 0; k--){ // loop through all rows above
                    for (var j = 0; j < 10; j++){
                        if (tetrisGrid[j][k] != null){ // if element has something in it
                            tetrisGrid[j][k+1] = tetrisGrid[j][k] // move down
                            tetrisGrid[j][k] = null //empty the row in the grid
                            blockName = ('class', 'block ' + 'C'+j+'R'+k);
                            var blockToMove = document.getElementsByClassName(blockName)[0];
                            blockToMove.setAttribute('class', 'block ' + 'C'+j+'R'+k+1);
                            blockToMove.style.transform = 'translate('+(30*j-30)+'px, '+(30*(k+1)-30)+'px)';
                        } 

                    }
                }
                rowComplete() //re-call to check for other rows
                break;
            }

        }
    }

    function postLeaderboardScore(){
        alert("Game over.") 
        var request = new XMLHttpRequest();
        request.open('POST', 'leaderboard.php');
        request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        alert(userScore)
        dataToSend = "score="+userScore;
        request.send(dataToSend);       
    }

</script>

</body>
</html>