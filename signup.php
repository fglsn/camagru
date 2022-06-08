<?php
	include("./header.php");
?>

<main>
	<div class="form-wrapper">
		<div class="form-container">
			<h3 class="form-header" style="font-family: 'Cookie', cursive;">Camagru</h3>
			<h4 class="form-header-text">Sign up to see photos and videos from your friends.</h4>
			<form action="register" class="form-box" method="post">
            <div class="mb-3">
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
            </div>
			<div class="mb-3">
                <input type="login" class="form-control" id="login" name="login" placeholder="Username" required>
            </div>

			<div class="mb-3">
				<input type="password" class="form-control" id="password" name="password" placeholder="Password" type="password" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{8,})" title="Must contain at least one number, upper- and lowercase letter, special character and be at least 8 characters long"  required>
				<div id="passwordHelp" class="form-text">Your password must be at least 8 characters long, contain uppercase and lowercase letters, numbers and at least one special character.</div>
			</div>
			<div class="mb-3">
				<input type="password" class="form-control"  name="confirmation" placeholder="Confirm password" id="confirmation" type="password">
			</div>
			<div class="d-grid gap-2">
					<button class="btn btn-primary" type="submit">Next</button>
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
	include("./footer.php");
?>