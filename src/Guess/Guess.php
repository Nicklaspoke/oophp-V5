<?php
/**
 * Guess my number, a class supporting the game through GET, POST and SESSION.
 */

namespace Niko\Guess;

class Guess
{
    /**
     * @var int $number   The current secret number.
     * @var int $tries    Number of tries a guess has been made.
     */
    private $number;
    private $tries;



    /**
     * Constructor to initiate the object with current game settings,
     * if available. Randomize the current number if no value is sent in.
     *
     * @param int $number The current secret number, default -1 to initiate
     *                    the number from start.
     * @param int $tries  Number of tries a guess has been made,
     *                    default 6.
     */
    public function __construct(int $tries = 6)
    {
        $this->random();
        $this->tries = $tries;
    }



    /**
     * Randomize the secret number between 1 and 100 to initiate a new game.
     *
     * @return void
     */
    private function random() : void
    {
        $this->number = rand(1, 100);
    }



    /**
     * Get number of tries left.
     *
     * @return int as number of tries made.
     */

    public function getTries() : int
    {
        return $this->tries;
    }




    /**
     * Get the secret number.
     *
     * @return int as the secret number.
     */

    public function getSecretNumber() : int
    {
        return $this->number;
    }




    /**
     * Make a guess, decrease remaining guesses and return a string stating
     * if the guess was correct, too low or to high or if no guesses remains.
     *
     * @throws GuessException when guessed number is out of bounds.
     *
     * @return string to show the status of the guess made.
     */

    public function makeGuess(int $number) : string
    {
        if ($number > 100 || $number < 1) {
            throw new \Exception();
        }

        $returnStr = "";
        if ($this->tries === 0) {
            $returnStr = "You are you out of gusses";
            return $returnStr;
        }

        $this->tries -= 1;

        if ($number > $this->number) {
            $returnStr = "Your guess ". $number . " is to high";
            return $returnStr;
        } elseif ($number < $this->number) {
            $returnStr = "Your guess " . $number . " is to low";
            return $returnStr;
        } elseif ($number === $this->number) {
            $returnStr = "Your guess " . $number . " is the correct number";
            return $returnStr;
        }
    }
}
