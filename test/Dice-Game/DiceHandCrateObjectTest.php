<?php

namespace Niko\Dice;

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

        $exp = 1;
        $res = count($hand->getCurrentTossValues());

        $this->assertEquals($exp, $res);
    }
    /**
     * constuct object with First argument to verify
     * that default value works on second argument
    */
    public function testCreateObjectFirstArgument()
    {
        $hand = new DiceHand(2);
    }

    /**
     * construct object with both arguments
     */
    public function testCreateObjectBothArguments()
    {
        $hand = new DiceHand(3, 20);
    }
}
