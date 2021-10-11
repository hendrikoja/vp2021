<?php
	
	session_start();
	if(!isset($_SESSION["user_id"])){
		header("Location: page3.php");
	}
	
	if(isset($_GET["logout"])){
		session_destroy();
		header("Location: page3.php");
	}
	
	$author_name = "Hendrik Oja";
	
	require_once("../../config.php");
	require_once("fnc_general.php");
	require_once("fnc_movie.php");
	require("page_header.php");
	
	$notice = null;
	$selected_person = null;
	$selected_movie = null;
	$selected_position = null;
	$selected_role = null;
	
	if(isset($_POST["person_input"])){
		$selected_person = $_POST["person_input"]; 
	}
	if(isset($_POST["movie_input"])){
		$selected_movie = $_POST["movie_input"];
	}
	if(isset($_POST["position_input"])){
		$selected_position = $_POST["position_input"];
	}
	if(isset($_POST["role_input"])){
		$selected_role = $_POST["role_input"];
	}
	
	if(isset($_POST["person_in_movie_submit"])){
		$notice = store_movie_relations($selected_person, $selected_movie, $selected_position, $selected_role);
	}
?>
	<h1><?php echo $author_name; ?>, veebiprogrammeerimine</h1>
	<p>See leht on valminud õppetöö raames ja ei sisalda mingisugust tõsiseltvõetavat sisu!</p>
	<p>Õppetöö toimus <a href="https://www.tlu.ee/dt">Tallinna Ülikooli Digitehnoloogiate instituudis.</a></p>
	<hr>
	<h2>Filmi info seostamine</h2>
	<h3>Film, inimene ja tema roll</h3>
	<form method="POST">
		<label for="person__input">Isik:</label>
		<select name="person_input">
			<option value="" selected disabled>Vali isik</option>
			<?php echo read_all_person($selected_person); ?>
		</select>
		<label for="movie_input">Film:</label>
		<select name="movie_input">
			<option value="" selected disabled>Vali film</option>
			<?php echo read_all_movie($selected_movie); ?>
		</select>
		<label for="position__input">Amet:</label>
		<select name="position_input">
			<option value="" selected disabled>Vali amet</option>
			<?php echo read_all_position($selected_position); ?>
		</select>
		<label for="role_input"></label>
		<input type="text" name="role_input" id="role_input" placeholder="Tegelase nimi" value="<?php echo $selected_role; ?>"></input>
		<input type="submit" name="person_in_movie_submit" value="Salvesta">
	</form>
	<span><?php echo $notice; ?></span>
	<hr>
	<ul>
		<li><a href="?logout=1">Logi välja</a></li>
		<li><a href="home.php">Kodulehele</a></li>
	</ul>
</body>
</html>