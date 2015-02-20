<?php
if(isset($_FILES['file']) && !empty($_FILES['file'])){
	$name = $_FILES['file']['name'];
	$tmp_name = $_FILES['file']['tmp_name'];
	if(isset($name) && !empty($name)){
		$path = "uploads/".$name;
		if(move_uploaded_file($tmp_name, $path)){
			$return = array();
			$return['path'] = $path;
			echo json_encode($return);
		}
	}
}		
?>
