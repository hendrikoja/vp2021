<?php
	session_start();
	
	if(!isset($_SESSION["user_id"])){
		header("Location: page3.php");
	}
	
	if(isset($_GET["logout"])){
		session_destroy();
		header("Location: page3.php");
	}
	
	require("page_header.php");
?>
	<h1><?php echo $_SESSION["first_name"] ." " .$_SESSION["last_name"]; ?>, veebiprogrammeerimine</h1>
	<p>See leht on valminud õppetöö raames ja ei sisalda mingisugust tõsiseltvõetavat sisu!</p>
	<p>Õppetöö toimus <a href="https://www.tlu.ee/dt">Tallinna Ülikooli Digitehnoloogiate instituudis</a>.</p>
	<hr>
    <ul>
        <li><a href="?logout=1">Logi välja</a></li>
		<li><a href="user_profile.php">Kasutaja profiil</a></li>
		<li><a href="movie_relations.php">Filmi info sidumine</a></li>
		<li><a href="gallery_photo_upload.php">Fotode üleslaadimine</a></li>
    </ul>
    
</body>
</html>