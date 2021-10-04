<?php
    $database = "if21_hen_oja";
    
    function store_new_user($name, $surname, $gender, $birth_date, $email, $password){
		$notice = null;
		
        $conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        $conn->set_charset("utf8");
        
		$stmt = $conn->prepare("SELECT id FROM vprog_users WHERE email = ?");
		$stmt->bind_param("s", $email);
		$stmt->execute();
		if($stmt->fetch()){
			$notice = "Sellise emailiga kasutaja on juba olemas!";
			return $notice;
		}
		
		$stmt = $conn->prepare("INSERT INTO vprog_users (firstname, lastname, birthdate, gender, email, password) VALUES(?,?,?,?,?,?)");
        echo $conn->error;
        //krüpteerime parooli
        $option = ["cost" => 12];
        $pwd_hash = password_hash($password, PASSWORD_BCRYPT, $option);
        
        $stmt->bind_param("sssiss", $name, $surname, $birth_date, $gender, $email, $pwd_hash);
        
        if($stmt->execute()){
            $notice = "Uus kasutaja edukalt loodud!";
        } else {
            $notice = "Uue kasutaja loomisel tekkis viga: " .$stmt->error;
        }
        
        $stmt->close();
        $conn->close();
        return $notice;
    }
    
    function sign_in($email, $password){
        $notice = null;
        $conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        $conn->set_charset("utf8");
        $stmt = $conn->prepare("SELECT id, firstname, lastname, password FROM vprog_users WHERE email = ?");
        echo $conn->error;
        $stmt->bind_param("s", $email);
        $stmt->bind_result($id_from_db, $firstname_from_db, $lastname_from_db, $password_from_db);
        $stmt->execute();
        if($stmt->fetch()){
            //tuli vaste, kontrollime parooli
            if(password_verify($password, $password_from_db)){
                //sisse logimine
                $_SESSION["user_id"] = $id_from_db;
                $_SESSION["first_name"] = $firstname_from_db;
                $_SESSION["last_name"] = $lastname_from_db;
                $stmt->close();
                $conn->close();
                header("Location: home.php");
                exit();
            } else {
                $notice = "Kasutajanimi või parool on vale!";
            }
        } else {
            $notice = "Kasutajanimi või parool on vale!";
        }
        
        $stmt->close();
        $conn->close();
        return $notice;
    }