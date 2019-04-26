<?php

namespace Niko\DiceGame;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class DiceHand
 */
class DiceHandCrateObjectTest extends TestCase
{
    /**
     * constuct object with no arguments to verify that default values works
     */
    public function testCreateObjectNoArguments()
    {
        $hand = new DiceHand();

        $this->assertInstanceOf("\Niko\DiceGame\DiceHand", $hand);

        $exp = 1;
        $res = $hand->getHandSize();

        $this->assertEquals($exp, $res);
    }
    /**
     * constuct object with First argument to verify
     * that default value works on second argument
    */
    public function testCreateObjectFirstArgument()
    {
        $hand = new DiceHand(2);

        $this->assertInstanceOf("\Niko\DiceGame\DiceHand", $hand);

        $exp = 2;
        $res = $hand->getHandSize();

        $this->assertEquals($exp, $res);
    }

    /**
     * construct object with both arguments
     */
    public function testCreateObjectBothArguments()
    {
        $hand = new DiceHand(3, 20);

        $this->assertInstanceOf("\Niko\DiceGame\DiceHand", $hand);

        $exp = 3;
        $res = $hand->getHandSize();

        $this->assertEquals($exp, $res);
    }
}
