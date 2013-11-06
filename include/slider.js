function mover (e) {
    this.style.cursor = 'pointer';
}

function mout (e) {
    this.style.cursor = 'normal';
}

function mclick (e) {
    var x = e.pageX - this.offsetLeft;
    var _this = this.slider;

    var position = Math.round (x/ (_this.width/_this.nstep));
    _this.sliderbullet.style.left = Math.round(position *
					       (_this.width/_this.nstep)) +
	"px";

    _this.value = Math.pow(2, position + Math.log(_this.rangemin)/_this.log2);
    _this.label.value = _this.value;
}

function mdragon (e) {
//    if(e.dataTransfer.getData('Text') != this.slider.id)
//	return;
    var x = e.pageX - this.offsetLeft;
    var _this = this.slider;

    var position = Math.round (x/ (_this.width/_this.nstep));
    _this.sliderbullet.style.left = Math.round(position *
					       (_this.width/_this.nstep)) +
	"px";

    _this.value = Math.pow(2, position + Math.log(_this.rangemin)/_this.log2);
    _this.label.value = _this.value;
}


function mdrag (e) {
  e.dataTransfer.setData('Text', this.slider.id);
  e.dataTransfer.setDragImage(this.slider.nothing, 0, 0);
}

function log2_slider (id, rangemin, rangemax) {
    if (navigator.appName == 'Microsoft Internet Explorer')
	return this;

    this.rangemin = rangemin;
    this.rangemax = rangemax;

    this.log2 = Math.log(2);
    this.nstep = Math.round(Math.log(rangemax)/this.log2 -
			    Math.log(rangemin)/this.log2);

    this.label = document.getElementById(id);
    if (this.label.slider)
	return this.label.slider;
    this.id = id;
    this.label.slider = this;
    this.value = this.label.value;
    var box = document.createElement("span");;
    this.sliderback = document.createElement("img");
    this.sliderbullet = document.createElement("img");
    box.appendChild(this.sliderbullet);
    box.appendChild(this.sliderback);
    this.sliderback.className = "sliderback";
    this.sliderbullet.className = "sliderbullet";
    this.sliderback.slider = this;
    this.sliderbullet.slider = this;


    var _this = this;
    _this.sliderback.onload = function() {
	_this.width = _this.sliderback.width;

	// Calculate the position of the bullet
	var position =  Math.round(Math.log(_this.value)/_this.log2);
	position -= 1;
	_this.sliderbullet.style.left = Math.round(position *
					     (_this.width/_this.nstep)) +
	    "px";
	_this.sliderbullet.style.zIndex++;

	// Make the bulled draggable
	_this.sliderback.draggable = "false";
	_this.sliderbullet.draggable = "true";

	_this.sliderback.addEventListener('mouseover', mover, false);
	_this.sliderback.addEventListener('mouseout', mout, false);
	_this.sliderback.addEventListener('click', mclick, false);
	_this.sliderbullet.addEventListener('dragstart', mdrag, false);
	_this.sliderback.addEventListener('dragover', mdragon, false);

	_this.label.parentNode.insertBefore(box, _this.label);
    };

    _this.sliderbullet.src = webdir + "/images/sliderbullet.gif";
    _this.sliderback.src = webdir + "/images/sliderback.gif";
    _this.nothing = new Image();
    _this.nothing.src = webdir + "/images/nothing.gif";

}