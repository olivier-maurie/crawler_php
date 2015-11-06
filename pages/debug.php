<?php

include_once('../include/bdd.php');

set_time_limit(3600);
/*
$url_bdd = $bdd->query('SELECT * FROM url GROUP BY id');

echo 'SELECT *<br/>
		FROM url<br/>
		WHERE id IN (';

foreach($url_bdd as $to_repair){
	if(preg_match_all('#http:\/\/www\.jeuxvideo\.comhttp:\/\/www\.jeuxvideo\.com\/#', $to_repair['url'])){
		echo $to_repair['id'].', ';
	}
}

echo ')';
*/
$url_bdd = $bdd->query('SELECT id, support_1 FROM liste_jeux WHERE support_1 IS NULL');

echo 'SELECT *<br/>
		FROM liste_jeux<br/>
		WHERE id IN (';

foreach($url_bdd as $to_repair){
	echo $to_repair['id'].', ';
}

echo ')';
?>