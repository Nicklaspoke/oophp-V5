<?php
// include "autoload.php";
include "MyTextFilter.php";
// namespace Niko\TextFilter;

$filter = new MyTextFilter();

$textText = "En [b]fet[/b] server. https://google.se";

$html = $filter->parse($textText, ["link"]);

echo $html;
