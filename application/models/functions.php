<?php
	/**
	* Generate phone numbers of given length(Not Unique)
	*/
	function generate_phone($length=8){
	    $characters = '0123456789';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}
	/**
	* Generate random string given length (Not Unique)
	*/
	function random_string($maxlength=15) {
		$characters = 'abcdefghijklmnopqrstuvwxyz';
    	$charactersLength = strlen($characters);
		$numbers = '0123456789';
		$length = mt_rand(9, $maxlength);
		$random_str = '';
		$c_length = 9;
		$n_length = $length - $c_length;
		for ($i = 0; $i < $c_length; $i++) {
			$random_str .= $characters[rand(0, $charactersLength - 1)];
		}
		for ($i = 0; $i < $n_length; $i++) {
			$random_str .= $numbers[rand(0, 9)];
		}
		return $random_str;
	}
	/**
	* A helper funciton to make phone number random
	*/
	function replace_digits($origin, $map, $length){
		$result = '';
		for($i=0; $i<$length; $i++){
			$index = $origin % 10;
			$result .= $map[$index];
			$origin /= 10;
		}
		return $result;
	}
	/**
	* Generate an array of numbers given range and step
	*/
	function numberRange($first, $last, $step=1) {
		$numbers = array();
		$cur = $first;
		while($cur < $last) {
			$numbers[] = $cur;
			$cur += $step;
		}
		return $numbers;
	}
	/**
	* Generate an array of dates given range
	*/
	function dateRange( $first, $last, $step = '+1 day', $format = 'Y-m-d' ) {
	
		$dates = array();
		$current = strtotime( $first );
		$last = strtotime( $last );
	
		while( $current < $last ) {
	
			$dates[] = date( $format, $current );
			$current = strtotime( $step, $current );
		}
	
		return $dates;
	}
	/**
	* generate random string
	*/
	function generateRandomString($length = 10) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}
	/**
	* Random number with normal distribution: Box_Muller algorithm
	*/
	function normal_random($min, $max, $std_dev, $step=1){
		$rand1 = (float)mt_rand()/(float)mt_getrandmax();
		$rand2 = (float)mt_rand()/(float)mt_getrandmax();
		$guassian_num = sqrt(-2 * log($rand1)) * cos(2 * M_PI * $rand2);
		$mean = ($max + $min) / 2;
		$random_num = ($guassian_num * $std_dev) + $mean;
		$random_num = round($random_num / $step) * $step;
		if($random_num < $min || $random_num > $max) $random_num = normal_random($min, $max, $std_dev, $step);// make sure in the range
		return $random_num;
	}
	/**
	*Random number uniformly
	*/
	function uniform_random($min, $max, $step=1){
		$rand = (float)mt_rand()/(float)mt_getrandmax();
		$random_num = $min + $rand * ($max - $min);
		$random_num = round($random_num / $step) * $step;
		if($random_num < $min || $random_num > $max) $random_num = uniform_random($min, $max, $step);
		return $random_num;
	}



?>
