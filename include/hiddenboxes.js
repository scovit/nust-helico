
function unhide(divID) {
    var item = document.getElementById(divID);
    if (item) {
	item.className=(item.className=='hidden')?'unhidden':'hidden';
    }
}

function update_sliding_window(sliID, id) {
    var immagine = document.getElementById(sliID);
    var caption = document.getElementById(sliID + '_caption');
    var bins = document.getElementById(sliID + '_bins').value;

    if ( bins & (bins - 1) != 0) {
	alert('The number of bins should be a power of 2');
	return;
    }


    caption.innerHTML="Loading results...";
    caption.className="loading_message";
    immagine.src = "../images/waiting-logo.gif";
    immagine.className = "naturalsize center";

    var imageSrc = 'cluster.php?action=getsliding&format=png&id=' +
	id + '&bins=' + bins ;
    var slidingImage = new Image();
    slidingImage.src = imageSrc;
    slidingImage.onload = function() {
	immagine.src = slidingImage.src;
	immagine.className = "graceplot center";
	caption.innerHTML = "<a href='cluster.php?action=getsliding"
	    + "&format=agr&id=" + id
	    + '&bins=' + bins + "'>Save as grace (.agr) file</a>";
	caption.className="caption";
    };

}

function show_sliding_window(sliID, id) {
    unhide(sliID + '_div');
    update_sliding_window(sliID, id);
}

function update_circular_rep(sliID, id) {
    return;
    var immagine = document.getElementById(sliID);
    var caption = document.getElementById(sliID + '_caption');
    var bins = document.getElementById(sliID + '_bins').value;

    if ( bins & (bins - 1) != 0) {
	alert('The number of bins should be a power of 2');
	return;
    }


    caption.innerHTML="Loading results...";
    caption.className="loading_message";
    immagine.src = "../images/waiting-logo.gif";
    immagine.className = "naturalsize center";

    var imageSrc = 'cluster.php?action=getsliding&format=png&id=' +
	id + '&bins=' + bins ;
    var slidingImage = new Image();
    slidingImage.src = imageSrc;
    slidingImage.onload = function() {
	immagine.src = slidingImage.src;
	immagine.className = "graceplot center";
	caption.innerHTML = "<a href='cluster.php?action=getsliding"
	    + "&format=agr&id=" + id
	    + '&bins=' + bins + "'>Save as grace (.agr) file</a>";
	caption.className="caption";
    };

}

function show_circular_rep(sliID, id) {
    unhide(sliID + '_div');
    update_circular_rep(sliID, id);
}