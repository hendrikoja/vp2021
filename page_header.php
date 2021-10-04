<?php
	$css_color = null;
	$css_color .= "<style> \n";
	$css_color .= "	body { \n";
	$css_color .= "		background-color: " . $_SESSION["bg_color"] . "; \n";
	$css_color .= "		color: " . $_SESSION["text_color"] . "; \n";
	$css_color .= "	} \n";
	$css_color .= "	</style> \n";
?>
<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title><?php echo $_SESSION["first_name"] ." " .$_SESSION["last_name"]; ?>, veebiprogrammeerimine</title>
	<?php echo $css_color; ?>
</head>
<body>
	<img src="pics/banner.png" alt="Veebiprogrammeerimise lehe banner">