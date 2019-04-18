<?php
/*
Configuation that aplies to all pages on this site
*/
$baseTitle = " | oophp";

$name = preg_replace("/[^a-z\d]/i", "", __DIR__);

//Setting session name and starting it
session_name($name);

session_start();
