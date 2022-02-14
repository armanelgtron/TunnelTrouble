function setpreview(map,author,mapfile)
{
	document.getElementById("pMapContent").innerHTML = "Please wait...";
	document.getElementById("pMapTitle").innerHTML = map+" by "+author;
	var mapload = new XMLHttpRequest();
	mapload.onreadystatechange = function() 
	{
		if(mapload.readyState == 4) 
		{
			document.getElementById("pMapContent").innerHTML = mapload.responseText;
			previewgrid(document.getElementById("gridcheck").checked);
		}
	}
	mapload.open("GET","./maps/?map="+map,true);
	mapload.send();
	document.getElementById("viewsrc").setAttribute("href","https://www.armanelgtron.tk/armagetronad/resource/"+mapfile+"");
}
function previewgrid(checked)
{
	var target = document.getElementById('mapdisp');
	if(checked) { target.style.background = "url(./floor.png) black";} else { target.style.background = "black";}
	
}
