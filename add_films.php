<?php
	
	session_start();
	if(!isset($_SESSION["user_id"])){
		header("Location: page3.php");
	}
	
	$author_name = "Hendrik Oja";
	
	require_once("../../config.php");
	require_once("fnc_film.php");
	require("page_header.php");
	
	$film_store_notice = null;
	
	$title = empty($_POST["title_input"]) ? "Siseta pealkiri": $_POST["title_input"];
	$year = empty($_POST["year_input"]) ? "2000": $_POST["year_input"];
	$duration = empty($_POST["duration_input"]) ? "60": $_POST["duration_input"];
	$genre = empty($_POST["genre_input"]) ? "Sisesta žanr": $_POST["genre_input"];
	$studio = empty($_POST["studio_input"]) ? "Sisesta stuudio": $_POST["studio_input"];
	$director = empty($_POST["director_input"]) ? "Sisesta lavastaja": $_POST["director_input"];
	
	$title_error = null;
	$year_error = null;
	$duration_error = null;
	$genre_error = null;
	$studio_error = null;
	$director_error = null;
	
	if(isset($_POST["film_submit"])){
		
		if(!empty($_POST["title_input"]) and is_numeric($_POST["duration_input"]) and is_numeric($_POST["year_input"]) and !empty($_POST["duration_input"]) and !empty($_POST["genre_input"]) and !empty($_POST["year_input"]) and !empty($_POST["genre_input"]) and !empty($_POST["studio_input"]) and !empty($_POST["director_input"]) and !empty($_POST["year_input"])){
			$film_store_notice = store_film($_POST["title_input"], $_POST["year_input"], $_POST["duration_input"], $_POST["genre_input"], $_POST["studio_input"], $_POST["director_input"]);
		} else {
			$film_store_notice = "Osa andmeid puudub!";
			
			if(empty($_POST["title_input"])){
				$title_error = "Pealkiri puudub";
			}
			if(empty($_POST["genre_input"])){
				$genre_error = "Žanr puudub";
			}
			if(empty($_POST["year_input"])){
				$year_error = "Aasta puudub";
			}
			if(empty($_POST["duration_input"])){
				$duration_error = "Filmi kestus puudub";
			}
			if(empty($_POST["director_input"])){
				$director_error = "Filmi lavastaja puudub";
			}
			if(empty($_POST["studio_input"])){
				$studio_error = "Stuudio puudub";
			}
		}
		
	}

?>
	<h1><?php echo $author_name; ?>, veebiprogrammeerimine</h1>
	<p>See leht on valminud õppetöö raames ja ei sisalda mingisugust tõsiseltvõetavat sisu!</p>
	<p>Õppetöö toimus <a href="https://www.tlu.ee/dt">Tallinna Ülikooli Digitehnoloogiate instituudis.</a></p>
	<hr>
	<h2>Eesti filmide lisamine andmebaasi</h2>
	<form method="POST">
		<label for ="title_input">Filmi pealkiri</label>
		<input type="text" name="title_input" id="title_input" placeholder="<?php echo $title;?>"<?php echo "<p>".$title_error."</p>"?>
		<br>
		<label for ="year_input">Valmimisaasta</label>
		<input type="number" name="year_input" id="year_input" value="<?php echo $year;?>" min="1912"><?php echo "<p>".$year_error."</p>"?>
		<br>
		<label for ="duration_input">Filmi kestus</label>
		<input type="number" name="duration_input" id="duration_input" value="<?php echo $duration;?>" min="1" max="600"><?php echo "<p>".$duration_error."</p>"?>
		<br>
		<label for ="genre_input">Filmi žanr</label>
		<input type="text" name="genre_input" id="genre_input" placeholder="<?php echo $genre;?>"><?php echo "<p>".$genre_error."</p>"?>
		<br>
		<label for ="studio_input">Filmi tootja</label>
		<input type="text" name="studio_input" id="studio_input" placeholder="<?php echo $studio;?>"><?php echo "<p>".$studio_error."</p>"?>
		<br>
		<label for ="director_input">Filmi lavastaja</label>
		<input type="text" name="director_input" id="director_input" placeholder="<?php echo $director;?>"><?php echo "<p>".$director_error."</p>"?>
		<br>
		<input type="submit" name="film_submit" value="Salvesta">
	</form>
	<span>
		<?php echo $film_store_notice; ?>
	</span>
</body>
</html>