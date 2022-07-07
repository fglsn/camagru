<?php
	include(__DIR__ . "/header.php");
?>

<main class="main-feed" role="main">

	<?php if ($info !== '') {
		echo '<span class="info-log" id="snackbar" style="display:block">' . $info . '</span>'; }?>
	<section class="feed">
		<div class="post-listing">
			<?php
				if (!empty($posts)) {
					foreach ($posts as $post) {
						$src = '.'.$post['picture_path'];
						$author = $post['username'];
						$description = $post['picture_description']
			?>

						<article class="post-wrapper">
						<div class="post">
							<div class="post-header">
								<h6 class="author-username"><?php echo '@'.$author;?></h6>
							</div>
							<div class="post-content">
								<div class="post-pic-section">
									<img alt="<?php echo 'Image by @' . $author?>" class="picture" src=<?php echo $src;?>>
								</div>
							</div>
							<div class="post-comment-section">
								<section class="post-buttons">
									<span class="post-button">
										<button class="button" type="button">
											<div class="like">
												<svg aria-label="Like" class="heart" color="#8e8e8e" fill="#8e8e8e" height="24" role="img" viewBox="0 0 24 24" width="24"><path d="M16.792 3.904A4.989 4.989 0 0121.5 9.122c0 3.072-2.652 4.959-5.197 7.222-2.512 2.243-3.865 3.469-4.303 3.752-.477-.309-2.143-1.823-4.303-3.752C5.141 14.072 2.5 12.167 2.5 9.122a4.989 4.989 0 014.708-5.218 4.21 4.21 0 013.675 1.941c.84 1.175.98 1.763 1.12 1.763s.278-.588 1.11-1.766a4.17 4.17 0 013.679-1.938m0-2a6.04 6.04 0 00-4.797 2.127 6.052 6.052 0 00-4.787-2.127A6.985 6.985 0 00.5 9.122c0 3.61 2.55 5.827 5.015 7.97.283.246.569.494.853.747l1.027.918a44.998 44.998 0 003.518 3.018 2 2 0 002.174 0 45.263 45.263 0 003.626-3.115l.922-.824c.293-.26.59-.519.885-.774 2.334-2.025 4.98-4.32 4.98-7.94a6.985 6.985 0 00-6.708-7.218z"></path></svg>
											</div>
										</button>
									</span>
									<span class="post-button">
										<button class="button" type="button">
											<div class="comment-button">
												<svg aria-label="Comment" class="bubble" color="#8e8e8e" fill="#8e8e8e" height="24" role="img" viewBox="0 0 24 24" width="24"><path d="M20.656 17.008a9.993 9.993 0 10-3.59 3.615L22 22z" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="2"></path></svg>
											</div>
										</button>
									</span>
									<span><h6 style="padding: 12px; font-style: bold; margin: 0;">0 likes</h6></span>
								</section>
								<section class="author-section">
									<h6 class="author-username" style="padding: 12px;"><?php echo $author ?></h6>
									<p class="post-description"><?php echo $description ?></p>
								</section>
								<?php if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id']))
										echo "<div style='display: none'>"?>
									<div class="line" style="flex-grow: 0"></div>
									<section class="comments">
										<div class="comment">
											<h6 class="commentator" style="padding: 12px;">commentator</h6>
											<p class="comment-text">comment-here comment-here comment-here comment-here comment-here comment-here comment-here </p>
										</div>
										<div class="comment">
											<h6 class="commentator" style="padding: 12px;">commentator</h6>
											<p class="comment-text">test longer comment test longer comment test longer comment test longer comment lalalala test longer test longer comment  test longer comment  </p>
										</div>
									</section>
									<section class="input-box">
										<input type="text" class="form-control input-comment-control" style="border: none!important;" id="input-comment" name="input-comment" placeholder="Add a comment..." autocomplete="off" type="input-comment" required>
										<button type="button" class="btn btn-outline-primary btn-sm">Post</button>
									</section>
								</div>
							</div>
						</div>
					</article> 

			<?php
				}
			}
			?>
		</div>
	</section>
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