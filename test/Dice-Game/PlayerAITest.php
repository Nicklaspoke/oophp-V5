<?php

namespace Niko\DiceGame;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class PlayerAI.
 */
class PlayerAITest extends TestCase
{
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
}
