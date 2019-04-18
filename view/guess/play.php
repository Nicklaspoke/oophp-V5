<?php

namespace Anax\View;

/**
 * Render content for play the game.
 */
?>


<h1>Play the game</h1>

<h3 class='center'>You have <?= $triesLeft ?> gusses left</h3>
<p class='center'> <?= $message ?></p>

<div class="formContainer">
    <form method="POST" class="guessForm">
            <input type="number" name="guessedNumber">
            <button type="submit" name="button" value="guess">Guess</button>
            <button type="submit" name="button" value="reset">Reset Game</button>
            <button type="submit" name="button" value="cheat">Cheat</button>
    </form>
</div>
