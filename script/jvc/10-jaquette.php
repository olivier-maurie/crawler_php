<?php
	include_once('00-bdd.php');
	$url_bdd = $bdd->query('SELECT * FROM liste_jeux_jvc');

	foreach($url_bdd as $url){

		$name = strtolower($url['titre']);
		$file_name = preg_replace('# #', '_', $name);
		$name = $file_name;
		$file_name = preg_replace('#:#', '_', $name);
		$name = $file_name;
		$file_name = preg_replace('#\/#', '_', $name);
		$name = $file_name;
		//echo $name;
		if(substr($name, -1) == "_"){
			$name = substr($name, 0, -1);
			$fichier = $_SERVER['DOCUMENT_ROOT'].'crawler_php/lib/images/'.$name.'.jpg';
			echo $fichier.'<br/>';
		}elseif($url['url_jaquette'] == "http://www.jeuxvideo.com/img/various/no-img/no-img-h.png"){
			echo 'pas d\'image<br/>';
		}
		else{
			$fichier = $_SERVER['DOCUMENT_ROOT'].'crawler_php/lib/images/'.$name.'.jpg';
			echo $fichier.'<br/>';
		}

		$ch = curl_init($url['url_jaquette']);
		$fp = fopen($fichier, 'wb');

		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_exec($ch);
		curl_close($ch);
		fclose($fp);
	}

	?>