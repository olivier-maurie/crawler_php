<?php

include_once('00-bdd.php');

$vider = $bdd->prepare('TRUNCATE TABLE theme_jeux');
$vider->execute();

for($l=0;$l<243590;$l++){

	$jeux = $bdd->query('SELECT id, theme_1, theme_2, theme_3, theme_4, theme_5 FROM liste_jeux_jvc WHERE id = '.$l);
	$theme = $bdd->query('SELECT * FROM liste_theme');

	foreach($jeux as $j){
		foreach($theme as $g){
			$req_theme_jeux = $bdd->prepare('INSERT INTO theme_jeux(theme_id, jeux_id) VALUES(:theme_id, :jeux_id)');

			for($i=1;$i<6;$i++){
				if($j[$i]==$g[1]){

					$req_theme_jeux->execute(array('theme_id' => $g[0],
													'jeux_id' => $j['id']
													));

					echo $j[$i].' - '. $g[0].' - '. $j[0].'<br/>';
				}
			}
		}
	}
}

?>