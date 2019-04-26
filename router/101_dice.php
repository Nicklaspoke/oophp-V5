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

    $app->session->set("diceGame", $diceGame);

    return $app->response->redirect("dice/play");
});

$app->router->get("dice/play", function () use ($app) {
    $game = $app->session->get("diceGame");

    $data = [
        "currentPlayer" => $game->getCurrentPlayer(),
        "currentPlayerScore" => $game->getCurrentPlayerScore(),
        "currentRoundScore"
    ];
});
