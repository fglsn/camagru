<?php
	include(__DIR__ . "/header.php");
?>

<!-- https://stackoverflow.com/questions/572768/styling-an-input-type-file-button -->
<!-- https://stackoverflow.com/questions/2189615/how-to-get-file-name-when-user-select-a-file-via-input-type-file -->
<!-- https://stackoverflow.com/questions/11642926/stop-close-webcam-stream-which-is-opened-by-navigator-mediadevices-getusermedia -->


<main class="container-fluid">
	<?php if ($info !== '') {
			echo '<span class="info-log" id="snackbar" style="display:block">' . $info . '</span>'; }?>
	<div class="form-wrapper">
		<div class="upload-form-container">
			<div class="stickers-wrapper container">
				<h4 class="form-header-light">Choose a sticker</h4>
				<div class="sticker-container">
					<img class="sticker img-thumbnail" id="stick1" onclick="selectSticker('stick1')" src="./static/stickers/1.png" alt="">
					<img class="sticker img-thumbnail" id="stick2" onclick="selectSticker('stick2')" src="./static/stickers/2.png" alt="">
					<img class="sticker img-thumbnail" id="stick3" onclick="selectSticker('stick3')" src="./static/stickers/3.png" alt="">
					<img class="sticker img-thumbnail" id="stick4" onclick="selectSticker('stick4')" src="./static/stickers/4.png" alt="">
					<img class="sticker img-thumbnail" id="stick5" onclick="selectSticker('stick5')" src="./static/stickers/5.png" alt="">
					<img class="sticker img-thumbnail" id="stick6" onclick="selectSticker('stick6')" src="./static/stickers/6.png" alt="">
					<img class="sticker img-thumbnail" id="stick7" onclick="selectSticker('stick7')" src="./static/stickers/7.png" alt="">
					<img class="sticker img-thumbnail" id="stick8" onclick="selectSticker('stick8')" src="./static/stickers/8.png" alt="">
				</div>
			</div>

			<button class="btn btn-primary" id="toggle" style="margin: 1rem;">Open Webcam</button>
			<div id="snap-btn" style="display:none;">
				<button class="btn btn-primary webcam-btn" id="snap" disabled>Take a pic</button>
				<button class="btn btn-danger webcam-btn"  id="hide-webcam" style="margin-bottom: 1rem;">Close</button>
			</div>
			<form class="container" id="camera" name="camera" action="snapshot.php" method="post" style="display:none; max-width: 80%">
				<div class="webcam-container container">
					<canvas id="canvas" class="container">
						<video autoplay="true" class="container" id="webcam"></video>
					</canvas>
					<input type="checkbox" class="webcam-checkbox" hidden id="stick1-webcam" name="stick1"></input>
					<input type="checkbox" class="webcam-checkbox" hidden id="stick2-webcam" name="stick2"></input>
					<input type="checkbox" class="webcam-checkbox" hidden id="stick3-webcam" name="stick3"></input>
					<input type="checkbox" class="webcam-checkbox" hidden id="stick4-webcam" name="stick4"></input>
					<input type="checkbox" class="webcam-checkbox" hidden id="stick5-webcam" name="stick5"></input>
					<input type="checkbox" class="webcam-checkbox" hidden id="stick6-webcam" name="stick6"></input>
					<input type="checkbox" class="webcam-checkbox" hidden id="stick7-webcam" name="stick7"></input>
					<input type="checkbox" class="webcam-checkbox" hidden id="stick8-webcam" name="stick8"></input>
					<input type="text" id="picture-url" name="pic-url" hidden readonly></input>
				</div>
				<div id="save-redo" style="display:none;">
					<button class="btn btn-success webcam-btn" type="submit" name="submit" value="submit" id="save-shot">Save</button>
					<button class="btn btn-danger webcam-btn" type="button" onclick="redoCallback()" id="redo-shot">Redo</button>
				</div>
			</form>

			<div id="upload-pic" style="min-width: 80%">
				<div class="separator"><div class="line"></div><div class="or">OR</div><div class="line"></div></div>
				<h4 class="form-header-light">Upload a picture</h4>
				<form enctype="multipart/form-data" action="upload.php" method="post" class="container">
					<div class="upload-form">
						<label for="file-upload" class="custom-file-upload">File: <span id="file-selected"></span></label>
						<input type="file" accept="image/png, image/jpeg" id="file-upload" name="file" onchange="showFilename()"/>
						<input type="text" class="custom-file-upload" name="description" value="" placeholder="Description: " autocomplete="off"/>
						<span class="error" style="padding-left: 10px;"><?php echo $error;?></span>
						<input type="checkbox" class="webcam-checkbox" hidden id="stick1-upload" name="stick1"></input>
						<input type="checkbox" class="webcam-checkbox" hidden id="stick2-upload" name="stick2"></input>
						<input type="checkbox" class="webcam-checkbox" hidden id="stick3-upload" name="stick3"></input>
						<input type="checkbox" class="webcam-checkbox" hidden id="stick4-upload" name="stick4"></input>
						<input type="checkbox" class="webcam-checkbox" hidden id="stick5-upload" name="stick5"></input>
						<input type="checkbox" class="webcam-checkbox" hidden id="stick6-upload" name="stick6"></input>
						<input type="checkbox" class="webcam-checkbox" hidden id="stick7-upload" name="stick7"></input>
						<input type="checkbox" class="webcam-checkbox" hidden id="stick8-upload" name="stick8"></input>
						<button class="btn btn-primary" id="upload-btn" type="submit" name="upload">Upload</button>
					</div>
				</form>
			</div>

		</div>
	</div>
