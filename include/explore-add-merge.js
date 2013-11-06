/* Developed by Vittore F. Scolari (2011) */

function set_add_output(id) {
    var submi = document.getElementById("submit-form-box-inter-pers-slid");
    submi.disabled = true;
}

function doneUpload(exitcode, code, userlist) {
    var box = document.getElementById("result-form-box-inter-pers-slid");
    var submi = document.getElementById("submit-form-box-inter-pers-slid");
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
    } else if (exitcode == 101) {
	add_merge_main();
	var nam = box.id.split("-")[4];

	if(userlist == "guest")
	    box.appendChild(document.createTextNode(
				"The data has been correctly created "
				    + "with code " + code + " - "));
	else
	    box.appendChild(document.createTextNode(
				"The data has been correctly created - "));

	var a = document.createElement("a");
	a.href = "../analizzatore/list.php?code=" + code + "&user=" + user;
	a.appendChild(document.createTextNode(
			  "Open the data set and analyze it with NuST"));
	a.target = "_top";
	box.appendChild(a);
	box.appendChild(document.createTextNode(
			    " - "));

	var hypboxid = "hyp-form-box-inter-pers-slid";
	var newTag = document.createElement("input");
	newTag.type = "button";
	newTag.value = "Load another data set";
	newTag.onclick = function () {
	    submi.disabled = true;
	    while(box.hasChildNodes())
		box.removeChild(box.firstChild);
	    var hypbox = document.getElementById(hypboxid);
	    while(hypbox.hasChildNodes())
		hypbox.removeChild(hypbox.firstChild);
	    hypbox.appendChild(document.createTextNode(
				   "Select two data sets first"));
	    var ilform1 = document.getElementById(
		"sl1-form-box-inter-pers-slid");
	    var ilform2 = document.getElementById(
		"sl2-form-box-inter-pers-slid");
	    ilform1.selectedIndex = ilform2.selectedIndex = 0;
	};
	box.appendChild(newTag);

    } else {
	box.appendChild(document.createTextNode(
			    "Unknown error " + exitcode));
	submi.disabled = false;
    }

}

function merge_update_add_content(userlists, commonlists) {
    var ilform1 = document.getElementById("sl1-form-box-inter-pers-slid");
    var ilform2 = document.getElementById("sl2-form-box-inter-pers-slid");
    var f1selection = 0;
    var f2selection = 0;
    if (ilform1.selectedIndex != -1)
	f1selection = ilform1.selectedIndex;
    if (ilform2.selectedIndex != -1)
	f2selection = ilform2.selectedIndex;

    while(ilform1.hasChildNodes())
     	ilform1.removeChild(ilform1.firstChild);
    while(ilform2.hasChildNodes())
     	ilform2.removeChild(ilform2.firstChild);

    compile_inter_select(ilform1, userlists, commonlists);
    compile_inter_select(ilform2, userlists, commonlists);

    ilform1.selectedIndex = f1selection;
    ilform2.selectedIndex = f2selection;

    var userfield = document.getElementById(
     	"user-form-box-inter-pers-slid");
    userfield.value = exploreuser;

    ilform1.onchange = ilform2.onchange = function () {
	if ((ilform1.selectedIndex != 0) &&
	    (ilform2.selectedIndex != 0)) {
	    var uno = ilform1.options[ilform1.selectedIndex].value.split("&");
	    var due = ilform2.options[ilform2.selectedIndex].value.split("&");

	    var user1field = document.getElementById(
     		"user1-form-box-inter-pers-slid");
	    user1field.value = uno[0];
	    var list1field = document.getElementById(
     		"list1-form-box-inter-pers-slid");
	    list1field.value = uno[1];
	    var user2field = document.getElementById(
     		"user2-form-box-inter-pers-slid");
	    user2field.value = due[0];
	    var list2field = document.getElementById(
     		"list2-form-box-inter-pers-slid");
	    list2field.value = due[1];

	    var subbutton = document.getElementById(
		"submit-form-box-inter-pers-slid");
	    subbutton.disabled = false;
	}
    };
}

function update_merge_add_content(lines) {
    var genomes = [];
    var commonlists = [];
    var userlists = [];
    var x;
    for (x = 0; x < lines.length; x++) {
	if (lines[x] === "&lists")
	    continue;
	if (lines[x] === "&genomes")
	    break;
	if(lines[x].split("&")[0] === "common")
	    commonlists.push(lines[x]);
	else
	    userlists.push(lines[x]);
    }

    for (x++; x < lines.length; x++)
	genomes.push(lines[x].split('&')[0]);
    userlists.push("&end");
    commonlists.push("&end");

    merge_update_add_content(userlists, commonlists);
}

explore_functions.push("add_merge_main");
function add_merge_main() {
    var getgenomesRequest = new XMLHttpRequest();
    getgenomesRequest.open("GET",
			   "../admin/explore-queries.php" +
			   "?action=showlistsandgenomes" +
			   "&user[]=" + exploreuser +
			   "&user[]=common", true);

    getgenomesRequest.onreadystatechange = function () {
	if (getgenomesRequest.readyState==4) {
//	    alert(getgenomesRequest.responseText);
	    var lines = getgenomesRequest.responseText.split("\n");
            update_merge_add_content(lines);
	}
    };

    getgenomesRequest.send(null);
}

