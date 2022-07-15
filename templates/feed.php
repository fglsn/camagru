<?php
	include(__DIR__ . "/header.php");
?>

<!-- todo: remember to pur require back to comment field! -->

<main class="main-feed container" role="main">

	<?php if ($info !== '') {
		echo '<span class="info-log" id="snackbar" style="display:block">' . $info . '</span>'; }?>
	<section class="feed container">
		<div class="post-listing">
			<?php
				if (!empty($posts)) {
					foreach ($posts as $post) {
						$src = '.'.$post['picture_path'];
						$author = $post['username'];
						$description = $post['picture_description'];
						$id = $post['post_id'];
			?>

						<article class="post-wrapper" >
						<div class="post">
							<div class="post-header">
								<h6 class="author-username"><?php echo '@'.$author;?></h6>
							</div>
							<div class="post-content">
								<div class="post-pic-section" id="<?php echo $id;?>">
									<img alt="<?php echo 'Image by @' . $author?>" class="picture" name="<?php echo $post_id;?>" src="<?php echo $src;?>">
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
									<h6 class="author-username" style="padding: 12px;"><?php echo '@' . $author ?></h6>
									<p class="post-description"><?php echo $description ?></p>
								</section>
								<?php if (!is_user_logged_in())
										echo "<div style='display: none'>"?>
									<div class="line" style="flex-grow: 0"></div>
									<section class="comments">
										<?php if (!empty($comments)) {
												foreach ($comments as $comment) {
													if ($comment['post_id'] == $id && $comment['post_owner'] == $author) {
														echo '<div class="comment">
																<h6 class="commentator" style="padding: 5px 12px;">' . $comment['commentator'] . '</h6>
																<p class="comment-text">' . $comment['comment'] . '</p>
															</div>';
													}
												}
											}
										?>
									</section>
									<!-- <div class="line" style="flex-grow: 0"></div> -->
									<section >
										<form action="feed.php" method="post" class="input-box">
											<input type="text" class="form-control input-comment-control" style="border: none!important;" id="input-comment" name="comment" placeholder="Add a comment..." autocomplete="off">
											<button type="submit" name="submit" value="submit" class="btn btn-outline-primary" onclick="window.location=<?php echo '#' . $id; ?>">Post</button>
											<input type="hidden" readonly value="<?php echo $after_id ?>" name="after_id"/>
											<input type="hidden" readonly value="<?php echo $id ?>" name="post_id"/>
											<input type="hidden" readonly value="<?php echo $author ?>" name="author"/>
										</form>
										<?php 
											if (isset($error) && !empty($error)) {
												if ($post_id == $id)
													echo '<div style="margin: 15px;"><span class="error">' . $error . '</span></div>'; 
											}
										?>
									</section>
								</div>
							</div>
						</div>
					</article> 

			<?php
				}
			}
			?>
				<ul class="pagination">
					<!-- make previous -->
					<li class="page-item"><a class="page-link" href="feed.php<?php
						
						if (count($posts) > 0) {
							$num = $posts[count($posts) - 1]['post_id'];
							if ($num + 10 >= $lateral_ids[0][0] || $num + 10 <= $lateral_ids[1][0])
								echo '';
							else
								echo '?after_id=' . $num + 10;
						} else {
							echo '';
						} ?>">Previous</a></li>

						<li class="page-item"><a class="page-link" href="feed.php<?php 
						if (count($posts) > 0) {
							$num = $posts[count($posts) - 1]['post_id'];
							if ($num >= $lateral_ids[0][0] || $num <= $lateral_ids[1][0])
								echo '';
							else
								echo '?after_id=' . $num;
						} else { echo ''; }?>">Next</a></li>
				</ul>
			</div>
		</div>
	</section>
</main>

<script type="text/javascript">
	snackbarPopup();

<?php
	if (isset($post_id) && !empty($post_id)) {
		echo 'const post = document.getElementById("' . $post_id . '"); post.scrollIntoView();'; 
	}
?>
</script>



<?php
	include(__DIR__ . "/footer.php");
?>