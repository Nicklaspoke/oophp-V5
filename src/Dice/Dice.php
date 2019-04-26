<?php

/**
 * The Dice Class for the dice game
 */
namespace Niko\DiceGame;

class Dice
{
    /**
     * @var int $faces          The number of sides/faces the dice has
     * @var int $thrownValue    The value on the dice from the last throw
     */
    private $faces;
    private $thrownValue;

    /**
     * Constructor to initiate a dice object
     *
     * @param int $faces    The number of sides/faces the dice will have, default 6.
     */
    public function __construct(int $faces = 6)
    {
        $this->faces = $faces;
        $this->thrownValue = -1;
    }

    /**
     * Toss the dice and randomize a value between 1 and the faces of the dice
     *
     * @return void
     */
    public function toss() : void
    {
        $this->thrownValue = rand(1, $this->faces);
    }

    /**
     * Get the thrown value of the dice
     *
     * @return int  the thrown value
     */
    public function getCurrentValue() : int
    {
        return $this->thrownValue;
    }

    /**
     * Get the number of faces the dice has
     *
     * @return int  the number of faces on the dice
     */
    public function getFaces() : int
    {
        return $this->faces;
    }
}
