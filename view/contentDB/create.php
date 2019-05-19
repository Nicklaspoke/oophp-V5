<?php

namespace Anax\View;

?>

<form method="POST">
    <fieldset>
    <legend>Create</legend>

    <p>
        <label>Title:<br>
        <input type="text" name="contentTitle" default="A Title"/>
        </label>
    </p>

    <p>
        <input type="submit" name="doCreate" value="Save">
        <button type="reset"><i class="fa fa-undo" aria-hidden="true"></i> Reset</button>
    </p>
    </fieldset>
</form>
