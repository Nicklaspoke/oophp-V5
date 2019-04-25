<?php

/**
 * The player class for the dice game
 */
namespace Niko\Dice;

class Player
{
    /**
     * @var int $totalScore     The total score of points the player has gathered
     */
    private $totalScore;

    public function __construct()
    {
        $this->totalScore = 0;
    }

    public function updateTotalScore(int $scoreToAdd) : void
    {
        $this->totalScore += $scoreToAdd;
    }

    public function getTotalScore() : int
    {
        return $this->totalScore;
    }
}
