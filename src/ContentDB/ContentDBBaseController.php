<?php

namespace Niko\ContentDB;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

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



    public function editActionGet()
    {
        $postId = $this->app->request->getGet("id");

        $this->app->db->connect();
        $sql = "SELECT * FROM content WHERE id = ?";
        $res = $this->app->db->executeFetch($sql, [$postId]);

        $this->app->page->add("contentDB/header");
        $this->app->page->add("contentDB/edit", [
            "resultset" => $res,
        ]);

        return $this->app->page->render([
            "title" => $this->title,
        ]);
    }

    public function editActionPost()
    {
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
            $this->app->db->connect();
            $sql = "UPDATE content SET title=?, path=?, slug=?, data=?, type=?, filter=?, published=? WHERE id = ?;";
            $this->app->db->execute($sql, array_values($params));

            return $this->app->response->redirect("contentDB/overView");
        } elseif ($action === "Delete") {
            $contentId = $this->app->request->getPost("contentId");
            echo $contentId;
            return $this->app->response->redirect("contentDB/delete?id=$contentId");
        }
    }

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

    public function deleteActionPost()
    {
        $contentId = $this->app->request->getPost("contentId");

        $this->app->db->connect();
        $sql = "UPDATE content SET deleted=NOW() WHERE id=?;";
        $this->app->db->execute($sql, [$contentId]);

        return $this->app->response->redirect("contentDB/overView");
    }

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

    public function pagesActionGet()
    {
        $this->app->db->connect();
        $sql = <<<EOD
SELECT
    *,
    CASE
        WHEN (deleted <= NOW()) THEN "isDeleted"
        WHEN (published <= NOW()) THEN "isPublished"
        ELSE "notPublished"
    END AS status
FROM content
WHERE type=?
;
EOD;

        $res = $this->app->db->executeFetchAll($sql, ["page"]);

        $this->app->page->add("contentDB/header");
        $this->app->page->add("contentDB/pages", [
            "resultset" => $res,
        ]);

        return $this->app->page->render([
            "title" => $this->title,
        ]);
    }
}
