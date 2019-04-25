<?php

/**
 * Init a new round with the help of post
 */
$app->router->post("dice/init", function () use ($app) {

    echo "<pre>";
    var_dump($_POST);
    echo "</pre>";
});
