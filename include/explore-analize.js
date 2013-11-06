/* Developed by Vittore F. Scolari (2011) */

function update_ana_content(links, lines) {
    var directory="";
    while(links.hasChildNodes())
	links.removeChild(links.firstChild);
    if (lines[0] === "&end") {
	var newTag = document.createElement("p");
	newTag.innerHTML = "No data found, you can add and manage data sets using the links above.";
	links.appendChild(newTag);
    } else for (x in lines) {
	if (lines[x] === "&end")
	    break;
	var line = lines[x].split("&");
	var newTag;
	if (line[4] != directory && !(exploreuser === 'guest')) {
	    directory = line[4];
	    newTag = document.createElement("p");
	    newTag.className = "dirname";
	    newTag.appendChild(document.createTextNode(directory));
	    links.appendChild(newTag);
	}

	newTag = document.createElement("a");
	newTag.className = "list-anchor";
	var image = document.createElement("img");
	image.src = "../images/applications-accessories.png";
	newTag.appendChild(image);
	var textbox = document.createElement("span");
	textbox.className = "list-text";
	if (exploreuser === "guest")
	    textbox.appendChild(
		document.createTextNode(" " + line[1] + " - " + line[2]));
	else
	    textbox.appendChild(
		document.createTextNode(" " + line[2] ));
	newTag.appendChild(textbox);
	newTag.href =
	    "../analizzatore/list.php" +
	    "?code=" + line[1] +
	    "&user=" + line[0];
	newTag.target="_parent";
	links.appendChild(newTag);
//	links.appendChild(document.createElement("br"));
    }

    if(exploreuser == "guest")
	links.appendChild(document.createTextNode(
			      "Tip: you can login and keep your data sets"
				  + " for multiple sessions. " +
				  "In order to obtain a username, please send an e-mail"
				  + " to the administrator"));
    document.triggerIResize();
}

explore_functions.push("analize_main");
function analize_main() {

    var getlistsRequest = new XMLHttpRequest();
    getlistsRequest.open("GET",
			 "../admin/explore-queries.php" +
			 "?action=showlists" +
			 "&user=" + exploreuser, true);

    getlistsRequest.onreadystatechange = function () {
	if (getlistsRequest.readyState==4) {
//	    alert(getlistsRequest.responseText);
	    var lines = getlistsRequest.responseText.split("\n");
	    var box = document.getElementById("analizecontent");
	    update_ana_content(box, lines);
	}
    };

    getlistsRequest.send(null);
}
