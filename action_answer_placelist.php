<?php
	if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
    }
	$res = file_get_contents("https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=".$_GET['action']."&radius=5000&types=food&key=AIzaSyAZwbQCDTf-AKn0dvdNahrgXOqkZQTydTQ");
	$jsonContent = json_decode($res, true);
	foreach ($jsonContent['results'] as $result) {
    	// now you have the $result array that contains the location of the place
    	// and the name ($result['formatted_address'], $result['name']) and other data.
    	if(isset($result['photos']))
		{
			foreach($result['photos'] as $r)
    		{	
                if(in_array("restaurant", $result['types']))
                {
                    $location = $result['geometry']['location']['lat'].",".$result['geometry']['location']['lng'];
                    $spacename = str_replace(" ", "+", $result['name']);
                    $spaceaddress = str_replace(" ", "+", $result['vicinity']);
                    $location = explode(",", $_GET['action']);
                    $lat1 = floatval($location[0]);
                    $long1 = floatval($location[1]);
                    $lat2 = floatval($result['geometry']['location']['lat']);
                    $long2 = floatval($result['geometry']['location']['lng']);
                    $loc = "http://www.google.com/maps/dir/".$_GET['action']."/".$spacename.",+".$spaceaddress;
    			    echo "<img src=\"https://maps.googleapis.com/maps/api/place/photo?key=AIzaSyDsBsq9Dei-OnXAYzrSZHC2s6Mvx8_XCxo&photoreference=".$r['photo_reference']."&maxheight=200\"><br>".$result['name']." ".distance($lat1,$long1,$lat2,$long2)."`".$result['vicinity']."ccc".$loc.";";	
                    echo $result['name']."ccc".$result['']
                }
    		}
    	}
    	else
    	{
            $location = $result['geometry']['location']['lat'].",".$result['geometry']['location']['lng'];
            $spacename = str_replace(" ", "+", $result['name']);
            $spaceaddress = str_replace(" ", "+", $result['vicinity']);
            $loc = "http://www.google.com/maps/dir/".$_GET['action']."/".$spacename.",+".$spaceaddress;
            $dist = distance()
			echo "<img src=\"".$result['icon']."\" height=\"200\"><br>".$result['name']."`".$result['vicinity']."ccc".$loc.";";
    	}
	}
    function distance($lat1, $lon1, $lat2, $lon2, $unit) {
  $theta = $lon1 - $lon2;
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
  $dist = acos($dist);
  $dist = rad2deg($dist);
  $miles = $dist * 60 * 1.1515;
  $unit = strtoupper($unit);
  if ($unit == "K") {
    return ($miles * 1.609344);
  } else if ($unit == "N") {
      return ($miles * 0.8684);
    } else {
        return $miles;
      }
}

?>
35.109052,-80.748268
