<?php
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
