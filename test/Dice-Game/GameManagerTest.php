<?php

namespace Niko\DiceGame;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class GameManager.
 */
class GameManagerTest extends TestCase
{
    /**
     * SetUp functions for all test except create object test
     */
    public function setUp()
    {
        $this->gm = new GameManager(4);
    }
    /**
     * constuct object with no arguments to verify that default values works
     */
    public function testCreateObject()
    {
        $gm = new GameManager();

        $this->assertInstanceOf("\Niko\DiceGame\GameManager", $gm);

        $exp = 1;
        $res = $gm->getPlayerCount();

        $this->assertEquals($exp, $res);
    }

    /**
     * Test that determinPlayerOrder returns a index
     */
    public function testPlayerOrder()
    {
        $exp = -1;
        $res = $this->gm->getStartingPlayer();

        $this->assertNotEquals($exp, $res);
    }

    /**
     * Test the set score function and if game is done
     */
    public function checkIfGameDone()
    {

    }
}
