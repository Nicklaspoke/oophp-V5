<?php

namespace Niko\DiceGame;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class DiceTossTest extends TestCase
{
    /**
     * Test that the toss function randomizes a value
     */
    public function testToss()
    {
        $dice = new Dice(20);
        $this->assertInstanceOf("\Niko\DiceGame\Dice", $dice);

        $dice->toss();

        $exp = -1;
        $res = $dice->getCurrentValue();

        $this->assertNotEquals($exp, $res);
    }
}
