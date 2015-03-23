<?php
function numberRange($first, $last, $step=1) {
	$numbers = array();
	$cur = $first;
	while($cur < $last) {
		$numbers[] = $cur;
		$cur += $step;
	}
	return $numbers;
}
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


class Free_generator extends CI_Model {
	var $region_flag;
	var $tables;
	var $get_start;
	var $get_end;
	var $u_types;
	var $n_types;
	var $r_u_types;
	var $r_n_types;

	public function __construct() {
		$this->load->database();
		$this->get_start = 1;
		$this->get_end = 1;
		$this->region_flag = FALSE;
	}

	public function set_types($unique_types, $normal_types, $amount) {
		$this->amount = $amount;
		$this->u_types = $unique_types;
		$this->n_types = $normal_types;
		$this->r_u_types = array();
		$this->r_n_types = array();
		$this->create_tables();
		$this->preprocess_unique();
		if (count($this->r_u_types) !== 0 || count($this->r_n_types) !== 0) {
			$this->region_flag = TRUE;
			$this->load->model('regional_generator_ram', 'regional_generator_ram2');
			$this->regional_generator_ram2->set_types($this->r_u_types, $this->r_n_types, array('United States'), $amount);
		}
	}

	public function get_data($size) {
		$this->get_end = $this->get_start + $size;
		$result = array();
		//$unique_datas = $this->get_unique_datas($this->get_start, $this->get_end);
		$normal_datas = $this->get_normal_datas($this->get_start, $this->get_end);
		$unique_datas = $this->get_unique_datas($this->get_start, $this->get_end);
		$result = $normal_datas + $unique_datas;
		if ($this->region_flag) {
			$r_datas = $this->regional_generator_ram2->get_data($size);
			$result += $r_datas;
		}
		
		$this->get_start = $this->get_end;
		return $result;
	}

	private function get_unique_datas($start, $end) {
		$columns = array();
		foreach ($this->tables as $key => $value) {
			$temp_a = array_slice($this->tables[$key], $start, $end-$start, TRUE);
			$columns[$key] = $temp_a;
		}
		
		return $columns;
	}

	private function get_normal_datas($start, $end) {
		// $query = $this->db->query("SELECT entry_id, country_name FROM $table_name 
		// 		WHERE entry_id>=$start and entry_id<$end ORDER BY entry_id");
		//initialize arrays
		$columns = array();
		foreach ($this->n_types as $key => $value) {
			$columns[$key] = array();
		}

		for($i=$start; $i<$end; $i++) {

			foreach ($this->n_types as $key => $value) {
				$columns[$key][$i] = $this->get_single_normal($value);
			}
		}

		return $columns;
	}
	private function get_single_normal($type){
		switch ($type['datatype']) {
			case 'STRING':
				return $this->g_string($type);
				break;

			case 'INTEGER':
				return $this->g_integer($type);
				break;

			case 'FLOAT':
				return $this->g_float($type);
				break;
			
			case 'DATE':
				return $this->g_date($type);
				break;

			default:
				# code...
				break;
		}
	}


	private function create_tables(){
		$this->tables = array();
		foreach ($this->n_types as $key => $value) {
			switch ($value['datatype']) {
				case 'NAME':
					$this->r_n_types[$key] = $value;
					unset($this->n_types[$key]);
					break;
				case 'EMAIL':
					$this->r_n_types[$key] = $value;
					unset($this->n_types[$key]);
					break;
				case 'PHONE':
					$this->r_n_types[$key] = $value;
					unset($this->n_types[$key]);
					break;
				
				default:
					break;
			}
		}
		foreach ($this->u_types as $key => $value) {
			switch ($value['datatype']) {
				case 'NAME':
					$this->r_u_types[$key] = $value;
					unset($this->u_types[$key]);
					break;
				case 'EMAIL':
					$this->r_u_types[$key] = $value;
					unset($this->u_types[$key]);
					break;
				case 'PHONE':
					$this->r_u_types[$key] = $value;
					unset($this->u_types[$key]);
					break;
				
				default:
					$this->tables[$key] = array("NULL");
					break;
			}
		}
	}

	private function preprocess_unique(){
		foreach ($this->u_types as $key => $value) {
			$table_name = $this->tables[$key];
			switch ($value['datatype']) {
				case 'INTEGER':
					$this->g_unique_integer($key);
					break;

				case 'DATE':
					$this->g_unique_date($key);
					break;

				case 'STRING':
					$this->g_unique_string($key);
					break;

				case 'FLOAT':
					$this->g_unique_float($key);
					break;

				default:
					# code...
					break;
			}
		}
	}

