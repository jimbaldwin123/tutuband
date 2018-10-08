var strobe_on = 1;

function switch_class(id, c1,html){
elem = document.getElementById(id);
elem.innerHTML = '<img src=\'' + html + '\'>';
elem.className = c1;

if(elem.className == 'invis'){
	strobe_on = 0;
	document.getElementById('msc').className = "";
}
	strobe();

}

function closeme(interval){
setTimeout("switch_class('window1','invis', '');",interval);

}

function surprise(html) {
	
	document.getElementById('message').className = "invis";

	document.getElementById('content').className = "";

	setTimeout("switch_class('window1','','/images/facekini.jpg');closeme(1000);document.getElementById('msc').className = 'invis';",2000);
	// setTimeout("switch_class('window1','','/images/facekini.jpg');strobe_on = 1;closeme(3000);document.getElementById('msc').className = 'invis';",5000);


}

function strobe() {

	if(document.body.className == "black") {
		document.body.className = "white";
	}
	else {
		document.body.className = "black";
	}

//	document.body.className = "white";

	if(strobe_on == 1) {
		setTimeout("strobe();",1);
	} else {
		document.body.className = "orange";
	}
}