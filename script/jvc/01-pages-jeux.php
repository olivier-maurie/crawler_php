<?php
include_once('00-bdd.php');

//ajoute les url dans la table url_jvc
$req_pages_jeux = $bdd->prepare('INSERT INTO url_jvc(url) VALUES(:url)');

for($i=2;$i<=2000;$i++){
	$url = 'http://www.jeuxvideo.com/tous-les-jeux/?p='.$i;
	echo $url.'<br/>';
	$req_pages_jeux->execute(array(
		'url' => $url));
}

?>