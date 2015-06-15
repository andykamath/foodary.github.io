<?php
	header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Credentials: true");
    	header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
    	header('Access-Control-Max-Age: 1000');
    	header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
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
            if($result['opening_hours']['open_now'])
            {
            	$open = "Open at this time";
            }
            else
            {
            	$open = "Not open currently"
            }
	    echo "<img src=\"".$result['icon']."\" height=\"200\"><br>".$result['name']."`".$result['vicinity']."<br>".$result['rating']."/5<br>Price: ".$price."/3<br>".$open."ccc".$loc.";";
    	}
	}
?>
