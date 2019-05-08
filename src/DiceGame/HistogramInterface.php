<?php

namespace Niko\DiceGame;

/**
 * A interface for a classes supporting histogram reports.
 */
interface HistogramInterface
{
    /**
     * Get the serie.
     *
     * @return array with the serie.
     */
    public function getHistogramSerie();

    /**
     * Get the full histogram as a string
     *
     * @return string
     */
    public function getHistogramAsString();

    public function getAvrageThrow();
}
