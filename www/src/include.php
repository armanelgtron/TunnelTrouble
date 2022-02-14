<?php
function addIncludes($ctx, $b="", $e="\n")
{
	global $includes;
	foreach($includes as $inc)
	{
		// make sure we should include the file now
		if( @$inc["defer"] )
		{
			if( $ctx != "end" ) continue;
		}
		else
		{
			if( $ctx != "head" ) continue;
		}
		
		if( isset($inc["if"]) )
		{
			// check results of calling function
			if( !(($inc["if"])()) )
			{
				continue;
			}
		}
		
		$pathinfo = (object)(isset($inc[0])?pathinfo($inc[0]):[]);
		
		$format = "<b>INCLUDE ERROR</b>: %s";
		$inline_format = "%s";
		switch( isset($inc["ext"]) ? $inc["ext"] : @$pathinfo->extension )
		{
			case "css":
				$format = '<link type="text/css" rel="stylesheet" href="%s" />';
				$inline_format = "<style>%s</style>";
				break;
			case "js":
				$format = '<script type="text/javascript" src="%s"></script>';
				$inline_format = '<script type="text/javascript">%s</script>';
				break;
		}
		
		if( @$inc["inline"] )
		{
			printf("{$b}{$inline_format}{$e}", $inc["inline"]);
		}
		else
		{
			$name = $inc[0];
			if( @$inc["modify"] )
			{
				$name .= "?".filemtime($inc[0]);
			}
			
			printf("{$b}{$format}{$e}", $name);
		}
	}
}
