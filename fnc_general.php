<?php
	function test_input($data) {
		$data = htmlspecialchars($data);
		$data = stripslashes($data);
		$data = trim($data);
		return $data;
	}
	
	#Takes number, but returns string!!
	function minutes_to_hour($minute_total){
		$hours = floor($minute_total / 60);
		$minutes = $minute_total % 60;
		
		return $hours. " tundi ja " . $minutes . " minutit";
	}
	
	function format_date($date){
		return date("d-m-Y", strtotime($date));
	}