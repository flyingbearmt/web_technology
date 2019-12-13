<!DOCTYPE html>
<html>
<head>
	<title>Weather Forecast</title>
	<style type="text/css">
	#maincontent{
		background-color: #2CA132;
		width: 900px;
		height: 400px;
		color:white;
		margin-left: auto;
		margin-right: auto;
		border-radius: 10px;
	}
	input:disabled{
		background: #ebebeb;
	}
	h2{
		text-align: center;
		padding-top: 50px;
	}
	form span{
		display:inline-block; 
		width: 60px;
	}
	.showblock{
		display: inline;
		width: 300px;
		float: left;

	}
	#search{
		margin-left: 10px;

	}
	#currLocation{
		float: left;
		position: relative;
		top: -30px;
	}
	#vertical{
		display: inline;
		/*float: left;*/
		background-color: white;
		width: 5px;
		height: 250px;
		margin: 0 40px 0;
		position: relative;
		top: -30px;
	}
	#button{
		display: block;
		position: relative;
		float: left;
		top: 230px;
		left: 00px;
		border-radius: 2px;
	}
	#button input{
		border-radius: 5px;
	}
	.hiden{
		display: none;
	}

	#error_alert{
		background-color: #EEEEEE;
		width: 300px;
		margin: 2px auto 2px;
		border: grey 1px solid;
	}
	.curweather{
		text-align: center;
		width: 100%;
	}

	table tr th,td{
		border: 1px solid #4393BF;
		text-align: center;
		color: white;
	}
	.weatherintable{
		width: 50px;
	}
	#dailyWeatherDetail{
		width: 600px;
		height: 500px;
		background-color: #9DCAD4;
		border-radius: 10px;
		margin: 0 auto;
	}
	#dailyWeatherDetail div{
		display: inline-block;
	}
	#summaryweather{
		top: -100px;
		position: relative;
		width: 40%;
		font-size: 80px;
		margin-left: 40px;
	}

	#weatherPicture{
		width: 40%;
		/*float: right;*/
		left: 300px;
		/*position: relative;*/
	}
	#weatherPicture img{
		width: 100%; 
		margin: 20px;
	}
	#detailedtable{
		position: relative;
		font-size: 25px;
		left: 200px;
		top: -50px
	}
	#detailedtable tr :first-child{
		text-align: right;
	}
	#detailedtable tr :nth-child(2){
		text-align: left;
	}
	#detailedtable td{
		border: 0px;
	}
	#hourlyweather{
		width: 1000px;
		margin: 0 auto;
		text-align: center;
	}
	#hourlyweather img{
		width: 50px;

	}
	</style>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>
