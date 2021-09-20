<?php
	$author_name = "Hendrik Oja";
	
	require_once("../../config.php");
	require_once("fnc_film.php");
	
	$film_store_notice = null;
	
	if(isset($_POST["film_submit"])){
		
		if(!empty($_POST["title_input"]) and !empty($_POST["genre_input"]) and !empty($_POST["studio_input"]) and !empty($_POST["director_input"]) and !empty($_POST["year_input"])){
			$film_store_notice = store_film($_POST["title_input"], $_POST["year_input"], $_POST["duration_input"], $_POST["genre_input"], $_POST["studio_input"], $_POST["director_input"]);
		} else {
			$film_store_notice = "Osa andmeid puudub!";
		}
		
	}

?>
<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title><?php echo $author_name; ?>, veebiprogrammeerimine</title>
</head>
<body>
	<h1><?php echo $author_name; ?>, veebiprogrammeerimine</h1>
	<p>See leht on valminud õppetöö raames ja ei sisalda mingisugust tõsiseltvõetavat sisu!</p>
	<p>Õppetöö toimus <a href="https://www.tlu.ee/dt">Tallinna Ülikooli Digitehnoloogiate instituudis.</a></p>
	<hr>
	<h2>Eesti filmide lisamine andmebaasi</h2>
	<form method="POST">
		<label for ="title_input">Filmi pealkiri</label>
		<input type="text" name="title_input" id="title_input" placeholder="Filmi pealkiri">
		<br>
		<label for ="year_input">Valmimisaasta</label>
		<input type="number" name="year_input" id="year_input" value="2000" min="1912">
		<br>
		<label for ="duration_input">Filmi kestus</label>
		<input type="number" name="duration_input" id="duration_input" value="60" min="1" max="600">
		<br>
		<label for ="genre_input">Filmi žanr</label>
		<input type="text" name="genre_input" id="genre_input" placeholder="Filmi žarn">
		<br>
		<label for ="studio_input">Filmi tootja</label>
		<input type="text" name="studio_input" id="studio_input" placeholder="Filmi tootja">
		<br>
		<label for ="director_input">Filmi lavastaja</label>
		<input type="text" name="director_input" id="director_input" placeholder="Filmi lavastaja">
		<br>
		<input type="submit" name="film_submit" value="Salvesta">
	</form>
	<span>
		<?php echo $film_store_notice; ?>
	</span>
</body>
</html>