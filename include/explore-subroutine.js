

function compile_inter_select(ilform, userlists, commonlists) {
    var directory="";

// delete everything
    while(ilform.hasChildNodes())
	ilform.removeChild(ilform.firstChild);
    var captione = document.createElement("option");
    captione.className="interdis";
    captione.disabled="disabled";
    captione.selected="selected";
    captione.value=("def");
    captione.appendChild(document.createTextNode("\xa0\xa0\xa0\xa0" +
    			     "Select a data set"));
    ilform.appendChild(captione);

// add personal data sets
    var optg= document.createElement("optgroup");
    optg.label = "Personal data sets";
    if (userlists[0] === "&end") {
	var optione = document.createElement("option");
	optione.disabled="disabled";
	optione.className="interdis";
	optione.appendChild(document.createTextNode(
    				"No personal data sets found"));
	optg.appendChild(optione);
    }
    for (x in userlists) {
	if (userlists[x] === "&end")
	    break;
	var line = userlists[x].split("&");
	if (line[4] != directory) {
	    directory = line[4];
	    var direc = document.createElement("option");
	    direc.className = "interdir";
	    direc.disabled="disabled";
	    direc.appendChild(document.createTextNode(directory));
	    optg.appendChild(direc);
	}
	var optione = document.createElement("option");
	optione.className = "interopt";
	optione.value = line[0] + "&" + line[1];
	if(user == "guest")
	    optione.appendChild(document.createTextNode("\xa0\xa0\xa0\xa0" +
							line[1] +  " - " +
							line[2]
						       ));
	//			          +  " - " + line[3]));
	else
	    optione.appendChild(document.createTextNode("\xa0\xa0\xa0\xa0" +
							line[2]
						       ));
	//			          +  " - " + line[3]));
	optg.appendChild(optione);
    }
    ilform.appendChild(optg);

    directory = "";
    optg= document.createElement("optgroup");
    optg.label = "Common data sets";

    if (commonlists[0] === "&end") {
	var optione = document.createElement("option");
	optione.disabled="disabled";
	optione.appendChild(document.createTextNode(
    			       "No common data sets found"));
	optg.appendChild(optione);
    }
    for (x in commonlists) {
	if (commonlists[x] === "&end")
	    break;
	var line = commonlists[x].split("&");
        if (line[4] != directory) {
            directory = line[4];
            var direc = document.createElement("option");
            direc.className = "interdir";
            direc.disabled="disabled";
            direc.appendChild(document.createTextNode(directory));
            optg.appendChild(direc);
        }
	var optione = document.createElement("option");
	optione.className = "interopt";
	optione.value = line[0] + "&" + line[1];
        optione.appendChild(document.createTextNode("\xa0\xa0\xa0\xa0" +
				line[2]
				        ));
//                    + " - " + line [3]));
	optg.appendChild(optione);
    }
    ilform.appendChild(optg);

}