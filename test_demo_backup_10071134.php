<?php
session_start();
$user_id = $_SESSION['session_user_id'];
echo "<pre>";
print_r($_SESSION);
echo "</pre>";
include("db.php");

if (isset($_REQUEST['d_id'])) {
$d_id =  $_REQUEST['d_id'];

$dlt_sql = "UPDATE site_search_result SET is_delete = '1' WHERE id = '$d_id' AND user_id = '$user_id'";
$dlt_query = mysqli_query($conn, $dlt_sql);
}

if (isset($_REQUEST['submit'])) {
	$features = $_REQUEST['features'];
	
}


?>

<!DOCTYPE html >

	<html xmlns="https://www.w3.org/1999/xhtml">

	<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<meta name="language" content="en" />

	<title>Lot & Sites</title>

	<link rel="stylesheet" type="text/css" href="../stylesheet.css" />

	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

	<script type="text/javascript" src="../scripts/jquery-1.9.1.min.js"></script>

	<script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js"></script>

	<script type="text/javascript" src="../scripts/isotope.pkgd.js"></script>

	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<style type="text/css">

	.messageenquiryfield  { 
		margin-bottom: 1em;
	}
	.siteDiv{    
		border: 1px solid rgb(204, 204, 204);
		padding: 1em;
		margin-bottom: 1em;
	}
	.instaTD{
		border: 1px solid;
	}
	.col_2{
		width: 49%;
		display: inline-block;
		vertical-align: top;
	}
	.col_3{
		width: 30%;
		display: inline-block;
		vertical-align: top;
	}
	.col_5{
		width: 19%;
		display: inline-block;
		vertical-align: top;
		text-align: center;
	}
	.div_col_5{
		margin: 35px 0;
	}
	/* Accordion start */
	.accordion {
		border: 1px solid #cccccc;
		color: #444;
		cursor: pointer;
		padding: 8px;
		width: 100%;
		text-align: left;
		padding-left: 25px;
	}

	.accordion:after {
		content: '\002B\00a0\00a0';
		color: #777;
		font-weight: bold;
		float: right;
		margin-left: 5px;
	}

	.active:after {
	  content: "\2212\00a0\00a0";
	}

	.panel {
		padding: 0 18px;
		background-color: white;
		max-height: 0;
		overflow: hidden;
	}
	.site_img {
		height: 70px;
		width: 70px;
	}
	.info_content {
		height: 300px;
		width: 300px;
	}
	img {
		height: 35px;
		width: 20px;
	}
	/* Accordion end */
	</style>
	
		<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCVWIZkVmiaI7t0R_5Lz-6lDQNw53Wgm04&callback=initMap"></script>
	
	</head>

	<body>

<script type="text/javascript">

