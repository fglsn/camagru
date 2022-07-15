<?php
	include(__DIR__ . "/header.php");
?>

<main>
	<?php if ($info !== '') {
			echo '<span class="info-log" id="snackbar" style="display:block">' . $info . '</span>'; } ?>
	<div class="form-wrapper">
		<div class="form-container">
			<h3 class="form-header" style="font-family: 'Cookie', cursive;">Camagru</h3>
			<h4 class="form-header-text">Set up your new password here:</h4>
			<span class="error"><?php echo $error;?> </span>
			<form action="reset_password.php" class="form-box" method="post">
				<div class="mb-3">
					<input type="password" class="form-control" id="password" name="password" placeholder="New Password" require title="Must contain at least one number, upper- and lowercase letter, special character and be at least 8 characters long">
					<span class="error"><?php echo $err_pass;?></span>
					<div id="passwordHelp" class="form-text">Your password must be at least 8 characters long, contain uppercase and lowercase letters, numbers and at least one special character.</div>
				</div>
				<div class="mb-3">
					<input type="password" id="confirmation" class="form-control" name="confirmation" placeholder="Confirm password" require>
					<span class="error"><?php echo $err_conf;?></span>
				</div>
				<div class="d-grid gap-2">
						<button class="btn btn-primary" type="submit" name="submit" value="submit">Submit</button>
				</div>
			</form>
		</div>
</main>

<script type="text/javascript">
	snackbarPopup();
</script>

<?php
	include(__DIR__ . "/footer.php");
?>