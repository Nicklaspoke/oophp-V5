<?php

/**
 * The dice hand class for the dice game
 */
namespace Niko\DiceGame;

class DiceHand
{
    /**
     *@var array<int>   $currentTossValues      Array that holds the values of the last toss of dice/s
     *@var array<Dice>  $diceHand               Array that holds the dice object/s
     *@var int          $handSize               The number of dice/s in the hand
     */
    private $currentTossValues = [];
    private $diceHand = [];
    private $handSize;

    /**
     * constructor for the DiceHand
     *
     * @param int $numberOfDices        The number of dices to be used in the game
     * @param int $numberOfDiceFaces    The number of faces for the dice/s
     */
    public function __construct(int $numberOfDices = 1, int $numberOfDiceFaces = 6)
    {
        for ($i = 0; $i < $numberOfDices; $i++) {
            $this->diceHand[] = new Dice($numberOfDiceFaces);
        }

        $this->handSize = $numberOfDices;
    }

    /**
     * Tosses the dice/s in the hand and saves them to an the array $currentTossValues
     *
     * @return void
     */
    public function toss() : void
    {
        for ($i = 0; $i < count($this->diceHand); $i++) {
            $this->diceHand[$i]->toss();
            $this->currentTossValues[$i] = $this->diceHand[$i]->getCurrentValue();
        }
    }

    /**
     * Returns an array with the values from the last toss
     *
     * @return array<int>
     */
    public function getCurrentTossValues()
    {
        return $this->currentTossValues;
    }

    /**
     * Returns the number of dice/s in the hand
     *
     * @return int
     */
    public function getHandSize()
    {
        return $this->handSize;
    }
}
