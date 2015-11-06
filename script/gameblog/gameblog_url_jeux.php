<?php

include_once('../include/bdd.php');

set_time_limit(3600);

$url_bdd = $bdd->query('SELECT * FROM url_gameblog GROUP BY id');
$req_stockage = $bdd->prepare('INSERT INTO liste_jeux_gameblog(url) VALUES(:url)');

$verif_doublon = $bdd->query("SELECT COUNT(*) AS nbr_doublon, id, url FROM url_gameblog GROUP BY id HAVING nbr_doublon > 1");
$row = $verif_doublon->fetch();

foreach($url_bdd as $listing){
	if($row >= 1){
		echo "doublons : ".$listing['url']."<br/>";;
	}
	else{
		if(preg_match_all('#\/joueur|\/news|\/videos|\/tests|\/blogs|\/articles#', $listing['url'])){
			echo "bug crawler : ".$listing['url']."<br/>";
		}
		else{
			if(preg_match_all('#^http:\/\/www\.gameblog\.fr\/jeux\/[0-9]{4}_(.*)#', $listing['url'])){
				echo $listing['id'].' '.$listing['url'].'<br/>';
				$req_stockage->execute(array(
					'url' => $listing['url']));
			}
		}
	}
}

?>