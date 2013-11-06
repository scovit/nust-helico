function evaluate_and_set_prnt(variable) {
    if (document.getElementById(variable))
	window[variable] = document.getElementById(variable).innerHTML;
    else
	window[variable] = null; 

// Update text
    var elements = getElementsByClassName("prnt_" + variable);
    var i, il;
    for(i = 0, il = elements.length; i < il; i += 1) {
	while(elements[i].hasChildNodes())
	    elements[i].removeChild(elements[i].firstChild);
	elements[i].appendChild(document.createTextNode(
				    window[variable]));
    }

// Update hrefs
    elements = getElementsByClassName("template-href");
    for(i = 0, il = elements.length; i < il; i += 1) {
	if (!(elements[i].firstChild) ||
	    elements[i].firstChild.className != "href-template") {
	    var tempele = document.createElement("a");
	    tempele.className = "href-template";
	    
	    if(elements[i].nodeName == "A")
		tempele.href = elements[i].href;
	    if (elements[i].nodeName == "FORM")
		tempele.href = elements[i].action;
	    if (elements[i].nodeName == "IMG")
		tempele.href = elements[i].src;
	    if (elements[i].nodeName == "IFRAME")
		tempele.href = elements[i].src;

	    if(elements[i].firstChild)
		elements[i].insertBefore(
		    tempele, elements[i].firstChild);
	    else
		elements[i].appendChild(tempele);
	    
	}
	
	if(elements[i].nodeName == "A") {
	    var hrefmod = elements[i].href;
	    elements[i].href = hrefmod.replace(
		"@@prnt_" + variable + "@@", window[variable]);
	}

	if (elements[i].nodeName == "FORM") {
	    var hrefmod = elements[i].action;
	    elements[i].action = hrefmod.replace(
		"@@prnt_" + variable + "@@", window[variable]);	    
	}

	if (elements[i].nodeName == "IMG") {
	    var hrefmod = elements[i].src;
	    elements[i].src = hrefmod.replace(
		"@@prnt_" + variable + "@@", window[variable]);	    
	}

	if (elements[i].nodeName == "IFRAME") {
	    var hrefmod = elements[i].src;
	    elements[i].src = hrefmod.replace(
		"@@prnt_" + variable + "@@", window[variable]);	    
	}

    }
}
