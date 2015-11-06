<?php
include_once('00_bdd.php');

$req = $bdd->prepare('INSERT INTO url_jvc(url) VALUES(:url)');

for($i=2;$i<=2000;$i++){
	$url = 'http://www.jeuxvideo.com/tous-les-jeux/?p='.$i;
	$req->execute(array(
		'url' => $url));
}

?>