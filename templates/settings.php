<?php
	include(__DIR__ . "/header.php");
?>

<!-- todo: Remember to put required and patterns back! -->

<main>
	<?php if ($info !== '') {
		echo '<span class="info-log" id="snackbar" style="display:block">' . $info . '</span>'; }?>
	<div class="form-wrapper">
		<!-- Notifications -->
		<div class="form-container">
			<form action="settings.php" method="post" class="form-box">
				<h6 class="form-header-light">Notifications Settings</h6>
				<?php 
				if (isset($_SESSION['notify']) && $_SESSION['notify'] === 0) {
					echo '<div class="d-grid gap-2">
							<button class="btn btn-primary" value="subscribe" name="subscribe" type="submit" style="margin: 10px 0;">Subscribe</button>
						</div>';
				} else {
					echo '<div class="d-grid gap-2">
							<button class="btn btn-secondary" value="unsubscribe" name="unsubscribe" type="submit" style="margin: 10px 0;">Unsubscribe</button>
						</div>';
				}?>
			</form>
		</div>
		<!-- Change username -->
		<div class="form-container">
			<form action="settings.php" method="post" class="form-box">
				<h6 class="form-header-light">Change Username</h6>
				<div class="mb-3">
					<label for="item">New Username: </label>
					<input type="text" class="form-control" id="new-username" name="new-username" autocomplete="off">
					<span class="error"><?php echo $err_username;?></span>
				</div>
				<div class="d-grid gap-2">
					<button class="btn btn-primary" value="sumbit-new-username" name="submit-new-username" type="submit" style="margin: 10px 0;">Submit</button>
				</div>
			</form>
		</div>
		<!-- Change email -->
		<div class="form-container">
			<form action="settings.php" method="post" class="form-box">
				<h6 class="form-header-light">Change Email</h6>
				<div class="mb-3">
					<label for="item">Old Email: </label>
					<input type="email" class="form-control" id="old-email" name="old-email" autocomplete="email">
					<span class="error"><?php echo $err_old_email;?></span>
				</div>
				<div class="mb-3">
					<label for="item">New Email: </label>
					<input type="email" class="form-control" id="new-email" name="new-email"autocomplete="off">
					<span class="error"><?php echo $err_email;?></span>
				</div>
				<div class="d-grid gap-2">
					<button class="btn btn-primary" value="sumbit-new-email" name="submit-new-email" type="submit" style="margin: 10px 0;">Submit</button>
				</div>
			</form>
		</div>
		<!-- Change password -->
		<div class="form-container">
			<form action="settings.php" method="post" class="form-box">
				<h6 class="form-header-light">Change Password</h6>
				<div class="mb-3">
					<label for="item">Old Password: </label>
					<input type="password" class="form-control" id="old-password" name="old-password" autocomplete="off">
					<span class="error"><?php echo $err_password;?></span>
				</div>
				<div class="mb-3">
					<label for="item">New Password: </label>
					<input type="password" class="form-control" id="new-password" name="new-password" title="Must contain at least one number, upper- and lowercase letter, special character and be at least 8 characters long" autocomplete="off">
					<span class="error"><?php echo $err_new_password;?></span>
				</div>
				<div class="mb-3">
					<label for="item">Confirm New Password: </label>
					<input type="password" class="form-control" id="repeat-password" name="repeat-password" title="Must contain at least one number, upper- and lowercase letter, special character and be at least 8 characters long" autocomplete="off">
				</div>
				<div class="d-grid gap-2">
					<button class="btn btn-primary" value="submit-new-password" name="submit-new-password" type="submit" style="margin: 10px 0;">Submit</button>
				</div>
			</form>
		</div>
		<!-- Delete user -->
		<div class="form-container">
			<form action="settings.php" method="post" class="form-box">
				<h6 class="form-header-light">Delete Account</h6>
				<div class="mb-3">
					<label for="item">Confirm With Password:  </label>
					<input type="password" class="form-control" id="password" name="password" autocomplete="off">
					<span class="error"><?php echo $err_pass;?></span>
				</div>
				<div class="d-grid gap-2">
					<button class="btn btn-danger" value="sumbit-removal" type="submit" name="submit-removal" style="margin: 10px 0;">Submit</button>
				</div>
			</form>
		</div>
	</div>
	<!-- pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{8,})"  -->
	<!-- pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{8,})"  -->
</main>


<script type="text/javascript">
	snackbarPopup();
</script>

<?php
	include(__DIR__ . "/footer.php");
?>