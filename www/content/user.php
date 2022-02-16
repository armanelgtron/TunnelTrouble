<?php if(!isset($maps)) { http_response_code(403); die("<title>403 Forbidden</title><center><h1>403 Forbidden</h1></center>"); } ?>
<?php 
$player = $_GET["user"];
PlayerStats::newPlayer($player);
PlayerStats::readPlayerStats();

$p = PlayerStats::$players[0];

// HACK
foreach([
	"topten", "topthree",
	"played", "name",
	"ranker",
	"notraced", "notranks",
	"top1", "top2", "top3",
] as $i)
{
	${$i} = $p->$i;
}
$playerrec = $p->rec;
$myranks = $p->ranks;
?>
<script>
	function showranks(num)
	{
		var all = document.getElementsByClassName("ranks");
		for(var i=0;i<all.length;i++)
		{
			if(num == 0 || all[i].attributes.name.value == "rank_"+num)
			{
				all[i].style.display = "block";
			}
			else
			{
				all[i].style.display = "none";
			}
		}
	}
</script>
<style>
	.btn-group
	{
		border-radius: 3px;
		display: inline-block;
		
		-webkit-box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 3px 1px -2px rgba(0, 0, 0, 0.12), 0 1px 5px 0 rgba(0, 0, 0, 0.2);
		box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 3px 1px -2px rgba(0, 0, 0, 0.12), 0 1px 5px 0 rgba(0, 0, 0, 0.2);
	}
	.btn-group .btn
	{
		border-radius: 0;
		-webkit-box-shadow: none;
		box-shadow: none;
		margin-right: 1px;
	}
	.active
	{
		background-color: #2b3940;
	}
</style>
<?php
if($p->played)
{
$e = "";
echo '<div class="container-alt" role="main">';
echo "<h3>{$name}{$e}</h3>";
echo "<b># of maps with 1st place:</b> $top1<br>";
foreach(getLadder() as $ldpos=>$ld)
{
	$c = strpos($ld,$player);
	if($c == (strpos($ld,' ')+1) && strlen($ld)-$c == strlen($player)) break;
}
echo "<b>Position on Ladder:</b> ".($ldpos+1)." ($ld)<br>";
echo "<b>Average Rank (of $played maps):</b> ".round($ranker/$played)." <br />";
echo "<b>Average Rank (of all maps):</b> ".round(($ranker+$notranks)/count($maps))."<br />";
echo "<b>Show maps with ranks:</b> ";
print("<div class=\"btn-group\" role=\"group\" aria-label=\"...\"><button type=\"button\" class=\"btn btn-default tooltipped\" data-toggle=\"tooltip\" data-position=\"bottom\" data-tooltip=\"".count($notraced)." unfinished maps\" onclick=\"showranks(-1)\">None</button><button type=\"button\" class=\"btn btn-default tooltipped\" onclick=\"showranks(0)\" data-toggle=\"tooltip\" data-position=\"bottom\" data-tooltip=\"$played maps with this rank\">All</button></div>\n");
print("<div class=\"btn-group\" role=\"group\" aria-label=\"...\">\n");
foreach($myranks as $rank=>$count)
{
	print("<button type=\"button\" class=\"btn btn-default tooltipped\" onclick=\"showranks($rank)\" data-toggle=\"tooltip\" data-position=\"bottom\" data-tooltip=\"$count maps with this rank\">$rank</button>");
}
print("</div>\n");
echo "<br></div><div style='margin: 3px 0;' class=\"row center-block\">";
foreach($playerrec as $map=>$rec)
{
(function($map, $rec) use($rankfiles) {
	global $_maps;
	$data = $_maps[array_search($map,array_column($_maps,0))];
	print('<div class="col s12 m6 ranks" name="rank_'.($rec+1).'">');
	print('<div class="panel panel-default" style="display:inline"><div class="panel-heading"> ');
	print(	"<a onclick=\"openpreview('{$data[0]}','{$data[4]}','{$data[1]}')\" style=\"cursor:pointer\">{$map}</a> ");
	print(	"<a href='?ranks={$map}' class='text-success'>(See all ranks)</a>");
	print("</div>");
	
	print("<table class=\"table table-bordered\"><thead><tr><th>#</th> <th>User</th> <th>Time</th> <th>Finished</th></tr></thead><tbody>");
	
	$start = max(1, $rec-1);
	$end = $start+3;
	
	$stats = StatsReader::fromMap($map);
	$stats->set($start);
	
	$r = $stats;
	while( $stats->next() && $stats->get() < $end )
	{
		if( $r->hasFinished() )
		{
			print("<tr ".( ( $r->get() == $rec ) ? 'class="active"' : "" )." >");
			print("<td>".$r->getRank()."</td>");
			print("<td><a href=\"./?user=".urlencode($r->getPlayer())."\">".htmlspecialchars($r->getPlayer())."</a></td>");
			print("<td>".htmlspecialchars($r->getTime())."</td>");
			print("<td>".htmlspecialchars($r->getTimesFinished())."</td>");
			print("</tr>");
		}
	}

})($map, $rec+1);
echo '</tbody></table></div><br/><br/></div>';
}
echo '</div>'."<div style='margin:1%'><b>Maps not finished:</b> ";

$c = "";
foreach($notraced as $map)
{
	$data = $_maps[array_search($map,array_column($_maps,0))];
	print($c."<a class='modal-trigger' data-toggle=\"modal\" data-target=\"previewmap\" onclick=\"setpreview('{$data[0]}','{$data[4]}','{$data[1]}')\" style=\"cursor:pointer\">{$map}</a>");
	$c = ", ";
}
if($c == "") print("No maps unfinished.");

echo '</div>';
?>
<?php } else { echo '<div class="container" role="main"><h2>This user has not ranked!</h2></div>'; } ?>