<?php

?>

<form method="POST">
    <fieldset>
        <legend>Do CRUD on the movie database</legend>

        <label>Movie:</label>
        <select name="movieId">
            <option value="">Select movie...</option>
            <?php foreach ($resultset as $movie) : ?>
            <option value="<?= $movie->id ?>"><?= $movie->title ?></option>
            <?php endforeach; ?>
        </select>

        <p>
        <input type="submit" name="action" value="Add">
        <input type="submit" name="action" value="Edit">
        <input type="submit" name="action" value="Delete">
        </p>
    </fieldset>
</form>
