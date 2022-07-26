<?php
	include(__DIR__ . "/header.php");
?>

<main class="main-feed container" role="main">

	<?php if ($info !== '') {
		echo '<span class="info-log" id="snackbar" style="display:block">' . $info . '</span>'; }?>
	<section class="feed container">
		<div class="post-listing">
			<?php
				if (empty($posts) || !isset($posts)) { ?>
					<div class="container" style="display: flex; flex-direction: column; align-items: center;">
						<svg style="margin: 2rem;" xmlns="http://www.w3.org/2000/svg" width="42" height="42" fill="currentColor" class="bi bi-postcard-heart" viewBox="0 0 16 16">
							<path d="M8 4.5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7Zm3.5.878c1.482-1.42 4.795 1.392 0 4.622-4.795-3.23-1.482-6.043 0-4.622ZM2.5 5a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3Zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3Zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3Z"/>
							<path fill-rule="evenodd" d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H2Z"/>
						</svg>
						<h3>No posts here yet!</h3>
						<h5 style="margin: 0 0 2rem 0;"> Are you ready to leave one? :) </h5>
					</div>
				<?php }
				if (!empty($posts)) {
					foreach ($posts as $post) {
						$src = '.'.$post['picture_path'];
						$author = $post['username'];
						$post_owner_id = $post['owner_id'];
						$description = $post['picture_description'];
						$creation_time = time_elapsed_string($post['created_at']);
						$id = $post['post_id'];
						$post_like_count = 0;
						if (!empty($posts_like_counts)) {
							foreach ($posts_like_counts as $count) {
								if ($count['post_id'] == $id) {
									$post_like_count = $count['like_count'];
								}
							}
						}
						$liked = false;
						if (!empty($liked_posts)) {
							foreach ($liked_posts as $liked_post) {
								if ($liked_post['post_id'] == $id) {
									$liked = true;
								}
							}
						}
						$post_comments = array();
						if (isset($comments) && !empty($comments)) {
							foreach ($comments as $comment) {
								if ($comment['post_id'] == $id) {
									array_push($post_comments, $comment);
								}
							}
						}
			?>

					<article class="post-wrapper" id="post-container-<?php echo $id; ?>">
						<div class="post">
							<div class="post-header">
								<h6 class="author-username"><a href="profile.php?user=<?php echo $post_owner_id;?>" style="color:black!important"><?php echo '@'.$author;?></a></h6>
							</div>
							<div class="post-content">
								<div class="post-pic-section" id="<?php echo $id;?>">
									<img alt="<?php echo 'Image by @' . $author?>" class="picture" name="<?php echo $post_id;?>" src="<?php echo $src;?>">
								</div>
							</div>
							<div class="post-comment-section">
								<?php if (!is_user_logged_in())
											echo "<div style='display: none'>"?>
								<section class="post-buttons">
									<span class="post-button">
										<button class="button" type="button" onclick="toggleLike(event)" data-post-id="<?php echo $id; ?>" data-liked="<?php if ($liked) echo 'true'; else echo 'false'; ?>">
											<div class="like">
												<svg aria-label="Like" class="heart" color="#8e8e8e" fill="<?php if ($liked) echo 'red'; else echo '#8e8e8e'; ?>" height="24" role="img" viewBox="0 0 24 24" width="24"><path d="M16.792 3.904A4.989 4.989 0 0121.5 9.122c0 3.072-2.652 4.959-5.197 7.222-2.512 2.243-3.865 3.469-4.303 3.752-.477-.309-2.143-1.823-4.303-3.752C5.141 14.072 2.5 12.167 2.5 9.122a4.989 4.989 0 014.708-5.218 4.21 4.21 0 013.675 1.941c.84 1.175.98 1.763 1.12 1.763s.278-.588 1.11-1.766a4.17 4.17 0 013.679-1.938m0-2a6.04 6.04 0 00-4.797 2.127 6.052 6.052 0 00-4.787-2.127A6.985 6.985 0 00.5 9.122c0 3.61 2.55 5.827 5.015 7.97.283.246.569.494.853.747l1.027.918a44.998 44.998 0 003.518 3.018 2 2 0 002.174 0 45.263 45.263 0 003.626-3.115l.922-.824c.293-.26.59-.519.885-.774 2.334-2.025 4.98-4.32 4.98-7.94a6.985 6.985 0 00-6.708-7.218z"></path></svg>
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
									<span><h6 style="padding: 12px; font-style: bold; margin: 0;" id="like-count-<?php echo $id; ?>"><?php echo $post_like_count; ?> like(s)</h6></span>
									<span class="error" id="like-error-<?php echo $id; ?>"></span>
									<?php if ($post['post_id'] == $id && isset($_SESSION['username']) && $author == $_SESSION['username']) { ?>
										<button class="delete" onclick="removePost(<?php echo $id; ?>)" style=" position: relative; width: 30px; ">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16" color="#8e8e8e" fill="#8e8e8e">
												<path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/>
											</svg>
										</button>
					<?php }; ?>
								</section>
								<section class="author-section">
									<h6 class="author-username" style="padding: 12px;"><?php echo '@' . $author ?></h6>
									<p class="post-description"><?php echo $description ?></p>
									<section class="date">
										<time datetime="<?php echo $post['created_at'];?>"><?php echo $creation_time;?></time>
									</section>
								</section>
									<?php if (!is_user_logged_in())
										echo "<div style='display: none'>"?>
								<div class="line" style="flex-grow: 0"></div>
								<section class="comments">
									<?php 
										if (!empty($post_comments)) {
											if (count($post_comments) > 5) {
												echo '<button class="comments-btn" id="show-comments-' . $id . '" onclick="toggleComments(' . $id . ')">Show all ' . count($post_comments) . ' comments</button>';
												echo '<div id="many-comments-' . $id . '" style="display: none">';
											}
											foreach ($post_comments as $comment) {
												echo '<div class="comment">
															<h6 class="commentator" style="padding: 5px 12px;">' . $comment['username'] . '</h6>
															<p class="comment-text">' . $comment['comment'] . '</p>
															<p class="date">' . time_elapsed_string($comment['created_at']) . '</p>
														</div>';
											}
											if (count($post_comments) > 5) {
												echo '<button class="comments-btn" id="hide-comments-' . $id . '" onclick="toggleComments(' . $id . ')">Hide comments</button>';
												echo '</div>';
											}
										}
									?>
								</section>
								<section>
									<form action="feed.php" method="post" class="input-box">
										<input type="text" required class="form-control input-comment-control" style="border: none!important;" id="input-comment" name="comment" placeholder="Add a comment..." autocomplete="off">
										<button type="submit" name="submit" value="submit" class="btn btn-outline-primary">Post</button>
										<input type="hidden" readonly value="<?php if (isset($after_id)) echo $after_id ?>" name="after_id"/>
										<input type="hidden" readonly value="<?php echo $id ?>" name="post_id"/>
										<input type="hidden" readonly value="<?php echo $post_owner_id ?>" name="post_owner_id"/>
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
					</article> 

			<?php
				}
			}
			?>
			<?php if (empty($posts)) echo '<div style="display: none;'; ?>
				<ul class="pagination">
					<?php 
						if (count($posts) > 0) {
							$latest_post_id = $lateral_ids[0][0];
							$first_post_id = $lateral_ids[1][0];

							$latest_post_on_page = $posts[0]['post_id'];
							if ($latest_post_on_page != $latest_post_id) {
								$previous_after_id = $latest_post_on_page + 5 + 1;
								echo '<li class="page-item"><a class="page-link" href="feed.php?after_id=' . $previous_after_id . '">Previous</a></li>';
							}

							$first_post_on_page = $posts[count($posts) - 1]['post_id'];
							if ($first_post_on_page != $first_post_id) {
								echo '<li class="page-item"><a class="page-link" href="feed.php?after_id=' . $first_post_on_page . '">Next</a></li>';
							}
						}
					?>
				</ul>
			<?php if (empty($posts)) echo '</div>'; ?>
		</div>
	</section>
