<?php
echo "<pre>";
var_dump($resultset);
echo "</pre>";
?>

<form method="POST">
    <fieldset>
        <legend>Edit</legend>
        <input type="hidden" name="movieId" value="<?= $resultset->id ?>"/>

        <p>
        <label>Title:<br>
        <input type="text" name="movieTitle" value="<?= $resultset->title ?>"/>
        </label>
        </p>

        <p>
            <label>Year:<br>
            <input type="number" name="movieYear" value="<?= $resultset->year ?>"/>
        </p>

        <p>
            <label>Image:<br>
            <input type="text" name="movieImage" value="<?= $resultset->image ?>"/>
            </label>
        </p>

        <p>
            <input type="submit" name="action" value="Save">
            <input type="reset" value="Reset">
        </p>
    </fieldset>
</form>
