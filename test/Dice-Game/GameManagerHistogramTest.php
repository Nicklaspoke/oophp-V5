<?php

namespace Niko\DiceGame;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class GameManagers Histogram Trait.
 */
class GameManagerHistogramTest extends TestCase
{
    /**
     * Set up a new GameManager and inject some values into the
     * histogram, by calling playerRound a couple of times
     */
    public function setUp()
    {
        $this->game = new GameManager(10);

        //Call some player rounds to testfill the histogram
        for ($i = 0; $i < 10; $i++) {
            $this->game->playerRound();
        }

        /**
         * Create a second GameManager for testing when the histogram
         * does not have any values
         */
        $this->game2 = new GameManager(2);
    }

    /**
     * Test that the array that is returned by the histogram
     * is not empty
     */
    public function testGetHistogramSerieNotEmpty()
    {
        $exp = [];
        $res = $this->game->getHistogramSerie();

        $this->assertNotEquals($exp, $res);
    }

    /**
     * Test the getHistogramSerie when it's empty
     */
    public function testGetHistogramSerieEmpty()
    {
        $exp = [];
        $res = $this->game2->getHistogramSerie();

        $this->assertEquals($exp, $res);
    }

    /**
     * Test the get avrage function when the histogram is not empty
     */
    public function testGetAvrageThrowNotEmpty()
    {
        $exp = 0;
        $res = $this->game->getAvrageThrow();

        $this->assertNotEquals($exp, $res);
    }

    /**
     * Test the get avrage function when the histogram is empty
     */
    public function testGetAvrageThrowEmpty()
    {
        $exp = 0;
        $res = $this->game2->getAvrageThrow();

        $this->assertEquals($exp, $res);
    }

    /**
     * Test that the the getHistogramAsString does not return a empty string
     * when there are values in the array
     */
    public function testGetHistogramAsStringNotEmpty()
    {
        $exp = "";
        $res = $this->game->getHistogramAsString();

        $this->assertNotEquals($exp, $res);
    }

    /**
     * Test that the getHistogramAsString returns a empty string when
     * the array is empty
     */
    public function testGetHistogramAsStringEmpty()
    {
        $exp = "";
        $res = $this->game2->getHistogramAsString();

        $this->assertEquals($exp, $res);
    }

    /**
     * Test that the getHistogramAsString returns a not empty string even
     * when it revices arguments
     */
    public function testGetHistogramAsStringWithArgs()
    {
        $exp = "";
        $res = $this->game->getHistogramAsString(1, 6);

        $this->assertNotEquals($exp, $res);
    }
}
