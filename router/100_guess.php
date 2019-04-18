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
 * Route for playing the game
 */
$app->router->get("guess/play", function () use ($app) {
    // echo "Some debugging information";
    $title = "Play the game";

    //Check if the game is still in the session, if not redirect to the startpage
    if (!isset($_SESSION["guessGame"])) {
        return $app->response->redirect("guess/init");
    }

    $triesLeft = $_SESSION["guessGame"]->getTries();
    //Get the message from session if there is any
    $message = $_SESSION["message"] ?? null;

    //Clear the message from the session
    $_SESSION["message"] = null;


    $data = [
        "triesLeft" => $triesLeft,
        "message" => $message
    ];

    $app->page->add("guess/play", $data);

    return $app->page->render([
        "title" => $title
    ]);
});

$app->router->post("guess/play", function () use ($app) {
    //Get the chooice of operation from the form
    $chooice = $_POST["button"];
    $message = "";

    if ($chooice === "cheat") {
        $message = "The secret number is ";
        $message .= $_SESSION["guessGame"]->getSecretNumber();
    } elseif ($chooice === "reset") {
        $message = "The game has been reseted";
        $_SESSION["guessGame"] = new Niko\Guess\Guess();
    } elseif ($chooice === "guess") {
        try {
            $number = intval($_POST["guessedNumber"]);
            $message = $_SESSION["guessGame"]->makeGuess($number);
        } catch (\Exception $e) {
            $message .= "Your guess must be in the range: 1-100";
        }
    }

    $_SESSION["message"] = $message;


    return $app->response->redirect("guess/play");
});
