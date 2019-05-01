<?php

namespace Niko\DiceGame;

class GameManager
{
    /**
     * @var array<player>   $players            Array containing all the players
     * @var Dice            $diceHand           The diceHand that holds all the dice/s
     * @var int             $nPlayers           The number of players in the game
     * @var int             $currentPlayer      The current players index in the players array
     * @var array<int>      $currentHandValues  The values from the last throw of dice/s
     * @var int             $currentRoundScore  The total score the player has collected during his/her turn
     */
    private $players;
    private $diceHand;
    private $nPlayers;
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
            $this->players[] = new PlayerAI;
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

        //Reset the toss values
        $this->diceHand->resetTossValues();

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
     * @return int
     */
    public function playerRound() : int
    {
        $this->diceHand->toss();
        $this->currentHandValues = $this->diceHand->getCurrentTossValues();

        foreach ($this->currentHandValues as $diceValue) {
            echo $diceValue;
            if ($diceValue == 1) {
                $this->currentRoundScore = 0;
                $this->endPlayerRound();
                return -1;
            }
            $this->currentRoundScore += $diceValue;
        }

        return $this->currentRoundScore;
    }

    /**
     * Ends the playerRound by setting the $currentRoundScore to 0
     * and moves $currentPlayer to the next one in line
     *
     * @return void
     */
    public function endPlayerRound() : void
    {
        if ($this->currentRoundScore > 0) {
            $this->addPlayerScore($this->currentPlayer, $this->currentRoundScore);
            $this->currentRoundScore = 0;
        }

        //Setting up for next players turn
        if ($this->currentPlayer + 1 < $this->nPlayers) {
            $this->currentPlayer++;
        } else {
            $this->currentPlayer = 0;
        }
    }

    /**
     * Handles the communication with the player AI
     *
     * @return void
     */
    public function computerRound() : void
    {
        $decision = true;
        $result = 0;
        //Call the AI decision maker until false is returned or a 1 is rolled
        while ($decision) {
            $decision = $this->players[$this->currentPlayer]->makePlayerDecision(
                $this->currentRoundScore,
                $this->getPlayerScore($this->getOpposingPlayer()),
                $this->getCurrentHandValues()
            );

            //If returned true, the player wants to throw again
            if ($decision) {
                $result = $this->playerRound();
            }
        }

        if ($result == -1) {
            $decision = false;
        }

        $this->endPlayerRound();
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
     * Takes the array of toss values and formats it into a string
     *
     * @return string
     */
    public function getCurrentTossValuesAsString() : string
    {
        $returnStr = "";

        foreach ($this->diceHand->getCurrentTossValues() as $diceValue) {
            $returnStr .= $diceValue .= ", ";
        }

        rtrim($returnStr, ", ");

        return $returnStr;
    }

    /**
     * Returns the score for the player
     *
     * @return int
     */
    public function getPlayerScore(int $playerIndex) : int
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
     * Returns the total collected score for the current player
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
     * Returns the gamestatus, aka. player scores in the form of a preforamted string
     *
     * @return string
     */
    public function getGameStatusAsString() : string
    {
        $returnStr = "";

        for ($i = 0; $i < $this->nPlayers; $i++) {
            $returnStr .= "<p>Player " . ($i+1) . " has a score of: ";
            $returnStr .= $this->getPlayerScore($i) . "</p>";
        }

        return $returnStr;
    }

    /**
     * Returns if the current player is a computer or a human player
     *
     * @return bool
     */
    public function isPlayerComputer() : bool
    {
        return $this->players[$this->currentPlayer]->isComputer();
    }

    /**
     * Get the opposing player for the playerAI. This funciton should only be used in a two player
     * game where one player is the AI
     *
     * @return int
     */
    public function getOpposingPlayer() : int
    {
        return $this->currentPlayer == 0 ? 0 : 1;
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
