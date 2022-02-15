<?php

$pages_nav = array(
	[ "Home", "./", "active"=>(function(){ return empty($_GET); }) ],
	[ "Ladder", "./?ladder", "active"=>(function(){ return isset($_GET["ladder"]); }) ],
);
