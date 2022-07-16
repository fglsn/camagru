<?php
	include(__DIR__ . "/header.php");
?>

<main class="container" role="main">
		<h4 class="profile-username"><?php if (!empty($username)) echo '@'. $username?></h4>
		<div class="profile-grid">
			<?php
				if (!empty($posts)) {
					foreach ($posts as $post) {
						$src = '.'.$post['picture_path'];
						$author = $post['username'];
						$id = $post['post_id'];
			?>
			<div class="user-pic" id="<?php echo $id;?>">
				<img alt="<?php echo 'Image by @' . $author?>" class="profile-grid-picture" name="<?php echo $post_id;?>" src="<?php echo $src;?>">
			</div>
			<?php
					}
				}
			?>
		</div>
<?php
	include(__DIR__ . "/footer.php");
?>
