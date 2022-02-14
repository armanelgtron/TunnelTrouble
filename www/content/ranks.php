<?php if(!isset($maps)) { http_response_code(403); die("<title>403 Forbidden</title><center><h1>403 Forbidden</h1></center>"); } ?>

<div class="container-alt" role="main">
<?php if(empty($_GET["ranks"])) { ?>
	<p>Select a map below:</p>
	<ul class="collection white z-depth-3 links-kludge" style="border:none;padding-right:0">
<?php
$mapss = array();
foreach($maps as $map)
{
	echo "\t\t<li><a class='collection-item' href=\"?ranks=$map[0]\" class=\"list-group-item\">$map[0]</a></li>";
	$mapss[] = $map[0];
}
/*
$file = json_decode(file_get_contents("$saveto/stats.txt"),true);
foreach($file as $map => $stats)
{
	if(!in_array($map,$mapss))
	{
		echo "\t\t<a href=\"?ranks=$map\" id=\"storage\" class=\"list-group-item list-group-item-info\">$map</a>";
	}
}
*/
?>
	</ul>
<?php } else { ?>
	<script>
		function filterItems(name)
		{
			var ranks = document.getElementsByClassName("arank");
			var found = 0;
			var lower = (name == name.toLowerCase());
			for(var i=ranks.length-1;i>=0;--i)
			{
				if( this.value == "" || 
					( lower && ranks[i].children[1].innerText.toLowerCase().indexOf(name) == 0 )
					||
					( !lower && ranks[i].children[1].innerText.indexOf(name) == 0 )
				)
				{
					ranks[i].style.display = "";
					++found;
				}
				else
				{
					ranks[i].style.display = "none";
				}
			}
			if(!found)
			{
				for(var i=ranks.length-1;i>=0;--i)
				{
					if( this.value == "" || 
						( lower && ranks[i].children[1].innerText.toLowerCase().match(name) )
						||
						( !lower && ranks[i].children[1].innerText.match(name) )
					)
					{
						ranks[i].style.display = "";
						++found;
					}
					else
					{
						ranks[i].style.display = "none";
					}
				}
			}
			if(!found)
			{
				document.getElementById("notrank").style.display = "";
			}
			else
			{
				document.getElementById("notrank").style.display = "none";
			}
		}
	</script>
	<div class="form-group" style="display:inline-block;position:absolute;left:21%;max-width:30%">
		<input type="text" class="form-control" style="position:relative;top:64px"
			placeholder="Badly Positioned Search Box"
			onkeyup="filterItems(this.value)"
		/>
		<!--placeholder="No longer a Useless Textbox"-->
	</div>
	<span style="font-size:20pt;">
		<a class="button btn btn-default" style="margin-top:8px;" href="?ranks">View other maps</a>
		<?=htmlentities($_GET["ranks"]);?>
	</span><br><br>
	<table class="table table-bordered list-group">
		<thead>
			<tr>
				<th>#</th> <th>User</th> <th>Time</th> <th>Improved</th>
			</tr>
		</thead>
		<tbody>
<?php
$file = getMapRankPath($_GET["ranks"]);
$ranks = explode("\n",file_get_contents($file));
$x=0;foreach($ranks as $rank) if($rank != "")
{
	$x++;
	$split = explode(" ",$rank);
	if($split[1] == -1) continue;
	echo "\t\t\t<tr class='arank'>\n\t\t\t\t<td>$x</td> <td><a href=\"./?user=".urlencode($split[0])."\">".htmlspecialchars($split[0])."</a></td> <td>".htmlspecialchars($split[1])."</td> <td>".htmlspecialchars($split[2])."</td>\n\t\t\t</tr>\n"; 
}
	echo "\t\t\t<tr id='notrank' style='display:none'>\n\t\t\t\t<td></td> <td>No matches found</td> <td></td> <td></td>\n\t\t\t</tr>\n"; 
?>
		</tbody>
	</table>
<?php } ?>
