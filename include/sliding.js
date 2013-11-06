function unhide(divID) {
    var item = document.getElementById(divID);
    if (item) {
	item.className=(item.className=='sliding-hidden')?'sliding-unhidden':'sliding-hidden';
    }
}

function update_sliding_window(sliID) {

}

function show_sliding_window(sliID) {
    unhide(sliID);
    update_sliding_window(sliID);
}
