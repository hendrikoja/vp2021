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
	$selected_genre = null;
	$selected_movie_input_for_genre = null;
	
	$genre_notice = null;
	
	$photo_submit_notice = null;
	$selected_person_for_photo = null;
	$photo_dir = "movie_photos/";
	
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
	if(isset($_POST["genre_input"])){
		$selected_genre = $_POST["genre_input"];
	}
	if(isset($_POST["movie_input_for_genre"])){
		$selected_movie_input_for_genre = $_POST["movie_input_for_genre"];
	}
	
	if(isset($_POST["person_in_movie_submit"])){
		$notice = store_movie_relations($selected_person, $selected_movie, $selected_position, $selected_role);
	}
	if(isset($_POST["movie_genre_submit"])){
		$genre_notice = store_movie_genre($selected_movie_input_for_genre, $selected_genre);
	}
	
	$file_type = null;
	$file_name = null;
	if(isset($_POST["person_photo_submit"])){
		$image_check = getimagesize($_FILES["photo_input"]["tmp_name"]);
		if($image_check !== false){
			
			if($image_check["mime"] == "image/jpeg"){
				$file_type = "jpg";
			}
			if($image_check["mime"] == "image/png"){
				$file_type = "png";
			}
			if($image_check["mime"] == "image/gif"){
				$file_type = "gif";
			}
			
			$person_name = get_name_from_id($_POST["person_for_photo_input"]);
			$time_stamp = microtime(1) * 10000;
			$file_name = $person_name . "_" . $time_stamp . "." . $file_type;
			
			move_uploaded_file($_FILES["photo_input"]["tmp_name"], $photo_dir . $file_name);
			$photo_submit_notice = store_person_img($_POST["person_for_photo_input"], $file_name);
		}
	}
?>
	<h1><?php echo $author_name; ?>, veebiprogrammeerimine</h1>
	<p>See leht on valminud ??ppet???? raames ja ei sisalda mingisugust t??siseltv??etavat sisu!</p>
	<p>??ppet???? toimus <a href="https://www.tlu.ee/dt">Tallinna ??likooli Digitehnoloogiate instituudis.</a></p>
	<hr>
	<h2>Filmi info seostamine</h2>
	<h3>Film, inimene ja tema roll</h3>
	<form method="POST">
		<label for="person_input">Isik:</label>
		<select name="person_input" id="person_input">
			<option value="" selected disabled>Vali isik</option>
			<?php echo read_all_person($selected_person); ?>
		</select>
		<label for="movie_input">Film:</label>
		<select name="movie_input" id="movie_input">
			<option value="" selected disabled>Vali film</option>
			<?php echo read_all_movie($selected_movie); ?>
		</select>
		<label for="position__input">Amet:</label>
		<select name="position_input" id="position_input">
			<option value="" selected disabled>Vali amet</option>
			<?php echo read_all_position($selected_position); ?>
		</select>
		<label for="role_input"></label>
		<input type="text" name="role_input" id="role_input" placeholder="Tegelase nimi" value="<?php echo $selected_role; ?>"></input>
		<input type="submit" name="person_in_movie_submit" value="Salvesta">
	</form>
	<span><?php echo $notice; ?></span>
	<hr>
	<h3>Filmi tegelase foto</h3>
	<form method="POST" enctype="multipart/form-data">
		<label for="person_for_photo_input">Isik:</label>
		<select name="person_for_photo_input", id="person_for_photo_input">
			<option value="" selected disabled>Vali isik</option>
			<?php echo read_all_person($selected_person_for_photo); ?>
		</select>
		<label for="photo_input">Vali pildifail:</label>
		<input type="file" name="photo_input" id="photo_input"></input>
		<input type="submit" name="person_photo_submit" value="Lae pilt ??les">
	</form>
	<span><?php echo $photo_submit_notice ?></span>
	<hr>
	<h3>Filmi ??anr</h3>
	<form method="POST">
		<label for="movie_input_for_genre">Film:</label>
		<select name="movie_input_for_genre" id="movie_input_for_genre">
			<option value="" selected disabled>Vali film</option>
			<?php echo read_all_movie($selected_movie_input_for_genre); ?>
		</select>
		<label for="genre_input">??anr:</label>
		<select name="genre_input" id="genre_input">
			<option value="" selected disabled>Vali ??anr</option>
			<?php echo read_all_genre($selected_genre); ?>
		</select>
		<input type="submit" name="movie_genre_submit" value="Salvesta">
		<span><?php echo $genre_notice; ?></span>
	</form>
	<hr>
	<ul>
		<li><a href="?logout=1">Logi v??lja</a></li>
		<li><a href="home.php">Kodulehele</a></li>
	</ul>
</body>
</html>