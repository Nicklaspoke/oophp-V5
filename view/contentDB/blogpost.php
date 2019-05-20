<?php
if (!$resultset) {
    return;
}
?>

<article>
    <header>
        <h1><?= esc($resultset->title) ?></h1>
        <p><i>Published: <time datetime="<?= esc($resultset->published_iso8601) ?>" pubdate><?= esc($resultset->published) ?></time></i></p>
    </header>
    <?= ($resultset->data) ?>
</article>
