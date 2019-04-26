<?php

namespace Niko\DiceGame;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class DiceHandTossTest extends TestCase
{
    public function testTossAndRetrive()
    {
        $hand = new DiceHand();

        $hand->toss();

        $exp = $hand->getHandSize();
        $res = sizeof($hand->getCurrentTossValues());

        $this->assertEquals($exp, $res);
    }
}
