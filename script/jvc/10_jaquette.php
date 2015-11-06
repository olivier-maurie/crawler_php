<?php
	include_once('bdd.php');
	$url_bdd = $bdd->query('SELECT * FROM liste_jeux_jvc WHERE id = 1');

	foreach($url_bdd as $url){

	$name = strtolower($url['titre']);
	$file_name = preg_replace('# #', '_', $name);
	$name = $file_name;
	echo $name;

	$fichier = $_SERVER['DOCUMENT_ROOT'].'crawler_php/lib/images/'.$name.'.jpg';

		set_time_limit(0);

		$ch = curl_init($url['url_jaquette']);
		$fp = fopen($fichier, 'wb');

		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_exec($ch);
		curl_close($ch);
		fclose($fp);
	}

	?>