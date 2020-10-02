<?php

namespace View;

class DateTimeView {

	// Returns a paragraf element with a date with format:  
	// Monday, the 8th of July 2015, The time is 10:59:21

	public function show() {

		$dateString = date("l") . ", the " . date("jS") . " of " . date("F") . " " . date("Y") . ",";
		$timeString = "The time is " . date("h:i:s"); 

		return '<p>' . $dateString . " " . $timeString . '</p>';
	}
}