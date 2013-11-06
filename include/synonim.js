/* Developed by Vittore F. Scolari (2011) */

function clean_up_box_unk(b, barr) {
    var box = document.getElementById(barr["n"]);
    if(document.getElementById(b + "_gene_unk-" + barr["n"]))
	box.removeChild(document.getElementById(b + "_gene_unk-" + barr["n"]));
    if (getElementsByClassName("unk_gene-" + barr["n"])[0] === undefined)
	box.removeChild(document.getElementById("unk_title-" + barr["n"]));
    if((document.getElementById("dup_title-" + barr["n"]) == null) &&
       (document.getElementById("unk_title-" + barr["n"]) == null))
	while(box.hasChildNodes())
	    box.removeChild(box.firstChild);
}

function clean_up_box_dup(b, barr) {
    var box = document.getElementById(barr["n"]);
    if(document.getElementById(b + "_gene_dup-" + barr["n"]))
	box.removeChild(document.getElementById(b + "_gene_dup-" + barr["n"]));

    if (getElementsByClassName("dup_gene-" + barr["n"])[0] === undefined)
	box.removeChild(document.getElementById("dup_title-" + barr["n"]));
    if((document.getElementById("dup_title-" + barr["n"]) == null) &&
       (document.getElementById("unk_title-" + barr["n"]) == null))
	while(box.hasChildNodes())
	    box.removeChild(box.firstChild);
}

function clean_up_box_all(b, barr) {
    clean_up_box_unk(b, barr);
    clean_up_box_dup(b, barr);
}

function set_unk_label(span, gene, barr) {
    while(span.hasChildNodes())
	span.removeChild(span.firstChild);

    span.id = gene[0] + "_gene_unk-" + barr["n"];
    span.appendChild(document.createTextNode(gene[0] + " --> "));

    var newTag = document.createElement("input");
    newTag.type="text";
    newTag.id= gene[0] + "_syn-" + barr["n"];
    newTag.className = "syn_input";
    newTag.size = 7;
    newTag.value = (gene[1] ? gene[1] : "" );
    span.appendChild(newTag);

    newTag = document.createElement("input");
    newTag.type="button";
    newTag.onclick= function () {
	synclick("replace", gene[0], barr);
    };
    newTag.value="Replace";
    span.appendChild(newTag);

    span.appendChild(document.createTextNode(" or "));
    newTag = document.createElement("input");
    newTag.type="button";
    newTag.onclick= function () {
	synclick("delete", gene[0], barr);
    };
    newTag.value="Delete gene";
    span.appendChild(newTag);
}

function set_dup_label(span, gene, barr) {
    while(span.hasChildNodes())
	span.removeChild(span.firstChild);
    span.id = gene[0] + "_gene_dup-" + barr["n"];
    span.appendChild(document.createTextNode(gene[0] + " "));
    var newTag = document.createElement("input");
    newTag.type="button";
    newTag.onclick= function () {
	synclick("collapse", gene[0], barr);
    };
    newTag.value="Collapse gene";
    span.appendChild(newTag);
}

function replace(a, b, c, barr) {
    if (c === "")
	return;
    var request = new XMLHttpRequest();
    var commando =  webdir +
	"/analizzatore/synonim.php" +
	"?action=replace" +
	"&code=" + barr["code"] +
	"&user=" + barr["user"] +
	'&gene=' + b +
	'&syn=' + c;
    request.open("GET", commando, true);
    request.onreadystatechange = function () {
	if (request.readyState==4) {
//	    alert(request.responseText);
	    var lines = request.responseText.split("\n");
	    if((lines[0]) == '&error') {
		alert("could not replace gene " + b + " with gene " + c);
	    } else {
		var status = 0;
		for (i in lines) {
		    if (lines[i] === "&unfounds") {
			status = 1;
		    } else if (lines[i] === "&duplicates") {
			status = 2;
		    } else if (lines[i].split("&")[0] === c) {
			if (status == 1) {
// It's still unknown
			    var gene = lines[i].split("&");
			    if((b === c) || (!document.getElementById(
				   c + '_gene_unk-' + barr["n"]))) {
				var span =
				    document.getElementById(
					b + '_gene_unk-' + barr["n"]);
				set_unk_label(span, gene, barr);
			    }
			} else if (status == 2) {
			    var gene = lines[i].split("&");
			    var span =
				document.getElementById(
				    b + '_gene_dup-' + barr["n"]);
			    if (span != null)
// It's still a duplicate
				if(!document.getElementById(
				       c + '_gene_dup-' + barr["n"])) {
				    set_dup_label(span, gene, barr);
				    continue;
				}
// It's a new duplicate
			    if(!document.getElementById(
				   c + '_gene_dup-' + barr["n"])) {
				var box =
				    document.getElementById(barr["n"]);
				var newTag = document.createElement("span");
				newTag.className =
				    "dup_gene-" + barr["n"] + " broken_gene";
				set_dup_label(newTag, gene, barr);
				if(!document.getElementById("dup_title-" +
							    barr["n"])) {
				    append_dup_title(box, barr);
				}
				box.appendChild(newTag);
			    }
			}
		    }
		}
	    }
	    if (b != c)
		clean_up_box_all(b, barr);
	}
    };
    request.send(null);
}

