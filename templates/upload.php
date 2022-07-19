<?php
	include(__DIR__ . "/header.php");
?>

<!-- https://stackoverflow.com/questions/572768/styling-an-input-type-file-button -->
<!-- https://stackoverflow.com/questions/2189615/how-to-get-file-name-when-user-select-a-file-via-input-type-file -->
<!-- https://stackoverflow.com/questions/11642926/stop-close-webcam-stream-which-is-opened-by-navigator-mediadevices-getusermedia -->


<main class="container-fluid upload-main">
	<?php if ($info !== '') {
			echo '<span class="info-log" id="snackbar" style="display:block">' . $info . '</span>'; }?>
	<div class="form-wrapper">
		<div class="upload-form-container">
			<div class="stickers-wrapper container">
				<h4 class="form-header-light">Choose a sticker</h4>
				<div class="sticker-container">
					<img class="sticker img-thumbnail" id="stick1" onclick="selectSticker(1)" src="./static/stickers/1.png" alt="">
					<img class="sticker img-thumbnail" id="stick2" onclick="selectSticker(2)" src="./static/stickers/2.png" alt="">
					<img class="sticker img-thumbnail" id="stick3" onclick="selectSticker(3)" src="./static/stickers/3.png" alt="">
					<img class="sticker img-thumbnail" id="stick4" onclick="selectSticker(4)" src="./static/stickers/4.png" alt="">
					<img class="sticker img-thumbnail" id="stick5" onclick="selectSticker(5)" src="./static/stickers/5.png" alt="">
					<img class="sticker img-thumbnail" id="stick6" onclick="selectSticker(6)" src="./static/stickers/6.png" alt="">
					<img class="sticker img-thumbnail" id="stick7" onclick="selectSticker(7)" src="./static/stickers/7.png" alt="">
					<img class="sticker img-thumbnail" id="stick8" onclick="selectSticker(8)" src="./static/stickers/8.png" alt="">
				</div>
			</div>

			<button class="btn btn-primary" id="toggle" style="margin: 1rem;">Open Webcam</button>
			<div id="snap-btn" style="display:none; align-items: flex-start;">
				<div>
					<button class="btn btn-primary webcam-btn" id="snap" disabled title="Select some sticker/s and take a shot.">Take a pic</button>
					<p id="snap-btn-text">Select some sticker(s) first.</p>
				</div>
				<button class="btn btn-danger webcam-btn" id="hide-webcam" style="margin-bottom: 1rem;">Close</button>
			</div>
			<form class="container" id="camera" name="camera" action="snapshot.php" method="post" style="display:none; max-width: 80%">
				<div class="webcam-container container">
					<div class="sticker-preview-container" style="width: 0; height: 332px;">
						<img src="" alt="" id="sticker-preview-1" class="sticker-preview">
						<img src="" alt="" id="sticker-preview-2" class="sticker-preview">
						<img src="" alt="" id="sticker-preview-3" class="sticker-preview">
						<img src="" alt="" id="sticker-preview-4" class="sticker-preview">
					</div>
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
					<input type="text" class="custom-file-upload" name="description" value="" placeholder="Description: " autocomplete="off"/>
					<button class="btn btn-success webcam-btn" type="submit" name="submit" value="submit" id="save-shot">Post</button>
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
	<?php
		if (empty($thumbnails)) echo '<div style="display: none;'; ?>
	<div class="form-wrapper thumbnails">
		<div class="form-container thumbnails-form">
			<div class="thumbnails-container">
				<?php
					if (!empty($thumbnails)) {
						foreach ($thumbnails as $pic) {
							$src = '.'.$pic['picture_path'];
							$post_id = $pic['post_id'];
				?>
				<div class="img-thumbnail-wrapper" id="post-container-<?php echo $post_id; ?>">
					<button class="delete" onclick="removePost(<?php echo $post_id; ?>)">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16" style="margin-bottom: 3px; margin-left: 1px;">
							<path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/>
						</svg>
					</button>
					<img class="img-thumbnail pic-thumbnail" src=<?php echo $src;?>>
				</div>
				<?php }}; ?>
			</div>
		</div>
	</div>
</main>

<?php
	include(__DIR__ . "/footer.php");
?>

<script type="text/javascript">

	let selectedStickers = [];

	function selectSticker(stickerId) {
		let stickerInputUpload = document.getElementById('stick' + stickerId + "-upload");
		let stickerInput = document.getElementById('stick' + stickerId + "-webcam");
		let currentlySelected = selectedStickers.includes(stickerId);
		if (checkboxControl() || (!checkboxControl() && currentlySelected === true)) {
			changeOpacity(stickerId);
			stickerInput.checked = !currentlySelected;
			stickerInputUpload.checked = !currentlySelected;
			if (!currentlySelected) {
				stickerPreview(stickerId);
			} else {
				removePreview(stickerId);
			}
		} 
		else if (!checkboxControl()) {
			alert("Max 4 stickers");
		}
		enableSnapButton();
	}

	function stickerPreview(stickerId) {
		selectedStickers.push(stickerId);
		previewSelected();
	}

	function removePreview(stickerId) {
		selectedStickers = selectedStickers.filter(s => s !== stickerId);
		previewSelected();
	}

	function previewSelected() {
		for (let i = 0; i < selectedStickers.length; i++) {
			const stickerPreview = document.getElementById('sticker-preview-' + (i + 1));
			stickerPreview.src = './static/stickers/' + selectedStickers[i] + '.png';
		}
		for (let i = selectedStickers.length; i < 4; i++) {
			const stickerPreview = document.getElementById('sticker-preview-' + (i + 1));
			stickerPreview.src = '';
		}
	}

	function countCheckboxes() {
		return selectedStickers.length;
	}

	function checkboxControl() {
		return (countCheckboxes() < 4);
	}

	function changeOpacity(stickId) {
		let stick = document.getElementById('stick' + stickId);
		stick.classList.toggle('selected');
	}

	function enableSnapButton() {
		let snapButton = document.getElementById("snap");
		let snapButtonText = document.getElementById("snap-btn-text");
		let saveButton = document.getElementById("save-shot");

		if (countCheckboxes() > 0) {
			snapButton.disabled = false;
			saveButton.disabled = false;
			snapButtonText.style.visibility = "hidden";
		}
		else {
			snapButton.disabled = true;
			saveButton.disabled = true;
			snapButtonText.style.visibility = "visible";
		}
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
			snapButtons.style.display = "flex";
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
	let shotButton = document.querySelector("#snap");

	shotButton.addEventListener('click', function() {
			var video = document.getElementById('webcam');
			var ctx = canvas.getContext('2d');
			ctx.scale(-1, 1);
			ctx.drawImage(video, 0, 0);
			let imageDataUrl = canvas.toDataURL('image/jpeg');
			saveRedoButtons.style.display = "flex";
			pictureUrl.value = imageDataUrl;
		});
	
	// Redo picture
	function redoCallback(e) {
		load_webcam(e);
	}

	snackbarPopup();

</script>
