
function notpowtwo (numb) {
    return (numb & (numb - 1));
}

function update_circular() {
    var bins1 = document.getElementById("circular_bins1").value;
    var bins2 = document.getElementById("circular_bins2").value;

    if ( notpowtwo(bins1) || notpowtwo(bins2) ) {
	alert('The number of bins should be a power of 2');
	return;
    }

    if ( (bins2 - bins1) < 0 ) {
	alert('The second bin-number should be greater-equal than the first');
	return;
    }

    var immagine = document.getElementById("circular");
    var sommario = document.getElementById("summary");
    var circsvg = document.getElementById("circsvg");
    var circpdf = document.getElementById("circpdf");
    var circtxt = document.getElementById("circtxt");
    var circbaw = document.getElementById("circbaw");


    immagine.src = webdir + "/admin/cluster-queries.php?action=getcircular" +
	"&code=" + lcode + "&user=" + luser +
	"&format=png&bins1=" + bins1 + "&bins2=" + bins2;

    sommario.src = webdir + "/admin/cluster-queries.php?action=getcircular" +
	"&code=" + lcode + "&user=" + luser +
	"&format=html&bins1=" + bins1 + "&bins2=" + bins2;

    circsvg.href = webdir + "/admin/cluster-queries.php?action=getcircular" +
	"&code=" + lcode + "&user=" + luser +
	"&format=svg&bins1=" + bins1 + "&bins2=" + bins2;
    circpdf.href = webdir + "/admin/cluster-queries.php?action=getcircular" +
	"&code=" + lcode + "&user=" + luser +
	"&format=pdf&bins1=" + bins1 + "&bins2=" + bins2;
    circtxt.href = webdir + "/admin/cluster-queries.php?action=getcircular" +
	"&code=" + lcode + "&user=" + luser +
	"&format=txt&bins1=" + bins1 + "&bins2=" + bins2;
    circbaw.href = webdir + "/admin/cluster-queries.php?action=getcircular" +
	"&code=" + lcode + "&user=" + luser +
	"&format=svgbaw&bins1=" + bins1 + "&bins2=" + bins2;

}

list_functions.push("cluster_main");
function cluster_main() {

  var here = document.getElementById("here");
  here.href = window.location.href;
//  if (navigator.appName != 'Microsoft Internet Explorer')
  while(here.hasChildNodes())
    here.removeChild(here.firstChild);
  here.appendChild(document.createTextNode(
    window.location.href));

    if (lcode == "")
	return;

    // Look if the graph is available
    var isokRequest = new XMLHttpRequest();
    var command = webdir +
	"/admin/cluster-queries.php" +
	"?action=available" +
	"&code=" + lcode +
	"&user=" + luser;
    isokRequest.open("GET", command, true);

    isokRequest.onreadystatechange = function () {
	if (isokRequest.readyState==4) {
	    var lines = isokRequest.responseText.split("\n");
	    if (lines[0] == "&available") {
		var box = document.getElementById("allright");
		box.className = "unhidden";
		box = document.getElementById("errore");
		box.className = "hidden";
		var slider1 = new log2_slider("circular_bins1", 2, 1024);
		var slider2 = new log2_slider("circular_bins2", 2, 1024);
		var cluimg = document.getElementById("cluplot");
		var cluhref1 = document.getElementById("cluplotget");
		var cluhref2 = document.getElementById("cluplotpdf");
		cluimg.src = webdir + "/admin" +
		    "/cluster-queries.php?action=getresults&"
		    + "format=png&"
		    + "code=" + lcode + "&user=" + luser;
		cluhref1.href = webdir + "/admin" +
		    "/cluster-queries.php?action=getresults&"
		    + "format=agr&"
		    + "code=" + lcode + "&user=" + luser;
		cluhref2.href = webdir + "/admin" +
		    "/cluster-queries.php?action=getresults&"
		    + "format=pdf&"
		    + "code=" + lcode + "&user=" + luser;

		update_circular();

	    } else {
		var box = document.getElementById("allright");
		box.className = "hidden";
		box = document.getElementById("errore");
		box.className = "unhidden";
		while(box.hasChildNodes())
		    box.removeChild(box.firstChild);

		if (lines[0].split("&")[1] == "procerror") {
		    var message = "Internal error " +
			lines[0].split("&")[2] + ", please contact the " +
			"administrator for help";
		    box.appendChild(document.createTextNode(message));

		} else if (lines[0] == "&synon") {
		    var message = "Please verify the data for synonyms";
		    box.appendChild(document.createTextNode(message));
		    box.appendChild(document.createElement("br"));
		    var gotothere = document.createElement("a");
		    gotothere.href = webdir +
			"/analizzatore/list.php?" +
			"code=" + lcode + "&user=" + luser;
		    gotothere.appendChild(document.createTextNode(
					      "Check now"));
		    box.appendChild(gotothere);
		} else if (lines[0] == "&waiting") {
		    var message = "It is the first time that a user runs "
		+ "the cluster analysis on this data set. "
		+ "The processing of the data can take a while, "
	        + "because it involves computer randomizations. "
		+ "the browser will check every 30 seconds until "
		+ "the results will be available. Alternatively you "
                + "can visit the results page later with the  link below. ";
		    box.appendChild(document.createTextNode(message));
//		    var here = document.createElement("a");
//		    here.href = window.location.href;
//		    here.appendChild(document.createTextNode(
//				       window.location.href));
//		    box.appendChild(here);
//                  box.appendChild(document.createTextNode("."));
		    var t = setTimeout(
			"cluster_main()", 30000);
		}
	    }
	}
    };
    isokRequest.send(null);

};
