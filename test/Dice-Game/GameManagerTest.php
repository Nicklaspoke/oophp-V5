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
        $this->game = new GameManager(10);
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
    public function testcheckIfGameDonePlayerWon()
    {
        $this->game->addPlayerScore(0, 100);

        $exp = 0;
        $res = $this->game->checkIfGameDone();

        $this->assertEquals($exp, $res);
    }

    /**
     * Test the checkifgameisdone when no players has a score of 100
     *
     */
    public function testcheckIfGameDoneNoWinner()
    {
        $exp = -1;
        $res = $this->game->checkIfGameDone();

        $this->assertEquals($exp, $res);
    }

    /**
     * Test playerround when the player rolls a 1.
     * Need to manipulate the dice for this one, becouse of the random factor.
     */
    public function testPlayerRoundLoss()
    {
        $game = new GameManager(1, 1, 1);

        $exp = -1;
        $res = $game->playerRound();

        $this->assertEquals($exp, $res);
    }

    /**
     * Test playerround when the player rolls a anythong but a 1.
     * Need to manipulate the dice for this one, becouse of the random factor.
     */
    public function testPlayerRoundNormal()
    {
        $game = new GameManager(1, 1, 1000);

        $exp = -1;
        $res = $game->playerRound();

        $this->assertNotEquals($exp, $res);
    }

    /**
     * Test that the currentRound gets reseted and that it rolls over to the next player
     * Need to manipulate the dice for this one, becouse of the random factor.
     */
    public function testEndPlayerTurn()
    {
        $game = new GameManager(1, 1, 1000);

        $game->playerRound();
        $game->endPlayerRound();

        //Check that the correct player gets choosen
        $exp = 1;
        $res = $game->getCurrentPlayer();

        $this->assertEquals($exp, $res);

        //Check that currentRoundScore gets reset
        $exp = 0;
        $res = $game->getCurrentRoundScore();

        $this->assertEquals($exp, $res);

        //Test when player 1 gets set
        $game->endPlayerRound();
        $exp = 0;
        $res = $game->getCurrentPlayer();

        $this->assertEquals($exp, $res);
    }
}
