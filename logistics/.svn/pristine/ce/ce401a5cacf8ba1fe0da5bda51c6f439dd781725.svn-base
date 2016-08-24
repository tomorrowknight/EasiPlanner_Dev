var canvas = document.querySelector("canvas");
var signaturePad = new SignaturePad(canvas);

function resizeCanvas() {
    var ratio =  Math.max(window.devicePixelRatio || 1, 1);
    canvas.width = canvas.offsetWidth * ratio;
    canvas.height = canvas.offsetHeight * ratio;
    canvas.getContext("2d").scale(ratio, ratio);
    signaturePad.clear(); // otherwise isEmpty() might return incorrect value
}

resizeCanvas();

function openSignature(){
	$("#signature").modal();
	setTimeout(function(){
		resizeCanvas();	
	},1000);
}