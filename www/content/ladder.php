<?php if(!isset($maps)) { http_response_code(403); die("<title>403 Forbidden</title><center><h1>403 Forbidden</h1></center>"); } ?>
<div class="container-alt" role="main">
	<style>
		.ladderposbelowten
		{
			display: none;
		}
		.active
		{
			background-color: #2b3940;
		}
	</style>
	<p>This ladder is a list of how well you perform in tunnel trouble based on the maps you've played (and not played) and the ranks you've got. Top ten is highlighted in grey, with the exception of rank 1 in green, 2 &amp; 3 in blue.</p>
	<div class="row">
		<div class="col s12 m6 l5">
			<table style="line-height:0.75"><?/*border: 1px solid #334*/?>
				<thead>
					<tr>
						<th>#</th> <th>Score</th> <th>User</th>
					</tr>
				</thead>
				<tbody>
<?php $rnkd = getLadder();
for($x=0;$x<count($rnkd);++$x)
{
	$ranked = explode(" ",$rnkd[$x]);
	echo "\t\t\t\t\t\t<tr"; if($x >= 1 && $x <= 2) echo " class=\"list-group-item-info\""; if($x == 0) { echo " class=\"list-group-item-success\""; } if($x >= 2 && $x <= 9) echo " class=\"active\""; if($x >= 9) echo " class=\"ladderposbelowten\""; echo ">\n\t\t\t\t\t\t<td>".($x+1)."</td> <td>{$ranked[0]}</td> <td><a href='?user=".urlencode($ranked[1])."'>{$ranked[1]}</a></td>\n\t\t\t\t\t</tr>\n"; 
}
?>
				</tbody>
			</table>
			<button class="btn btn-secondary" style="width:100%" onclick="$('.ladderposbelowten').css('display','table-row'); this.style.display='none';">Show all...</button>
		</div>
	</div>
</div>
<br />