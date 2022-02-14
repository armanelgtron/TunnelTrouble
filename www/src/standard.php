<?php
function stars($rating)
{
	$stars = "";
	for($x=1;$x<=floor($rating/2);$x++)
	{
		$stars .= "<i class='fa fa-star' aria-hidden='true'></i>";
	}
	if(round($rating/2) != $rating/2)
	{
		$x++;$stars .= "<i class='fa fa-star-half-o' aria-hidden='true'></i>";
	}
	while($x<=5)
	{
		$x++; $stars .= "<i class='fa fa-star-o' aria-hidden='true'></i>";
	}
	return $stars;
}

function time2str($ts)
{
	if($ts == 0)
		return "Too long ago";
	
	$diff = time() - $ts;
	if($diff == 0)
		return 'now';
	elseif($diff > 0)
	{
		$day_diff = floor($diff / 86400);
		if($day_diff == 0)
		{
			if($diff < 60) return 'just now';
			if($diff < 120) return '1 minute ago';
			if($diff < 3600) return floor($diff / 60) . ' minutes ago';
			if($diff < 7200) return '1 hour ago';
			if($diff < 86400) return floor($diff / 3600) . ' hours ago';
		}
		//if($day_diff == 1) return 'Yesterday';
		if($day_diff == 1) return '1 day ago';
		if($day_diff < 7) return $day_diff . ' days ago';
		if($day_diff < 31) return ceil($day_diff / 7) . ' weeks ago';
		//if($day_diff < 60) return 'last month';
		if($day_diff < 60) return '1 month ago';
		return date('F Y', $ts);
	}
	else
	{
		$diff = abs($diff);
		$day_diff = floor($diff / 86400);
		if($day_diff == 0)
		{
			if($diff < 120) return 'in a minute';
			if($diff < 3600) return 'in ' . floor($diff / 60) . ' minutes';
			if($diff < 7200) return 'in an hour';
			if($diff < 86400) return 'in ' . floor($diff / 3600) . ' hours';
		}
		if($day_diff == 1) return 'Tomorrow';
		if($day_diff < 4) return date('l', $ts);
		if($day_diff < 7 + (7 - date('w'))) return 'next week';
		if(ceil($day_diff / 7) < 4) return 'in ' . ceil($day_diff / 7) . ' weeks';
		if(date('n', $ts) == date('n') + 1) return 'next month';
		return date('F Y', $ts);
	}
}

