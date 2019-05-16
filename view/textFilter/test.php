<?php

namespace Niko\TextFilter;

$filter = new MyTextFilter();

$textText = "En [b]fet[/b] server.";

$html = $filter->parse($text, ["bbcode"]);

echo $html;
