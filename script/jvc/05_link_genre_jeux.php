<?php

include_once('bdd.php');

$vider = $bdd->prepare('TRUNCATE TABLE genre_jeux');
$vider->execute();

for($l=0;$l<243590;$l++){

	$jeux = $bdd->query('SELECT id, genre_1, genre_2, genre_3, genre_4, genre_5 FROM liste_jeux_jvc WHERE id = '.$l);
	$genre = $bdd->query('SELECT * FROM liste_genre');

	foreach($jeux as $j){
		foreach($genre as $g){
			$req_genre_jeux = $bdd->prepare('INSERT INTO genre_jeux(genre_id, jeux_id) VALUES(:genre_id, :jeux_id)');

			for($i=1;$i<6;$i++){
				if($j[$i]==$g[1]){

					$req_genre_jeux->execute(array('genre_id' => $g[0],
													'jeux_id' => $j['id']
													));

					echo $j[$i].' - '. $g[0].' - '. $j[0].'<br/>';
				}
			}
		}
	}
}

?>