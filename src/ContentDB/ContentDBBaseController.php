<?php

namespace Niko\ContentDB;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */

class ContentDBBaseController implements AppInjectableInterface
{
    use AppInjectableTrait;

    /**
     * @var string  $title  The base title that is common for all the pages on this route
     *
     */
    private $title = "Content";
    private $textFilter;

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
        $this->textFilter = new \Niko\TextFilter\MyTextFilter();
    }

    /**
     * Show the index page with a overview of all the content in the database
     */
    public function overViewAction()
    {
        $this->app->db->connect();
        $sql = "SELECT * FROM content";
        $res = $this->app->db->executeFetchAll($sql);
        $data["resultset"] = $res;

        // $uri = $this->app->request->getServer("REQUEST_URI");

        // if (strpos($uri, "index") !== false) {

        // } else {
        //     $this->app->page->add("contentDB/defaultNav");
        // }
        $this->app->page->add("contentDB/header");
        $this->app->page->add("contentDB/index", $data);

        return $this->app->page->render([
            "title" => $this->title,
        ]);
    }

    /**
     * Route for displaying the admin wiht all pages and posts to edit or delete
     */
    public function adminActionGet()
    {
        $this->app->db->connect();
        $sql = "SELECT * FROM content";
        $res = $this->app->db->executeFetchAll($sql);
        $data["resultset"] = $res;

        $this->app->page->add("contentDB/header");
        $this->app->page->add("contentDB/admin", $data);

        return $this->app->page->render([
            "title" => $this->title,
        ]);
    }


    /**
     * Route for displaying the user with the edit form for a post/page
     */
    public function editActionGet()
    {
        $postId = $this->app->request->getGet("id");

        $this->app->db->connect();
        $sql = "SELECT * FROM content WHERE id = ?";
        $res = $this->app->db->executeFetch($sql, [$postId]);

        $data["resultset"] = $res;

        if ($this->app->session->has("flashMessage")) {
            $data["flashMessage"] = $this->app->session->getonce("flashMessage");
        }
        $this->app->page->add("contentDB/header");
        $this->app->page->add("contentDB/edit", $data);

        return $this->app->page->render([
            "title" => $this->title,
        ]);
    }

    /**
     * Route for commiting the edit of a page or post to the database
     */
    public function editActionPost()
    {
        $this->app->db->connect();
        $action = $this->app->request->getPost("action");

        if ($action === "Save") {
            $params = [
                "contentTitle" => $this->app->request->getPost("contentTitle"),
                "contentPath" => $this->app->request->getPost("contentPath"),
                "contentSlug" => $this->app->request->getPost("contentSlug"),
                "contentData" => $this->app->request->getPost("contentData"),
                "contentType" => $this->app->request->getPost("contentType"),
                "contentFilter" => $this->app->request->getPost("contentFilter"),
                "contentPublish" => $this->app->request->getPost("contentPublish"),
                "contentId" => $this->app->request->getPost("contentId"),
            ];

            if (!$params["contentSlug"]) {
                $params["contentSlug"] = slugify($params["contentTitle"]);
            }

            if (!$params["contentPath"]) {
                $params["contentPath"] = null;
            }

            $sql = "SELECT slug FROM content WHERE slug= ?";
            $res = $this->app->db->executeFetchAll($sql, [$params["contentSlug"]]);

            if (count($res) > 0) {
                $contentId = $this->app->request->getPost("contentId");
                $flashMessage = "You can't have two pages/posts with the same slug";
                $this->app->session->set("flashMessage", $flashMessage);
                return $this->app->response->redirect("contentDB/edit?id=$contentId");
            }

            $sql = "UPDATE content SET title=?, path=?, slug=?, data=?, type=?, filter=?, published=? WHERE id = ?;";
            $this->app->db->execute($sql, array_values($params));

            return $this->app->response->redirect("contentDB/overView");
        } elseif ($action === "Delete") {
            $contentId = $this->app->request->getPost("contentId");
            echo $contentId;
            return $this->app->response->redirect("contentDB/delete?id=$contentId");
        }
    }

    /**
     * Route for the user to confirm the deltion of th post/page
     */
    public function deleteActionGet()
    {
        $contentId =  $this->app->request->getGet("id");

        $this->app->db->connect();
        $sql = "SELECT id, title FROM content WHERE id = ?;";
        $res = $this->app->db->executeFetch($sql, [$contentId]);

        $this->app->page->add("contentDB/header");
        $this->app->page->add("contentDB/delete", [
            "resultset" => $res,
        ]);

        return $this->app->page->render([
            "title" => $this->title,
        ]);
    }

    /**
     * Route for deleting a post or page
     */
    public function deleteActionPost()
    {
        $contentId = $this->app->request->getPost("contentId");

        $this->app->db->connect();
        $sql = "UPDATE content SET deleted=NOW() WHERE id=?;";
        $this->app->db->execute($sql, [$contentId]);

        return $this->app->response->redirect("contentDB/overView");
    }

    /**
     * Route for cxreating a new blogpost or page
     */
    public function createAction()
    {
        if ($this->app->request->getPost("doCreate")) {
            $title = $this->app->request->getPost("contentTitle");

            $this->app->db->connect();
            $sql = "INSERT INTO content (title) VALUES (?);";
            $this->app->db->execute($sql, [$title]);
            $id = $this->app->db->lastInsertId();

            return $this->app->response->redirect("contentDB/edit?id=$id");
        }
        $this->app->page->add("contentDB/header");
        $this->app->page->add("contentDB/create");

        return $this->app->page->render([
            "title" => $this->title,
        ]);
    }

    /**
     * Route to display all pages and a single page
     */
    public function pagesActionGet($id = null)
    {
        $this->app->db->connect();

        if (!$id) {
            $sql =
            "SELECT
                *,
                CASE
                    WHEN (deleted <= NOW()) THEN 'isDeleted'
                    WHEN (published <= NOW()) THEN 'isPublished'
                    ELSE 'notPublished'
                END AS status
            FROM content
            WHERE type=?
            ;";

            $res = $this->app->db->executeFetchAll($sql, ["page"]);

            $this->app->page->add("contentDB/header");
            $this->app->page->add("contentDB/pages", [
                "resultset" => $res,
            ]);
        } else {
            $sql =
            "SELECT
                *,
                DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS modified_iso8601,
                DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS modified
            FROM content
            WHERE
                path = ?
                AND type = ?
                AND (deleted IS NULL OR deleted > NOW())
                AND published <= NOW()
            ;";

            $res = $this->app->db->executeFetch($sql, [$id, "page"]);

            $this->app->page->add("contentDB/secondaryHeader");

            if (!$res) {
                $this->app->page->add("contentDB/404");
            } else {
                $filters = explode(",", $res->filter);
                $res->data = $this->textFilter->parse($res->data, $filters);
                $this->app->page->add("contentDB/page", [
                    "resultset" => $res,
                ]);
            }
        }
        return $this->app->page->render([
            "title" => $this->title,
        ]);
    }

    /**
     * Route for the blog, renders all blog posts and a single blog post when it's clicked
     */
    public function blogActionGet($id = null)
    {

        $this->app->db->connect();

        if (!$id) {
            $sql =
                "SELECT
                *,
                    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
                    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
                FROM content
                    WHERE type=?
                ORDER BY published DESC
                ;";
                    $res = $this->app->db->executeFetchAll($sql, ["post"]);

                    $this->app->page->add("contentDB/header");
                    $this->app->page->add("contentDB/blog", [
                        "resultset" => $res,
                    ]);
        } else {
            $sql =
                "SELECT
                *,
                    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
                    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
                FROM content
                    WHERE
                        slug = ?
                        AND type = ?
                        AND (deleted IS NULL OR deleted > NOW())
                        AND published <= NOW()
                ORDER BY published DESC
                ;";

            $res = $this->app->db->executeFetch($sql, [$id, "post"]);

            $this->app->page->add("contentDB/secondaryHeader");

            if (!$res) {
                $this->app->page->add("contentDB/404");
            } else {
                $filters = explode(",", $res->filter);
                $res->data = $this->textFilter->parse($res->data, $filters);
                $this->app->page->add("contentDB/blogpost", [
                    "resultset" => $res,
                ]);
            }
        }
        return $this->app->page->render([
            "title" => $this->title,
        ]);
    }
}
