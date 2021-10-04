<?php
	$author_name = "Hendrik Oja";
	
	session_start();
	if(!isset($_SESSION["user_id"])){
		header("Location: page3.php");
	}
	
	require_once("../../config.php");
	require_once("fnc_film.php");
	require("page_header.php");

	$films_html = read_all_films();
?>
	<h1><?php echo $author_name; ?>, veebiprogrammeerimine</h1>
	<p>See leht on valminud õppetöö raames ja ei sisalda mingisugust tõsiseltvõetavat sisu!</p>
	<p>Õppetöö toimus <a href="https://www.tlu.ee/dt">Tallinna Ülikooli Digitehnoloogiate instituudis.</a></p>
	<hr>
	<h2>Eesti filmid</h2>
	<?php echo $films_html; ?>
</body>
</html>