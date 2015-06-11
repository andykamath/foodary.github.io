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
                    $loc = "http://www.google.com/maps/dir/".$_GET['action']."/".$spacename.",+".$spaceaddress;
    			    echo "<img src=\"https://maps.googleapis.com/maps/api/place/photo?key=AIzaSyDsBsq9Dei-OnXAYzrSZHC2s6Mvx8_XCxo&photoreference=".$r['photo_reference']."&maxheight=200\"><br>".$result['name']."`".$result['vicinity']."ccc".$loc.";";	
                }
    		}
    	}
    	else
    	{
            $location = $result['geometry']['location']['lat'].",".$result['geometry']['location']['lng'];
            $spacename = str_replace(" ", "+", $result['name']);
            $spaceaddress = str_replace(" ", "+", $result['vicinity']);
            $loc = "http://www.google.com/maps/dir/".$_GET['action']."/".$spacename.",+".$spaceaddress;
			echo "<img src=\"".$result['icon']."\" height=\"200\"><br>".$result['name']."`".$result['vicinity']."ccc".$loc.";";
    	}
	}
?>
35.109052,-80.748268
