<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
</head>
<body>
<?php

//connexion à la bdd
include_once('../include/bdd.php');

//parser tous les liens sans doublons
$url_bdd = $bdd->query("SELECT * FROM url_gameblog GROUP BY id");
foreach($url_bdd as $url){
	set_time_limit(0);
	$curl = curl_init();
	$timeout = 5000;
	curl_setopt($curl, CURLOPT_URL, $url['url']);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
	curl_setopt($curl, CURLOPT_AUTOREFERER, false);
	curl_setopt($curl, CURLOPT_COOKIESESSION, true);
	$html = curl_exec($curl);
	curl_close($curl);

	$dom = new DOMDocument();
	@$dom->loadHTML($html);

	$req_recup_link = $bdd->prepare('INSERT INTO url_gameblog(url) VALUES(:url)');
	$verif_doublon = $bdd->query("SELECT COUNT(*) AS nbr_doublon, id, url FROM url_gameblog GROUP BY id HAVING nbr_doublon > 1");
	$row = $verif_doublon->fetch();

	foreach($dom->getElementsByTagName('a') as $link) {
		$recup_link = $link->getAttribute('href');
		if(preg_match_all('#yahoo|\/images|fnac#U', $recup_link)){
			echo "-<br/>";
		}
		else{
			if($row >= 1){
				echo "<span class=\"red\">Doublon</span><br/>";
			}
			else{
				if(!preg_match_all('#\/jeux#', $recup_link)){
					echo "-<br/>";
				}
				else{
					if(preg_match_all('#^http:\/\/www\.gameblog\.fr#', $recup_link)){
						echo $url['id'].''.$recup_link.'<br/>';
						$req_recup_link->execute(array(
							'url' => $recup_link));
					}
					else{
						echo $url['id'].''.$recup_link.'<br/>';
						$req_recup_link->execute(array(
							'url' => 'http://www.gameblog.fr'.$recup_link));
					}
				}
			}
		}
	}
}


?>

</body>
</html>