function replace_synonims(barr) {
    var elements = getElementsByClassName("syn_input");
    var re = new RegExp(barr["n"] + "$");
    var i, il;
    for(i = 0, il = elements.length; i < il; i += 1) {
	if(re.exec(elements[i].id) && (elements[i].value != "")) {
	    var gene = elements[i].id.substr(0,
					     elements[i].id.indexOf(
					     "_syn-" + barr["n"], 0));
	    synclick("replace", gene, barr);
	}
    }
}

function synclick(a, b, barr) {

    var request = new XMLHttpRequest();

    switch (a) {
    case 'delete':
	request.open("GET", webdir +
		     "/analizzatore/synonim.php" +
		     "?action=delete" +
		     "&code=" + barr["code"] +
		     "&user=" + barr["user"] +
		     '&gene=' + b, true);
	request.onreadystatechange = function () {
	    if (request.readyState==4) {
//	    alert(request.responseText);
		var lines = request.responseText.split("\n");
		if((lines[0]) != '&end') {
		    alert("could not delete gene " + b);
		} else {
		    clean_up_box_all(b, barr);
		}

	    }
	};
	request.send(null);
	break;
    case 'collapse':
	request.open("GET", webdir +
		     "/analizzatore/synonim.php" +
		     "?action=collapse" +
		     "&code=" + barr["code"] +
		     "&user=" + barr["user"] +
		     '&gene=' + b, true);
	request.onreadystatechange = function () {
	    if (request.readyState==4) {
//	    alert(request.responseText);
		var lines = request.responseText.split("\n");
		if((lines[0]) != '&end') {
		    alert("could not collapse gene " + b);
		} else {
		    clean_up_box_dup(b, barr);
		}

	    }
	};
	request.send(null);
	break;
    case 'replace':
    	var c = document.getElementById(b + "_syn-" + barr["n"]).value;
	replace(a, b, c, barr);
	break;
    }
}

function append_dup_title(box, barr) {
    var newTag = document.createElement("h2");
    newTag.id = "dup_title-" + barr["n"];
    newTag.appendChild(document.createTextNode("The following genes are present multiple times in the data set"));
    box.appendChild(newTag);
}

function show_synonim_tool(lines, barr) {
    var box = document.getElementById(barr["n"]);

    var newTag = document.createElement("h1");
    newTag.appendChild(document.createTextNode("Synonym tool"));
    box.appendChild(newTag);

    newTag = document.createElement("p");
    newTag.appendChild(document.createTextNode(
			   "The gene names indicator reports genes that are not known in the genome database, or are present multiple times in the data set. It will disappear once all errors will be corrected. This tool allows to correct the errors interactively."));
    box.appendChild(newTag);

    var i;
    var status = 0;
    for (i = 0; i < lines.length; i++) {
	if (lines[i] == "&unfounds") {
	    status = 1;
	    newTag = document.createElement("h2");
	    newTag.id = "unk_title-" + barr["n"];
	    newTag.appendChild(document.createTextNode("The following genes are not part of the genome database, please insert a synonym"));
	    box.appendChild(newTag);
	    continue;
	}
	if (lines[i] == "&duplicates") {
	    if (status == 1) {
		box.appendChild(document.createElement("br"));
		newTag = document.createElement("input");
		newTag.type = "button";
		newTag.value="Replace all synonyms";
		newTag.onclick = function () {
		    replace_synonims(barr);
		};
		box.appendChild(newTag);
	    }
	    status = 2;
	    append_dup_title(box, barr);
	    continue;
	}
	if (lines[i] == "&end") {
	    if (status == 1) {
		box.appendChild(document.createElement("br"));
		newTag = document.createElement("input");
		newTag.type = "button";
		newTag.value="Replace all synonyms";
		newTag.onclick = function () {
		    replace_synonims(barr);
		};
		box.appendChild(newTag);
	    }
	    status = 3;
	    break;
	}

	var gene;
	switch (status) {
	case 1:
	    gene = lines[i].split("&");
	    if (document.getElementById(gene[0] + "_gene_unk-" + barr["n"]))
		break;
	    newTag = document.createElement("span");
	    newTag.className = "unk_gene-" + barr["n"] + " broken_gene";
	    set_unk_label(newTag, gene, barr);
	    box.appendChild(newTag);

	    break;
	case 2:
	    gene = lines[i].split(" ");
	    if (document.getElementById(gene[0] + "_gene_dup-" + barr["n"]))
		break;
	    newTag = document.createElement("span");
	    newTag.className = "dup_gene-" + barr["n"] + " broken_gene";
	    set_dup_label(newTag, gene, barr);
	    box.appendChild(newTag);
	    break;
	}

    }

    if(barr.onload)
	barr.onload();
//    box.style.display = "block";
}

function check_synonim(code, user, boxname) {
    this["n"] = boxname;
    this["code"] = code;
    this["user"] = user;

    var box = document.getElementById(this["n"]);
    while(box.hasChildNodes())
	box.removeChild(box.firstChild);

    this.doit = function () {
	var isokRequest = new XMLHttpRequest();
	var command = webdir +
	    "/analizzatore/synonim.php" +
	    "?action=isok" +
	    "&code=" + this["code"] +
	    "&user=" + this["user"];
	//    alert(command);
	isokRequest.open("GET", command, true);

	var _this = this;
	isokRequest.onreadystatechange = function () {
	    if (isokRequest.readyState==4) {
		//	    alert(isokRequest.responseText);
		var lines = isokRequest.responseText.split("\n");
		if((lines[0]) != '&end') {
		    show_synonim_tool(lines, _this);
		}
	    }
	};

	isokRequest.send(null);
    };
};
