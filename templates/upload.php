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
					<img class="sticker img-thumbnail" id="stick1" onclick="changeOpacity('stick1')" src="./static/stickers/1.png" alt="">
					<img class="sticker img-thumbnail" id="stick2" onclick="changeOpacity('stick2')" src="./static/stickers/2.png" alt="">
					<img class="sticker img-thumbnail" id="stick3" onclick="changeOpacity('stick3')" src="./static/stickers/3.png" alt="">
					<img class="sticker img-thumbnail" id="stick4" onclick="changeOpacity('stick4')" src="./static/stickers/4.png" alt="">
					<img class="sticker img-thumbnail" id="stick5" onclick="changeOpacity('stick5')" src="./static/stickers/5.png" alt="">
					<img class="sticker img-thumbnail" id="stick6" onclick="changeOpacity('stick6')" src="./static/stickers/6.png" alt="">
					<img class="sticker img-thumbnail" id="stick7" onclick="changeOpacity('stick7')" src="./static/stickers/7.png" alt="">
					<img class="sticker img-thumbnail" id="stick8" onclick="changeOpacity('stick8')" src="./static/stickers/8.png" alt="">
				</div>
			</div>

			<div id="upload-pic" style="min-width: 80%">
				<h4 class="form-header-light">Upload a picture</h4>
				<form enctype="multipart/form-data" action="upload.php" method="post" class="container">
					<div class="upload-form">
						<label for="file-upload" class="custom-file-upload">File: <span id="file-selected"></span></label>
						<input type="file" accept="image/png, image/jpeg" id="file-upload" name="file" onchange="showFilename()"/>
						<input type="text" class="custom-file-upload" name="description" value="" placeholder="Description: " autocomplete="off"/>
						<span class="error" style="padding-left: 10px;"><?php echo $error;?></span>
						<button class="btn btn-primary" id="upload-btn" type="submit" name="upload">Upload</button>
					</div>
				</form>
				<div class="separator"><div class="line"></div><div class="or">OR</div><div class="line"></div></div>
			</div>

			<button class="btn btn-primary" id="toggle" style="margin-bottom: 1rem;">Open Webcam</button>
			<div id="snap-btn" style="display:none;">
				<button class="btn btn-primary webcam-btn" id="snap">Take a pic</button>
				<button class="btn btn-danger webcam-btn"  id="hide-webcam" style="margin-bottom: 1rem;">Close</button>
			</div>
			<form class="container" style="display:none;" id="camera" style="max-width: 80%">
				<div class="webcam-container container">
					<canvas id="canvas" class="container">
						<video autoplay="true" class="container" id="webcam"></video>
					</canvas>
				</div>
			</form>
			<div id="save-redo" style="display:none;">
					<button class="btn btn-success webcam-btn" id="save-shot">Save</button>
					<button class="btn btn-danger webcam-btn" id="redo-shot">Redo</button>
			</div>
		</div>
	</div>
</main>

<script type="text/javascript">

	function changeOpacity(stickId) {
		let stick = document.getElementById(stickId);
		if (stick.style.opacity == .5) 
			stick.style.opacity = 1;
		else
			stick.style.opacity = .5;
	}

	let s1 = document.getElementById("stick1");
	let s2 = document.getElementById("stick2");
	let s3 = document.getElementById("stick3");
	let s4 = document.getElementById("stick4");
	let s5 = document.getElementById("stick5");
	let s6 = document.getElementById("stick6");
	let s7 = document.getElementById("stick7");
	let s8 = document.getElementById("stick8");

	const paths = new Array(
					"./static/stickers/1.png",
					"./static/stickers/2.png",
					"./static/stickers/3.png",
					"./static/stickers/4.png",
					"./static/stickers/5.png",
					"./static/stickers/6.png",
					"./static/stickers/7.png",
					"./static/stickers/8.png",
				);

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

	// Stop streaming from wabcamera, hide preview and buttons
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
					setTimeout(loop, 1000 / 80); // drawing at 30fps
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
			// data url of the image
			console.log(image_data_url);
		});

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