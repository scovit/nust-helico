
function notpowtwo (numb) {
    return (numb & (numb - 1));
}

var colotable = new Array("Blue",
 			  "Red",
 			  "Lime",
 			  "Purple",
 			  "Cyan",
 			  "Fuchsia",
			  "Yellow",
			  "Brown",
			  "Grey",
			  "Black");

var foretable = new Array("White",
			  "White",
			  "Black",
			  "White",
			  "Black",
			  "Black",
			  "Black",
			  "White",
			  "White",
			  "White");

var backtable = new Array("Blue",
			  "Red",
			  "Lime",
			  "Purple",
			  "Cyan",
			  "Fuchsia",
			  "Yellow",
			  "Brown",
			  "Grey",
			  "Black");


function get_code_user_string() {
    var retval = "";
    var elements = getElementsByClassName("multipleselection");
    var i, il;
    for(i = 0, il = elements.length; i < il; i += 1) {
	var user = elements[i].value.split('&')[0];
	var code = elements[i].value.split('&')[1];
	retval += "&code[]=" + code + "&user[]=" + user;
	var colo = elements[i].nextSibling.value;
	retval += "&color[]=" + colo;
    }
    return retval;
}

function update_sliding_window() {
    var immagine = document.getElementById("sliding");
    var caption = document.getElementById("caption");
    var bins = document.getElementById('bins').value;
    var normalize = document.getElementById('norm').checked;

    if ( notpowtwo( bins )) {
	alert('The number of bins should be a power of 2');
	return;
    }

    while(caption.hasChildNodes())
	caption.removeChild(caption.firstChild);

    caption.appendChild(document.createTextNode("Loading results..."));

    immagine.className = "naturalsize center";
    immagine.src = "../images/waiting-logo.gif";

// This should be an array of codes and users
    var codeuserstring = get_code_user_string();
    var imageSrc = webdir + '/admin/sliding-queries.php?action=getsliding' +
	'&format=png' +
	codeuserstring + '&bins=' +
	bins + '&normalize=' + normalize;

    var slidingImage = new Image();
    slidingImage.src = imageSrc;
    slidingImage.onload = function() {
	immagine.src = slidingImage.src;
	immagine.className = "graceplot center";
	while(caption.hasChildNodes())
	    caption.removeChild(caption.firstChild);
	var an = document.createElement("a");
	an.href = webdir + '/admin/sliding-queries.php?action=getsliding' +
	    '&format=agr' + codeuserstring +
	    '&bins=' + bins + '&normalize=' + normalize;
	an.appendChild(document.createTextNode("Save as grace (.agr) file"));
	caption.appendChild(an);
	caption.appendChild(document.createTextNode(" or "));
	an = document.createElement("a");
	an.href = webdir + '/admin/sliding-queries.php?action=getsliding' +
	    '&format=pdf' + codeuserstring +
	    '&bins=' + bins + '&normalize=' + normalize;
	an.appendChild(document.createTextNode("Save as pdf"));
	caption.appendChild(an);
	caption.appendChild(document.createTextNode(" or "));
	an = document.createElement("a");
	an.href = webdir + '/admin/sliding-queries.php?action=getsliding' +
	    '&format=zip' + codeuserstring +
	    '&bins=' + bins + '&normalize=' + normalize;
	an.appendChild(document.createTextNode("Save as raw data file"));
	caption.appendChild(an);
    };

}

function ColorChooser(numb, selectelement) {
    if (!numb)
	numb = 0;

    if (!selectelement)
	this.selector = document.createElement("select");
    else
	this.selector = selectelement;

    this.selector.className = "colorchooser";

    var i, il;
    for(i = 0, il = colotable.length; i < il; i += 1) {
	var colore = document.createElement("option");
	colore.style.backgroundColor = colotable[i];
	colore.style.color = foretable[i];
	colore.value = colotable[i];
	colore.text = colotable[i];
	this.selector.appendChild(colore);
    }

    this.selector.value = colotable[numb];

    var _this = this;

    this.selector.onchange = function() {
	var sele = _this.selector;
	sele.style.backgroundColor =
	    sele.options[sele.selectedIndex].style.backgroundColor;
	sele.style.color =
	    sele.options[sele.selectedIndex].style.color;
	update_sliding_window();
    };

    this.appendTo = function(towhat) {
	towhat.appendChild(_this.selector);
    };

    var sele = _this.selector;
    sele.style.backgroundColor =
	sele.options[sele.selectedIndex].style.backgroundColor;
    sele.style.color =
	sele.options[sele.selectedIndex].style.color;
    
}

function add_list_to_load() {
    // Look if there are already ten lists
    var elements = getElementsByClassName("multipleselection");
    if (elements.length == 10)
	return;


    // Add another list to the options
    var multiple = document.getElementById("multiple-selection");
    multiple.appendChild(document.createElement("br"));
    var newlist = document.createElement("select");
    newlist.className = "virginselection intersel";
    compile_list_option(newlist, user, "common");
    newlist.onchange = function () {
	if(newlist.className == "virginselection intersel") {
	    newlist.className = "multipleselection intersel";

	    var numb = (getElementsByClassName("colorchooser")).length;
	    var colorchooser = new ColorChooser(numb);
	    
	    var killbutton = document.createElement("input");
	    killbutton.type="button";
	    killbutton.className="killbutton";
	    killbutton.value="x";
	    killbutton.onclick = function () {
		multiple.removeChild(
		    killbutton.previousSibling.previousSibling.previousSibling);
		multiple.removeChild(
		    killbutton.previousSibling.previousSibling);
		multiple.removeChild(killbutton.previousSibling);
		multiple.removeChild(killbutton);
		var ele = getElementsByClassName("multipleselection");
		if (ele.length == 9)
		    add_list_to_load();
		sliding_main();
	    };
	    multiple.removeChild(newlist.nextSibling);
	    colorchooser.appendTo(multiple);
	    multiple.appendChild(killbutton);
	    add_list_to_load();
	}
	sliding_main();
    };
    multiple.appendChild(newlist);
    multiple.appendChild(document.createTextNode(
			     " You can load another list."));
}

var firstrun = 0;

list_functions.push("sliding_main");
function sliding_main() {
    if (lcode == "")
	return;

    var tendina = document.getElementById("get-list-tendina");
    tendina.className = "multipleselection intersel";

    if (!firstrun) {
	firstrun++;
	var binsbox = new log2_slider("bins", 2 , 1024);
	var colochos = getElementsByClassName("colorchooser");
	var i, il;
	for(i = 0, il = colochos.length; i < il; i += 1) {
	    var cius = new ColorChooser(0, colochos[i]);
	}
	add_list_to_load();
    }

    update_sliding_window();
}
