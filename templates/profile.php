<?php
	include(__DIR__ . "/header.php");
?>

<main class="container" role="main">
		<div class="stats">
			<h4 class="profile-username"><?php if (!empty($username)) echo '@'. $username?></h4>
			<h6><?php if (!empty($total_posts) && $total_posts > 0) echo $total_posts . ' post(s)';?></h6>
		</div>

		<?php
			if (empty($posts)) { ?>
				<div class="container" style="display: flex; flex-direction: column; align-items: center;">
					<svg style="margin: 2rem;" xmlns="http://www.w3.org/2000/svg" width="42" height="42" fill="currentColor" class="bi bi-postcard-heart" viewBox="0 0 16 16">
						<path d="M8 4.5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7Zm3.5.878c1.482-1.42 4.795 1.392 0 4.622-4.795-3.23-1.482-6.043 0-4.622ZM2.5 5a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3Zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3Zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3Z"/>
						<path fill-rule="evenodd" d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H2Z"/>
					</svg>
					<h3>No posts here yet!</h3>
					<?php if ($username == $_SESSION['username']) { ?>
					<h5 style="margin: 0 0 2rem 0;"> Click <a href="upload.php">here</a> to add your first post. </h5>
				</div>
		<?php }}; ?>

		<div class="profile-grid">
			<?php
				if (!empty($posts)) {
					foreach ($posts as $post) {
						$src = '.'.$post['picture_path'];
						$author = $post['username'];
						$id = $post['post_id'];
			?>
			<div class="user-pic" id="post-container-<?php echo $id; ?>">
				<button class="delete" onclick="removePost(<?php echo $id; ?>)">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16" style="margin-bottom: 3px; margin-left: 1px;">
						<path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/>
					</svg>
				</button>
				<img alt="<?php echo 'Image by @' . $author?>" class="profile-grid-picture" name="<?php echo $id;?>" src="<?php echo $src;?>">
			</div>
			<?php
					}
				}
			?>
		</div>
<?php
	include(__DIR__ . "/footer.php");
?>
