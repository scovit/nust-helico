/* Developed by Vittore F. Scolari (2011) */

function set_add_output(id) {
    var submi = document.getElementById("submit-form-box-file-pers-slid");
    submi.disabled = true;
}

function doneUpload(exitcode, code, userlist) {
    var box = document.getElementById("result-form-box-file-pers-slid");
    var submi = document.getElementById("submit-form-box-file-pers-slid");
    while(box.hasChildNodes())
	box.removeChild(box.firstChild);

    if(exitcode == -1) {
	box.appendChild(document.createTextNode(
			    "Error: Please fill the gene list file field"));
	submi.disabled = false;
    } else if (exitcode == -2) {
	box.appendChild(document.createTextNode(
			    "Error: The list file must be smaller than 1Mb"));
	submi.disabled = false;
    } else if (exitcode == -3) {
	box.appendChild(document.createTextNode(
			    "Error: Code should contain only " +
			    "alphanumeric exitcodes"));
	submi.disabled = false;
    } else if (exitcode == -4) {
	box.appendChild(document.createTextNode(
			    "Error: Code already in use"));
	submi.disabled = false;
    } else if (exitcode == -5) {
	box.appendChild(document.createTextNode(
			    "Error: Internal db error"));
	submi.disabled = false;
    } else if (exitcode == -6) {
	box.appendChild(document.createTextNode(
			    "Error: Permission error"));
	submi.disabled = false;
    } else if (exitcode == -7) {
	box.appendChild(document.createTextNode(
			    "Error: Title cannot contain (\\, &, \", ') characters"));
	submi.disabled = false;
    } else if (exitcode == 100) {
	add_file_main();
	var nam = box.id.split("-")[4];

	if(userlist == "guest") {
	    box.appendChild(document.createTextNode(
				"The data has been correctly uploaded "
				    + "with code " + code));
	    box.appendChild(document.createElement("br"));
            var a = document.createElement("a");
            a.href = "../analizzatore/list.php?code=" +
                code + "&user=" + userlist;
            a.appendChild(document.createTextNode(
				"Open the data set and analyze it with NuST"));
            a.target = "_top";
            box.appendChild(a);
            box.appendChild(document.createTextNode(
                                                    " - "));
	    a = document.createElement("a");
            a.href = "../analizzatore/cluster.php?code=" +
                code + "&user=" + userlist;
            a.appendChild(document.createTextNode(
                "Perform the linear aggregation analysis directly"));
            a.target = "_top";
            box.appendChild(a);
            box.appendChild(document.createTextNode(
                                                    " - "));
	} else {
	    box.appendChild(document.createTextNode(
				"The data has been correctly uploaded - "));
	    var a = document.createElement("a");
	    a.href = "../analizzatore/list.php?code=" +
		code + "&user=" + userlist;
	    a.appendChild(document.createTextNode(
			  "Open the data set and analyze it with NuST"));
	    a.target = "_top";
	    box.appendChild(a);
	    box.appendChild(document.createTextNode(
						    " - "));
	}

	var synonbox = "synonim-form-box-file-pers-slid";
	var newTag = document.createElement("input");
	newTag.type = "button";
	newTag.value = "Load another data set";
	newTag.onclick = function () {
	    submi.disabled = false;
	    while(box.hasChildNodes())
		box.removeChild(box.firstChild);
	    var synbox = document.getElementById(synonbox);
	    while(synbox.hasChildNodes())
		synbox.removeChild(synbox.firstChild);
	};
	box.appendChild(newTag);

	var synontool = new check_synonim(code, userlist, synonbox);
	synontool.onload = function() { document.triggerIResize();};
	synontool.doit();

    } else {
	box.appendChild(document.createTextNode(
			    "Unknown error " + exitcode));
	submi.disabled = false;
    }

}


function file_update_add_content(lines) {
    var userfield = document.getElementById("user-form-box-file-pers-slid");
    userfield.value = exploreuser;


    var ilform = document.getElementById("cb-box-file-pers-slid");
    while(ilform.hasChildNodes())
     	ilform.removeChild(ilform.firstChild);

    if (lines[0] === "&end") {
     	ilform.appendChild(document.createTextNode(
    			       "Error: no genomes found."));
    } else for (x in lines) {
	if (lines[x] === "&end")
	    break;
	var line = lines[x].split("&");
	var cb;
    	cb = document.createElement("input");
	cb.setAttribute("type", "radio");
	cb.setAttribute("name", "genome");
	cb.id = line[0] + "-cb";
	cb.setAttribute("value", line[0]);

	if (x == 0)
	    cb.checked = true;
	var l = document.createElement("label");
	l.appendChild(
	    document.createTextNode(" " + line[0] + " (" + line[1] + ")")
	);
	l.setAttribute("for", line[0] + "-cb");
	ilform.appendChild(cb);
	ilform.appendChild(l);
	ilform.appendChild(document.createElement("br"));
    }
  document.triggerIResize();
}

function update_file_add_content(lines) {
    var genomes = [];

    var x = 0;
    for (; x < lines.length; x++)
	genomes.push(lines[x]);

    file_update_add_content(genomes);
}

explore_functions.push("add_file_main");
function add_file_main() {
    var getgenomesRequest = new XMLHttpRequest();
    getgenomesRequest.open("GET",
			   "../admin/explore-queries.php" +
			   "?action=showgenomes", true);

    getgenomesRequest.onreadystatechange = function () {
	if (getgenomesRequest.readyState==4) {
//	    alert(getgenomesRequest.responseText);
	    var lines = getgenomesRequest.responseText.split("\n");
            update_file_add_content(lines);
	}
    };

    getgenomesRequest.send(null);
}
