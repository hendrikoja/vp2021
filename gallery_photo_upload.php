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
	require_once("fnc_photo_upload.php");
	require("page_header.php");
	
	$alt_text = null;
	$privacy = 1;
	
	$photo_orig_upload_dir = "upload_photos_orig/";
	$photo_normal_upload_dir = "upload_photos_normal/";
	$photo_thumbnail_upload_dir = "upload_photos_thumbnail/";
	$normal_photo_max_width = 600;
	$normal_photo_max_height = 400;
	$watermark_file = "pics/overlay.png";
	
	$photo_size_ratio = 1;
	$photo_error = null;
	$photo_upload_notice = null;
	$file_type = null;
	$file_name = null;
	$alt_text = null;
	$privacy = 1;
	$photo_filename_prefix = "vp_";
	$photo_upload_size_limit = 1024 * 1024;
	
	if(isset($_POST["photo_submit"])){
		if(isset($_FILES["photo_input"]["tmp_name"]) and !empty($_FILES["photo_input"]["tmp_name"])){
			//kas on pilt ja mis tüüpi?
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
			} else {
				$photo_error = "Valitud fail ei ole pilt!";
			}
			
			//Kas on lubatud suurusega?
			if(empty($photo_error) and $_FILES["photo_input"]["size"] > $photo_upload_size_limit){
				$photo_error .= "Valitud fail on liiga suur!";
			}
			
			//kas alt tekst on
			if(isset($_POST["alt_input"]) and !empty($_POST["alt_input"])){
				$alt_text = test_input(filter_var($_POST["alt_input"], FILTER_SANITIZE_STRING));
				if(empty($alt_text)){
					$photo_error .= "Alternatiivtekst on lisamata!";
				}
			}
			
			if(empty($photo_error)){
				$time_stamp = microtime(1) * 10000;
				$file_name = $photo_filename_prefix ."_" .$time_stamp ."." .$file_type;
				
				if($file_type == "jpg"){
					$my_temp_img = imagecreatefromjpeg($_FILES["photo_input"]["tmp_name"]);
				}
				if($file_type == "png"){
					$my_temp_img = imagecreatefrompng($_FILES["photo_input"]["tmp_name"]);
				}
				if($file_type == "gif"){
					$my_temp_img = imagecreatefromgif($_FILES["photo_input"]["tmp_name"]);
				}
				
				$image_width = imagesx($my_temp_img);
				$image_height = imagesy($my_temp_img);
				if($image_width/$normal_photo_max_width > $image_height/$normal_photo_max_height){
					$photo_size_ratio = $image_width / $normal_photo_max_width;
				} else {
					$photo_size_ratio = $image_height / $normal_photo_max_height;
				}
				
				$new_width = round($image_width / $photo_size_ratio);
				$new_height = round($image_height / $photo_size_ratio);
				
				$my_new_temp_image = imagecreatetruecolor($new_width, $new_height);
				imagecopyresampled($my_new_temp_image, $my_temp_img, 0, 0, 0, 0, $new_width, $new_height, $image_width, $image_height);
				
				$watermark = imagecreatefrompng($watermark_file);
				$watermark_width = imagesx($watermark);
				$watermark_height = imagesy($watermark);
				$watermark_x = $new_width - $watermark_width - 10;
				$watermark_y = $new_height - $watermark_width - 10;
				
				imagecopy($my_new_temp_image, $watermark, $watermark_x, $watermark_y, 0, 0, $watermark_width, $watermark_height);
				
				imagedestroy($watermark);
				
				$photo_upload_notice .= save_image($my_new_temp_image, $file_type, $photo_normal_upload_dir . $file_name);
				
				imagedestroy($my_new_temp_image);
				
				if(move_uploaded_file($_FILES["photo_input"]["tmp_name"], $photo_orig_upload_dir .$file_name)){
					$photo_upload_notice .= "Originaalfoto laeti üles!";
					//$photo_upload_notice = store_person_photo($file_name, $_POST["person_for_photo_input"]);
				} else {
					$photo_upload_notice .= "Foto üleslaadimine ei õnnestunud!";
				}
			}
		} else {
			$photo_error = "Pildifaili pole valitud!";
		}
		
		$photo_upload_notice = $photo_error;
	}
?>
	<h1><?php echo $author_name; ?>, veebiprogrammeerimine</h1>
	<p>See leht on valminud õppetöö raames ja ei sisalda mingisugust tõsiseltvõetavat sisu!</p>
	<p>Õppetöö toimus <a href="https://www.tlu.ee/dt">Tallinna Ülikooli Digitehnoloogiate instituudis.</a></p>
	<hr>
	<h3>Foto üleslaadimine</h3>
	<form method="POST" enctype="multipart/form-data">
		<label for="photo_input">Vali pildifail:</label>
		<input type="file" name="photo_input" id="photo_input"></input>
		<br>
		<label for="alt_input">Alternatiivtekst</label>
		<input type="text" name="alt_input" id="alt_input" placeholder="alternatiivtekst" value="<?php echo $alt_text; ?>"></input>
		<br>
		<input type="radio" name="privacy_input_1" id="privacy_input_1" value="1" <?php if($privacy == 1){echo "checked";} ?>>
		<label for="privacy_input_1">Privaatne(Ainult mina näen)</label>
		<br>
		<input type="radio" name="privacy_input_2" id="privacy_input_2" value="2" <?php if($privacy == 2){echo "checked";} ?>>
		<label for="privacy_input_2">Sisseloginud kasutajatele</label>
		<br>
		<input type="radio" name="privacy_input_3" id="privacy_input_3" value="3" <?php if($privacy == 3){echo "checked";} ?>>
		<label for="privacy_input_3">Avalik</label>	
		<br>
		<input type="submit" name="photo_submit" value="Lae pilt üles">
	</form>
	<span><?php echo $photo_upload_notice; ?></span>
	<hr>
	<ul>
		<li><a href="?logout=1">Logi välja</a></li>
		<li><a href="home.php">Kodulehele</a></li>
	</ul>
</body>
</html>