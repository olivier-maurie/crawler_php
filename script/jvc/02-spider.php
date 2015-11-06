<?php
include_once('00-bdd.php');

//parser tous les liens qui n'ont jamais été parsé
$url_bdd = $bdd->query("SELECT * FROM url_jvc WHERE url_checked = 1 AND id > 33650 GROUP BY id");

//stock les lien dans url_jvc et les url de jeux dans liste_jeux_jvc
$req_stock_url_jvc = $bdd->prepare('INSERT INTO url_jvc(url) VALUES(:url)');
$req_stockage = $bdd->prepare('INSERT INTO liste_jeux_jvc(url) VALUES(:url)');

//checker de doublons
$verif_doublon = $bdd->query("SELECT COUNT(*) AS nbr_doublon, id, url FROM url_jvc GROUP BY id HAVING nbr_doublon > 1");
$row = $verif_doublon->fetch();

foreach($url_bdd as $url){

	//initialisation de curl
	$curl = curl_init();
	$timeout = 0;
	curl_setopt($curl, CURLOPT_URL, $url['url']);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
	curl_setopt($curl, CURLOPT_AUTOREFERER, false);
	curl_setopt($curl, CURLOPT_COOKIESESSION, true);
	$html = curl_exec($curl);
	curl_close($curl);

	//création d'un objet dom qui va charger tout le html
	$dom = new DOMDocument();
	@$dom->loadHTML($html);

	//requête d'un token qui vérifira si un lien à déjà été parcouru
	$req_checked = $bdd->prepare('UPDATE url_jvc SET url_checked = 1 WHERE id ='.$url['id'] );

	//récupère les liens type 2 (http://jeuxvideo.com/jeux/console/12345678-titre-jeu.htm)
	preg_match_all('#<span class="label-support(.*)">(.*)</span>#U', $html, $support_span);
	preg_match_all('#<span class="JvCare (.*) label-support" title="(.*)">(.*)</span>#U', $html, $support_a);
	if(sizeof($support_span[2]) == 1 && sizeof($support_a[3]) == 0 && preg_match_all('#\/jeux\/(.*)\/[0-9]{8}-(.*)\.htm$#U', $url['url'], $url_trie5)){
		$req_stockage->execute(array(
			'url' => $url['url']));
		echo 'Ajout jeux : '.$url['url'].'<br/>';
	}

	//trie et récupère les liens de type 1 (http://jeuxvideo.com/jeux/123456-titre-jeux.htm)
	foreach($dom->getElementsByTagName('a') as $link) {
		$recup_link = $link->getAttribute('href');
		if(preg_match_all('#news|preview|forum|wearefans|boutique|twitter|itune|fnac|noelshack|amazon|allocine|wiki|download|t\.co|avis|chroniques|wallpaper|\/videos|\/recherche\/|gaming-live|test#', $recup_link)){
			echo "erreur".$recup_link."<br/>";
		}
		else{
			if($row >= 1){
				echo "<span class=\"red\">Doublon</span><br/>";
			}
			else{
				if(preg_match_all('#(.+)\#$#U', $recup_link)){
					echo "<span class=\"red\">Dièse</span><br/>";
				}
				else{
					if(preg_match_all('#^http:\/\/www\.jeuxvideo\.com(.+)\/\/(.+)$#U', $recup_link)){
						
						echo "<span class=\"red\">Double slash</span><br/>";
					}
					else{
						if(preg_match_all('#\/jeux/jeu\-[0-9]{5,6}\/$#', $recup_link)){
							echo $url['id'].''.$recup_link.'<br/>';
							$req_stock_url_jvc->execute(array(
								'url' => 'http://www.jeuxvideo.com'.$recup_link));
							$req_stockage->execute(array(
								'url' => 'http://www.jeuxvideo.com'.$recup_link));
						}
						elseif(preg_match_all('#^http:\/\/www\.jeuxvideo\.com#U', $recup_link)){
							echo $url['id'].''.$recup_link.'<br/>';
							$req_stock_url_jvc->execute(array(
								'url' => $recup_link));
						}
						else{
							echo $url['id'].''.$recup_link.'<br/>';
							$req_stock_url_jvc->execute(array(
								'url' => 'http://www.jeuxvideo.com'.$recup_link));
						}
					}
				}
			}
		}
		$req_checked->execute();
	}
}

?>

</body>
</html>