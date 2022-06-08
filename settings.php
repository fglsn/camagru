<?php
	include("./header.php");
?>

<main>
	<div class="form-wrapper">
		<!-- Change username -->
		<div class="form-container">
			<form action="change-username" method="post" class="form-box">
				<h6 class="form-header-light">Change Username</h6>
				<div class="mb-3">
					<label for="item">New Username: </label>
					<input type="email" class="form-control" id="new-email" name="new-email"autocomplete="off" required>
				</div>
				<div class="d-grid gap-2">
					<button class="btn btn-primary" type="submit">Submit</button>
				</div>
			</form>
		</div>
		<!-- Change email -->
		<div class="form-container">
			<form action="change-email" method="post" class="form-box">
				<h6 class="form-header-light">Change Email</h6>
				<div class="mb-3">
					<label for="item">Old Email: </label>
					<input type="email" class="form-control" id="old-email" name="old-email" autocomplete="off" required>
				</div>
				<div class="mb-3">
					<label for="item">New Email: </label>
					<input type="email" class="form-control" id="new-email" name="new-email"autocomplete="off" required>
				</div>
				<div class="d-grid gap-2">
					<button class="btn btn-primary" name="submit" type="submit">Submit</button>
				</div>
			</form>
		</div>
		<!-- Change password -->
		<div class="form-container">
			<form action="change-password" method="post" class="form-box">
				<h6 class="form-header-light">Change Password</h6>
				<div class="mb-3">
					<label for="item">Old Password: </label>
					<input type="password" class="form-control" id="old-password" name="old-password" autocomplete="off" required>
				</div>
				<div class="mb-3">
					<label for="item">New Password: </label>
					<input type="password" class="form-control" id="new-password" name="new-password" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{8,})" title="Must contain at least one number, upper- and lowercase letter, special character and be at least 8 characters long" autocomplete="off" required>
				</div>
				<div class="mb-3">
					<label for="item">Confirm New Password: </label>
					<input type="password" class="form-control" id="repeat-password" name="repeat-password" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{8,})" title="Must contain at least one number, upper- and lowercase letter, special character and be at least 8 characters long" autocomplete="off" required>
				</div>
				<div class="d-grid gap-2">
					<button class="btn btn-primary"  name="submit" type="submit">Submit</button>
				</div>
			</form>
		</div>
		<!-- Delete user -->
		<div class="form-container">
			<form action="./delete-user.php" method="post" class="form-box">
				<h6 class="form-header-light">Delete Account</h6>
				<div class="mb-3">
					<label for="item">Confirm with password:  </label>
					<input type="email" class="form-control" id="new-email" name="new-email"autocomplete="off" required>
				</div>
				<div class="d-grid gap-2">
					<button class="btn btn-danger"type="submit" name="submit" value="Delete">Submit</button>
				</div>
			</form>
		</div>
	</div>
</main>

<?php
	include("./footer.php");
?>