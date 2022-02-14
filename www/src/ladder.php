<?php
function getLadder($beta=false)
{
	global $saveto, $rankfiles;
	$name = $played = $ranker = array();
	foreach($rankfiles as $file)
	{
		$mapname = basename($file, ".aamap.xml.txt");
		$maprnk = file_get_contents($file);
		$ranks = explode("\n",$maprnk);
		$x=0;foreach($ranks as $rank)
		{
			if($rank == "") continue;
			$split = explode(" ",$rank);
			if( $split[1] != -1 )
			{
				$x++;
				
				if(!isset($played[$split[0]])) $played[$split[0]] = 0;
				$played[$split[0]]++;
				
				$name[$split[0]] = $split[0]; // ????
				
				if(!isset($ranker[$split[0]])) $ranker[$split[0]] = 0;
				$ranker[$split[0]] += $x;
				
				if(!isset($rankon[$split[0]])) $rankon[$split[0]] = [];
				$rankon[$split[0]][$mapname] = $x;
				
				if(!isset($mapsplayed[$split[0]])) $mapsplayed[$split[0]] = [];
				$mapsplayed[$split[0]][] = $mapname;
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
