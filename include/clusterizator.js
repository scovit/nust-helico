/* Developed by Vittore F. Scolari (2011) */

function switch_class_hack(oldclass, newclass) {
    var elements = getElementsByClassName(oldclass);
    for(var i = 0, il = elements.length; i < il; i += 1){
	var current = elements[i];
	var cla = current.className;
	cla = oldclass + " " + newclass;
//	cla = cla.replace(oldclass, newclass);
// cla += " " + oldclass;
	current.className = cla;
    }
}

var main_functions = [];
var user;
var webdir;


function main() {
// Set the user variable
    if (document.getElementById("user"))
	user = document.getElementById("user").innerHTML;
    else
	user = null;
// Set the webdir variable
    if (document.getElementById("webdir"))
	webdir = document.getElementById("webdir").innerHTML;
    else
	webdir = null;

// Set the visibility of reserved content
    var getpermRequest = new XMLHttpRequest();
    getpermRequest.open("GET", webdir +
			"/admin/user.php" + 
			"?action=getperm",
			true);

    getpermRequest.onreadystatechange = function () {
	if (getpermRequest.readyState==4) {
	    var lines = getpermRequest.responseText.split("\n");
	    if (lines[0] === "&admin") {
		switch_class_hack("notlogged", "clu_hidden");
		switch_class_hack("logged", "clu_unhidden");
		switch_class_hack("admin", "clu_unhidden");
		switch_class_hack("notadmin", "clu_hidden");
	    } else if (lines[0] === "&logged") {
		switch_class_hack("notlogged", "clu_hidden");
		switch_class_hack("logged", "clu_unhidden");
		switch_class_hack("admin", "clu_hidden");
		switch_class_hack("notadmin", "clu_unhidden");
	    } else if (lines[0] === "&notlogged"){
		switch_class_hack("notlogged", "clu_unhidden");
		switch_class_hack("logged", "clu_hidden");
		switch_class_hack("admin", "clu_hidden");
		switch_class_hack("notadmin", "clu_unhidden");
	    }
	}
    };

    getpermRequest.send(null);

// Execute the various main functions
    for (x in main_functions) {
	window[main_functions[x]]();
    }
}

document.triggerIResize = function (height) {
    if (height)
	document.exploreHeight = height;
    else
	document.exploreHeight = document.body.clientHeight + 30 + "px";

    if(parent != window && parent.resizeIFrame)
	parent.resizeIFrame(document);
};

function resizeIFrame(childoc) {
    var frames = document.getElementsByTagName("IFRAME");
    for (x in frames)
	if (frames[x].contentDocument == childoc)
	    frames[x].style.height = childoc.exploreHeight;

    if (document.ontriggeredframeresize)
	document.ontriggeredframeresize();
}

// Set the main function for every kind of browser
if (document.addEventListener)
    document.addEventListener("DOMContentLoaded",main,false);
else
    window.onload=main;