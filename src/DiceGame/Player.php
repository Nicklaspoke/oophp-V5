<?php

/**
 * The player class for the dice game
 */
namespace Niko\DiceGame;

class Player
{
    /**
     * @var int     $totalScore     The total score of points the player has gathered
     * @var bool    $isComputer     Determines if the player is computer controlled or not
     */
    private $totalScore;
    private $isComputer;

    public function __construct($isComputer = false)
    {
        $this->totalScore = 0;
        $this->isComputer = true;
    }

    public function updateTotalScore(int $scoreToAdd) : void
    {
        $this->totalScore += $scoreToAdd;
    }

    public function getTotalScore() : int
    {
        return $this->totalScore;
    }

    public function getIsComputer() : bool
    {
        return $this->isComputer;
    }
}
