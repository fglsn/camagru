<?php
	include(__DIR__ . "/header.php");
?>
<!-- remember to put required back -->
<main>
	<?php if ($info !== '') {
		echo '<span class="info-log" id="snackbar" style="display:block">' . $info . '</span>'; }?>
	<div class="form-wrapper">
		<div class="form-container">
			<h3 class="form-header" style="font-family: 'Cookie', cursive;">Camagru</h3>
			<span class="error" style="padding-bottom: 20px"><?php echo $error;?> </span>
			<form action="login.php" method="post" class="form-box">
				<div class="mb-3">
					<input type="email" class="form-control" id="email" name="email" placeholder="Email" autocomplete="off">
					<span class="error"><?php echo $err_email;?> </span>
				</div>
				<div class="mb-3">
					<input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete="off" type="password">
					<span class="error"><?php echo $err_pass;?> </span>
				</div>
				<div class="d-grid gap-2">
					<button class="btn btn-primary" type="submit">Log in</button>
				</div>
				<div class="separator"><div class="line"></div><div class="or">OR</div><div class="line"></div></div>
				<div class="form-footer"><a href="./forgot_password.php">Forgot password?</a></div>
			</form>
		</div>
		<div class="form-container">
			<div class="sign-text">
				<p class="sign-up">Don't have an account?
					<a data-testid="sign-up-link" href="./signup.php">
						<span class="sign-link">
							Sign up
						</span>
					</a>
				</p>
			</div>
		</div>
	</div>
</main>

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