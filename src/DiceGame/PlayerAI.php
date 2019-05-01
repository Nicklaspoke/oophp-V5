<?php

/**
 * PlayerAI class for the dice game, this class extends the player class
 * and handles the AI decisions for the computer player
 */
namespace Niko\DiceGame;

class PlayerAI extends Player
{
    public function __construct($isComputer = true)
    {
        parent::__construct($isComputer);
    }

    /**
     * The main fuction for making a decision in the game
     *
     * @param int           $currenRoundScore       The total number of points gathered this round
     * @param int           $playerScore            The score of the opposing player
     * @param array<int>    $currentHandValues      The hand values from the last toss with the hand
     *
     * @return bool     True if continue playing, False if it wants to end the round
     */
    public function makePlayerDecision(int $currentRoundScore, int $opponentScore, array $currentHandValues) : bool
    {
        $decision = false;

        $state = $this->decideGameState();

        return $decision;
    }

    /**
     * Decides if the AI should make early or lategame decisions
     *
     * @return int  which state the game is in, 1 for early and 2 for late
     */
    public function decideGameState()
    {
        if ($this->totalScore > 75) {
            return 2;
        }

        return 1;
    }

    /**
     * Makes decision for the early portion of the dice game
     */
    public function earlyGameDecision()
    {

    }

    /**
     * Makes decision for the late portion of the dice game
     */
    public function lateGameDecision()
    {

    }
}
