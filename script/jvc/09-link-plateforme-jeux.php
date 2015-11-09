<?php

include_once('00-bdd.php');

$vider = $bdd->prepare('TRUNCATE TABLE plateforme_jeux');
$vider->execute();

for($l=0;$l<243590;$l++){

	$jeux = $bdd->query('SELECT id, support_1, support_2, support_3, support_4, support_5, support_6, support_7, support_8, support_9, support_10, support_11, support_12, support_13, support_14, support_15, support_16, support_17, support_18, support_19, support_20  FROM liste_jeux_jvc WHERE id = '.$l);
	$support = $bdd->query('SELECT * FROM liste_plateforme');

	foreach($jeux as $j){
		foreach($support as $g){
			$req_support_jeux = $bdd->prepare('INSERT INTO plateforme_jeux(plateforme_id, jeux_id) VALUES(:plateforme_id, :jeux_id)');

			for($i=1;$i<6;$i++){
				if($j[$i]==$g[1]){

					$req_support_jeux->execute(array('plateforme_id' => $g[0],
													'jeux_id' => $j['id']
													));

					echo $j[$i].' - '. $g[0].' - '. $j[0].'<br/>';
				}
			}
		}
	}
}

?>