function initMap() {

    var map;
    var bounds = new google.maps.LatLngBounds();

    var mapOptions = {
       
        mapTypeId: 'roadmap'
    };
                    
    // Display a map on the web page

    map = new google.maps.Map(document.getElementById("map"), mapOptions);
    map.setTilt(50);
    // var input = 'rajkot';
    // var geocoder = new google.map.geocode();

    /*geocoder.geocode( { 'input': input}, function(results, status) {
          var location = results[0].geometry.location;
          alert('LAT: ' + location.lat() + ' LANG: ' + location.lng());
        });*/
        
   	/*map.addListener ('bounds_changed' , function() {
   		map.getBounds();
   	});*/

        <?php
        	
	    	$lot_site_sql = "SELECT sites.id AS Uid, lot.lot_id AS lid, lot.lot_name, lot.lot_address, lot.lot_coordinates, sites.site_id, sites.lot_id AS sid, sites.image, sites.type, sites.other_type FROM lot JOIN sites ON lot.lot_id = sites.lot_id";

		$query = mysqli_query($conn, $lot_site_sql);
		$markers = array();
		while ($lot_site = mysqli_fetch_assoc($query)) {
			$cordin = explode(", ", $lot_site['lot_coordinates']);
			$markers[ $lot_site['Uid'] ] ['lot_id'] = $lot_site['lid'];
			$markers[ $lot_site['Uid'] ] ['lat'] = $cordin[0];
			$markers[ $lot_site['Uid'] ] ['long'] = $cordin[1];
			$markers[ $lot_site['Uid'] ] ['name'] = $lot_site['lot_name'];
			$markers[ $lot_site['Uid'] ] ['address'] = $lot_site['lot_address'];
			$markers[ $lot_site['Uid'] ] ['image'] = $lot_site['image'];
			$markers[ $lot_site['Uid'] ] ['site_id'] = $lot_site['site_id'];
		}

	    ?>
    // Multiple markers location, latitude, and longitude
    var markers = [ 
    	<?php 

    	// $marker_pin = 'https://www.streetfightermedia.com.au/runsheets/images/pin_red.png';
    		foreach($markers as $key => $value){
    			if (empty($value['lat']) || empty($value['long']))
    				continue;
    			$map_site_id = $value['lot_id'];
    			$map_sql = "SELECT * FROM site_search_result WHERE site_id = '$map_site_id' AND is_delete = 0 AND user_id = '$user_id'";
    			$map_query = mysqli_query($conn, $map_sql);
    			$map_row = mysqli_fetch_assoc($map_query);

    			if ($map_row['type'] == 'list') {
    				$marker_pin = 'https://www.streetfightermedia.com.au/runsheets/images/pin_green.png';
    			} elseif ($map_row['type'] == 'stared') {
    				$marker_pin = 'https://www.streetfightermedia.com.au/runsheets/images/pin_yellow.png';
    			} else {
    				$marker_pin = 'https://www.streetfightermedia.com.au/runsheets/images/pin_red.png';
    			}

    			echo "['".$value['lot_id']."', '".$value['lat']."', '".$value['long']."', '".$value['name']."', '".$marker_pin."'],";
    		}
    	?>
	];

    // Info window content
    var infoWindowContent = [
    	<?php 
    		foreach($markers as $key => $value){
    			
    			$site_id = $value['lot_id'];
    			$check_sql = "SELECT * FROM site_search_result WHERE site_id = '$site_id' AND is_delete = '0' AND user_id = '$user_id'";
    			$check_query = mysqli_query($conn, $check_sql);
    			$type_result = mysqli_fetch_assoc($check_query);
    			$type = $type_result['type'];

    			if ($type == 'list') {
    				$list = 'checked';
    				$stared = '';
    			} elseif ($type == 'stared') {
    				$stared = 'checked';
    				$list = '';
    			} else {
    				$list = $stared = '';
    			}

    			$image = "uploads/" . $value['lot_id'] . "-" . $value['site_id'] . ".png";
    			$site_id = $value['lot_id'] . '-' . $value['site_id'];
    			$site_value = $value['lot_id'];
    			$url = "lot_id=" . $value['lot_id'] . "&site_id=" . $value['site_id'];
    			$asasTag =  '<div class="info_content">'.
    				'<h3 class = "site_id" data-myval="'. htmlspecialchars($site_value) .'">'.$site_id.' </h3>'.
    				'<p>'.$value['name'].'</p>'.
    				'<p>'.$value['address']. '</p>'.
    				'<p> <input type="checkbox" name="price" onclick = "availability()" '. $list .'> Check price and availability <br> </p>'.
					'<p> <input type="checkbox" name="stared" onclick = "stared()" '. $stared .'> Stared <br> </p>';
    				
    			if (file_exists($image)) {
    				$asasTag .='<img src = '.$image.' class="site_img">';
    			}
    			$asasTag .='<center><a href="https://www.streetfightermedia.com.au/streetposters/site_view.php?'.$url.'" class="button" style="margin-bottom:0;">VIEW DETAILS</a></center>'.
    			'</div>';

    			echo "['".
    			$asasTag
    			."'],";
    		}
    	?>
    ];
        
       
    var infoWindow = new google.maps.InfoWindow(), marker, i;
    
    // Place each marker on the map  
    for( i = 0; i < markers.length; i++ ) {
        var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
        bounds.extend(position);
        marker = new google.maps.Marker({
            position: position,
            map: map,
			icon: markers[i][4],
			label : markers[i][3],
            title: markers[i][0]
        });
        
        // Add info window to marker    
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
                infoWindow.setContent(infoWindowContent[i][0]);
                infoWindow.open(map, marker);
            }
        })(marker, i));

        // Center the map to fit all markers on the screen
       // if (input.geometry) {
              // Only geocodes have viewport.
             /* bounds.union(input.geometry.viewport);
            } else {
              bounds.extend(input.geometry.location);
            }*/
        map.fitBounds(bounds);
    }

    // Set zoom level
    var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
        this.setZoom(12);

        google.maps.event.removeListener(boundsListener);
    });
    
}
 
</script>

