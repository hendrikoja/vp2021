<?php
	$database = "if21_hen_oja";
	
	function read_all_films(){
		
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		
		$stmt = $conn->prepare("SELECT * FROM film");
		$stmt->bind_result($title_from_db, $year_from_db, $duration_from_db, $genre_from_db, $studio_from_db, $director_from_db);
		$stmt->execute();

		$films_html = null;

		while($stmt->fetch()){
			$films_html .= "<h3>" . $title_from_db . "</h3> \n";
			$films_html .= "<ul> \n";
			$films_html .= "<li>Valmimisaasta: " . $year_from_db . "</li> \n";
			$films_html .= "<li>Kestus: " . $duration_from_db . "</li> \n";
			$films_html .= "<li>Žanr: " . $genre_from_db . "</li> \n";
			$films_html .= "<li>Tootja: " . $studio_from_db . "</li> \n";
			$films_html .= "<li>Lavastaja: " . $director_from_db . "</li> \n";
			$films_html .= "</ul> \n";
		}
		
		$stmt->close();
		$conn->close();
		
		return $films_html;
	}
	
	function store_film($title, $year, $duration, $genre, $studio, $director){
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		
		$stmt = $conn->prepare("INSERT INTO film (pealkiri, aasta, kestus, zanr, tootja, lavastaja) values(?, ?, ?, ?, ?, ?)");
		$stmt->bind_param("siisss", $title, $year, $duration, $genre, $studio, $director);
		
		$success = null;
		
		if($stmt->execute()){
			$success = "Salvestamine õnnestus";
		} else {
			$success = "Salvestamine ei õnnestunud";
		}
		
		$stmt->close();
		$conn->close();
		
		return $success;
		}
?>