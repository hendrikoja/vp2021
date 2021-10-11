<?php
	$database = "if21_hen_oja";
	
	function read_all_person($selected){
		$html = null;
		
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		
		$stmt = $conn->prepare("SELECT id, first_name, last_name, birth_date FROM person");
		$stmt->bind_result($id_from_db, $first_name_from_db, $last_name_from_db, $birth_date_from_db);
		$stmt->execute();
		
		while($stmt->fetch()){
			$html .='<option value="'. $id_from_db .'"';
			
			if($selected == $id_from_db){
				$html .= " selected";
			}
			
			$html .= ">" . $first_name_from_db . " " . $last_name_from_db . " (" . $birth_date_from_db . ")</option>";
			$html .= "\n";
		}
		
		$stmt->close();
		$conn->close();
		
		return $html;
	}

	function read_all_movie($selected){
		$html = null;
		
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		
		$stmt = $conn->prepare("SELECT id, title, production_year FROM movie");
		$stmt->bind_result($id_from_db, $movie_from_db, $production_year_from_db);
		$stmt->execute();
		
		while($stmt->fetch()){
			$html .='<option value="'. $id_from_db .'"';
			
			if($selected == $id_from_db){
				$html .= " selected";
			}
			
			$html .= ">" . $movie_from_db . " (" . $production_year_from_db . ")</option>";
			$html .= "\n";
		}
		
		$stmt->close();
		$conn->close();
		
		return $html;
	}
	
	function read_all_position($selected){
		$html = null;
		
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		
		$stmt = $conn->prepare("SELECT id, position_name FROM position");
		$stmt->bind_result($id_from_db, $positon_name_from_db);
		$stmt->execute();
		
		while($stmt->fetch()){
			$html .='<option value="'. $id_from_db .'"';
			
			if($selected == $id_from_db){
				$html .= " selected";
			}
			
			$html .= ">" . $positon_name_from_db ."</option>";
			$html .= "\n";
		}
		
		$stmt->close();
		$conn->close();
		
		return $html;
	}

	function store_movie_relations($person, $movie, $position, $role){
		#pooleli
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		
		$stmt = $conn->prepare("SELECT * FROM person_in_movie WHERE person_id= ? AND movie_id= ? AND position_id= ? AND role= ?");
		$stmt->bind_param("iiis", $person, $movie, $position, $role);
		$stmt->execute();
		
		if($stmt->fetch()){
			$stmt->close();
			$conn->close();
			return "Selline seos on juba olemas!";
		}
		
		$stmt->close();
		
		
		
	}

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