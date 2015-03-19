<?php
include 'generator.php';

for ($i=0; $i<1000; $i++){
	echo normal_random(1, 100, 15);
	echo "\n";
}
for ($i=0; $i<1000; $i++){
	echo uniform_random(1, 100);
	echo "\n";
}
?>
