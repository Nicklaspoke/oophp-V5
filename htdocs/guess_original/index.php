<?php
/**
 * Site controller for the number guessing game
 */
include(__DIR__ . "/autoload.php");
include(__DIR__ . "/config.php");
include(__DIR__ . "/src/functions.php");

if (!isset($_SESSION["guessGame"])) {
    $_SESSION["guessGame"] = new Guess();
}

$triesLeft = $_SESSION["guessGame"]->getTries();

$title = "Guess my number" . $baseTitle;

include(__DIR__ . "/view/header.php");

echo "<h3 class='center'>You have {$triesLeft} gusses left</h3>";

include(__DIR__ . "/view/guessForm.php");

//Get the message from session if there is any
$message = $_SESSION["message"] ?? null;

//Clear the message from the session
$_SESSION["message"] = null;

if ($message != null) {
    echo "<p class='center'>{$message}</p>";
}

include(__DIR__ . "/view/footer.php");
