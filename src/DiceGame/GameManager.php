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
     * @var int             $currentRoundScore  The total score the player has collected during his/her turn
     */
    private $players;
    private $diceHand;
    private $nPlayers;
    private $startingPlayer;
    private $currentPlayer;
    private $currentHandValues;
    private $currentRoundScore;

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
            $this->nPlayers = 2;

        } else {
            for ($i = 0; $i < $nPlayers; $i++) {
                $this->players[] = new Player();
            }
            $this->nPlayers = $nPlayers;

        }

        $this->diceHand = new DiceHand($nDice, $nDiceFaces);
        $this->currentRoundScore = 0;
    }

    /**
     * Determines playerOrder, the player with the highest dice value begins
     * and then down from there in decending order
     */
    public function getStartingPlayer()
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

        $this->currentPlayer = $highestValueIndex;
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

    /**
     * Toss round for the player. Checks if a 1 has been thrown.
     * If not the score will be added to the $currentRoundScore.
     * If a 1 has been thrown reset $currentRoundScore and return -1
     *
     * @return void : int
     */
    public function playerRound()
    {
        $this->diceHand->toss();
        $this->currentHandValues = $this->diceHand->getCurrentTossValues();

        foreach($this->currentHandValues as $diceValue) {
            if ($diceValue = 1) {
                $this->currentRoundScore = 0;
                $this->endPlayerRound();
            }
            $this->currentRoundScore += $diceValue;
        }
    }

    public function endPlayerRound()
    {
        if ($this->currentRoundScore > 0) {
            $this->addPlayerScore($this->currentPlayer, $this->currentRoundScore);
            $this->currentRoundScore = 0;
        }

        //Setting up for next players turn
        if ($this->currentPlayer += 1 < $this->nPlayers) {
            $this->currentPlayer++;
        } else {
            $this->currentPlayer = 0;
        }
    }

    /**
     * Accsessors
     */
    /**
     * Returns the number of players in the game
     *
     * @return int
     */
    public function getPlayerCount() : int
    {
        return $this->nPlayers;
    }

    /**
     * Returns the array with the current dice values from the last throw
     *
     * @return array<int>
     */
    public function getCurrentHandValues() : array
    {
        return $this->currentHandValues;
    }

    /**
     * Returns the score for the player
     *
     * @return int
     */
    public function getPlayerScore($playerIndex) : int
    {
        return $this->players[$playerIndex]->getTotalScore();
    }

    /**
     * Return the index for current player
     *
     * @return int
     */
    public function getCurrentPlayer() : int
    {
        return $this->currentPlayer;
    }

    /**
     * Returns the total collected score forthe current player
     *
     * @return int
     */
    public function getCurrentPlayerScore() : int
    {
        return $this->getPlayerScore($this->currentPlayer);
    }

    /**
     * Returns the total score for the current round
     *
     * @return int
     */
    public function getCurrentRoundScore() : int
    {
        return $this->currentRoundScore;
    }

    /**
     * Modifiers
     */

    /**
     * Adds score to the player
     *
     * @param int   $playerIndex    The index in the player array for the player to add score to
     * @param int   $score          The score to add to the player
     */
    public function addPlayerScore(int $playerIndex, int $score) : void
    {
        $this->players[$playerIndex]->updateTotalScore($score);
    }
}