	private function g_unique_integer($key){
		$start = 1;
		$type = $this->u_types[$key];
		if (isset($type['start'])) $start = $type['start'];
		for($i=$start; $i< $start+$this->amount; $i++) {
			array_push($this->tables[$key], $i);
		}
	}
	private function g_unique_float($key){
		$type = $this->u_types[$key];
		$low = (float)0;
		$high = (float)1000;
		$step = 0.01;
		if (isset($type['low'])) $low = (float)$type['low'];
		if (isset($type['high'])) $high = (float)$type['high'];
		if (isset($type['step'])) $step = (float)$type['step'];
		$size = floor(($high-$low)/$step);
		if ($size < $this->amount) {
			$cur = $low;
			for($i=0; $i<$size; $i++) {
				array_push($this->tables[$key], $cur);
				$cur += $step;
			}
			shuffle($this->tables[$key]);
			for($i=0; $i<$this->amount-$size; $i++) {
				array_push($this->tables[$key], 'NULL');
			}
		}else{

			$jump = floor(($size-$this->amount)/20);
	     	$amount = $this->amount;
	     	$jump_s = ceil($this->amount/20);
	     	$amount = $this->amount;
	     	$start = $low;
	     	$result = array();
	     	while($amount > 0) {
	     		$jump_size = min($amount, $jump_s);
	     		$next = $start + $jump_size * $step;
	     		//print_r($result);
	     		//die();
	     		//print_r($start.":".$next);
	     		$result = array_merge($result, numberRange($start, $next, $step));
	     		$amount -= $jump_size;
	     		$start += mt_rand($jump/3, $jump) * $step;
	     	}
	     	shuffle($result);
	     	$this->tables[$key] = array_merge($this->tables[$key], $result);
	     	//print_r($this->tables[$key]);
		}

	}
	private function g_unique_string($key){
		for($i=0; $i<$this->amount; $i++){
			array_push($this->tables[$key], uniqid());
		}
	}
	private function g_unique_date($key){
		$type = $this->u_types[$key];
		$low = strtotime("-10000days");
		$high = strtotime("+10000days");
		if (isset($type['low'])) $low = strtotime($type['low']);
		if (isset($type['high'])) $high = strtotime($type['high']);
     	$datediff = $high - $low;
     	$days = floor($datediff/(60*60*24));
     	$start = date('Y-m-d', $low);
     	$end = date('Y-m-d', $high);
     	if( $days < $this->amount) {
     		$result = dateRange($start, $end);
     		shuffle($result);
     		for($i = 0; $i < $this->amount-$days; $i++) {
     			array_push($result, 'NULL');
     		}
     		$this->tables[$key] = $result;
     	}else{

	     	//if days enough
	     	$jump = floor(($days-$this->amount)/20);
	     	$jump_s = ceil($this->amount/20);
	     	$amount = $this->amount;
	     	$result = array();
	     	while($amount > 0) {
	     		$jump_size = min($amount, $jump_s);
	     		$next = date('Y-m-d',strtotime("+$jump_size days", strtotime($start)));
	     		$result = array_merge($result, dateRange($start, $next));

	     		$start = date('Y-m-d',strtotime("+$jump days", strtotime($next)));
	     		$amount -= $jump_size;
	     	}
	     	shuffle($result);
	     	$this->tables[$key] = array_merge($this->tables[$key],$result);
	     }
	}

	private function g_integer($type){
		$low = 0;
		$high = 100;
		$step = 1;
		if(isset($type['low'])) $low = $type['low'];
		if(isset($type['high'])) $high = $type['high'];
		if(isset($type['step'])) $step = $type['step'];

		if(isset($type['distribution']) && $type['distribution'] == 'normal') {
			$std_dev = $type['std_dev'];
			return normal_random($low, $high, $std_dev, $step);
		}
		return uniform_random($low, $high, $step);
	}

	private function g_float($type){
		$low = 0;
		$high = 100;
		$step = 0.01;
		if(isset($type['low'])) $low = $type['low'];
		if(isset($type['high'])) $high = $type['high'];
		if(isset($type['step'])) $step = $type['step'];

		if(isset($type['distribution']) && $type['distribution'] == 'normal') {
			$std_dev = $type['std_dev'];
			return normal_random($low, $high, $std_dev, $step);
		}
		return uniform_random($low, $high, $step);
	}
	private function g_string($type){
		$result = generateRandomString();
		if (isset($type['domain'])) $result = $type['domain'][array_rand($type['domain'])];
		return $result;
	}
	private function g_date($type){
		$low = strtotime('-365 days');
		$high = strtotime('now');
		$format = "Y-m-d";
		$step = 86400;
		if(isset($type['low'])) $low = strtotime($type['low']);
		if(isset($type['high'])) $high = strtotime($type['high']);
		if(isset($type['format'])) $format = strtotime($type['format']);

		if(isset($type['distribution']) && $type['distribution'] == 'normal') {
			$std_dev = $type['std_dev'] * 86400;
			return date($format, normal_random($low, $high, $std_dev, $step));
		}
		return date($format, uniform_random($low, $high, $step));
	}


}


?>
