<?php

namespace Anax\View;

if (!$resultset) {
    return;
}

?>

<a class="center-link" href="movies/titleSearch">Search by titel | </a>
<a class="center-link" href="movies/yearSearch">Search by year | </a>
<a class="center-link" href="movies/crud">CRUD</a>
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
