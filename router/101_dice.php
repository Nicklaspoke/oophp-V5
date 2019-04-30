<?php
use Niko\DiceGame\GameManager;

/**
 * 'nPlayers' => string '1' (length=1)
 * 'nDices' => string '1' (length=1)
 * 'diceFaces' => string '6' (length=1)
 * 'playButton' => string 'init' (length=4)
 */
/**
 * Init a new round with the help of post
 */
$app->router->post("dice/init", function () use ($app) {

    $diceGame = new GameManager(
        intval($app->request->getPost("nPlayers")),
        intval($app->request->getPost("nDices")),
        intval($app->request->getPost("diceFaces"))
    );

    $diceGame->getStartingPlayer();

    $app->session->set("diceGame", $diceGame);

    echo "<pre>";
    var_dump($app->session->get("diceGame"));
    echo "</pre>";

    return $app->response->redirect("dice/nextPlayer");
});

$app->router->get("dice/play", function () use ($app) {
    $game = $app->session->get("diceGame");

    $title = "Dice Game";

    $data = [
        "currentPlayer" => $game->getCurrentPlayer(),
        "currentPlayerScore" => $game->getCurrentPlayerScore(),
        "currentRoundScore" => $game->getCurrentRoundScore(),
        "lastToss" => $game->getCurrentTossVAluesAsString()
    ];

    $app->page->add("dice-game/play", $data);

    return $app->page->render([
        "title" => $title
    ]);
});

$app->router->get("dice/nextPlayer", function () use ($app) {
    $title = "Dice Game";

    $game = $app->session->get("diceGame");

    $data = [
        "gameStatus" => $game->getGameStatusAsString(),
        "nextPlayer" => $game->getCurrentPlayer()
    ];

    $app->page->add("dice-game/nextPlayer", $data);

    return $app->page->render([
        "title" => $title
    ]);
});

$app->router->post("dice/play", function() use ($app) {
    //Get the button chooice
    $chooice = $app->request->getPost("button");

    $title = "Dice Game";

    //Get the gameobject stored in the session
    $game = $app->session->get("diceGame");

    if($chooice === "toss again") {
        $status = $game->playerRound();

        if($status === -1) {
            // $app->session->set("diceGame", $game);
            $app->page->add("dice-game/lostRound");

            return $app->page->render([
                "title" => $title
            ]);
        }

        return $app->response->redirect("dice/play");

    } else if ($chooice === "end turn") {
        $game->endPlayerRound();

        //Write the object back into the session
        // $app->session->set("diceGame", $game);

        return $app->response->redirect("dice/nextPlayer");
    }
});
