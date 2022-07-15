function showFilename() {
	var name = document.getElementById('file-upload');
	document.getElementById("file-selected").innerHTML = name.files.item(0).name;
};

function snackbarPopup() {
	if (document.getElementById("snackbar")) {
		var x = document.getElementById("snackbar");
		x.className = "show";
		setTimeout(function(){ x.className = x.className.replace("show", ""); }, 2500);
	}
}
