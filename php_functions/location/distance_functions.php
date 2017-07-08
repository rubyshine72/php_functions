<?php
	
function distance($lat1, $lon1, $lat2, $lon2, $unit) {

	$theta = $lon1 - $lon2;
	$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
	$dist = acos($dist);
	$dist = rad2deg($dist);
	$miles = $dist * 60 * 1.1515;
	$unit = strtoupper($unit);

	if ($unit == "K") {
		return ($miles * 1.609344);
	}else if ($unit == "N") {
		return ($miles * 0.8684);
	}else {
		return $miles;
	}
}

function distance_field_mysql($lat1, $lon1, $lat_field, $lon_field,  $unit) {
	$k = 3959;
	if ($unit == "K") {
		$k = $k * 1.609344;
	}else if ($unit == "N") {
		$k = $k * 0.8684;
	}
	
	return "( ".$k." * acos( cos(radians(".$lat1.")) * cos( radians(`".$lat_field."`)) * cos( radians(`".$lon_field."`) - radians(".$lon1.")) + sin(radians(".$lat1.")) * sin(radians(`".$lat_field."`)) ) )";
}

/* Usage of distance_field_mysql function */
$query = "select ".distance_field_mysql(36.589, 65.489, 'location.latitude', 'location.longitude', 'K')." as `distance` from location where ".distance_field_mysql(36.589, 65.489, 'location.latitude', 'location.longitude', 'K')." < 200";