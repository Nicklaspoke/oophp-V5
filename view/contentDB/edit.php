<?php

namespace Anax\View;

if (!$resultset) {
    return;
}

if ($flashMessage) {
    echo "<div class='flashmessage'>$flashMessage </div>";
}

?>

<form method="POST">
    <fieldset>
    <legend>Edit</legend>
    <input type="hidden" name="contentId" value="<?= esc($resultset->id) ?>"/>

    <p>
        <label>Title:<br>
        <input type="text" name="contentTitle" value="<?= esc($resultset->title) ?>"/>
        </label>
    </p>

    <p>
        <label>Path:<br>
        <input type="text" name="contentPath" value="<?= esc($resultset->path) ?>"/>
    </p>

    <p>
        <label>Slug:<br>
        <input type="text" name="contentSlug" value="<?= esc($resultset->slug) ?>"/>
    </p>

    <p>
        <label>Text:<br>
        <textarea rows="10" cols="50" name="contentData"><?= esc($resultset->data) ?></textarea>
    </p>

    <p>
        <label>Type:<br>
        <input type="text" name="contentType" value="<?= esc($resultset->type) ?>"/>
    </p>

    <p>
        <label>Filter:<br>
        <input type="text" name="contentFilter" value="<?= esc($resultset->filter) ?>"/>
    </p>

    <p>
        <label>Publish:<br>
        <input type="datetime" name="contentPublish" value="<?= esc($resultset->published) ?>"/>
    </p>

    <p>
        <input type="submit" name="action" value="Save">
        <input type="reset" value="Reset">
        <input type="submit" name="action" value="Delete">
    </p>
    </fieldset>
</form>