<body>
	<?php 
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$geokey = $street = $city = $state = $geoReqUel = "";
		$curLoc ="";
		$iscurLoc= $_POST["curLoc"];
		$curLocLat= $_POST["curLoclat"];
		$curLocLon= $_POST["curLoclon"];
		$geokey = "AIzaSyDOK6lrRZ-TF-UzUO-zbZebcEvez6wE8Zk";
		$street = $_POST["street"];
		$city = $_POST["city"];
		$state = $_POST["state"];

		$geoReqUel = "https://maps.googleapis.com/maps/api/geocode/xml?address=[".rawurlencode($street).",".rawurlencode($city).",".rawurlencode($state)."]&key=".$geokey;
		// get the xml file from google api;
		$geocontent = file_get_contents($geoReqUel);
		$handle = simplexml_load_string($geocontent);
		$geoLoc = $handle->result->geometry->location;
		// if (empty($geoLoc) && $iscurLoc =="false"){
		// 	$notvalid = true;	
		// }else{
		// 	$notvalid = false;
		// }
		// this is for those not use curLoc
		if (!empty($iscurLoc) && $iscurLoc == "true") {
			$lat = $curLocLat;
			$lng = $curLocLon;
			$currentCity = $_POST["currentCity"];
		} else {	
			$lat = $geoLoc->lat;
			$lng = $geoLoc->lng;
		}
	}
	?>
	<div id="maincontent">
		<p style="font-style: italic; font-size: 30px; text-align: center;width: 100%; padding-top: 20px;"> Weather Search</p>
		<div id="search">
			<form method="post" action="<?php echo $_SERVER["PHP_SELF"] ?>" onsubmit="return valid()">
				<div class="showblock" style="padding-left: 20px;">
				<span>Street:</span><input type="text" name="street" id="curStreet" value="<?php echo $street; ?>"><?php if ($notvalid == true) { echo "not valid city";} ?><br>
				<span>City:</span><input type="text" name="city" id="curCity" value="<?php echo $city; ?>"><?php if ($notvalid == true) { echo "not valid city";} ?><br>
				<span>State:</span><select name="state" id="curState" value="<?php echo $state ?>">
					<option <?php if(!isset($state)) echo "selected = \"selected\""?>>states</option>
					<option>-----</option>
					<option value = "AL" <?php if(isset($state) && $state == "AL") echo "selected = \"selected\""?>>Alabama</option>
					<option value = "AK" <?php if(isset($state) && $state == "AK") echo "selected = \"selected\""?>> Alaska</option>
					<option value = "AS" <?php if(isset($state) && $state == "AS") echo "selected = \"selected\""?>> American Samoa</option>
					<option value = "AZ" <?php if(isset($state) && $state == "AZ") echo "selected = \"selected\""?>> Arizona</option>
					<option value = "AR" <?php if(isset($state) && $state == "AR") echo "selected = \"selected\""?>> Arkansas</option>
					<option value = "CA" <?php if(isset($state) && $state == "CA") echo "selected = \"selected\""?>> California</option>
					<option value = "CO" <?php if(isset($state) && $state == "CO") echo "selected = \"selected\""?>> Colorado</option>
					<option value = "CT" <?php if(isset($state) && $state == "CT") echo "selected = \"selected\""?>> Connecticut</option>
					<option value = "DE" <?php if(isset($state) && $state == "DE") echo "selected = \"selected\""?>> Delaware</option>
					<option value = "DC" <?php if(isset($state) && $state == "DC") echo "selected = \"selected\""?>> District Of Columbia</option>
					<option value = "FM" <?php if(isset($state) && $state == "FM") echo "selected = \"selected\""?>> Federated States Of Micronesia</option>
					<option value = "FL" <?php if(isset($state) && $state == "FL") echo "selected = \"selected\""?>> Florida</option>
					<option value = "GA" <?php if(isset($state) && $state == "GA") echo "selected = \"selected\""?>> Georgia</option>
					<option value = "GU" <?php if(isset($state) && $state == "GU") echo "selected = \"selected\""?>> Guam</option>
					<option value = "HI" <?php if(isset($state) && $state == "HI") echo "selected = \"selected\""?>> Hawaii</option>
					<option value = "ID" <?php if(isset($state) && $state == "ID") echo "selected = \"selected\""?>> Idaho</option>
					<option value = "IL" <?php if(isset($state) && $state == "IL") echo "selected = \"selected\""?>> Illinois</option>
					<option value = "IN" <?php if(isset($state) && $state == "IN") echo "selected = \"selected\""?>> Indiana</option>
					<option value = "IA" <?php if(isset($state) && $state == "IA") echo "selected = \"selected\""?>> Iowa</option>
					<option value = "KS" <?php if(isset($state) && $state == "KS") echo "selected = \"selected\""?>> Kansas</option>
					<option value = "KY" <?php if(isset($state) && $state == "KY") echo "selected = \"selected\""?>> Kentucky</option>
					<option value = "LA" <?php if(isset($state) && $state == "LA") echo "selected = \"selected\""?>> Louisiana</option>
					<option value = "ME" <?php if(isset($state) && $state == "ME") echo "selected = \"selected\""?>> Maine</option>
					<option value = "MH" <?php if(isset($state) && $state == "MH") echo "selected = \"selected\""?>> Marshall Islands</option>
					<option value = "MD" <?php if(isset($state) && $state == "MD") echo "selected = \"selected\""?>> Maryland</option>
					<option value = "MA" <?php if(isset($state) && $state == "MA") echo "selected = \"selected\""?>> Massachusetts</option>
					<option value = "MI" <?php if(isset($state) && $state == "MI") echo "selected = \"selected\""?>> Michigan</option>
					<option value = "MN" <?php if(isset($state) && $state == "MN") echo "selected = \"selected\""?>> Minnesota</option>
					<option value = "MS" <?php if(isset($state) && $state == "MS") echo "selected = \"selected\""?>> Mississippi</option>
					<option value = "MO" <?php if(isset($state) && $state == "MO") echo "selected = \"selected\""?>> Missouri</option>
					<option value = "MT" <?php if(isset($state) && $state == "MT") echo "selected = \"selected\""?>> Montana</option>
					<option value = "NE" <?php if(isset($state) && $state == "NE") echo "selected = \"selected\""?>> Nebraska</option>
					<option value = "NV" <?php if(isset($state) && $state == "NV") echo "selected = \"selected\""?>> Nevada</option>
					<option value = "NH" <?php if(isset($state) && $state == "NH") echo "selected = \"selected\""?>> New Hampshire</option>
					<option value = "NJ" <?php if(isset($state) && $state == "NJ") echo "selected = \"selected\""?>> New Jersey</option>
					<option value = "NM" <?php if(isset($state) && $state == "NM") echo "selected = \"selected\""?>> New Mexico</option>
					<option value = "NY" <?php if(isset($state) && $state == "NY") echo "selected = \"selected\""?>> New York</option>
					<option value = "NC" <?php if(isset($state) && $state == "NC") echo "selected = \"selected\""?>> North Carolina</option>
					<option value = "ND" <?php if(isset($state) && $state == "ND") echo "selected = \"selected\""?>> North Dakota</option>
					<option value = "MP" <?php if(isset($state) && $state == "MP") echo "selected = \"selected\""?>> Northern Mariana Islands</option>
					<option value = "OH" <?php if(isset($state) && $state == "OH") echo "selected = \"selected\""?>> Ohio</option>
					<option value = "OK" <?php if(isset($state) && $state == "OK") echo "selected = \"selected\""?>> Oklahoma</option>
					<option value = "OR" <?php if(isset($state) && $state == "OR") echo "selected = \"selected\""?>> Oregon</option>
					<option value = "PW" <?php if(isset($state) && $state == "PW") echo "selected = \"selected\""?>> Palau</option>
					<option value = "PA" <?php if(isset($state) && $state == "PA") echo "selected = \"selected\""?>> Pennsylvania</option>
					<option value = "PR" <?php if(isset($state) && $state == "PR") echo "selected = \"selected\""?>> Puerto Rico</option>
					<option value = "RI" <?php if(isset($state) && $state == "RI") echo "selected = \"selected\""?>> Rhode Island</option>
					<option value = "SC" <?php if(isset($state) && $state == "SC") echo "selected = \"selected\""?>> South Carolina</option>
					<option value = "SD" <?php if(isset($state) && $state == "SD") echo "selected = \"selected\""?>> South Dakota</option>
					<option value = "TN" <?php if(isset($state) && $state == "TN") echo "selected = \"selected\""?>> Tennessee</option>
					<option value = "TX" <?php if(isset($state) && $state == "TX") echo "selected = \"selected\""?>> Texas</option>
					<option value = "UT" <?php if(isset($state) && $state == "UT") echo "selected = \"selected\""?>> Utah</option>
					<option value = "VT" <?php if(isset($state) && $state == "VT") echo "selected = \"selected\""?>> Vermont</option>
					<option value = "VI" <?php if(isset($state) && $state == "VI") echo "selected = \"selected\""?>> Virgin Islands</option>
					<option value = "VA" <?php if(isset($state) && $state == "VA") echo "selected = \"selected\""?>> Virginia</option>
					<option value = "WA" <?php if(isset($state) && $state == "WA") echo "selected = \"selected\""?>> Washington</option>
					<option value = "WV" <?php if(isset($state) && $state == "WV") echo "selected = \"selected\""?>> West Virginia</option>
					<option value = "WI" <?php if(isset($state) && $state == "WI") echo "selected = \"selected\""?>> Wisconsin</option>
					<option value = "WY" <?php if(isset($state) && $state == "WY") echo "selected = \"selected\""?>> Wyoming</option>
				</select>
				<br>
				<br>
				</div>
				<br>
				<div id="button">
					<input type="submit" value="search">
					<input type="reset" value="clear" onclick="clearall()">
				</div>
				<div class="showblock" id="vertical">
					<br>
				</div>
				<div class="showblock" id="currLocation" >
					<input type="checkbox" name="curLoc" id="curLoc" onchange="disableInput()" <?php if (!empty($iscurLoc) && $iscurLoc == "true") {
						echo "checked";
					}?> >Current Location
					<input type="text" name="curLoclat" id="curLoclat"  <?php  echo "value = \"$lat\"";?> hidden>
					<input type="text" name="curLoclon" id="curLoclon" <?php  echo "value = \"$lng\"";?> hidden>
					<input type="text" name="date" id="date" hidden>
					<input type="text" name="isdetailed" id="isdetailed" hidden>
					<input type="text" name="currentCity" id="currentCity" <?php  echo "value = \"$currentCity\"";?> hidden>
				</div>
				
			</form>
		</div>
	</div>
	<div id="error_alert" class="hiden">
		<p>Please check the input address</p>
	</div>
	<?php 
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// get the information from api.forecast.io
		$forecastKey  = "5ae1665ee0a92bd7bd8279c1e80c8896";
		if (!empty($lat)&& !empty($lng)) {
			$forcastApi = "https://api.forecast.io/forecast/".$forecastKey."/".rawurlencode($lat).",".rawurlencode($lng)."?exclude=minutely,hourly,alerts,flags";
			$content =json_decode(file_get_contents($forcastApi));
		}
		
		if (isset($content) && (isset($_POST["isdetailed"]) && $_POST["isdetailed"] != "true")) {
			// for today weather forecast report tab
			echo "<div id=\"weekWeather\">";
			echo "<div id=\"currentWeather\" style=\"background-color: #52BCF2; width: 500px; height:300px; color: white; margin:30px auto;padding:20px; border-radius:20px;\">";
			function getCity($city,$currentCity){
				if($city != null) {
					return $city;
				} else{
					return $currentCity;
				}
			}
			echo "<span style=\"font-size:40px;\">".getCity($city,$currentCity)."</span><br>";
			echo $content->timezone."<br>";
			echo "<span style=\"font-size:80px\">".round($content->currently->temperature,0)."</span><img width=\"15px\" src=\"https://cdn3.iconfinder.com/data/icons/virtual-notebook/16/button_shape_oval-512.png\" style=\" position: relative; top: -40px;\"><span style=\"font-size:40px;\">F</span><br>";
			echo "<span style=\"font-size:40px;\">".$content->currently->summary."</span><br>";
			// humidity
			if ($content->currently->humidity != 0) {
				echo "<div style=\"display: inline-block; width: 15%; margin:0px 2px;\">";
				echo "<img src=\"https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-16-512.png\" width=\"100%\" title =\"Humidity\"><br>";
				echo "<div class=\"curweather\">".$content->currently->humidity."</div>";
				echo "</div>";
			}
			// presure
			if ($content->currently->pressure != 0) {
				echo "<div style=\"display: inline-block; width: 15%; margin:0px 2px;\">";
				echo "<img src=\"https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-25-512.png\" width=\"100%\" title =\"Pressure\"><br>";
				echo "<div class=\"curweather\">".$content->currently->pressure."</div>";
				echo "</div>";
			}
			// windspeed
			echo "<div style=\"display: inline-block; width: 15%; margin:0px 2px;\">";
			echo "<img src=\"https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-27-512.png\" width=\"100%\" title =\"WindSpeed\"><br>";
			echo "<div class=\"curweather\">".$content->currently->windSpeed."</div>";
			echo "</div>";
			// visibility	
			echo "<div style=\"display: inline-block; width: 15%; margin:0px 2px;\">";
			echo "<img src=\"https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-30-512.png\" width=\"100%\" title =\"Visibility\"><br>";
			echo "<div class=\"curweather\">".$content->currently->visibility."</div>";
			echo "</div>";
			// cloudCover
			if ($content->currently->cloudCover != 0) {
				echo "<div style=\"display: inline-block; width: 15%; margin:0px 2px;\">";
				echo "<img src=\"https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-28-512.png\" width=\"100%\" title =\"CloudCover\"><br>";
				echo "<div class=\"curweather\">".$content->currently->cloudCover."</div>";
				echo "</div>";
			}
			// ozone
			if ($content->currently->ozone != 0) {
				echo "<div style=\"display: inline-block; width: 15%; margin:0px 2px;\">";
				echo "<img src=\"https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-24-512.png\" width=\"100%\" title =\"Ozone\"><br>";
				echo "<div class=\"curweather\">".$content->currently->ozone."</div>";
				echo "</div>";
				echo "</div>";
			}
			// start weather table div
			echo "<div id=\"weatherTable\">";
			echo "<table style=\"background-color: #93C1F3; border: #4393BF; width: 1000px; border-collapse: collapse; margin: 0px auto;\">";
			echo " <tr>";
			echo "<th>Date</th>";
			echo "<th>Status</th>";
			echo "<th>Summary</th>";
			echo "<th>TemperatureHigh</th>";
			echo "<th>TemperatureLow</th>";
			echo "<th>Wind Speed</th>";
			echo "</tr><tr>";
			$daily = $content->daily->data;
			// loop for daily forecast
			for ($i=0; $i <sizeof($daily) ; $i++) { 
				echo "<tr>";
				// date
				echo "<td>"; 
				echo date('Y-m-d',$daily[$i]->time);
				echo "</td>";
				// Status
				echo "<td>";
				switch ($daily[$i]->icon) {
					case 'clear-day':
				 		echo "<img src=\"https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-12-512.png\" class=\"weatherintable\">";
					break;
					case 'clear-night':
				 		echo "<img src=\"https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-12-512.png\" class=\"weatherintable\">";
					break;
					case 'rain':
				 		echo "<img src=\"https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-04-512.png\" class=\"weatherintable\">";
					break;
					case 'snow':
				 		echo "<img src=\"https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-19-512.png\" class=\"weatherintable\">";
					break;
					case 'sleet':
				 		echo "<img src=\"https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-07-512.png\" class=\"weatherintable\">";
					break;
					case 'wind':
				 		echo "<img src=\"https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-27-512.png\" class=\"weatherintable\">";
					break;
					case 'fog':
				 		echo "<img src=\"https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-28-512.png\" class=\"weatherintable\">";
					break;
					case 'cloudy':
				 		echo "<img src=\"https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-01-512.png\" class=\"weatherintable\">";
					break;
					case 'partly-cloudy-day':
				 		echo "<img src=\"https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-02-512.png\" class=\"weatherintable\">";
					break;
					case 'partly-cloudy-night':
				 		echo "<img src=\"https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-02-512.png\" class=\"weatherintable\">";
					break;
				 	default:
				 		echo "<img src=\"https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-12-512.png\" class=\"weatherintable\">";
				 		break;
				 }
				echo "</td>";
				// summary
				echo "<td>";
				echo "<span onclick=detailWeather(".$daily[$i]->time.") style=\"cursor:pointer;\">".$daily[$i]->summary."</span>";
				echo "</td>";
				// TemperatureHigh
				echo "<td>";
				echo $daily[$i]->temperatureHigh;
				echo "</td>";
				// TemperatureLow
				echo "<td>";
				echo $daily[$i]->temperatureLow;
				echo "</td>";
				// windSpeed
				echo "<td>";
				echo $daily[$i]->windSpeed;
				echo "</td>";
				echo "</tr>";
			}
			echo "</tr></table>";
			echo "</div>";
			echo "</div>";
		}
	}

	?>

	<?php  
	// for detailed weather forcast
	if(isset($_POST["isdetailed"]) && $_POST["isdetailed"] == "true" ) {
		$forcastApi = "https://api.darksky.net/forecast/".$forecastKey."/".rawurlencode($_POST["curLoclat"]).",".rawurlencode($_POST["curLoclon"]).",".rawurlencode($_POST["date"])."?exclude=minutely";
		$content =json_decode(file_get_contents($forcastApi));
		// if i get the result
		if (isset($content)) {
			$dailyweather = $content->currently;
			echo "<h2 style =\" text-align: center;\">Daily Weather Detail</h2>";
			echo "<div id=\"dailyWeatherDetail\" style=\" color:white;\">";
			echo "<div id=\"summaryweather\">"."<span style=\"font-size:40px;\">".$dailyweather->summary."</span>";
			echo "<br>";
			echo intval($dailyweather->temperature)."<img width=\"15px\" src=\"https://cdn3.iconfinder.com/data/icons/virtual-notebook/16/button_shape_oval-512.png\" style=\" position: relative; top: -40px;\"><span style=\"font-size: 60px;\">F</span><br>";
			echo "</div>";
			echo "<div id=\"weatherPicture\" style=\"margin-top:20px;\">";
			function getWthRPic($wthr){
				switch ($wthr) {
					case 'clear-day':
					case 'clear-night':
						return "https://cdn3.iconfinder.com/data/icons/weather-344/142/sun-512.png";
						break;
					case 'rain':
						return "https://cdn3.iconfinder.com/data/icons/weather-344/142/rain-512.png";
						break;
					case 'snow':
						return "https://cdn3.iconfinder.com/data/icons/weather-344/142/snow-512.png";
						break;
					case 'sleet':
						return "https://cdn3.iconfinder.com/data/icons/weather-344/142/lightning-512.png";
						break;
					case 'wind':
						return "https://cdn4.iconfinder.com/data/icons/the-weather-is-nice-today/64/weather_10-512.png";
						break;
					case 'fog':
						return "https://cdn3.iconfinder.com/data/icons/weather-344/142/cloudy-512.png";
						break;
					case 'cloudy':
						return "https://cdn3.iconfinder.com/data/icons/weather-344/142/cloud-512.png";
						break;
					case 'partly-cloudy-day':
					case 'partly-cloudy-night':
						return "https://cdn3.iconfinder.com/data/icons/weather-344/142/sunny-512.png";
						break;
					default:
						return "https://cdn3.iconfinder.com/data/icons/weather-344/142/sun-512.png";
						break;
				}
			}
			echo "<img src=\"".getWthRPic($content->hourly->icon)."\">";
			echo "</div>";
			echo "<br>";
			echo "<div id=\"detailedtable\">";
			echo "<table>";
			echo "<tr>";
			echo "<td>Precipitation:</td>";
			function getPresepDes($pre){
				if ($pre <= 0.001) {
					return "None";
				}
				else if ($pre <=0.015) {
					return "Very Light";
				}
				else if ($pre <=0.05) {
					return "Light";
				}
				else if ($pre <=0.1) {
					return "Moderate";
				}
				else {
					return "Heavy";
				}

			}
			echo "<td>".getPresepDes($dailyweather->precipIntensity)."</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td>Chance of Rain:</td>";
			echo "<td>".(round(($dailyweather->precipProbability),2)*100)."%</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td>Wind Speed:</td>";
			echo "<td>".$dailyweather->windSpeed."mph</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td>Humidity:</td>";
			echo "<td>".(($dailyweather->humidity)*100)."%</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td>Visibility:</td>";
			echo "<td>".$dailyweather->visibility."mi</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td>Sunrise/Sunset:</td>";
			$sunriseTime = $content->daily->data[0]->sunriseTime;
			$sunsetTime = $content->daily->data[0]->sunsetTime;
			date('Y-m-d',$daily[$i]->time);
			function convertTime($time,$timeZone,$type){
				$datetime = new DateTime("@$time");
				$datetime->setTimezone(new DateTimeZone($timeZone));
				return $datetime->format($type);
			}
			echo "<td>".convertTime($sunriseTime,$content->timezone,"gA")."/".convertTime($sunsetTime,$content->timezone,"gA")."</td>";
			echo "</tr>";
			echo "</table>";
			echo "</div>";
			echo "</div>";
			echo "<div id=\"hourlyweather\">";
			echo "<h2 style =\" text-align: center;\">Day's Hourly Weather</h2>";
			echo "<img src=\"https://cdn4.iconfinder.com/data/icons/geosm-e-commerce/18/point-down-512.png\" onclick=\"showChart()\">";
			echo "</div>";
			$chartdata = $content->hourly->data;
			// do some js function
		}

	} 
	
	?>
	
