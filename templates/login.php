<?php
	include("./header.php");
?>

<main>
	<div class="form-wrapper">
		<div class="form-container">
			<h3 class="form-header" style="font-family: 'Cookie', cursive;">Camagru</h3>
			<form action="login" method="post" class="form-box">
				<div class="mb-3">
					<input type="email" class="form-control" id="email" name="email" placeholder="Email" autocomplete="off" required>
				</div>
				<div class="mb-3">
					<input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete="off" type="password" required>
				</div>
				<div class="d-grid gap-2">
					<button class="btn btn-primary" type="submit">Log in</button>
				</div>
				<div class="separator"><div class="line"></div><div class="or">OR</div><div class="line"></div></div>
				<div class="form-footer"><a href="#">Forgot password?</a></div>
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

<?php
	include("./footer.php");
?>