<?php

namespace Niko\DiceGame;

/**
 * A historgram for Dice rolls
 */
trait HistogramTrait
{
    /**
     * @var array   $serie  The numbers stored for the histogram
     */
    private $serie = [];

    /**
     * Get the serie.
     *
     * @return array with the serie
     */
    public function getHistogramSerie()
    {
        return $this->serie;
    }

    public function getHistogramMin()
    {
        return 1;
    }

    /**
     * Print out the histogram, default is to print out only the numbers
     * in the serie, but when $min and $max is set then print also empty
     * values in the serie, within the range $min, $max.
     *
     * @param int $min The lowest possible integer number.
     * @param int $max The highest possible integer number.
     *
     * @return string representing the histogram.
     */
    public function getHistogramAsString(int $min = null, int $max = null)
    {
        // echo "<pre>";
        // var_dump($this->serie);
        // echo "</pre>";
        sort($this->serie);

        //Get how many times a certain number has been rolled
        $numberCounts = array_count_values($this->serie);

        $returnStr = "";

        if ($min && $max != null) {
            for ($i = $min; $i <= $max; $i++) {
                $returnStr .= $i . ": ";

                if (in_array($i, $this->serie)) {
                    for ($j = 0; $j < $numberCounts[$i]; $j++) {
                        $returnStr .= "*";
                    }
                }

                $returnStr .= "\n";
            }
        } else {
            foreach ($numberCounts as $key => $value) {
                $returnStr .= $key . ": ";

                for ($i = 0; $i < $value; $i++) {
                    $returnStr .= "*";
                }

                $returnStr .= "\n";
            }
        }

        return $returnStr;
    }
}
