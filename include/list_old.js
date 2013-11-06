/* Developed by Vittore F. Scolari (2011) */


// The real code

var lid;

var unknown;
var duplicates;

function clean_up_box_unk(b) {
    var box = document.getElementById("synonim_box");
    if(document.getElementById(b + "_gene_unk"))
	box.removeChild(document.getElementById(b + "_gene_unk"));
    if (getElementsByClassName("unk_gene")[0] === undefined)
	box.removeChild(document.getElementById("unk_title"));
    if((document.getElementById("dup_title") == null) &&
       (document.getElementById("unk_title") == null))
	document.getElementById("synonim").className = "hidden";
}

function clean_up_box_dup(b) {
    var box = document.getElementById("synonim_box");
    if(document.getElementById(b + "_gene_dup"))
	box.removeChild(document.getElementById(b + "_gene_dup"));

    if (getElementsByClassName("dup_gene")[0] === undefined)
	box.removeChild(document.getElementById("dup_title"));
    if((document.getElementById("dup_title") == null) &&
       (document.getElementById("unk_title") == null))
	document.getElementById("synonim").className = "hidden";
}

function clean_up_box_all(b) {
    clean_up_box_unk(b);
    clean_up_box_dup(b);
}

function set_unk_label(span, gene) {
    span.id = gene[0] + "_gene_unk";
    span.innerHTML = gene[0] + " --> " +
	'<input type="text" id="' + gene[0] +
	"_syn" +
	'" size="7" value="' +
	(gene[1] ? gene[1] : "" ) +
	'">' +
	'<button type="button" onclick=\''
	+ 'synclick("replace", "' + gene[0] +
	'")\'>Replace</button>' +
	" or " +
	'<button type="button" onclick=\''
	+ 'synclick("delete", "' + gene[0] +
	'")\'>Delete gene</button>';
}

function set_dup_label(span, gene) {
    span.id = gene[0] + "_gene_dup";
    span.innerHTML = gene[0] + " " +
	'<button type="button" onclick=\''
	+ 'synclick("collapse", "' + gene[0] +
	'")\'>Collapse gene</button>';
}

function replace(a, b, c) {
    var request = new XMLHttpRequest();

    request.open("GET",
		 "synonim.php?action=replace" +
		 "&id=" + lid +
		 '&gene=' + b +
		 '&syn=' + c, true);
    request.onreadystatechange = function () {
	if (request.readyState==4) {
//	    alert(request.responseText);
	    var lines = request.responseText.split("\n");
	    if((lines[0]) === '&error') {
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
			    if(!document.getElementById(c + '_gene_unk')) {
				var span =
				    document.getElementById(b + '_gene_unk');
				set_unk_label(span, gene);
			    }
			} else if (status == 2) {
			    var gene = lines[i].split("&");
			    var span =
				document.getElementById(b + '_gene_dup');
			    if (span != null)
// It's still a duplicate
				if(!document.getElementById(c + '_gene_dup')) {
				    set_dup_label(span, gene);
				    continue;
				}
// It's a new duplicate
			    if(!document.getElementById(c + '_gene_dup')) {
				var box =
				    document.getElementById("synonim_box");
				var newTag = document.createElement("span");
				newTag.className = "dup_gene broken_gene";
				set_dup_label(newTag, gene);
				box.appendChild(newTag);
			    }
			}
		    }
		}
	    }
	    clean_up_box_all(b);
	}
    };
    request.send(null);
}


function synclick(a, b) {

    var request = new XMLHttpRequest();

    switch (a) {
    case 'delete':
	request.open("GET",
		     "synonim.php?action=delete" +
		     "&id=" + lid +
		     '&gene=' + b, true);
	request.onreadystatechange = function () {
	    if (request.readyState==4) {
//	    alert(request.responseText);
		var lines = request.responseText.split("\n");
		if((lines[0]) != '&end') {
		    alert("could not delete gene " + b);
		} else {
		    clean_up_box_all(b);
		}

	    }
	};
	request.send(null);
	break;
    case 'collapse':
	request.open("GET",
		     "synonim.php?action=collapse" +
		     "&id=" + lid +
		     '&gene=' + b, true);
	request.onreadystatechange = function () {
	    if (request.readyState==4) {
//	    alert(request.responseText);
		var lines = request.responseText.split("\n");
		if((lines[0]) != '&end') {
		    alert("could not collapse gene " + b);
		} else {
		    clean_up_box_dup(b);
		}

	    }
	};
	request.send(null);
	break;
    case 'replace':
    	var c = document.getElementById(b + "_syn").value;
	replace(a, b, c);
	break;
    }
}

function show_synonim_tool(lines) {
    var box = document.getElementById("synonim_box");

    var newTag = document.createElement("h1");
    newTag.innerHTML = "Synonym tool";
    box.appendChild(newTag);

    newTag = document.createElement("p");
    newTag.innerHTML = "The gene names indicator reports the genes that are not"
	+ " known in the genome database, or which are present multiple times"
	+ " in the data set."
	+ " It will disappear once all errors will be corrected."
	+ " This tool lets you correct the errors, otherwise you can "
	+ "<a href=\"list_old.php?action=delete&id="
	+ lid + "\">delete this data set</a>"
	+ " and add a manually corrected data set to the database.";
    box.appendChild(newTag);

    var i;
    var status = 0;
    for (i = 0; i < lines.length; i++) {
	if (lines[i] == "&unfounds") {
	    status = 1;
	    newTag = document.createElement("h2");
	    newTag.id = "unk_title";
	    newTag.innerHTML = "The following genes are not part of the"
		+ " genome table, please insert a synonym";
	    box.appendChild(newTag);
	    continue;
	}
	if (lines[i] == "&duplicates") {
	    status = 2;
	    newTag = document.createElement("h2");
	    newTag.id = "dup_title";
	    newTag.innerHTML = "The following genes appear multiple"
		+ " times in the data set";
	    box.appendChild(newTag);
	    continue;
	}
	if (lines[i] == "&end") {
	    break;
	}

	var gene;
	switch (status) {
	case 1:
	    gene = lines[i].split("&");
	    if (document.getElementById(gene[0] + "_gene_unk"))
		break;
	    newTag = document.createElement("span");
	    newTag.className = "unk_gene broken_gene";
	    set_unk_label(newTag, gene);
	    box.appendChild(newTag);

	    break;
	case 2:
	    gene = lines[i].split(" ");
	    if (document.getElementById(gene[0] + "_gene_dup"))
		break;
	    newTag = document.createElement("span");
	    newTag.className = "dup_gene broken_gene ";
	    set_dup_label(newTag, gene);
	    box.appendChild(newTag);
	    break;
	}

    }

    document.getElementById("synonim").className = "unhidden";
}

main_functions.push("list_main");
function list_main() {
    lid = document.getElementById("lid").innerHTML;

    var isokRequest = new XMLHttpRequest();
    isokRequest.open("GET", "synonim.php?action=isok&id=" + lid, true);

    isokRequest.onreadystatechange = function () {
	if (isokRequest.readyState==4) {
//	    alert(isokRequest.responseText);
	    var lines = isokRequest.responseText.split("\n");
	    if((lines[0]) != '&end') {
		show_synonim_tool(lines);
	    }
	}
    };

    isokRequest.send(null);

};
