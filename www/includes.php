<?php
// "modify" - to bypass caching modified files, adds the file modification time
// "defer" - stick the file at end of <body>, instead of in <head>
// "ext" - can be used to specify the extension, otherwise guesses based on file name
$includes = array(
	[ WEB_MATERIALIZE_CSS_PATH ],
	[ "./css/frombootstrap.css", "modify"=>true ],
	[ "./css/sortableTable.css", "modify"=>true, 
		"if"=>(function(){ global $_GET; return empty($_GET); }) 
	],
	[ "inline" => " " ],
	[ "./css/main.css", "modify"=>true ],
	[ WEB_JQUERY_PATH, "defer"=>true ],
	[ WEB_MATERIALIZE_JS_PATH, "defer"=>true ],
	[ "inline"=>"M.AutoInit()", "ext"=>"js", "defer"=>true ],
	[ "./js/sortableTable.js", "defer"=>true, "modify"=>true, 
		"if"=>(function(){ global $_GET; return empty($_GET); }) 
	],
	[ "./js/previewmodal.js", "defer"=>true, "modify"=>true ],
);
?>