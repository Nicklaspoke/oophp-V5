<?php

namespace Niko\DiceGame;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class PlayerAI.
 */
class PlayerAITest extends TestCase
{
    /**
     * Setup function for use in all tests except
     * testCreateObject
     */
    public function setUp()
    {
        $this->playerAI = new PlayerAI();
    }
    /**
     * Test if the PlayerAI constructor works
     */
    public function testCreateObject()
    {
        $playerAI = new PlayerAI();

        $this->assertInstanceOf("\Niko\DiceGame\PlayerAI", $playerAI);

        $exp = true;
        $res = $playerAI->isComputer();

        $this->assertEquals($exp, $res);
    }

    /**
     * Test if fuction returns the right answer for a early game state
     */
    public function testDecideGameStateEarly()
    {
        $this->playerAI->updateTotalScore(40);

        $exp = 1;
        $res = $this->playerAI->decideGameState();

        $this->assertEquals($exp, $res);
    }

    /**
     * Test if fuction returns the right answer for a late game state
     */
    public function testDecideGameStateLate()
    {
        $this->playerAI->updateTotalScore(80);

        $exp = 2;
        $res = $this->playerAI->decideGameState();

        $this->assertEquals($exp, $res);
    }

    /**
     * Test earlygameDecision when the currentRoundScore is below 20
     */
    public function testEarlyGameDecisionContinue()
    {
        $exp = true;
        $res = $this->playerAI->earlyGameDecision(15);

        $this->assertEquals($exp, $res);
    }

    /**
     * Test earlygameDecision when the currentRoundScore is above 20
     */
    public function testEarlyGameDecisionStop()
    {
        $exp = false;
        $res = $this->playerAI->earlyGameDecision(25);

        $this->assertEquals($exp, $res);
    }

    /**
     * Test lategameDecision when the opposing player has a score of 94 or more
     */
    public function testLateGameDecisionOpposingPlayerWinning()
    {
        $exp = true;
        $res = $this->playerAI->lateGameDecision(95, 2);

        $this->assertEquals($exp, $res);
    }

    /**
     * Test lategameDecision when the player has reached their score
     */
    public function testLateGameDecisionPlayerWinning()
    {
        $this->playerAI->updateTotalScore(80);

        $exp = false;
        $res = $this->playerAI->lateGameDecision(55, 21);

        $this->assertEquals($exp, $res);
    }

    /**
     * Test lategameDecision when the player has entered the late game
     * but nither player is on the way to win a the moment
     */
    public function testLateGameDecision()
    {
        $this->playerAI->updateTotalScore(80);

        $exp = true;
        $res = $this->playerAI->lateGameDecision(55, 2);

        $this->assertEquals($exp, $res);
    }

    /**
     * Test the makePlayerDecision function when it's in early game
     */
    public function testMakePlayerDecisionEarlyGame()
    {
        $exp = true;
        $res = $this->playerAI->makePlayerDecision(15, 5);

        $this->assertEquals($exp, $res);
    }

    /**
     * Test the makePlayerDecision function when it's in late game
     */
    public function testMakePlayerDecisionLateGame()
    {
        $this->playerAI->updateTotalScore(80);

        $exp = true;
        $res = $this->playerAI->makePlayerDecision(15, 5);

        $this->assertEquals($exp, $res);
    }
}
