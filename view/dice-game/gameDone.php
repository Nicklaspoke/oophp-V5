<?php

namespace Anax\View;

/**
 * Render content for telling player that the game is over
 */
?>

<h1>Dice Game</h1>

<p>
    Congratulations player <?= $playerIndex + 1 ?>
    you have won the game with a score of <?= $playerScore ?>
</p>

<p>Thanks for playing</p>
