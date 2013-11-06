function unhide(divID) {
    var item = document.getElementById(divID);
    if (item) {
	var cla = item.className;
	cla = cla.replace("sliding-hidden", "sliding-temp");
	cla = cla.replace("sliding-unhidden", "sliding-hidden");
	cla = cla.replace("sliding-temp", "sliding-unhidden");
	item.className = cla;
    }
    
    item.contentDocument.triggerIResize();
}

function update_sliding_window(sliID) {

}

function show_sliding_window(sliID) {
    document.ontriggeredframeresize = function () { 
	document.triggerIResize();
    };
    unhide(sliID);
    update_sliding_window(sliID);
    document.triggerIResize();
}
