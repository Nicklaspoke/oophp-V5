<?php

namespace Niko\DiceGame;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class DiceGameController implements AppInjectableInterface
{
    use AppInjectableTrait;



    /**
     * @var string $title   The title for all pages using this controller
     */
    private $title = "Dice Game";



    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
    public function initialize() : void
    {
        // Use to initialise member variables.
        $this->db = "active";

        // Use $this->app to access the framework services.
    }



    // /**
    //  * This is the index method action, it handles:
    //  * ANY METHOD mountpoint
    //  * ANY METHOD mountpoint/
    //  * ANY METHOD mountpoint/index
    //  *
    //  * @return string
    //  */
    // public function indexAction() : string
    // {
    //     // Deal with the action and return a response.
    //     return "Index";
    // }

    public function debugAction() : string
    {
        // Deal with the action and return a response.
        return "Debug Of DiceGameController";
    }

    public function indexAction()
    {
        $this->app->page->add("dice-game/init");

        return $this->app->page->render([
            "title" => $this->title
        ]);
    }

    /**
     * Catches the POST result from the index form
     * and redirects to the nextplayer Page
     */
    public function initActionPost()
    {
        $diceGame = new GameManager(
            intval($this->app->request->getPost("nPlayers")),
            intval($this->app->request->getPost("nDices")),
            intval($this->app->request->getPost("diceFaces"))
        );

        $diceGame->getStartingPlayer();

        $this->app->session->set("diceGame", $diceGame);

        echo "<pre>";
        var_dump($this->app->session->get("diceGame"));
        echo "</pre>";

        return $this->app->response->redirect("dice-game/nextPlayer");
    }

    /**
     * Play portion of the game where the player or computer makes decisions
     */
    public function playActionGet()
    {
        $game = $this->app->session->get("diceGame");

        if ($game->isPlayerComputer()) {
            $game->computerRound();

            return $this->app->response->redirect("dice-game/nextPlayer");
        }

        $data = [
            "currentPlayer" => $game->getCurrentPlayer(),
            "currentPlayerScore" => $game->getCurrentPlayerScore(),
            "currentRoundScore" => $game->getCurrentRoundScore(),
            "lastToss" => $game->getCurrentTossValuesAsString()
        ];

        $this->app->page->add("dice-game/play", $data);

        return $this->app->page->render([
            "title" => $this->title
        ]);
    }

    /**
     * Catches POST action for the play route in the game
     */
    public function playActionPost()
    {
        //Get the button chooice
        $chooice = $this->app->request->getPost("button");

        //Get the gameobject stored in the session
        $game = $this->app->session->get("diceGame");

        //Check for the players chooice
        if ($chooice === "toss again") {
            $status = $game->playerRound();

            //Detect if the player tossed a 1
            if ($status === -1) {
                // $this->app->session->set("diceGame", $game);
                return $this->app->response->redirect("dice-game/lostRound");
            }

            return $this->app->response->redirect("dice-game/play");
        } else {
            $game->endPlayerRound();
            return $this->app->response->redirect("dice-game/nextPlayer");
        }
    }

    public function nextPlayerActionGet()
    {
        $game = $this->app->session->get("diceGame");

        //Check if any of the players has reached 100 points
        $currentStatus = $game->checkIfGameDone();

        if ($currentStatus > -1) {
            $data = [
                "playerIndex" => $currentStatus,
                "playerScore" => $game->getPlayerScore($currentStatus)
            ];

            $this->app->page->add("dice-game/gameDone", $data);

            return $this->app->page->render([
                "title" => $this->title
            ]);
        }
        $data = [
            "gameStatus" => $game->getGameStatusAsString(),
            "nextPlayer" => $game->getCurrentPlayer(),
            "histogram" => $game->getHistogramAsString(),
            "avrageThrow" => $game->getAvrageThrow()
        ];

        $this->app->page->add("dice-game/nextPlayer", $data);

        return $this->app->page->render([
            "title" => $this->title
        ]);
    }

    /**
     * If the player lost the round by tossing a 1 they end up here
     */
    public function lostRoundActionGet()
    {
        $this->app->page->add("dice-game/lostRound");

        return $this->app->page->render([
            "title" => $this->title
        ]);
    }

}
