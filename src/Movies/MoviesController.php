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

    public function titleSearchAction()
    {
        $data = [];
        if ($this->app->request->getGet("titleSearch")) {
            $titleSearch = $this->app->request->getGet("titleSearch");
            $this->app->db->connect();
            $sql = "SELECT * FROM movie WHERE title LIKE ?;";
            $res = $this->app->db->executeFetchAll($sql, [$titleSearch]);
            $data = [
                "resultset" => $res,
                "titleSearch" => $titleSearch,
            ];
        }

        if (!isset($data["titleSearch"])) {
            $data["titleSearch"] = "";
        }

        $this->app->page->add("movie/titleSearch", $data);

        return $this->app->page->render([
            "title" => $this->title
        ]);
    }

    public function yearSearchAction()
    {
        $minYear = $this->app->request->getGet("minYear");
        $maxYear = $this->app->request->getGet("maxYear");
        $data = [
            "minYear" => $minYear,
            "maxYear" => $maxYear,
        ];

        $this->app->db->connect();

        if ($minYear && $maxYear) {
            $sql = "SELECT * FROM movie WHERE year >= ? AND year <= ?;";
            $res = $this->app->db->executeFetchAll($sql, [$minYear, $maxYear]);
        } elseif ($minYear) {
            $sql = "SELECT * FROM movie WHERE year >= ?;";
            $res = $this->app->db->executeFetchAll($sql, [$minYear]);
        } elseif ($maxYear) {
            $sql = "SELECT * FROM movie WHERE year <= ?;";
            $res = $this->app->db->executeFetchAll($sql, [$maxYear]);
        }

        $data["resultset"] = isset($res) ? $res : null;

        $this->app->page->add("movie/yearSearch", $data);

        return $this->app->page->render([
            "title" => $this->title
        ]);
    }

    public function crudActionGet()
    {
        $this->app->db->connect();
        $sql = "SELECT * FROM movie;";
        $res = $this->app->db->executeFetchAll($sql);

        $this->app->page->add("movie/crud", [
            "resultset" => $res,
        ]);

        return $this->app->page->render([
            "title" => $this->title,
        ]);
    }

    public function crudActionPost()
    {
        $this->app->db->connect();

        $movieId = $this->app->request->getPost("movieId");
        $action = $this->app->request->getPost("action");

        if ($action === "Add") {
            $sql = "INSERT INTO movie (title, year, image) VALUES (?, ?, ?);";
            $this->app->db->execute($sql, ["A title", 2000, "img/noimage.png"]);
            $movieId = $this->app->db->lastInsertId();

            $sql = "SELECT * FROM movie WHERE id = ?";
            $res = $this->app->db->executeFetch($sql, [$movieId]);

            $this->app->page->add("movie/edit-movie", [
                "resultset" => $res,
            ]);

            return $this->app->page->render([
                "title" => $this->title,
            ]);
        } elseif ($action === "Edit") {
            $sql = "SELECT * FROM movie WHERE id = ?;";
            $res = $this->app->db->executeFetch($sql, [$movieId]);

            $this->app->page->add("movie/edit-movie", [
                "resultset" => $res,
            ]);

            return $this->app->page->render([
                "title" => $this->title,
            ]);
        } elseif ($action === "Delete") {
            $sql = "DELETE FROM movie WHERE id = ?;";
            $this->app->db->execute($sql, [$movieId]);
        } elseif ($action === "Save") {
            $movieId = $this->app->request->getPost("movieId");
            $movieTitle = $this->app->request->getPost("movieTitle");
            $movieYear = $this->app->request->getPost("movieYear");
            $movieImage = $this->app->request->getPost("movieImage");
            $sql = "UPDATE movie SET title = ?, year = ?, image = ? WHERE id = ?;";
            $this->app->db->execute($sql, [$movieTitle, $movieYear, $movieImage, $movieId]);
        }

        return $this->app->response->redirect("movie");
    }
}