</body>
<script type="text/javascript">
	google.charts.load('current', {'packages':['corechart']});
     
	function valid(){
		var curStreet = document.getElementById("curStreet").value;
		var curCity = document.getElementById("curCity").value;
		var curState = document.getElementById("curState").value;
		var isCurLoc = document.getElementById("curLoc").value;
		if (isCurLoc != "true" && (curStreet == null || curStreet.length == 0)) {
			document.getElementById("error_alert").classList.remove("hiden");
			return false;
		}
		if (isCurLoc != "true" && (curCity == null || curCity.length == 0)) {
			document.getElementById("error_alert").classList.remove("hiden");
			return false;
		}
	}
	function disableInput(){
		var ele1 = document.getElementById("curStreet");
		var ele2 = document.getElementById("curCity");
		var ele3 = document.getElementById("curState");


		ele1.value ="";
		ele2.value ="";
		ele3.value ="states";
		ele1.disabled = !ele1.disabled;
		ele2.disabled = !ele2.disabled;
		ele3.disabled = !ele3.disabled;
		
		// query the current lat and log
		var curLocjson = loadGeoJSON();	
		// put the curlat and curlon to hidden element;
		document.getElementById("curLoclat").value = curLocjson.lat;
		document.getElementById("curLoclon").value = curLocjson.lon;
		document.getElementById("currentCity").value = curLocjson.city;
		
		// this is for set the curLoc value, nomatter the checkbox is checked or not
		document.getElementById("curLoc").value = document.getElementById("curLoc").checked;
	}
	// load current local machine geo information 
	function loadGeoJSON(){
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.open("GET","http://ip-api.com/json",false);
		xmlhttp.send();
		jsondoc = xmlhttp.responseText;
		list = JSON.parse(jsondoc);
		return list;
	}
	// forn the weather to get into more detailed waether situation
	function detailWeather(time){
		var curloclat = document.getElementById("curLoclat").value;
		var curloclon = document.getElementById("curLoclon").value;
		var date = time;
		var x = document.getElementById("weekWeather");
		document.getElementById("date").value = date;
		document.getElementById("isdetailed").value = "true";
		document.getElementsByTagName("form")[0].submit();
		console.log(curloclat);
		console.log(curloclon);
	}
	// clear all information
	function clearall(){
		location.href="<?php echo($_SERVER[PHP_SELF])?>";
	}

	function showChart(){
		var imgold = document.getElementById("hourlyweather").childNodes;
		if (imgold[1].src == "https://cdn0.iconfinder.com/data/icons/navigation-set-arrows-part-one/32/ExpandLess-512.png") {
			imgold[1].setAttribute("src","https://cdn4.iconfinder.com/data/icons/geosm-e-commerce/18/point-down-512.png");
			var x = document.getElementById("chart");
			x.parentNode.removeChild(x);
		}
		else{
			imgold[1].setAttribute("src","https://cdn0.iconfinder.com/data/icons/navigation-set-arrows-part-one/32/ExpandLess-512.png");
			drawChart();
		}
     
	}
	function drawChart(){
		var chartNode = document.createElement("div");
		chartNode.setAttribute("id","chart");
		chartNode.setAttribute("style","width: 1000px; height: 300px; margin: 0 auto;");
		document.getElementById("hourlyweather").append(chartNode);
		var data = google.visualization.arrayToDataTable([
			['Time', 'T'],
			<?php  
			if(isset($_POST["isdetailed"]) && $_POST["isdetailed"] == "true" ) {
				$basetime = $content->currently->time;
				foreach ($chartdata as $key => $value) {
					$interval = (($value->time)-($basetime))%86400/3600;
				// echo $interval%86400/ 3600;
					echo "[".$interval.",".$value->temperature."],";
				}
			}
			?>
        ]);
		
		var options = {
			curveType: 'function',
			legend: { position: 'right' },
			vAxis: {
				title: 'Temperature',
				textPosition:"none"
			},
			colors: ['#A8D0D9']
		};

        var chart = new google.visualization.LineChart(document.getElementById('chart'));

        chart.draw(data, options);
	}
	window.addEventListener("load", function(event) {
		<?php 
		if ($iscurLoc == true) {
			echo "disableInput();";
			echo "document.getElementById(\"curLoc\").setAttribute(\"checked\",\"checked\");";
		} 
		?>
	});
</script>
</html>