</main>

<script type="text/javascript">

	function selectSticker(stickerId) {
		let stickerInputUpload = document.getElementById(stickerId + "-upload");
		let stickerInput = document.getElementById(stickerId + "-webcam");

		if (checkboxControl() || (!checkboxControl() && stickerInput.checked === true)) {
			changeOpacity(stickerId);
			stickerInput.checked = !stickerInput.checked;
			// console.log("1: " + stickerInput.checked);
		} if (checkboxControl() || (!checkboxControl() && stickerInputUpload.checked === true)) {
			stickerInputUpload.checked = !stickerInputUpload.checked;
			// console.log("2: " + stickerInput.checked);
		}
		else if (!checkboxControl()) {
			alert("Max 4 stickers");
		}
		enableSnapButton();
	}

	function countCheckboxes () {
		let inputElems = document.getElementsByClassName("webcam-checkbox"),
		count = 0;
		for (var i = 0; i < inputElems.length; i++) {
			if (inputElems[i].type === "checkbox" && inputElems[i].checked === true)
				count++;
		}
		return (count);
	}

	function checkboxControl() {
		count = countCheckboxes();
		return (count < 8);
	}

	function changeOpacity(stickId) {
		let stick = document.getElementById(stickId);
		stick.classList.toggle('selected');
	}

	function enableSnapButton() {
		let snapButton = document.getElementById("snap");
		if (countCheckboxes() > 0)
			snapButton.disabled = false;
		else 
			snapButton.disabled = true;
	}

</script>

<script type="text/javascript">

	const uploadDiv = document.getElementById("upload-pic");
	const webcamPreview = document.getElementById("camera");
	const snapButtons = document.getElementById("snap-btn");
	const video = document.getElementById("webcam");
	const open = document.getElementById("toggle");
	const hide = document.getElementById("hide-webcam");
	const saveRedoButtons = document.getElementById("save-redo");
	const save = document.getElementById("save-shot");
	const redo = document.getElementById("redo-shot");
	const pictureUrl = document.getElementById("picture-url");

	// Open webcamera preview and its buttons
	open.onclick = function () {
		if (webcamPreview.style.display !== "none" && snapButtons.style.display !== "none" ) {
			webcamPreview.style.display = "none";
			snapButtons.style.display = "none";
		} else {
			load_webcam();
			open.style.display = "none";
			webcamPreview.style.display = "flex";
			snapButtons.style.display = "block";
			uploadDiv.style.display = "none";
		}
	};

	// Stop streaming from webcamera, hide preview and buttons
	hide.onclick = function () {
		stream = video.srcObject;
		tracks = stream.getTracks();
		tracks.forEach(function(track) {
			track.stop();
		});
		video.srcObject = null;
		open.style.display = "block";
		uploadDiv.style.display = "block";
		webcamPreview.style.display = "none";
		snapButtons.style.display = "none";
		saveRedoButtons.style.display = "none";
	};


	function load_webcam(e) {

		var canvas = document.getElementById('canvas');
		var ctx = canvas.getContext('2d');

		// set canvas size = video size when known
		video.addEventListener('loadedmetadata', function() {
			canvas.width = video.videoWidth;
			canvas.height = video.videoHeight;
		});

		if (navigator.mediaDevices.getUserMedia) {
			navigator.mediaDevices
				.getUserMedia({ video: true })
				.then(function (stream) {
					video.srcObject = stream;
				})
				.catch(function (error) {
					console.log("Something went wrong!");
				});
		}

		video.addEventListener('play', function() {
			var $this = this;
			(function loop() {
				if (!$this.closed) {
					ctx.drawImage($this, 0, 0);
					setTimeout(loop, 1000 / 80); //fps
				}
			} ) ();
		}, 0);
	}

	// Take snapshot
	let click_button = document.querySelector("#snap");

	click_button.addEventListener('click', function() {
			var video = document.getElementById('webcam');
			var ctx = canvas.getContext('2d');
			ctx.scale(-1, 1);
			ctx.drawImage(video, 0, 0);
			let image_data_url = canvas.toDataURL('image/jpeg');
			saveRedoButtons.style.display = "block";
			pictureUrl.value = image_data_url;
		});
	
	// Redo picture
	function redoCallback(e) {
		load_webcam(e);
	}

</script>

<script type="text/javascript">
	function showFilename() {
		var name = document.getElementById('file-upload');
		document.getElementById("file-selected").innerHTML = name.files.item(0).name;
	};
</script>

<script type="text/javascript">
	function myFunction() {
		if (document.getElementById("snackbar")) {
			var x = document.getElementById("snackbar");
			x.className = "show";
			setTimeout(function(){ x.className = x.className.replace("show", ""); }, 2500);
		}
	}
	myFunction();
</script>

<?php
	include(__DIR__ . "/footer.php");
?>