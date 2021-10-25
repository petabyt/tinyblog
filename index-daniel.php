<?php
/*

Add this into ../index.php for a last post blog preview thing

$postsDirectory = scandir("blog/posts");
$postCount = count($postsDirectory) - 2;
if (file_exists("blog/posts/" . strval($postCount))) {
	echo("<div id='post'>");

	$f = fopen("blog/posts/" . strval($postCount), "r");
	echo("<a href='blog?post=" . strval($postCount) . "'><h1>" . substr(fgets($f), 2) . "</h1></a>");
	echo("<h2>" . fgets($f) . "</h2>");
	fclose($f);
	
	echo("</div>");
}

*/
?>

<!DOCTYPE html>
<html>
<head>
	<?php
		if (isset($_GET["post"])) {
			if (!is_numeric($_GET["post"])) {
				echo("Invalid post");
				die();
			}
		}
	
		# Automatically count files in /posts
		$postsDirectory = scandir("posts");
		$postCount = count($postsDirectory) - 2;

		# Assuming first line is markdown h1, make title
		if (isset($_GET["post"]) && file_exists("posts/" . strval($_GET["post"]))) {
			$f = fopen("posts/" . strval($_GET["post"]), "r");
			echo("<title>" . substr(fgets($f), 2) . "</title>");
			fclose($f);
		} else {
			echo("<title>Daniel's Blog</title>");
		}
	?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style>
		body, html {
			background: #141414;
			color: #d6d6d6;
			font-family: arial;
		}

		.post {
			background: #363636;
			padding: 5px 5px;
			margin-bottom: 20px;
			white-space: pre-wrap;
			width: 60%;
			margin: auto;
			margin-bottom: 20px;
		}

		@media only screen and (max-width: 600px) {
			.post {
				width: 100%;
			}
		}
		
		.post img {
			max-width: 90%;
			max-height: 400px;
		}
		
		a {
			color: lightblue;
		}
		
		.post h1 {
			margin: 0px;
			margin-bottom: -10px;
		}

		.header {
			text-align: center;
		}
	</style>
</head>
<body>
	<div class="header">
		<h1>Daniel's Blog</h1>
	</div>
	<?php
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

            # Replace "# " with h1
			$asHtml = preg_replace("/## (.+)/i", "<h2>$1</h2>", $asHtml);

			# Replace "# " with h1
			$asHtml = preg_replace("/# (.+)/i", "<h1>$1</h1>", $asHtml);

			# Replace [text](link) with HTML links. Prevent ][ and )( in them
			$findBetween = "([^\n|\[\]\(\)]+)";

			# Parse images first, since they require a ! in front of them
			$imageRegex = "/\!\[" . $findBetween . "\]\(" . $findBetween . "\)/i";
			$asHtml = preg_replace($imageRegex, "<img src='$2' alt='$1' title='$1'>", $asHtml);

			# Parse links, Prevent ! at beginning
			$linkRegex = "/(?!\!)\[" . $findBetween . "\]\(" . $findBetween . "\)/i";
			$asHtml = preg_replace($linkRegex, "<a href='$2'>$1</a>", $asHtml);

			# Different regex for comments as one needs newline.
			$asHtml = preg_replace("/```([^```]+)```/s", "<code>$1</code>", $asHtml);
			$asHtml = preg_replace("/\`([^\n]+)\`/i", "<code>$1</code>", $asHtml);

			# Replace bold, then italics
			$asHtml = preg_replace("/\*\*([^\n]+)\*\*/i", "<b>$1</b>", $asHtml);
			$asHtml = preg_replace("/\*([^\n]+)\*/i", "<i>$1</i>", $asHtml);

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
