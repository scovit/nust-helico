
list_functions.push("list_main");
function list_main() {
    if (lcode == "")
	return;

    var toclear = document.getElementById("description");
    while(toclear.hasChildNodes())
        toclear.removeChild(toclear.firstChild);
    toclear = document.getElementById("references");
    while(toclear.hasChildNodes())
        toclear.removeChild(toclear.firstChild);

    var readmeRequest = new XMLHttpRequest();
    var command = webdir + "/admin/list-queries.php?action=showreadme" + 
	"&code=" + lcode + "&user=" + luser;

    readmeRequest.open("GET", command, true);
    readmeRequest.onreadystatechange = function () {
	if (readmeRequest.readyState==4) {
	    var lines = readmeRequest.responseText.split("\n");
	    var i, il;
	    var ele = null;
	    for(i = 0, il = lines.length; i < il; i += 1) {
		if ( lines[i].match("^#") ) {
		    ele = null;
		}
		if ( lines[i].match("^# DESCRIPTION")) {
		    ele = document.getElementById("description");
		    ele.appendChild(document.createElement("br"));
		    var boldi = (document.createElement("span"));
		    boldi.className = "infotitle";
		    boldi.appendChild(document.createTextNode(
					  "Description: "));
		    ele.appendChild(boldi);
		    var data = document.createElement("span");
		    data.className= "infodata";
		    ele.appendChild(data);
		    ele = data;
		    continue;
		}
		if ( lines[i].match("^# REFERENCES")) {
		    ele = document.getElementById("references");
		    ele.appendChild(document.createElement("br"));
		    var boldi = (document.createElement("span"));
		    boldi.className = "infotitle";
		    boldi.appendChild(document.createTextNode(
					  "References: "));
		    ele.appendChild(boldi);
		    var data = document.createElement("span");
		    data.className= "infodata";
		    ele.appendChild(data);
		    ele = data;
		    continue;
		}
		if ( ele != null ) {
		    ele.appendChild(document.createTextNode(lines[i]));
		}
		
	    }
	}
    };
    readmeRequest.send(null);

    var synontool = new check_synonim(lcode, luser, "synonim-box");
    synontool.doit();

};
