<?php

namespace Niko\DiceGame;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class GameManagers Accessor functions.
 */
class GameManagerAccessorTest extends TestCase
{
    public function setUp()
    {
        $this->game = new GameManager();
        $this->game->addPlayerScore(0, 40);
        $this->game->addPlayerScore(1, 55);
    }

    /**
     * Test the getPlayerCount function
     */
    public function testGetPlayerCount()
    {
        $exp = 2;
        $res = $this->game->getPlayerCount();

        $this->assertEquals($exp, $res);
    }

    /**
     * Test the getCurrentHandValues fucntion
     */
    public function testGetCurrentHandValues()
    {
        $exp = [];
        $res = $this->game->getCurrentHandValues();

        $this->assertEquals($exp, $res);
    }

    /**
     * Test the getCurrentTossValuesAsString function
     */
    public function testGetCurrentTossValuesAsString()
    {
        $game = new GameManager();
        $game->playerRound();
        $exp = "";
        $res = $game->getCurrentTossValuesAsString();

        $this->assertNotEquals($exp, $res);
    }

    /**
     * Test the getPlayerScore function
     */
    public function testGetPlayerScore()
    {
        $exp = 55;
        $res = $this->game->getPlayerScore(1);

        $this->assertEquals($exp, $res);
    }

    /**
     * Test getCurrentPlayerScore function
     */
    public function testGetCurrentPlayerScore()
    {
        $exp = 40;
        $res = $this->game->getCurrentPlayerScore();

        $this->assertEquals($exp, $res);
    }

    /**
     * Test getCurrentRoundScore function
     */
    public function testGetCurrentRoundScore()
    {
        $exp = 0;
        $res = $this->game->getCurrentRoundScore();

        $this->assertEquals($exp, $res);
    }

    /**
     * Test getGameStatusAsString function
     */
    public function testGetGameStatusAsString()
    {
        $exp = "<p>Player 1 has a score of: 40</p><p>Player 2 has a score of: 55</p>";
        $res = $this->game->getGameStatusAsString();

        $this->assertEquals($exp, $res);
    }

    /**
     * Test the isPlayerComputer function
     */
    public function testIsPlayerComputer()
    {
        $exp = false;
        $res = $this->game->isPlayerComputer();

        $this->assertEquals($exp, $res);
    }

    /**
     * Test the getOpposingPlayer function
     */
    public function testGetOpposingPlayer()
    {
        $exp = 0;
        $res = $this->game->getOpposingPlayer();

        $this->assertEquals($exp, $res);
    }

    /**
     * Test getCurrentPlayer fucntion
     */
    public function testGetCurrentPlayer()
    {
        $exp = 0;
        $res = $this->game->getCurrentPlayer();

        $this->assertEquals($exp, $res);
    }
}
