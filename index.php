<?php require "markdown.php"; ?>
<!DOCTYPE html>
<html>
<head>
	<title>My Blog</title>
	<style>
		body, html {
			background: lightgrey;
			margin: auto;
			width: 70%;
		}

		.post {
			background: white;
			padding: 5px 5px;
			margin-bottom: 20px;
			white-space: pre-wrap;
		}

		.post h1 {
			margin: 0px;
		}

		.header {
			text-align: center;
		}
	</style>
</head>
<body>
	<div class="header">
		<h1>My Blog</h1>
		<h3>Cool things go here.</h3>
	</div>
	<?php
		$specificPost = $_GET["post"];
		$postCount = 24;

		# Show specific post or all
		if (!isset($specificPost)) {
			for ($post = $postCount; $post >= 1; $post--) {
				makePost($post, FALSE);
			}
		} else {
			makePost($specificPost, TRUE);
		}

		function makePost($post, $showRest) {
			$text = file_get_contents("posts/" . strval($post));
			$text = parse($text, $showRest, $post);

			echo("<div class='post' title='Post number $post'>" . $text . "</div>");
		}
	?>
</body>
</html>
