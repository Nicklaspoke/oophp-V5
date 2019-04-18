<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * Init the game and redirect to play the game
 */
$app->router->get("guess/init", function () use ($app) {
    // Init the session for the gamestart;
    $guessGame = new Niko\Guess\Guess();
    $_SESSION["guessGame"] = $guessGame;
    return $app->response->redirect("guess/play");
});



/**
 * Returning a JSON message with Hello World.
 */
$app->router->get("guess/play", function () use ($app) {
    // echo "Some debugging information";
    $title = "Play the game";

    $app->page->add("guess/play");

    return $app->page->render([
        "title" => $title,
    ]);
});
