function showFilename() {
	var name = document.getElementById('file-upload');
	document.getElementById('file-selected').innerHTML = name.files.item(0).name;
};

function snackbarPopup() {
	if (document.getElementById('snackbar')) {
		var x = document.getElementById('snackbar');
		x.className = 'show';
		setTimeout(function(){ x.className = x.className.replace('show', ''); }, 2500);
	}
}

function removePost(postId) {
	const formData = new FormData();
	formData.append('post_id', postId);

	fetch('remove_post.php', {
		method: 'POST',
		body: formData
	})
	.then(response => response.text())
	.then(text => {
		if (!text) {
			const postToRemove = document.getElementById('post-container-' + postId);
			postToRemove.remove();
		} else {
			console.error('Error removing post: ' + text);
		}
	})
	.catch(error => {
		console.error('Error removing post: ' + error);
	});
}