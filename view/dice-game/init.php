<h1>Dice Game</h1>
<p>Now with a fancy controller</p>

<p>Welcome to my game, dice game. Aka pig</p>
<form method="POST" action="dice-game/init">
    <table>
        <tr>
            <td>
                <label for="nPlayers">Number Of Player (input 1 for play against Computer):</label>
            </td>

            <td>
                <input type="number" name="nPlayers" value=1>
            </td>
        </tr>

        <tr>
            <td>
                <label for="nDices">Number Of Dices To Use:</label>
            </td>

            <td>
                <input type="number" name="nDices" value=1>
            </td>
        </tr>

        <tr>
            <td>
            <label for="diceFaces">Number Of Faces On The Dice/s</label>
            </td>

            <td>
                <input type="number" name="diceFaces" value=6>
            </td>
        </tr>
    </table>

    <button type="submit" name="playButton" value="init">Begin Playing</button>
</form>