<?php include("../header.php"); ?>

	<div class="container">
		<div class="col-md-6 col-sm-12">
			<h2>Map of Sites</h2>
			<div id="map"></div>
			<div class="heading">
				<h3>Refine fectures</h3>
			</div>
			<div class="refine">
	<form action="" method="POST">
		<p class="line">
			<input type="checkbox" name="features[]" value="well_lit"> <span style="font-size:large"> Well Lit </span><br>
		</p>

		<p class="line">
			<input type="checkbox" name="features[]" value="main_road"> <span style="font-size:large"> Main Road </span><br>
		</p>

		<p class="line">
			<input type="checkbox" name="features[]" value="near_train_station"> <span style="font-size:large"> Near Train Station </span><br>
		</p>

		<p class="line">
			<input type="checkbox" name="features[]" value="near_bus_stop"> <span style="font-size:large"> Near Bus Stop </span><br>
		</p>

		<p class="line">
			<input type="checkbox" name="features[]" value="near_light_rail_station"> <span style="font-size:large"> Near Light Rail Station </span><br>
		</p>

		<p class="line">
			<input type="checkbox" name="features[]" value="near_major_venue_or_attraction"> <span style="font-size:large"> Near Major Venue Or Attraction </span><br>
		</p>

		<p class="line">
			<input type="checkbox" name="features[]" value="foot_traffic"> <span style="font-size:large"> Foot Traffic </span><br>
		</p>

		<p class="line">
			<input type="checkbox" name="features[]" value="cbd"> <span style="font-size:large"> CBD </span><br>
		</p>

			</div>
			<div class="button">
				
				<input type="submit" name="submit" class="button">
			</div>
	</form>	
			<hr class="headerhr">

			<div class="search">
				<div class="heading">
					<h3>Change your search area</h3>
				</div>
				<p class="line">
					<span style="font-size:large"> 
					<input type="text" name="searchBox" id="search_val" class="runsheetform">			</span><br>
					<span style="font-size:large"> 
							</span><br>
				</p>
				<div class="button">
					<a href="#" onclick="initMap()" class="button" style="margin-bottom:0;">SUBMIT</a>
				</div>
			</div>
		</div>


		<div class="col-md-6 col-sm-12">
			<div class="button">
				<div class="button">
					<center><a href="#" class="button" style="margin-bottom:0;">MAP VIEW</a>
					<a href="#" class="button" style="margin-bottom:0;">LIST VIEW</a></center>
				</div>
				
			</div>
			<div class="location_info">

				<p class="line"> <img src="https://www.streetfightermedia.com.au/runsheets/images/pin_vayolate.png"> Matches your availability</p>
				<p class="line"> <img src="https://www.streetfightermedia.com.au/runsheets/images/pin_sblue.png"> Near match </p>
				<p class="line"> <img src="https://www.streetfightermedia.com.au/runsheets/images/pin_red.png"> Other site </p>
				<p class="line"> <img src="https://www.streetfightermedia.com.au/runsheets/images/pin_yellow.png"> Stared </p>
				<p class="line"> <img src="https://www.streetfightermedia.com.au/runsheets/images/pin_green.png"> On your price list </p>
			</div>

			<hr class="headerhr">

			<div class="heading" >
				<h3>Your list of sites to check price and availability</h3>
			</div>

			<div class="site_list" id="site_availability_list" >
					<?php
						$list_sql = "SELECT lot.lot_id, lot.lot_name, lot.lot_address, site_search_result.id, site_search_result.site_id, site_search_result.type FROM lot JOIN site_search_result ON lot.lot_id = site_search_result.site_id WHERE type = 'list' AND is_delete = '0' AND user_id = '$user_id'";

						
						$list_query = mysqli_query($conn, $list_sql);
						while ($list = mysqli_fetch_assoc($list_query)) {
 						$site_name = $list['lot_name'];
						$site_address = $list['lot_address'];
						$type = $list['type'];
						$d_id = $list['id'];
					?>
						<p class="line"><img src="https://www.streetfightermedia.com.au/runsheets/images/pin_green.png"><a href="https://www.streetfightermedia.com.au/streetposters/lot_all_view.php?d_id=<?php echo $d_id; ?>"><i class="fa fa-times fa-2x" style="color: red;"></i></a> <a href="#"><b><?php echo $site_name; ?></b></a> <br><?php echo $site_address; ?> </p>
					<?php
						} 
					?>
				<div class="button">
					<a href="#" class="button" style="margin-bottom:0;">SEND REQUEST</a>
				</div>
			</div>

			<hr class="headerhr">

			<div class="heading">
				<h3>Stared</h3>
			</div>

			<div class="site_Stared" id = "site_availability_stared">
				
				<?php
						$list_sql = "SELECT lot.lot_id, lot.lot_name, lot.lot_address, site_search_result.id, site_search_result.site_id, site_search_result.type FROM lot JOIN site_search_result ON lot.lot_id = site_search_result.site_id WHERE type = 'stared' AND is_delete = '0' AND user_id = '$user_id'";
						$list_query = mysqli_query($conn, $list_sql);
						while ($list = mysqli_fetch_assoc($list_query)) {
 						$site_name = $list['lot_name'];
						$site_address = $list['lot_address'];
						$type = $list['type'];
						$d_id = $list['id'];
					?>
						<p class="line"><img src="https://www.streetfightermedia.com.au/runsheets/images/pin_yellow.png"><a href="https://www.streetfightermedia.com.au/streetposters/lot_all_view.php?d_id=<?php echo $d_id; ?>"><i class="fa fa-times fa-2x" style="color: red;"></i></a> <a href="#"><b><?php echo $site_name; ?></b></a> <br><?php echo $site_address; ?> </p>
					<?php
						} 
					?>
				<div class="button">
					<center><a href="#" class="button" style="margin-bottom:0;">Request Prices & Availability</a><br><br>
					<a href="#" class="button" style="margin-bottom:0;">SAVE THIS SEARCH</a></center>
				</div>

			</div>

			<hr class="headerhr">

			<div class="heading">
				<h3> Match your availability</h3>
			</div>

			<div class="site_list">
				<p class="line"><img src="https://www.streetfightermedia.com.au/runsheets/icons/pin_green.png"><a href="#"><i class="fa fa-times fa-2x" style="color: red;"></i></a> <a href="#"><b>Site Name</b></a> <br> about site</p>
				<p class="line"><img src="https://www.streetfightermedia.com.au/runsheets/icons/pin_green.png"><a href="#"><i class="fa fa-times fa-2x" style="color: red;"></i></a> <a href="#"><b>Site Name</b></a> <br> about site</p>
				<p class="line"><img src="https://www.streetfightermedia.com.au/runsheets/icons/pin_green.png"><a href="#"><i class="fa fa-times fa-2x" style="color: red;"></i></a> <a href="#"><b>Site Name</b></a> <br> about site</p>
				
			</div>

			<hr class="headerhr">

			<div class="heading">
				<h3>Near matches</h3>
			</div>

			<div class="site_list">
				<p class="line"><img src="https://www.streetfightermedia.com.au/runsheets/icons/pin_green.png"><a href="#"><i class="fa fa-times fa-2x" style="color: red;"></i></a> <a href="#"><b>Site Name</b></a> <br> about site</p>
				<p class="line"><img src="https://www.streetfightermedia.com.au/runsheets/icons/pin_green.png"><a href="#"><i class="fa fa-times fa-2x" style="color: red;"></i></a> <a href="#"><b>Site Name</b></a> <br> about site</p>
				<p class="line"><img src="https://www.streetfightermedia.com.au/runsheets/icons/pin_green.png"><a href="#"><i class="fa fa-times fa-2x" style="color: red;"></i></a> <a href="#"><b>Site Name</b></a> <br> about site</p>

			</div>

		</div>
	</div>
		
<?php include("../footer.php"); ?>

<script type="text/javascript">
	// $('#mydiv').attr('data-myval');
	function availability() {
		
		var site_id = $('.site_id').data('myval');
		var user_id = <?php echo $user_id; ?>;
		var s_type = "list";
		var dataString = 'site_id='+ site_id + '&s_type='+ s_type + '&user_id='+ user_id;

		$.ajax({
            type: "POST",
            url: "site_availability.php",
            data: dataString,
            cache: false,
            success: function(result) {
            	console.log(result);
                //$("#display").html(result);
                location.reload(true);
            }
        });
    return false;
	}

	function stared() {

		var site_id = $('.site_id').data('myval');
		var user_id = <?php echo $user_id; ?>;
		var s_type = "stared";
		var dataString = 'site_id='+ site_id + '&s_type='+ s_type + '&user_id='+ user_id;

		$.ajax({
            type: "POST",
            url: "site_availability.php",
            data: dataString,
            cache: false,
            success: function(result) {
            	console.log(result);
                location.reload(true);
            }
        });
    return false;
	}

	/*function search() {
		var search_val = $('#search_val').val();

		$.ajax({
			type: "POST",

		})
	}*/
</script>
</body>
</html>