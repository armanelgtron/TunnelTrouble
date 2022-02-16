<?php
function getLadder($beta=false)
{
	global $saveto, $rankfiles;
	$name = $played = $ranker = array();
	foreach($rankfiles as $file)
	{
		$mapname = basename($file, ".aamap.xml.txt");
		$stats = new StatsReader($file);
		
		$x = 0;
		
		$r = $stats;
		while( $stats->next() )
		{
			if( $r->hasFinished() )
			{
				$player = $r->getPlayer();
				$x = $stats->get();
				
				if(!isset($played[$player])) $played[$player] = 0;
				$played[$player]++;
				
				$name[$player] = $player; // ????
				
				if(!isset($ranker[$player])) $ranker[$player] = 0;
				$ranker[$player] += $x;
				
				if(!isset($rankon[$player])) $rankon[$player] = [];
				$rankon[$player][$mapname] = $x;
				
				if(!isset($mapsplayed[$player])) $mapsplayed[$player] = [];
				$mapsplayed[$player][] = $mapname;
			}
		}
		
		$allrankings[$mapname] = $x;
	}
	foreach($rankon as $p=>$r)
	{
		$i=0;
		$avg[$p] = 0;
		foreach($r as $mn=>$m)
		{
			$avg[$p] += $m/$allrankings[$mn];
			++$i;
		}
		$avg[$p] /= $i;
	}
	foreach($name as $ls)
	{
		$myranker = $ranker[$ls]; $myplayed = $played[$ls];
		/*foreach($mapsplayed[$ls] as $mplay)
		{
			$myranker+=$allrankings[$mplay] ;
			$myplayed++;
		}*/
		if($beta) $rnkd[] = round( ((($avg[$ls]/$myplayed)*4000) + ( count($allrankings) / $myplayed ))/4 ,4)." {$ls}";
		else      $rnkd[] = round((($myranker/$myplayed)*count($allrankings))/$myplayed,4)." $ls";
	}
	sort($rnkd,SORT_NUMERIC);
	
	return $rnkd;
}
