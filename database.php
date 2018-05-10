<?php
function select_languages($link) {
	$sql = "SELECT name,code FROM Languages ORDER BY name ASC";
	$result = mysqli_query($link, $sql);
	$array = array();
	while ($row = mysqli_fetch_row($result)) {
		$name = $row[0];
		$code = $row[1];
		$array[$code] = $name;
	}
	return $array; 
}
?>