<?php

	$author_name = "Hendrik Oja";
	
	$weekday_names_et = ["esmaspäev", "teisipäev", "kolmapäev", "neljapäev", "reede", "laupäev", "pühapäev"];
	
	$full_time_now = date("d.m.Y H:i:s");
	$hour_now = date("H");
	$weekday_now = date("N");
	$day_category = "Ebamäärane";
	$time_of_day = "Ebamäärane";
	
	if($weekday_now <= 5){
		$day_category = "koolipäev";
		
		if($hour_now < 8 or $hour_now >= 23){
			$time_of_day = "uneaeg";
		}
		elseif($hour_now >= 8 and $hour_now <= 18){
			$time_of_day = "tundide aeg";
		}
		else{
			$time_of_day = "vaba aeg";
		}
		
	}
	else{
		$day_category = "puhkepäev";
		
		if($hour_now < 8 or $hour_now >= 23){
			$time_of_day = "uneaeg";
		}
		else{
			$time_of_day = "vaba aeg";
		}
		
	}
	
	$photo_dir = "photos/";
	$allowed_photo_types = ["image/jpeg", "image/png"];
	$all_files = array_slice(scandir($photo_dir), 2);
	
	$photo_files = [];
	foreach($all_files as $file){
		$file_info = getimagesize($photo_dir . $file);
		if(isset($file_info["mime"])){
			if(in_array($file_info["mime"], $allowed_photo_types)){
				array_push($photo_files, $file);
			}
		}
	}
	
	$limit = count($photo_files);
	$pic_num = mt_rand(0, $limit - 1);
	$pic_file = $photo_files[$pic_num];
	$pic_html = '<img src="' . $photo_dir . $pic_file . '" alt="Tallinna Ülikool">';
	
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
	<img src="tlu.jpg" alt="Tallinna Ülikooli Terra õppehoone" width="600">
	<p>Lehe avamise hetk: <span><?php echo $weekday_names_et[$weekday_now - 1] . ", " . $full_time_now . ", on " . $day_category ." ning praegu on "  . $time_of_day; ?></span></p>
	<h2>Kursusel õpime</h2>
	<ul>
		<li>HTML keelt</li>
		<li>PHP programmeerimiskeelt</li>
		<li>SQL päringukeelt</li>
		<li>jne</li>
	</ul>
	<?php echo $pic_html; ?>
</body>
</html>