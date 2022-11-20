<?php
require_once "vendor/autoload.php";

use App\Game;
use App\Player;
use App\PlayerCollection;

$playerDb = new PlayerCollection();
//player info input - amount of cash
$playerAge = (int)readline("Enter your age :");
if ($playerAge < 18) {
    echo "Grow up little kido, nothing to see here!!!" . PHP_EOL;
    exit;
}

$playerName = (string)readline("Enter your name :");
echo PHP_EOL;


echo 'Welcome to the Ca$ino, prepare to double your $$$$$!' . PHP_EOL;
$balance = 0;
$depositAmount = (int)readline("Enter the amount of money to buy in : ");
echo PHP_EOL;

/*if ($playerMoney < 1) {
   echo "Sorry, the amount of money is invalid! Please choose  larger amount! y_(^_^)_y";}*/
$player = new Player($playerName, $playerAge);
$playerDb->addPlayer($player);
$player->deposit($depositAmount);
echo "Your balance is : " . $player->getBalance() . " $" . PHP_EOL;
while (true) {
    $game = new Game();

    echo "[1] Spin \n [2] Select number of lines \n [3] Select bet on one line \n [4] Deposit \n [5] Withdraw and Quit \n";
    $selection = (int)readline('Select option : ');

    switch ($selection) {
        case 1:
            $game->spin();
            $player->withdraw($game->getBet());
            echo $game->showDisplay();
            $player->deposit($game->countWinAmount());
            echo "You have won " . $game->countWinAmount() . " $! Your balance is : " . $player->getBalance() . PHP_EOL;
            echo "Currently selected line count :" . $game->getLineCount() . " || And current bet :" . $game->getBet() . PHP_EOL;
            break;
        case 2:
            $lineCount = (int)readline('Enter num of lines (5) or (3) :');
            echo PHP_EOL;
            $game->setLineCount($lineCount);
            break;
        case 3:
            $betOnLine = (float)readline('Enter on one lines : ');
            if ($betOnLine > $player->getBalance()) {
                echo 'Invalid amount';
                break;
            }
            $game->setBet($betOnLine);
            break;
        case 4:
            $amount = readline('Enter deposit amount :');
            $player->deposit($amount);
            break;
        case 5:
            $player->withdraw($player->getBalance());
    }


}