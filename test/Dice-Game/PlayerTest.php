<?php

namespace Niko\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Player.
 */
class PlayerTest extends TestCase
{
    /**
     * SetUp for the two test in this testclass
     */
    public function setUp()
    {
        $this->player = new Player();
    }

    /**
     * Test that constructor gives an instance of the player class
     * and that score recives 0 in value
     */
    public function testCreateObject()
    {
        $this->assertInstanceOf("\Niko\Dice\Player", $this->player);

        $exp = 0;
        $res = $this->player->getTotalScore();

        $this->assertEquals($exp, $res);
    }

    /**
     * Test updatescore
     */
    public function testUpdateTotalScore()
    {
        $this->player->updateTotalScore(42);

        $exp = 42;
        $res = $this->player->getTotalScore();

        $this->assertEquals($exp, $res);
    }
}
