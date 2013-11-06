/* Developed by Vittore F. Scolari (2011) */

function delete_lists(event) {
    if(window.event) event = window.event;
    var srcEl = event.srcElement ? event.srcElement : event.target;
    var cboxes = srcEl.getElementsByTagName("input");
    var deletel = [];
    for (x in cboxes) {
	if ((cboxes[x].type==="checkbox") &&(cboxes[x].checked== true))
	    deletel.push(cboxes[x].value);
    }

    var deleteRequest = new XMLHttpRequest();
    var req = "../admin/explore-queries.php" + 
	"?action=delete" +
	"&user=" + exploreuser;
    for (x in deletel) {
	req += "&deletel[]=" + deletel[x];
    }

    deleteRequest.open("GET", req, true);
    
    deleteRequest.onreadystatechange = function () {
	if (deleteRequest.readyState==4) {
//	    alert(deleteRequest.responseText);
	    var lines = deleteRequest.responseText.split("\n");
	    delete_main();
	}
    };

    deleteRequest.send(null);

}

function update_del_content(ilform, lines) {
    while(ilform.hasChildNodes())
	ilform.removeChild(ilform.firstChild);
    if (lines[0] === "&end") {
	var newTag = document.createElement("p");
	newTag.innerHTML = "No data found, you can add and manage datasets using the links above.";
	ilform.appendChild(newTag);
    } else for (x in lines) {
	if (lines[x] === "&end")
	    break;
	var line = lines[x].split("&");
	var cb;
    	cb = document.createElement("input");
	cb.setAttribute("type", "checkbox");
	cb.setAttribute("name", "deletel");
	cb.id = line[1] + "-cb";
	cb.setAttribute("value", line[1]);
	var l = document.createElement("label");
//	l.className = "list-text";
	if (exploreuser == "guest")
	    l.appendChild(
		document.createTextNode(" " + line[1] + " - " + line [3] ));
	else
	    l.appendChild(
		document.createTextNode(" " + line[2] + " - " + line [3] ));
	l.setAttribute("for", line[0] + "-cb");
	ilform.appendChild(cb);
	ilform.appendChild(l);
	ilform.appendChild(document.createElement("br"));
    }

    document.triggerIResize();
}

explore_functions.push("delete_main");
function delete_main() {
    var getlistsRequest = new XMLHttpRequest();
    getlistsRequest.open("GET", 
			 "../admin/explore-queries.php" + 
			 "?action=showlists" +
			 "&user=" + exploreuser, true);

    getlistsRequest.onreadystatechange = function () {
	if (getlistsRequest.readyState==4) {
	    var lines = getlistsRequest.responseText.split("\n");
	    var box = document.getElementById("deletecontent");
            update_del_content(box, lines);
	}
    };

    getlistsRequest.send(null);
}
