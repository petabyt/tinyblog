<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.5, maximum-scale=2.0, user-scalable=yes" />
		<link rel="shortcut icon" href="https://petabyte.heb12.com/favicon.ico">
		<title>My Blog</title>
	</head>
	<style>
		* {
			box-sizing: border-box;
		}
		html {
			-webkit-text-size-adjust: none;
		}
		table {
			font-size: 100%;
		}
		body {
			font-family: "lucida grande", "lucida sans unicode", lucida, helvetica, "Hiragino Sans GB", "Microsoft YaHei", "WenQuanYi Micro Hei", sans-serif;
			font-size: 18px;
		}
		body.mobile {
			font-size: 32px;
		}
		P, li {
			line-height: 1.8;
		}
		H1 {
			margin-bottom: -10px;
			font-family: "Palatino Linotype", "Book Antiqua", Palatino, Helvetica, STKaiti, SimSun, serif;
		}
		H2 {
			font-family: "Palatino Linotype", "Book Antiqua", Palatino, Helvetica, STKaiti, SimSun, serif;
			margin-bottom: 60px;
			margin-bottom: 40px;
			padding: 5px;
			border-bottom: 2px LightGrey solid;
			width: 98%;
			line-height: 150%;
			color: #666666;
		}
		H3 {
			font-family: "Palatino Linotype", "Book Antiqua", Palatino, Helvetica, STKaiti, SimSun, serif;
			margin-top: 40px;
			margin-bottom: 30px;
			border-bottom: 1px LightGrey solid;
			width: 98%;
			line-height: 150%;
			color: #666666;
		}
		H4 {
			font-family: "Palatino Linotype", "Book Antiqua", Palatino, Helvetica, STKaiti, SimSun, serif;
			margin-top: 40px;
			margin-bottom: 30px;
			border-bottom: 1px LightGrey solid;
			width: 98%;
			line-height: 150%;
			color: #666666;
		}
		.box {
			padding: 2% 8% 5% 8%;
			border: 1px solid LightGrey;
		}
		li {
			margin-left: 10px;
		}
		blockquote {
			border-left: 5px lightgrey solid;
			padding-left: 15px;
			margin-left: 20px;
			background: #f4f4f4;
		}
		pre {
			font-family: Inconsolata, Consolas, "DEJA VU SANS MONO", "DROID SANS MONO", Proggy, monospace;
			font-size: 80%;
			background-color: #FAFAFA;
			border: 1px solid #E0E0E0;
			border-radius: 4px;
			padding: 12px;
			line-height: 1.5;
			display: block;
			width: 100%;
			overflow: auto;
		}
		code {
			font-family: Inconsolata, Consolas, "DEJA VU SANS MONO", "DROID SANS MONO", Proggy, monospace;
		}
		a {
			text-decoration: none;
			cursor: crosshair;
			border-bottom: 1px dashed #2f6f9c;
			color: #2f6f9c;
		}
		a:hover {
			background-color: LightGrey;
		}
		img {
			display: block;
			box-shadow: 0 0 10px #555;
			border-radius: 6px;
			margin-left: auto;
			margin-right: auto;
			margin-top: 10px;
			margin-bottom: 10px;
			-webkit-box-shadow: 0 0 10px #555;
		}
		img.displayed {
			text-align: center;
			display: block;
		}
		hr {
			color: LightGrey;
		}
		p.notice {
			color: #AA4433;
			font-size: 14px;
		}
		div.tweet p {
			font-size: 16px;
			border: 1px solid #aaa;
			border-left: 10px solid #f28500;
			padding: 2px 0.5em 2px 0.5em;
			margin-bottom: 20px;
			background-color: #fbfbfb;
		}
		div.tweet i {
			color: brown;
			font-size: 14px;
			font-style: normal;
			border: 1px solid #aaa;
			margin-right: 0.5em;
			padding: 0px 2px;
		}
		div.outer {
			margin: 2% 5% 2% 5%;
		}
		body.mobile div.outer {
			margin: 2% 0% 2% 0%;
		}
		div.inner {
			margin: 0% 14%;
			padding: 2% 8% 4% 8%;
			border: 1px solid LightGrey;
		}
		body.mobile div.inner {
			margin: 0;
			padding: 2% 4% 4% 4%;
		}
		div.ad-banner {
			margin: 0% 14%;
		}
		body.mobile div.ad-banner {
			display: none;
		}
		.side-ad.mobile {
			display: none;
		}
		.left {
			float: left;
			clear: both;
			width: 50%;
			padding: 25 24 25 0;
			border-top: 1px solid lightblue;
		}
		.right {
			float: left;
			clear: none;
			width: 50%;
			padding: 25 0 25 24;
			border-top: 1px solid lightblue;
		}
		.row:after {
			content: "";
			display: table;
			clear: both;
		}
		.row {
			clear: both;
		}
		.post {
			white-space: pre-wrap;
		}
		img { 
			max-width: 100%; 
			max-height: 100%;
		}
	</style>
	<body>
		<div class="inner">
			<h1><a href="/">My Blog</a></h1>
			<h3>This is where my stuff goes.</h3>
			<?php
				# Automatically count files in /posts
				$postsDirectory = scandir("posts");
				$postCount = count($postsDirectory) - 2;

				# Show specific post or all
				if (!isset($_GET["post"])) {
					for ($post = $postCount; $post >= 1; $post--) {
						makePost($post, FALSE);
					}
				} else {
					makePost($_GET["post"], TRUE);
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

					# Replace bold, then italics (don't replace \*)
					$asHtml = preg_replace("/\*\*([^\n]+)\*\*/i", "<b>$1</b>", $asHtml);
					$asHtml = preg_replace("/\*[^\\\\]([^\n]+)[^\\\\]\*/i", "<i>$1</i>", $asHtml);
					
					# Replace \* with *
					# Optional, may break C/C++ code.
					#$asHtml = preg_replace("/(\\\\\*)/i", "*", $asHtml);

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
		</div>
	</body>
</html>
