<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8" />
<style>
.meteo {
	margin: 50px auto;
	width: 200px;
	padding: 10px;
	background: #095CB2;
	font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
	color: #fff;
	text-align: center;
}
.meteo-titre1 {
	margin: 0;
	padding: 0;
	font-size: 20px;
	font-weight: 100;	
}
.meteo-titre2 {
	margin: 0;
	padding: 10px 0 0 0;
	font-size: 16px;
	font-weight: 100;	
}
.meteo-p {
	margin: 0;
	padding: 0 0 10px 0;
	font-size: 14px;
	font-weight: 100;	
}
.meteo-icon {
	width: 25%;
	height: 25%;
}
</style>
	</head>
	<body>
		<h1>Tests de l'API OpenWeather - extraction json</h1>
		<form action="" method="get">
			<p>
				<label for="meteo-ville">saisir une ville</label><input type="text" name="meteo-ville" />
				<label for="meteo-nbjours">Nombre de jours de la prévision</label><input type="text" name="meteo-nbjours" />
				<input type="submit" value="ok" />
			</p>
		</form>
	<?php
	/* 
	Json pour Cornas, prévision 3 prochains jours
	http://api.openweathermap.org/data/2.5/forecast/daily?lat=44.96&lon=4.84&cnt=3&mode=json
	
	avec APPID : 
	http://api.openweathermap.org/data/2.5/forecast/daily?lat=44.96&lon=4.84&cnt=3&mode=json&APPID=6466c16218f7972f1e4b46d8625fea58
	
	avec APPID et en français
	http://api.openweathermap.org/data/2.5/forecast/daily?lang=fr&lat=44.96&lon=4.84&cnt=3&mode=json&APPID=6466c16218f7972f1e4b46d8625fea58
	*/
if (!empty($_GET['meteo-ville']) && !empty($_GET['meteo-nbjours'])) {	
// mise en place des variables
$urlOpenWeather	= 'http://api.openweathermap.org/data/2.5/forecast/daily?q=' . $_GET['meteo-ville'].'&lang=fr&cnt=' . $_GET['meteo-nbjours'] . '&mode=json&APPID=6466c16218f7972f1e4b46d8625fea58';

// Lecture du fichier json
$getdataOpenWeather = file_get_contents($urlOpenWeather);
$dataOpenWeather = json_decode($getdataOpenWeather, true);
$i = 0;
$output .= '<div class="meteo">';
if (!empty($_GET['meteo-ville']) && !empty($_GET['meteo-nbjours'])) {
	$output .= '<h1 class="meteo-titre1">météo à '.$dataOpenWeather['cnt'].' jours<br />— '.$dataOpenWeather['city']['name'].' —</h1>';
} else {
	$output .= '<h1 class="meteo-titre1">Remplir le formulaire…</h1>';
}
while ($i < $dataOpenWeather['cnt']) {
	$output .= '<h2 class="meteo-titre2">'. date('d/m/Y', $dataOpenWeather['list'][$i]['dt']) .'</h2>';
	$output .= '<p class="meteo-p">';
	$output .= $dataOpenWeather['list'][$i]['weather'][0]['description'];
	$output .= ' - ';
	$output .= intval($dataOpenWeather['list'][$i]['temp']['day']-273.15).'°C<br />';
	$output .= '<img class="meteo-icon" src="images/'.$dataOpenWeather['list'][$i]['weather'][0]['id'].'.png" alt="'.$dataOpenWeather['list'][$i]['weather'][0]['description'].'" /><br />';
	$output .= '</p>';
	$i++;
}	
$output .= '</div>';
echo $output;

echo '<br /><br /><hr />Fichier brut 3j N 43°30 E 005°39 : <br />';
var_dump($dataOpenWeather);
}
	?>
	<!--
	{
	"cod":"200",
	"message":0.0078,
	"city":{
		"id":3023617,
		"name":"Cornas",
		"coord":{"lon":4.84806,"lat":44.964981},
		"country":"FR",
		"population":0
	},
	"cnt":3,
	"list":
		[
		{
		"dt":1384858800,
		"temp":{
			"day":278.72,
			"min":274.95,
			"max":278.72,
			"night":274.95,
			"eve":275.72,
			"morn":277.07    },
		"pressure":962.24,
		"humidity":100,
		"weather":
			[{
			"id":601,
			"main":"Snow",
			"description":"neige",
			"icon":"13d"
			}],
			"speed":3.93,
			"deg":6,
			"clouds":92,
			"rain":13.5,
			"snow":4.75
		}
		,{"dt":1384945200,"temp":{"day":276.16,"min":272.34,"max":276.18,"night":272.34,"eve":275.77,"morn":274.55},"pressure":965.87,"humidity":97,"weather":[{"id":601,"main":"Snow","description":"neige","icon":"13d"}],"speed":5.45,"deg":7,"clouds":92,"rain":1,"snow":2.25},{"dt":1385031600,"temp":{"day":275.2,"min":271.25,"max":275.62,"night":272.5,"eve":272.93,"morn":271.25},"pressure":959.32,"humidity":100,"weather":[{"id":600,"main":"Snow","description":"légères neiges","icon":"13d"}],"speed":1.61,"deg":327,"clouds":92,"snow":1.5}]}
	-->
	
	
	</body>
</html>