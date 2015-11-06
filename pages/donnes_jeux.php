<?php
include_once('../include/bdd.php');

set_time_limit(3600);

$url_bdd = $bdd->query('SELECT * FROM liste_jeux WHERE id > 65000');
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

	//recupération du titre
	$req_recup_titre = $bdd->prepare('UPDATE liste_jeux SET titre = :titre WHERE id = '.$url['id']);
	
	foreach($dom->getElementsByTagName('h1') as $titre){
		$recup_titre = $titre->nodeValue;
	}

	$req_recup_titre->execute(array('titre' => $recup_titre));

	echo $recup_titre.'<br/>';


}
?>