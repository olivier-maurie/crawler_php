<?php
include_once('bdd.php');

set_time_limit(5000);
$theme = $bdd->query('SELECT id, theme_1, theme_2, theme_3, theme_4, theme_5 FROM liste_jeux_jvc');

while($liste_theme = $theme->fetch()){
	$req_theme = $bdd->prepare('INSERT INTO liste_theme(theme) VALUES(:theme)');

	$tab = array(
		$liste_theme['theme_1'],
		$liste_theme['theme_2'],
		$liste_theme['theme_3'],
		$liste_theme['theme_4'],
		$liste_theme['theme_5']
	);
	for($i=0;$i<5;$i++){
		if($tab[$i] == null){
			echo '-';
		}
		else{
			$req_theme->execute(array('theme' => $tab[$i]));
			echo $liste_theme['id'].' - Ajout '.$tab[$i].'<br/>';
		}
	}
	var_dump($tab);
}
?>