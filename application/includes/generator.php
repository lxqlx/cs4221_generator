<?php
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
/**
* Generate random integers with normal or uniform distribution
*/
function generate_int($min, $max, $amount, $normal_dev=0){
	// if($unique){
	// 	if($max-$min+1 < $amount) return NULL;//check if there are enough data
	// } 
	$results = array();
	while($amount >= 0){
		$value = NULL;
		if($normal_dev){
			$value = normal_random($min, $max, $normal_dev);
		}else{
			$value = uniform_random($min, $max, $normal_dev);
		}
		array_push($results, $value);
		$amount--;
	}
	return $results;
}
/**
* Generate random float number with normal or uniform distribution
*/
function generate_float($min, $max, $amount, $normal_dev=0, $step=0.01){	
	// if($unique){
	// 	if(($max-$min)*pow(10,$numOfFloat) < $amount) return NULL;//check if there are enough data
	// }
	$results = array();
	while($amount >= 0){
		$value = NULL;
		if($normal_dev){
			$value = normal_random($min, $max, $normal_dev, $step);
		}else{
			$value = uniform_random($min, $max, $normal_dev, $step);
		}
		array_push($results, $value);
		$amount--;
	}
	return $results;
}
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
* Generate list of phone numbers of given length(Unique)(Fake Randomness)
*/
function generate_unique_phones($amount, $length=8){
	$max_number = pow(10, $length);
	if ($amount > $max_number) return NULL; //impossible

	$results = array();
	$number = mt_rand(0, $max_number-1);
	$digits_map = range(0, 9);
	shuffle($digits_map);
	$count = 0;
	$jump = ($max_number-$amount)/($amount/10000+1);
	while($count < $amount){
		$str_number = replace_digits($number, $digits_map, $length);
		array_push($results, $str_number);

		if($count !== 0 && $count % 10000 === 0){
			//@TODO
			shuffle($results);
			print "".$count.":".$results[0]."\n";
			unset($results);
			$results = array();
			$number = ($number + mt_rand($jump/10 * 9, $jump))%$max_number;
		}

		$count++;
		$number = ($number+1) % $max_number;
	}
	shuffle($results);//cannot handle too much data e.g. 1 million
	return $results;
}
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
* Generate date within given range(Not Unique)
*/
function generate_date($start, $end){
	return mt_rand($start, $end);
}
?>
