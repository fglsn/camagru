<?php
	include(__DIR__ . "/header.php");
?>

<main>
	<span class="info"><?php echo $info;?> </span>
	<div class="form-wrapper">
		<div class="form-container">
			<div style="padding: 48px 0 0 0;">
				<svg xmlns="http://www.w3.org/2000/svg" width="72" height="72" fill="currentColor" class="bi bi-lock" viewBox="0 0 16 16">
					<path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2zM5 8h6a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1z"/>
				</svg>
			</div>
			<h3 style="font-size: 1em; padding: 32px 0 0 0;" class="form-header">Trouble Logging In?</h3>
			<p class="form-header-text" style="font-size: 15px; font-weight: 300;">Enter your email and we'll send you a link to get back into your account.</p>
			<form action="forgot_password.php" method="post" class="form-box">
				<div class="mb-3">
					<input type="email" class="form-control" id="email" name="email" placeholder="Email" autocomplete="off" required>
				</div>
				<div class="d-grid gap-2">
					<button class="btn btn-primary" type="submit">Send Link</button>
				</div>
				<div class="separator"><div class="line"></div><div class="or">OR</div><div class="line"></div></div>
				<div class="sign-up"><a href="./signup.php">Create New Account</a></div>
			</form>
		</div>
		<div class="form-container">
			<div class="sign-text">
				<p class="sign-up">
					<a data-testid="sign-up-link" href="./signup.php">
						<span class="sign-link" style="color: black; font-weight: 500;">
							Back To Login
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