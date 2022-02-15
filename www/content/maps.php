<?php if(!isset($maps)) { http_response_code(403); die("<title>403 Forbidden</title><center><h1>403 Forbidden</h1></center>"); } ?>

<div class="container-alt" role="main">

<?php if(empty($_GET)): ?>
	<br />
	<div class="card blue-grey darken-3">
		<div class="card-content white-text">
			<span class="card-title">Tunnel Trouble</span>
			<p>Practice mazing with fortress and sumo physics. Difficulty ranging from easy to basically impossible.</p>
		</div>
	</div>
<?php endif; ?>
	<div class="card-panel white-text" style="background-color:#2c383f;padding-top:9px">
		<h6 style="font-family:'Lato'"><?=count($maps);?> maps <span style="font-family:'Open Sans'">(rotation)</span></h6>
			<table data-toggle="table" data-sort-name="rotnum" data-sort-order="asc" class="table table-no-bordered ui-sortable-table" style="border">
				<thead>
					<tr>
						<th data-field="rotnum" data-sortable="true">#</th>
						<th></th>
						<th data-field="author" data-sortable="true">Author</th>
						<th data-field="name" data-sortable="true">Map Name</th>
						<!--<th data-field="ratings" data-sortable="true">Ratings</th>-->
						<th data-field="completed" data-sortable="true">Completed</th>
						<th>Record</th>
					</tr>
				</thead>
				<tbody id="maps">
<?php 
#print_r($ratings);
$ratingsls = array();
foreach($ratings as $rating)
{
	$ratingsls[] = $rating["map"];
}
$x=0;foreach((empty($_GET)?$maps:$_maps) as $map)
{$x++;
	echo "\t\t\t\t\t<tr id='map_".($x-1)."' ";
	if($map[0] == $currmap)
	{
		echo " class='active";
		if($currrot == $x-1)
		{
			$ta = "rotation";
		}
		else
		{
			$ta = "queue";
		}
	}
	else
	{
		echo " class='";
		if($currrot == $x-1)
		{
			$ta="rotation";
		}
		else
		{
			$ta="";
		}
	}
	if( count($maps) < $x ) echo " info";
	echo "' >";
	if(in_array($map[0],$ratingsls))
	{
		$tsr = $asr = 0; 
		foreach($ratings as $trating) 
		{
			if($trating["map"] == $map[0])
			{
				$tsr++; $asr = $trating["rating"]+$asr;
			}
		}
		$rated = $asr/$tsr;
		$rating = stars(round($rated));
		#$orated = number_format($rated,1,'.','');
		$orated = round($rated);
		if(strlen($orated) === 1) $orated = '0'.$orated;
	}
	else
	{
		$rating = "Rate this map";
		$rated = $orated = 0;
	}
	$ranks = explode("\n",file_get_contents(getMapRankPath($map[0])));
	$rk = $c = 0; foreach($ranks as $r) { if($r=="") continue; if( (explode(" ",$r))[1] != -1 ) { ++$c; } ++$rk; }
	$ranker = ($c==0)?(""):(explode(" ",($ranks[0]))[0]);
	echo "\n\t\t\t\t\t\t<td>$x</td> <td>$ta</td> <td>";
	
	if(isset($mapmakers[$map[4]]))
	{
		print("<a href='?user=".urlencode($mapmakers[$map[4]])."' class='text-danger'>{$map[4]}</span></td>");
	}
	else print("<span class='text-danger'>{$map[4]}</span></td>");
	print("<td><a class='text-warning' onclick=\"openpreview('{$map[0]}','{$map[4]}','{$map[1]}')\" style=\"cursor:pointer\">{$map[0]}</a></td>");
	//print("<td><span style='display:none;'>$orated</span><a href=\"?rate={$map[0]}\" class='text-info'>$rating</a></td>");
	print("<td>".floor(($c/$rk)*100)."%</td>");
	print("<td><a href=\"./?user=".urlencode($ranker)."\">$ranker</a> <a href='?ranks={$map[0]}' class='text-success'>(See all ranks)</a></td>");
	
	echo "\n\t\t\t\t\t</tr>\n"; 
}
?>
				</tbody>
			</table>
		<!--</div>-->
	</div>

</div>
