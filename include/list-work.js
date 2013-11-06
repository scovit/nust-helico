var tendinaloaded = false;

function compile_list_option(ilform, user1, user2) {
    var getgenomesRequest = new XMLHttpRequest();
    var comando = webdir + "/admin/explore-queries.php" + 
	"?action=showlistsandgenomes" +
	"&user[]=" + user1 +
	"&user[]=" + user2;
    
    getgenomesRequest.open("GET", 
			   comando, true);

    getgenomesRequest.onreadystatechange = function () {
	if (getgenomesRequest.readyState==4) {
//	    alert(getgenomesRequest.responseText);
	    var lines = getgenomesRequest.responseText.split("\n");
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

	    compile_inter_select(ilform, userlists, commonlists);
	    if (lcode != "" && (ilform.id == "get-list-tendina"))
		ilform.value = luser + "&" + lcode;

	    tendinaloaded = true;
	}
    };
 
    getgenomesRequest.send(null);

}

function fill_list_fields(luser, llist) {
    var lcodebox = document.getElementById("lcode");
    while(lcodebox.hasChildNodes())
	lcodebox.removeChild(lcodebox.firstChild);
    var luserbox = document.getElementById("luser");
    while(luserbox.hasChildNodes())
	luserbox.removeChild(luserbox.firstChild);
    var ltitlebox = document.getElementById("ltitle");
    while(ltitlebox.hasChildNodes())
	ltitlebox.removeChild(ltitlebox.firstChild);
    var ldirecbox = document.getElementById("ldirec");
    while(ldirecbox.hasChildNodes())
        ldirecbox.removeChild(ldirecbox.firstChild);
    var gcodebox = document.getElementById("gcode");
    while(gcodebox.hasChildNodes())
	gcodebox.removeChild(gcodebox.firstChild);

    var getinfoRequest = new XMLHttpRequest();
    var comando = webdir + "/admin/list-queries.php" + 
	"?action=getinfo" +
	"&code=" + llist +
	"&user=" + luser;

    getinfoRequest.open("GET", 
			comando, true);

    getinfoRequest.onreadystatechange = function () {
	if (getinfoRequest.readyState==4) {
//	    alert(getinfoRequest.responseText);
	    var lines = getinfoRequest.responseText.split("\n");
	    var info = [];
	    for (x = 0; x < lines.length; x++) {
		var line = lines[x].split("&");
		info[line[0]] = line[1];
	    }

	    lcodebox.appendChild(document.createTextNode(info["lcode"]));
	    luserbox.appendChild(document.createTextNode(info["luser"]));
	    ltitlebox.appendChild(document.createTextNode(info["ltitle"]));
            ldirecbox.appendChild(document.createTextNode(info["ldirec"]));
	    gcodebox.appendChild(document.createTextNode(info["gcode"]));

	    // Reset link templates
	    var elements = getElementsByClassName("template-href");
	    for(i = 0, il = elements.length; i < il; i += 1)
		if (elements[i].firstChild.className == "href-template") {
		    var tempele = elements[i].firstChild;
		    
		    if(elements[i].nodeName == "A")
			elements[i].href = tempele.href;
		    if (elements[i].nodeName == "FORM")
			elements[i].action = tempele.href;
		    if (elements[i].nodeName == "IMG")
			elements[i].src = tempele.href;
		}

	    list_work_main();    
	}
    };
 
    getinfoRequest.send(null);   
}

window.onpopstate = function(event) {
    if(event.state != null)
	window.location.href = window.location.href;
};

var list_functions = [];
var lcode, luser, ltitle, ldirec, gcode;

function execute_list_functions() {
    if(!tendinaloaded) {
        setTimeout(execute_list_functions, 10);
	return;
    }

    // Execute the various list functions
    for (x in list_functions) {
	window[list_functions[x]]();
    }
}

main_functions.push("list_work_main");
function list_work_main() {
    // Look if the list have not been selected
    if (document.getElementById("lcode").innerHTML == "") {
	switch_class_hack("get-list-off", "get-list-temp");
	switch_class_hack("get-list-on", "get-list-off");
	switch_class_hack("get-list-temp", "get-list-on");
    }
 
    // Set variables and fill the variables in prnt classes
    evaluate_and_set_prnt("lcode");
    evaluate_and_set_prnt("luser");
    evaluate_and_set_prnt("ltitle");
    evaluate_and_set_prnt("ldirec");
    evaluate_and_set_prnt("gcode");

    // Compile the list of lists
    var tendina = document.getElementById("get-list-tendina");
    if (tendina) {
	compile_list_option(tendina, user, "common");

	tendina.onchange = function () {
	    var val = tendina.options[tendina.selectedIndex].value.split("&");

	    if (lcode == "") {
		switch_class_hack("get-list-off", "get-list-temp");
		switch_class_hack("get-list-on", "get-list-off");
		switch_class_hack("get-list-temp", "get-list-on");
	    }

	    fill_list_fields(val[0], val[1]);
    
	};
    }

    // Get ownership permissions
    var getpermRequest = new XMLHttpRequest();
    var command = webdir +
	"/admin/list-queries.php" + 
	"?action=ownership" + 
	"&code=" + lcode +
	"&user=" + luser;
    getpermRequest.open("GET", command, true);

    getpermRequest.onreadystatechange = function () {
	if (getpermRequest.readyState==4) {
//	    alert(getpermRequest.responseText);
	    var lines = getpermRequest.responseText.split("\n");
	    if (lines[0] === "&true")
		switch_class_hack("list-owner", "clu_unhidden");
	    else
		switch_class_hack("list-owner", "clu_hidden");
	    if (luser === "guest") {
		switch_class_hack("list-guest", "clu_unhidden");
		switch_class_hack("list-noguest", "clu_hidden");
	    } else {
		switch_class_hack("list-guest", "clu_hidden");
		switch_class_hack("list-noguest", "clu_unhidden");
	    }
	}
    };
    getpermRequest.send(null);

    if(lcode && history.pushState) {
	history.pushState({code: lcode, user: luser}, "",
			  window.location.pathname +
			  "?code=" + lcode + "&user=" + luser);
    }

    execute_list_functions();
};
