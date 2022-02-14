<?php

if(!include_once("./config.php"))
{
	if(file_exists("config.tmp.php"))
	{
		die("Please copy config.tmp.php to config.php, and configure according to your environment.");
	}
	die();
}

$ratings = [];
$currmap = $currrot = -1;

$saveto = SAVE_TO;
$race_scores = RACESCORES_PATH;

include("src/getMaps.php");

require_once("src/standard.php");

require_once("src/include.php");

require_once("src/PlayerStats.php");
require_once("src/ladder.php");
require_once("src/map.php");
