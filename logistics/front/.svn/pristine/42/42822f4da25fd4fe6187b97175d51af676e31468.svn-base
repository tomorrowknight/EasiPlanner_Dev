//Author: Evan Lee, Email: chief725@gmail.com
console.log("############ Coded by Evan Lee, Email: chief725@gmail.com ############");
function Site() {
	this.webUrl = document.body.getAttribute("data-root");
	this.urlTo = function(relativeUrl) {
		return this.webUrl + relativeUrl;
	};
}

var site = new Site();

// Storage
Storage.prototype.setObj = function(key, obj) {
	return this.setItem(key, JSON.stringify(obj));
};
Storage.prototype.getObj = function(key) {
	return JSON.parse(this.getItem(key)) || {};
};

function getParameterByName(name) {
	name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
	var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"), results = regex.exec(location.search);
	return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

function isValidLatLng($lat, $lng) {
	return !($lat < 1.2 || $lat > 1.6 || $lng < 100 || $lng > 110);
}

function empty($var) {
	return $var == undefined || $var == null || $var == "" || $var == 0;
}

function hexColor(index) {
	return tinycolor("hsv(" + (index * 37)%360 + ", 100%, 100%)").toHexString();
}

function hexInvertColor(index) {
	color = 256*256*256 - parseInt(hexColor(index).slice(-6),16);
	return "#"+("000000"+color.toString(16)).slice(-6);
}

function parseDate(str){
	return Date.parse(str.replace(" ","T")) ;
}

function createDate(str){
	return new Date(parseDate(str));
}
