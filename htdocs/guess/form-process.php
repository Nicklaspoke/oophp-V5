<?php

include(__DIR__ . "/autoload.php");
include(__DIR__ . "/config.php");

echo "<pre>";
var_dump($_POST);
echo "</pre>";

//Get the chooice of operation from the form
$chooice = $_POST["button"];
$message = "";

if ($chooice === "cheat") {
    $message = "The secret number is ";
    $message .= $_SESSION["guessGame"]->getSecretNumber();
} elseif ($chooice === "reset") {
    $message = "The game has been reseted";
    $_SESSION["guessGame"] = new Guess();
} elseif ($chooice === "guess") {
    try {
        $number = intval($_POST["guessedNumber"]);
        $message = $_SESSION["guessGame"]->makeGuess($number);
    } catch (GuessException $e) {
        $message .= "Your guess must be in the range: 1-100";
    }
}


echo $message;
$_SESSION["message"] = $message;

header("Location: index.php");
