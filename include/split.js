/* Developed by Vittore F. Scolari (2011) */

function get_splits(splitname) {
    var splits = document.getElementsByClassName("split");
    var rex = RegExp(splitname + "$", "");
    var retur = [];
    for (x in splits)
	if(rex.test(splits[x].id)) {
	    retur.push(splits[x]);
	}
    
    return retur;
}

function get_splits_c(splitname) {
    var splits = document.getElementsByClassName("split-c");
    var rex = RegExp(splitname + "$", "");
    var retur = [];
    for (x in splits)
	if(rex.test(splits[x].id)) {
	    retur.push(splits[x]);
	}
    
    return retur;
}

function is_active_split(losplit) {
    if(/\bactive-split\b/.test(losplit.className))
	return true;
    else
	return false;
}

function set_split_handlers(splitname) {

    if (document.getElementById(splitname) == null)
	return;

    var splits = get_splits(splitname);
    for (x in splits) {
	var nam = splits[x].id.split("-")[0];
	if(is_active_split(splits[x])) {
	    document.getElementById("c-" + nam + "-" + splitname).className +=
	    " active-split-c";
	    window["set_split_content_" + nam](splitname);
	}
	var anchor = document.getElementById("a-" + nam + "-" + splitname);
	anchor.onclick = function (e) {
	    if(window.event) e = window.event;
	    var srcEl = e.srcElement ? e.srcElement : e.target;
	    var nam = srcEl.id.split("-")[1];
	    window["set_split_content_" + nam](splitname);
	    var splats = get_splits(splitname);
	    var rex = RegExp("^" + nam, "");
	    for (y in splats) {
		if (rex.test(splats[y].id)) {
		    splats[y].className = "split active-split";
		}
		else
		    splats[y].className = "split";
	    }
	    var splats_c = get_splits_c(splitname);
	    var rex_c = RegExp("^c-" + nam, "");
	    for (y in splats_c) {
		if (rex_c.test(splats_c[y].id)) {
		    splats_c[y].className = "split-c active-split-c";
		}
		else
		    splats_c[y].className = "split-c";
	    }
	};
    }
}
