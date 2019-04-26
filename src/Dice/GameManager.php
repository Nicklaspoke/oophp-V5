<?php

namespace Niko\DiceGame;

class GameManager
{
    /**
     * @var array<player>   $players            Array containing all the players
     * @var Dice            $diceHand           The diceHand that holds all the dice/s
     * @var int             $nPlayers           The number of players in the game
     * @var int             $startingPlayer     The index of the player gets the first round
     * @var int             $currentPlayer      The current players index in the players array
     * @var array<int>      $currentHandValues  The values from the last throw of dice/s
     */
    private $players;
    private $diceHand;
    private $nPlayers;
    private $startingPlayer;
    private $currentPlayer;
    private $currentHandValues;

    /**
     * Contructor for the whole game
     *
     * @param int $nPlayers     The number of players that will play the game, default is 1 human and one AI
     * @param int $nDice        The number of dice/s to be used in the game, default is 1 dice
     * @param int $nDiceFaces   The number of sides/faces every dice in the game will have, default i a 6 sided dice
     */
    public function __construct($nPlayers = 1, $nDice = 1, $nDiceFaces = 6)
    {
        if ($nPlayers === 1) {
            $this->players[] = new Player();
            $this->players[] = new Player(true);
        } else {
            for ($i = 0; $i < $nPlayers; $i++) {
                $this->players[] = new Player();
            }
        }

        $this->diceHand = new DiceHand($nDice, $nDiceFaces);
        $this->nPlayers = $nPlayers;
    }

    /**
     * Determines playerOrder, the player with the highest dice value begins
     * and then down from there in decending order
     */
    public function determinPlayerOrder()
    {
        $highestValue = 0;
        $highestValueIndex = -1;

        for ($i = 0; $i < $this->nPlayers; $i++) {
            $this->diceHand->toss();
            $lastThrownValue = $this->diceHand->getCurrentTossValues()[0];

            if ($highestValue === 0) {
                $highestValue = $lastThrownValue;
                $highestValueIndex = $i;
            } elseif ($lastThrownValue > $highestValue) {
                $highestValue = $lastThrownValue;
                $highestValueIndex = $i;
            }
        }

        $this->startingPlayer = $highestValueIndex;
    }

    /**
     * Checks if any player has reashed 100 points, if they have return the player index
     * if not return -1
     *
     * @return int
     */
    public function checkIfGameDone() : int
    {
        $playerIndex = -1;

        for ($i = 0; $i < $this->nPlayers; $i++) {
            if ($this->players[$i]->getTotalScore() >= 100) {
                $playerIndex = $i;
                return $playerIndex;
            }
        }

        return $playerIndex;
    }
}
