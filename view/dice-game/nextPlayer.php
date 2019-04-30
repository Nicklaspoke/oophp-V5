<?php

namespace Anax\View;

/**
 * Render content for info infor the next round
 */
?>

<h1>Dice Game</h1>

<p>The current status of the game is:</p>
<p><?= $gameStatus ?></p>

<p>Next player is player: <?= $nextPlayer+1 ?></p>

<div class="formContainer">
    <form method="GET" class="guessForm" action="play">
        <button type="submit" name="button" value="Next Player">Next Player</button>
    </form>
</div>
