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
        $this->game = new GameManager(4);
    }
    /**
     * constuct object with no arguments to verify that default values works
     */
    public function testCreateObject()
    {
        $game = new GameManager();

        $this->assertInstanceOf("\Niko\DiceGame\GameManager", $game);

        $exp = 2;
        $res = $game->getPlayerCount();

        $this->assertEquals($exp, $res);
    }

    /**
     * Test that determinPlayerOrder returns a index
     */
    public function testPlayerOrder()
    {
        $exp = -1;
        $res = $this->game->getStartingPlayer();

        $this->assertNotEquals($exp, $res);
    }

    /**
     * Test the set score function and if game is done when there is a player
     * with a score of 100
     */
    public function checkIfGameDonePlayerWon()
    {
        $this->game->addPlayerScore(0, 100);

        $exp = 0;
        $res = $this->game->checkIfGameDone();

        $this->assertNotEquals($exp, $res);
    }

    /**
     * Test the checkifgameisdone when no players has a score of 100
     *
     */
    public function checkIfGameDoneNoWinner()
    {
        $exp = -1;
        $res = $this->game->checkIfGameDone();

        $this->assertNotEquals($exp, $res);
    }
}
