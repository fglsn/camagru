<?php
	include(__DIR__ . "/header.php");
?>

<main>
	<div class="form-wrapper">
		<div class="form-container">
			<h3 class="form-header" style="font-family: 'Cookie', cursive;">Camagru</h3>
			<h4 class="form-header-text">Sign up to see photos and videos from your friends.</h4>
			<span class="error"><?php echo $error;?> </span>
			<form action="signup.php" class="form-box" method="post">
				<div class="mb-3">
					<input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $email?>" require>
					<span class="error"><?php echo $err_email;?> </span>
				</div>
				<div class="mb-3">
					<input type="username" class="form-control" id="username" name="username" placeholder="Username" value="<?php echo $username?>" require>
					<span class="error"><?php echo $err_username; ?></span>
				</div>

				<div class="mb-3">
					<input type="password" class="form-control" id="password" name="password" placeholder="Password" require title="Must contain at least one number, upper- and lowercase letter, special character and be at least 8 characters long">
					<span class="error"><?php echo $err_pass;?></span>
					<div id="passwordHelp" class="form-text">Your password must be at least 8 characters long, contain uppercase and lowercase letters, numbers and at least one special character.</div>
				</div>
				<div class="mb-3">
					<input type="password" id="confirmation" class="form-control" name="confirmation" placeholder="Confirm password" require>
					<span class="error"><?php echo $err_conf;?></span>
				</div>
				<div class="d-grid gap-2">
						<button class="btn btn-primary" type="submit" name="submit" value="submit">Next</button>
				</div>
			</form>
		</div>
		<div class="form-container">
				<div class="sign-text">
					<p class="sign-up">Have an account?
						<a href="./login.php">
							<span class="sign-link">
								Log in
							</span>
						</a>
					</p>
				</div>
			</div>
		</div>

</main>

<?php
	include(__DIR__ . "/footer.php");
?>

<!-- pattern='^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,20}$' -->
<!-- (?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{8,}) -->