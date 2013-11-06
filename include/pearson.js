
function notpowtwo (numb) {
    return (numb & (numb - 1));
}

function update_pearson_graph() {
    var immagine = document.getElementById("sliding");
    var caption = document.getElementById("caption");
    var bins = document.getElementById('bins').value;

    if ( notpowtwo( bins )) {
	alert('The number of bins should be a power of 2');
        return;
    }

    while(caption.hasChildNodes())
        caption.removeChild(caption.firstChild);

    caption.appendChild(document.createTextNode("Loading results..."));

    immagine.className = "naturalsize center";
    immagine.src = "../images/waiting-logo.gif";

    var codeuserstring = '&code[]=' + lcode + '&user[]=' + luser +
	'&code[]=' + lcode2 + '&user[]=' + luser2;
    var imageSrc = webdir + '/admin/sliding-queries.php?action=getpearson' +
        '&format=png' +
        codeuserstring + '&bins=' + bins;

    var slidingImage = new Image();
    slidingImage.src = imageSrc;
    slidingImage.onload = function() {
        immagine.src = slidingImage.src;
        immagine.className = "graceplot center";
        while(caption.hasChildNodes())
            caption.removeChild(caption.firstChild);
        var an = document.createElement("a");
        an.href = webdir + '/admin/sliding-queries.php?action=getpearson' +
            '&format=agr' + codeuserstring +
            '&bins=' + bins;
        an.appendChild(document.createTextNode("Save as grace (.agr) file"));
        caption.appendChild(an);
        caption.appendChild(document.createTextNode(" or "));
        an = document.createElement("a");
        an.href = webdir + '/admin/sliding-queries.php?action=getpearson' +
            '&format=pdf' + codeuserstring +
            '&bins=' + bins;
        an.appendChild(document.createTextNode("Save as pdf"));
        caption.appendChild(an);
        caption.appendChild(document.createTextNode(" or "));
        an = document.createElement("a");
        an.href = webdir + '/admin/sliding-queries.php?action=getpearson' +
            '&format=pdfbaw' + codeuserstring +
            '&bins=' + bins;
        an.appendChild(document.createTextNode("Save as pdf (black&white)"));
        caption.appendChild(an);
        caption.appendChild(document.createTextNode(" or "));
        an = document.createElement("a");
        an.href = webdir + '/admin/sliding-queries.php?action=getpearson' +
            '&format=txt' + codeuserstring +
            '&bins=' + bins;
        an.appendChild(document.createTextNode("Save as data txt file"));
        caption.appendChild(an);
    };

}

var secondcompiled = false;
var goon = false;
var lcode2, luser2;

list_functions.push("pearson_main");
function pearson_main() {

    var tendina = document.getElementById("get-list-tendina");
    var sectendina = document.getElementById("get-list-second");
    if (!secondcompiled) {
	if (user)
	    compile_list_option(sectendina,
				user, "common");
	else
	    compile_list_option(sectendina,
				"", "common");

	sectendina.onchange = function () {
	    pearson_main();
	};
	secondcompiled = true;
	return;
    }

    if ((tendina.selectedIndex != 0) &&
        (sectendina.selectedIndex != 0) &&
        !goon) {
        switch_class_hack("get-list-second-off",
			  "get-list-second-temp");
        switch_class_hack("get-list-second-on",
                          "get-list-second-off");
        switch_class_hack("get-list-second-temp",
                          "get-list-second-on");
        goon = true;
    }

    if ((tendina.selectedIndex != 0) &&
        (sectendina.selectedIndex != 0)) {
	var binsbox = new log2_slider("bins", 2 , 1024);
	luser2 = sectendina.options[
	    sectendina.selectedIndex].value.split("&")[0];
	lcode2 = sectendina.options[
	    sectendina.selectedIndex].value.split("&")[1];
	update_pearson_graph();
    }

    // Enable everything
    for(var i = 1, il = tendina.length; i < il; i += 1) {
      tendina.options[i].disabled = false;
    }

    for(var i = 1, il = sectendina.length; i < il; i += 1) {
      sectendina.options[i].disabled = false;
    }

    // Disable the other
    if (tendina.selectedIndex != 0) sectendina.options[tendina.selectedIndex].disabled = true;
    if (sectendina.selectedIndex != 0) tendina.options[sectendina.selectedIndex].disabled = true;
};
