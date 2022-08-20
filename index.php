<!DOCTYPE html>
<html>
<head>
	<title>My Blog</title>
	<style>
		body, html {
			background: lightgrey;
			margin: auto;
			width: 70%;
			font-family: sans-serif;
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
		<h3>This is where my stuff goes.</h3>
	</div>
	<?php
		# Make sure number is valid
		if (isset($_GET["post"])) {
			if (!ctype_digit($_GET["post"])) {
				echo("Invalid post");
				die();
			}
		}
	
		# Automatically count files in /posts
		$postsDirectory = scandir("posts");
		$postCount = count($postsDirectory) - 2;

		# Show specific post or all
		if (!isset($_GET["post"])) {
			for ($post = $postCount; $post >= 1; $post--) {
				makePost($post, FALSE);
			}
		} else {
			if (file_exists("posts/" . strval($_GET["post"]))) {
				makePost($_GET["post"], TRUE);
			} else {
				echo("Bad param");
			}
		}

		function makePost($post, $showRest) {
			$text = file_get_contents("posts/" . strval($post));
			$text = parse($text, $showRest, $post);

			echo("<div class='post' title='Post number $post'>" . $text . "</div>");
		}
		
		function parse($string, $showRest, $post) {
			$asHtml = $string;

			$asHtml = htmlspecialchars($asHtml);
			
			$asHtml = str_replace("\\`", "&#96;", $asHtml);
			$asHtml = str_replace("\\*", "&#42;", $asHtml);

            		# Replace "# " with h1
			$asHtml = preg_replace("/## (.+)/i", "<h2>$1</h2>", $asHtml);

			# Replace "# " with h1
			$asHtml = preg_replace("/# (.+)/i", "<h1>$1</h1>", $asHtml);

			# Replace [text](link) with HTML links. Prevent ][ and )( in them
			$findBetween = "([^\n|\[\]\(\)]+)";

			# Parse images first, since they require a ! in front of them
			$imageRegex = "/\!\[" . $findBetween . "\]\(" . $findBetween . "\)/i";
			$asHtml = preg_replace($imageRegex, "<a href='$2'><img width='300' src='$2' alt='$1' title='$1'></a>", $asHtml);

			# Parse links, Prevent ! at beginning
			$linkRegex = "/(?!\!)\[" . $findBetween . "\]\(" . $findBetween . "\)/i";
			$asHtml = preg_replace($linkRegex, "<a href='$2'>$1</a>", $asHtml);

			# Different regex for comments as one needs newline.
			$asHtml = preg_replace("/```([^```]+)```/s", "<code class='long'>$1</code>", $asHtml);
			$asHtml = preg_replace("/\`([^\n`]+)\`/i", "<code>$1</code>", $asHtml);

			# Replace bold, then italics
			$asHtml = preg_replace("/\*\*([^\n\*]+)\*\*/i", "<b>$1</b>", $asHtml);
			$asHtml = preg_replace("/\*([^\n\*]+)\*/i", "<i>$1</i>", $asHtml);

			# Replace --- with mothing and add "back" link or add "read more" if chosen.
			if ($showRest == TRUE) {
				$asHtml = preg_replace("/---/s", "", $asHtml);
				$asHtml .= "<a href='index.php'>Back</a>";
			} else {
				$asHtml = preg_replace("/---(.+)/s", "<p><a href='?post=$post'>Read more</a></p>", $asHtml);
			}

			return $asHtml;
		}
	?>
</body>
</html>
