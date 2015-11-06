<table border="1">
	<thead>
		<td>ID</td>
		<td>Titre</td>
	</thead>
<?php
include_once('00-bdd.php');

$url_bdd = $bdd->query('SELECT * FROM liste_jeux_jvc WHERE titre = ""');
 
foreach($url_bdd as $url){
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
	
	$req_donnees = $bdd->prepare('UPDATE liste_jeux_jvc
		SET titre = :titre,
			date_sortie = :date_sortie,
			pegi = :pegi,
			genre_1 = :genre_1,
			genre_2 = :genre_2,
			genre_3 = :genre_3,
			genre_4 = :genre_4,
			genre_5 = :genre_5,
			url_jaquette = :url_jaquette,
			support_1 = :support_1,
			support_2 = :support_2,
			support_3 = :support_3,
			support_4 = :support_4,
			support_5 = :support_5,
			support_6 = :support_6,
			support_7 = :support_7,
			support_8 = :support_8,
			support_9 = :support_9,
			support_10 = :support_10,
			support_11 = :support_11,
			support_12 = :support_12,
			support_13 = :support_13,
			support_14 = :support_14,
			support_15 = :support_15,
			support_16 = :support_16,
			support_17 = :support_17,
			support_18 = :support_18,
			support_19 = :support_19,
			support_20 = :support_20,
			theme_1 = :theme_1,
			theme_2 = :theme_2,
			theme_3 = :theme_3,
			theme_4 = :theme_4,
			theme_5 = :theme_5,
			note = :note
		WHERE id = '.$url['id']);
	
	//recupération du titre
	if(preg_match_all('#<h1 class="highlight">(.*) sur (.*)</h1>#U', $html, $titre)){
		$recup_titre = $titre[1][0];
	}else if(preg_match_all('#<h1 class="highlight">(.*)</h1>#U', $html, $titre)){
		$recup_titre = $titre[1][0];
	}
	
	//récupération des supports de jeux
	if(preg_match_all('#<a href="(.*)" class="label-support">(.*)</a>#U', $html, $support)){
	    $size_support = sizeof($support[2]);
	}
	elseif(preg_match_all('#<span class="label-support(.*)>(.*)</span>#U', $html, $support)){
		$size_support = sizeof($support[2]);
	}
	else {
		$support = NULL;
	}

	//récupération des genres
	if(preg_match_all('#<span itemprop="genre"><(.*)>(.*)</(.*)></span>#U', $html, $genre)){
		$size_genre = sizeof($genre[2]);
		$genre_1 = @$genre[2][0];
		$genre_2 = @$genre[2][1];
		$genre_3 = @$genre[2][2];
		$genre_4 = @$genre[2][3];
		$genre_5 = @$genre[2][4];
	}
	else{
		$genre = NULL;
	}

	//récupération PEGI
	if(preg_match_all('#<li><strong>Classification : </strong><span>+(.*) ans</span></li>#U', $html, $pegi)){
		$recup_pegi = $pegi[1][0];
	}
	else{
		$recup_pegi = NULL;
	}
	//récupération date de sortie

	if(preg_match_all('#<span content="(.*)" itemprop="datePublished" ></span>#', $html, $p)){
		$valeur_p = $p[1][0];
	}
	else{
		$valeur_p = NULL;
	}

	//récupération des jaquettes
	if(preg_match_all('#<meta itemprop="image" content="(.*).jpg" \/>#U', $html, $image)){
		$jaquette = $image[1][0].'.jpg';
	}elseif(preg_match_all('#<meta itemprop="image" content="(.*).png" \/>#U', $html, $image)){
		$jaquette = $image[1][0].'.png';
	}elseif(preg_match_all('#<meta itemprop="image" content="(.*).jpeg" \/>#U', $html, $image)){
		$jaquette = $image[1][0].'.jpeg';
	}

	//récupération thème
	if(preg_match_all('#<strong>(.*)</strong>#U', $html, $exist)){
		$table_theme = array();
		for($i=0;$i<10;$i++){
			if(@$exist[1][$i] == 'Thème(s) : '){
				if(preg_match_all('#<span class="JvCare [A-Z0-9]{32,38} lien-jv">([^0-9].*)</span>#U', $html, $theme) || preg_match_all('#<span>(Golf|Futuriste)</span>#U', $html, $theme)){
					for($j=0;$j<15;$j++){
						if(@$theme[1][$j] != @$genre[2][0] && @$theme[1][$j] != @$genre[2][1] && @$theme[1][$j] != @$genre[2][2] && @$theme[1][$j] != @$genre[2][3] && @$theme[1][$j] != @$genre[2][4]){
							//echo $j.' - '.@$theme[1][$j].'<br/>';
							@array_push($table_theme, $theme[1][$j]);
						}
						else{
							@$theme[1][$j] == NULL;
						}
					}
				}
			}
			else{
				@$exist[1][$i] == NULL;
			}
		}
		$theme_1 = @$table_theme[0];
		$theme_2 = @$table_theme[1];
		$theme_3 = @$table_theme[2];
		$theme_4 = @$table_theme[3];
		$theme_5 = @$table_theme[4];
		$size_theme = sizeof($table_theme);
	}

	
	//récupération note
	if(preg_match_all('#<div class="corps-cell-hit hit-note-g">(.*)</div>#U', $html, $note)){
		$note_g = $note[1][0];
	}
	else{
		$note_g = NULL;
	}

	//insertion dans la bdd
	@$req_donnees->execute(array(
		'titre' => $recup_titre,
		'date_sortie' => $valeur_p,
		'pegi' => $recup_pegi,
		'genre_1'=> $genre_1,
		'genre_2'=> $genre_2,
		'genre_3'=> $genre_3,
		'genre_4'=> $genre_4,
		'genre_5'=> $genre_5,
		'url_jaquette' => $jaquette,
		'support_1' => $support[2][0],
		'support_2' => $support[2][1],
		'support_3' => $support[2][2],
		'support_4' => $support[2][3],
		'support_5' => $support[2][4],
		'support_6' => $support[2][5],
		'support_7' => $support[2][6],
		'support_8' => $support[2][7],
		'support_9' => $support[2][8],
		'support_10' => $support[2][9],
		'support_11' => $support[2][10],
		'support_12' => $support[2][11],
		'support_13' => $support[2][12],
		'support_14' => $support[2][13],
		'support_15' => $support[2][14],
		'support_16' => $support[2][15],
		'support_17' => $support[2][16],
		'support_18' => $support[2][17],
		'support_19' => $support[2][18],
		'support_20' => $support[2][19],
		'theme_1' => $theme_1,
		'theme_2' => $theme_2,
		'theme_3' => $theme_3,
		'theme_4' => $theme_4,
		'theme_5' => $theme_5,
		'note' => $note_g
		));

	echo '<tr>
			<td>'.$url['id'].'</td>
			<td><a href="'.$url['url'].'">'.$recup_titre.'</a></td>
			<!--td><img src="'.$jaquette.'"/></td>
			<td>'.$valeur_p.'</td>
			<td>'.$recup_pegi .'</td>
			<td>genre('.$size_genre.')</td>
			<td>support('.$size_support.')</td>
			<td>theme('.$size_theme.')</td>
			<td>'.$note_g.'</td-->
		</tr>';
}

echo '</table>';
?>