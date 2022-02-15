function setpreview(map,author,mapfile)
{
	$("#pMapContent").html("<span style='position:absolute'>Please wait...</span>");
	document.getElementById("pMapTitle").innerHTML = map+" by "+author;
	
	var e = document.createElement("IFRAME");
	var props = "";
	props += "hideselect=true&";
	props += "hidetxtbox=true&";
	props += "set_scale=3&";
	e.setAttribute("src", "https://www.armanelgtron.tk/tools/map/preview/loadFromResource.php?file=/resource/"+mapfile+"#"+props)
	setTimeout(function()
	{
	e.setAttribute("width", $("#pMapContent").width());
	e.setAttribute("height", $("#pMapContent").height());
	$("#pMapContent").children(0).text("");
	}, 100);
	e.style.border = "none";
	
	document.getElementById("pMapContent").appendChild(e);
	
	document.getElementById("viewsrc").setAttribute("href","https://www.armanelgtron.tk/armagetronad/resource/"+mapfile+"");
}

function openpreview(map, author, mapfile)
{
	setpreview(map, author, mapfile);
	$("#previewmap").modal("open");
}

function previewgrid(checked)
{
	/*
	var target = document.getElementById('mapdisp');
	if(checked) { target.style.background = "url(./floor.png) black";} else { target.style.background = "black";}
	*/
}
