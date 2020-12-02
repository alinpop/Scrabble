#Concepts

##App
* has Players
* has Games

##Game
* has Players
* has a Board
* has a Bag of Letters
* changes Player Turn (to move)
* decides when the Game is over
* decides which Player won
* keeps the Score

##Player
* in Game State:
    * has Letters
    * has Score
    * has Turn (to move)
    * moves (adds Letters)
    * can be Winner
    * add Player to Game
    * start Game
    * abort Game
    * pass move to next Player
    * change Letters
    * add Letters to the Board
    * has Time
* in App
    * login
    * create account
    * prepare Game

## Game State
* belongs to Player 
* compute Word value

##Board
* has Squares [1-15, A-O]
    * Squares have Letters
    * Squares have Values
        * x times the Value of the Word
        * x times the Value of the Letter
* has Words
* validate move

##Letter
* has Value

##Bag of Letters
* has Letters
* counter

##Word
* has Validation

# Help

## Xdebug
In windows CLI activate the debugger with `set XDEBUG_CONFIG="idekey=PHPSTORM"`.