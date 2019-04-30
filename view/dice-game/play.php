<?php

namespace Anax\View;

/**
 * Render content for play the game.
 */
?>

<h1>Dice Game</h1>

<h3>Turn for player <?= $currentPlayer + 1 ?></h3>
<p>You have a total score of <?= $currentPlayerScore ?></p>
<p>This round you have gathered a total of <?= $currentRoundScore ?> points</p>
<p>Last toss you rolled <?= $lastToss ?></p>
<p>Do you wanna throw the dices again. Or end your turn?</p>
<div class="formContainer">
    <form method="POST" class="guessForm">
        <button type="submit" name="button" value="end turn">End Turn</button>
        <button type="submit" name="button" value="toss again">Toss dices</button>
    </form>
</div>
