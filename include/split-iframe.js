/* Developed by Vittore F. Scolari (2011) */

function get_splits(splitname) {
    var splits = getElementsByClassName("split");
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

//function autoResize(iframe){
//    
//    if (!iframe.contentDocument.exploreHeight) {
//	setTimeout(function () {autoResize(iframe);} , 20);
//	return;
//    }
//    iframe.style.height = iframe.contentDocument.exploreHeight;
//}


function set_split_handlers(splitname) {

    if (document.getElementById(splitname) == null)
	return;

    var liframe;
    if (document.getElementById("c-" + splitname) == null)
	return;
    else
	liframe = document.getElementById("c-" + splitname);

    var splits = get_splits(splitname);
    for (x in splits) {
	var nam = splits[x].id.split("-")[0];
	var anchor = document.getElementById("a-" + nam + "-" + splitname);
	anchor.target = "c-" + splitname;
	anchor.onclick = function (e) {
	    if (!e && window.event) 
		e = window.event;
	    var srcEl = e.srcElement ? e.srcElement : e.target;
	    var nam = srcEl.id.split("-")[1];
	    var splats = get_splits(splitname);
	    var rex = RegExp("^" + nam, "");
	    for (y in splats) {
		if (rex.test(splats[y].id)) {
		    splats[y].className = "split active-split";
		}
		else
		    splats[y].className = "split";
	    }
	};
	if(is_active_split(splits[x])) {
            if (document.createEvent) {
                var e = document.createEvent('MouseEvents');
                e.initEvent( 'click', true, true );
                anchor.dispatchEvent(e);
            } else if (document.createEventObject) {
                anchor.click();
            }
	}
    }
}
