<form method="GET">
    <fieldset>
        <legend>Search</legend>
        <p>
            <label>Search by titel (use % as wildcard):
                <input type="search" name="titleSearch" value="<?= htmlentities($titleSearch) ?>">
            </label>
        </p>
        <p>
        <input type="submit" name="doSearch" value="Search">
        </p>
    </fieldset>
</form>

<?php if(isset($resultset)): ?>
    <table>
        <tr class="first">
            <th>Rad</th>
            <th>Id</th>
            <th>Bild</th>
            <th>Titel</th>
            <th>År</th>
        </tr>
    <?php $id = -1; foreach ($resultset as $row) :
        $id++; ?>
        <tr>
            <td><?= $id ?></td>
            <td><?= $row->id ?></td>
            <td><img class="thumb" src="<?= $row->image ?>"></td>
            <td><?= $row->title ?></td>
            <td><?= $row->year ?></td>
        </tr>
    <?php endforeach; ?>
    </table>
<?php endif ?>