</main>

<script type="text/javascript">
	snackbarPopup();

	function toggleLike(e) {
		const likeButton = e.currentTarget;
		const postId = likeButton.dataset.postId;
		const liked = likeButton.dataset.liked == "true";

		const formData = new FormData();
		formData.append('post_id', postId);
		formData.append('like', !liked);

		fetch('like.php', {
			method: 'POST',
			body: formData
		})
		.then(response => response.json())
		.then(json => {
			changeLikeCount(postId, json['postLikeCount']);
			likeButton.dataset.liked = !liked;
			const likeSvg = likeButton.getElementsByTagName('svg')[0];
			if (!liked) {
				likeSvg.style.fill = "red";
			} else {
				likeSvg.style.fill = "#8e8e8e";
			}
		})
		.catch(error => {
			console.error('Error: ' + error);
			changeLikeError(postId, 'Could not like post!');
		});
	}

	function changeLikeError(postId, error) {
		const el = document.getElementById('like-error-' + postId);
		el.textContent = error;
	}

	function changeLikeCount(postId, likeCount) {
		const el = document.getElementById('like-count-' + postId);
		el.textContent = likeCount + ' like(s)';
	}

	function toggleComments(postId) {
		const commentsDiv = document.getElementById('many-comments-' + postId);
		const showButton = document.getElementById('show-comments-' + postId);
		const hideButton = document.getElementById('hide-comments-' + postId);
		if (commentsDiv.style.display == 'none') {
			showButton.style.display = 'none';
			commentsDiv.style.display = 'block';
			hideButton.style.display = 'inline-block';
		} else {
			showButton.style.display = 'inline-block';
			commentsDiv.style.display = 'none';
			hideButton.style.display = 'none';
		}
	}

<?php
	if (isset($post_id) && !empty($post_id)) {
		echo 'const post = document.getElementById("' . $post_id . '"); post.scrollIntoView();'; 
	}
?>
</script>



<?php
	include(__DIR__ . "/footer.php");
?>