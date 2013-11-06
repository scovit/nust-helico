/* Developed by Vittore F. Scolari (2011) */

explore_functions.push("add_main");
function add_main() {
    var frame1 = document.getElementById("file-pers-slid");
    var frame2 = document.getElementById("inter-pers-slid");

    var loaded = 0;
    frame1.onload = frame2.onload = function () {
	loaded++;
	if (loaded == 2)
	    document.triggerIResize();
    };
}
