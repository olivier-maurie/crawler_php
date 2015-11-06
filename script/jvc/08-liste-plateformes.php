<?php
include_once('00-bdd.php');

$console = $bdd->query('SELECT * FROM liste_jeux_jvc');

while($liste_plateforme = $console->fetch()){
	$req_console = $bdd->prepare('INSERT INTO liste_plateforme(plateforme) VALUES(:plateforme)');

	$tab = array(
		$liste_plateforme['support_1'],
		$liste_plateforme['support_2'],
		$liste_plateforme['support_3'],
		$liste_plateforme['support_4'],
		$liste_plateforme['support_5'],
		$liste_plateforme['support_6'],
		$liste_plateforme['support_7'],
		$liste_plateforme['support_8'],
		$liste_plateforme['support_9'],
		$liste_plateforme['support_10'],
		$liste_plateforme['support_11'],
		$liste_plateforme['support_12'],
		$liste_plateforme['support_13'],
		$liste_plateforme['support_14'],
		$liste_plateforme['support_15'],
		$liste_plateforme['support_16'],
		$liste_plateforme['support_17'],
		$liste_plateforme['support_18'],
		$liste_plateforme['support_19'],
		$liste_plateforme['support_20']
	);
	for($i=0;$i<20;$i++){
		if($tab[$i] == null){
			echo '-';
		}
		else{
			$req_console->execute(array('plateforme' => $tab[$i]));
			echo $liste_plateforme['id'].' - Ajout '.$tab[$i].'<br/>';
		}
	}
	var_dump($tab);
}
?>