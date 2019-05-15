<?php

namespace Niko\Movies;

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

class MoviesController implements AppInjectableInterface
{
    use AppInjectableTrait;

    /**
     * @var string  $title  The base title that is common for all the pages on this route
     *
     */
    private $title = "Movies";

    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
    public function initialize() : void
    {
        // Use $this->app to access the framework services.
    }

    public function indexAction()
    {
        $this->app->db->connect();
        $sql = "SELECT * FROM movie;";
        $res = $this->app->db->executeFetchAll($sql);

        $this->app->page->add("movie/index", [
            "resultset" => $res,
        ]);

        return $this->app->page->render([
            "title" => $this->title,
        ]);
    }

    public function searchTitelAction()
    {

    }

    public function searchYearAction()
    {

    }


}
