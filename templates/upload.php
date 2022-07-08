<?php
	include(__DIR__ . "/header.php");
?>

<!-- https://stackoverflow.com/questions/572768/styling-an-input-type-file-button -->
<!-- https://stackoverflow.com/questions/2189615/how-to-get-file-name-when-user-select-a-file-via-input-type-file -->

<main class="container-fluid">
	<?php if ($info !== '') {
			echo '<span class="info-log" id="snackbar" style="display:block">' . $info . '</span>'; }?>
	<div class="form-wrapper">
		<div class="upload-form-container">
			<h4 class="form-header-light">Upload a picture</h4>
			<form enctype="multipart/form-data" action="upload.php" method="post" class="container" style="max-width: 80%">
				<div class="upload-form">
					<label for="file-upload" class="custom-file-upload">File: <span id="file-selected"></span></label>
					<input type="file" accept="image/png, image/jpeg" id="file-upload" name="file" onchange="showname()"/>
					<input type="text" class="custom-file-upload" name="description" value="" placeholder="Description: " autocomplete="off"/>
					<span class="error" style="padding-left: 10px;"><?php echo $error;?></span>
					<button class="btn btn-primary" id="upload-btn" type="submit" name="upload">Upload</button>
				</div>
			</form>
			<div class="separator"><div class="line"></div><div class="or">OR</div><div class="line"></div></div>
			<button class="btn btn-primary" onclick=load_webcam(); style="margin-bottom: 1rem;">Open Webcam</button>
			<form class="container" style="display:none;" id="camera" style="max-width: 80%">
				<button class="btn btn-outline-danger btn-sm"  id="hide-webcam" style="margin-bottom: 1rem;" onclick=hide_webcam();>Hide</button>
				<div class="webcam-container container">
					<canvas id="canvas" class="container">
						<video autoplay="true" class="container" id="webcam">
						</video>
					</canvas>
				</div>
				<div>
					<button class="btn btn-outline-success webcam-btn">Take a pic</button>
				</div>
			</form>

		</div>
	</div>
</main>

<script type="text/javascript">
	function showname() {
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

<script type="text/javascript">
	function load_webcam(e) {
		document.getElementById('camera').style.display = "flex";

		var canvas = document.getElementById('canvas');
		var ctx = canvas.getContext('2d');
		var video = document.getElementById('webcam');

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
			.catch(function (err0r) {
			console.log("Something went wrong!");
			});
		}

		video.addEventListener('play', function() {
			var $this = this; //cache
			(function loop() {
				if (!$this.paused && !$this.ended) {
					ctx.drawImage($this, 0, 0);
					setTimeout(loop, 1000 / 80); // drawing at 30fps
				}
			} ) ();
		}, 0);
	}

	function hide_webcam(e) {
		document.getElementById('hide-webcam').style.display = "none";
	}

</script>

<?php
	include(__DIR__ . "/footer.php");
?>