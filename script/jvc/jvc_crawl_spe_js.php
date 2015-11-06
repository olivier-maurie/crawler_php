<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
</head>
<body>
<?php

//connexion à la bdd
include_once('bdd.php');
$req = $bdd->prepare('INSERT INTO url_jvc(url) VALUES(:url)');

for($i=2;$i<=2000;$i++){
	$url = 'http://www.jeuxvideo.com/tous-les-jeux/?p='.$i;
	$req->execute(array(
		'url' => $url));
}
?>

</body>
<script>document.location.href='jvc_spider.php';</script>
</html>