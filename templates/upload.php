<?php
	include(__DIR__ . "/header.php");
?>
<!-- <video id="" width="340" height="240" autoplay></video> -->
<!-- https://stackoverflow.com/questions/572768/styling-an-input-type-file-button -->
<!-- https://stackoverflow.com/questions/2189615/how-to-get-file-name-when-user-select-a-file-via-input-type-file -->
<main>
	<?php if ($info !== '') {
			echo '<span class="info-log" id="snackbar" style="display:block">' . $info . '</span>'; }?>
	<div class="form-wrapper">
		<div class="upload-form-container">
			<h4 class="form-header-light">Upload a picture</h4>
			<form enctype="multipart/form-data" action="upload.php" method="post">
				<div class="upload-form">
					<label for="file-upload" class="custom-file-upload">File: <span id="file-selected"></span></label>
					<input type="file" accept="image/png, image/jpeg" id="file-upload" name="file" onchange="showname()"/>
					<input type="text" class="custom-file-upload" name="description" value="" placeholder="Description: " autocomplete="off"/>
					<span class="error" style="padding-left: 10px;"><?php echo $error;?></span>
					<button class="btn btn-primary" id="upload-btn" type="submit" name="upload">Upload</button>
				</div>
			</form>
			<h4 class="form-header-light">Or</h4>
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

<?php
	include(__DIR__ . "/footer.php");
?>