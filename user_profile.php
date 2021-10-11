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
	
	$notice = null;
	$description = null;
	$bg_color = null;
	$text_color = null;

	$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
	$conn->set_charset("utf8");
	
	$stmt = $conn->prepare("SELECT id FROM vp_userprofiles WHERE userid = ?");
	$stmt->bind_param("i", $_SESSION["user_id"]);
	$stmt->execute();
	
	if(isset($_POST["profile_submit"])){
		if($stmt->fetch()){
			$stmt->close();
			$stmt = $conn->prepare("UPDATE vp_userprofiles SET description = ?, bgcolor = ?, txtcolor = ? WHERE userid = ?");
			$stmt->bind_param("sssi", $_POST["description_input"], $_POST["bg_color_input"], $_POST["text_color_input"], $_SESSION["user_id"]);
			$stmt->execute();
		} else {
			$stmt->close();
			$stmt = $conn->prepare("INSERT INTO vp_userprofiles (userid, description, bgcolor, txtcolor) values(?, ?, ?, ?)");
			$stmt->bind_param("isss", $_SESSION["user_id"], $_POST["description_input"], $_POST["bg_color_input"], $_POST["text_color_input"]);
			$stmt->execute();
		}
		echo $stmt->error;
	}
	
	$stmt->close();
	
	$stmt = $conn->prepare("SELECT description, bgcolor, txtcolor FROM vp_userprofiles WHERE userid = ?");
	$stmt->bind_param("i", $_SESSION["user_id"]);
	$stmt->bind_result($description, $bg_color, $text_color);
	$stmt->execute();
	
	if(!$stmt->fetch()){
		$bg_color = "#FFFFFF";
		$text_color = "#000000";
	}
	
	$stmt->close();
	
	$_SESSION["text_color"] = $text_color;
	$_SESSION["bg_color"] = $bg_color;
	
	require("page_header.php");
	
?>
	<h1><?php echo $author_name; ?>, veebiprogrammeerimine</h1>
	<p>See leht on valminud õppetöö raames ja ei sisalda mingisugust tõsiseltvõetavat sisu!</p>
	<p>Õppetöö toimus <a href="https://www.tlu.ee/dt">Tallinna Ülikooli Digitehnoloogiate instituudis.</a></p>
	<hr>
	<h2>Kasutaja profiil</h2>
	<form method="POST">
		<label for="description_input">Minu lühikirjeldus</label>
		<br>
		<textarea name="description_input" id="description_input" rows="10" cols="80" placeholder="Minu lühikirjeldus.."><?php echo $description; ?></textarea>
		<br>
		<label for="bg_color_input">Taustavärv</label>
		<input type="color" name="bg_color_input" id="bg_color_input" value="<?php echo $bg_color; ?>">
		<br>
		<label for="text_color_input">Tekstivärv</label>
		<input type="color" name="text_color_input" id="text_color_input" value="<?php echo $text_color; ?>">
		<br>
		<input type="submit" name="profile_submit" value="Salvesta">
	</form>
	<span><?php echo $notice; ?></span>
	<hr>
	<ul>
		<li><a href="?logout=1">Logi välja</a></li>
		<li><a href="home.php">Kodulehele</a></li>
	</ul>
</body>
</html>