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
     *
     * @return bool     True if continue playing, False if it wants to end the round
     */
    public function makePlayerDecision(int $currentRoundScore, int $opponentScore) : bool
    {
        $decision = false;

        $state = $this->decideGameState();

        switch ($state) {
            case 1:
                $decision = $this->earlyGameDecision($opponentScore, $currentRoundScore);
                break;
            case 2:
                $decision = $this->lateGameDecision($opponentScore, $currentRoundScore);
                break;
        }

        return $decision;
    }

    /**
     * Decides if the AI should make early or lategame decisions
     *
     * @return int  which state the game is in, 1 for early and 2 for late
     */
    public function decideGameState()
    {
        if ($this->getTotalScore() > 75) {
            return 2;
        }

        return 1;
    }

    /**
     * Makes decision for the early portion of the dice game
     *
     * @param int       $opponentScore    The score of the opponent
     *
     * @return bool     decision if it should throw dices again, or end its turn
     */
    public function earlyGameDecision(int $opponentScore, int $currentRoundScore)
    {
        if ($currentRoundScore < 20) {
            return true;
        }

        return false;
    }

    /**
     * Makes decision for the late portion of the dice game
     *
     * @param int       $opponentScore    The score of the opponent
     *
     * @return bool     decision if it should throw dices again, or end its turn
     */
    public function lateGameDecision(int $opponentScore, int $currentRoundScore)
    {
        $potensialTotalscore = $this->getTotalScore() + $currentRoundScore;

        //Check if oponent can win the next round
        if ($opponentScore >= 94) {
            return true;
        }

        if ($potensialTotalscore >= 100) {
            return false;
        }

        return true;
    }
}
