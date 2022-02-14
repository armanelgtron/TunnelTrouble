<?php
$maps = $maps_other = array();

$rankfiles = glob("$race_scores/*/*/*.txt");

(function() use($rankfiles, $race_scores)
{
	global $maps;
	foreach($rankfiles as $r)
	{
		$map_file = rtrim(substr($r, strlen($race_scores)+1),".txt");
		array_push($maps, [
			basename($r, ".aamap.xml.txt"), 
			$map_file,
			4, // axes
			0, // size_factor
			((explode("/", $map_file))[0]), // author
		]);
	}

})();

$_maps = array_merge($maps,$maps_other);

