<?php

function getMapRankPath($map)
{
	global $rankfiles;
	return current(array_filter($rankfiles, function($o) use($map) { return (bool)strstr($o, $map); }));
}
