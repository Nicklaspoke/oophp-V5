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

    /**
     * Constructor for the player class.
     *
     * @param bool  $isComputer Determines if the player should be controlled by the computer or a human, default is false, aka human player
     */
    public function __construct($isComputer = false)
    {
        $this->totalScore = 0;
        $this->isComputer = $isComputer;
    }

    public function updateTotalScore(int $scoreToAdd) : void
    {
        $this->totalScore += $scoreToAdd;
    }

    public function getTotalScore() : int
    {
        return $this->totalScore;
    }

    public function isComputer() : bool
    {
        return $this->isComputer;
    }
}
