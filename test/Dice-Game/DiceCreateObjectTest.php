<?php

namespace Niko\DiceGame;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class DiceCreateObjectTest extends TestCase
{
    /**
     * Constuct the object unsing no arguments
     * to test the defaul tvalue
     */
    public function testCreateObjectNoArguments()
    {
        $dice = new Dice();
        $this->assertInstanceOf("\Niko\DiceGame\Dice", $dice);

        $res = $dice->getFaces();
        $exp = 6;

        $this->assertEquals($exp, $res);
    }

    public function testCreateObjectOneArgument()
    {
        $dice = new Dice(20);
        $this->assertInstanceOf("\Niko\DiceGame\Dice", $dice);

        $res = $dice->getFaces();
        $exp = 20;

        $this->assertEquals($exp, $res);
    }
}
