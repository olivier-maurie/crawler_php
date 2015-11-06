<?php
include_once('bdd.php');

set_time_limit(5000);
$genre = $bdd->query('SELECT id, genre_1, genre_2, genre_3, genre_4, genre_5 FROM liste_jeux_jvc');

while($liste_genre = $genre->fetch()){
	$req_genre = $bdd->prepare('INSERT INTO liste_genre(genre) VALUES(:genre)');

	$tab = array(
		$liste_genre['genre_1'],
		$liste_genre['genre_2'],
		$liste_genre['genre_3'],
		$liste_genre['genre_4'],
		$liste_genre['genre_5']
	);
	for($i=0;$i<5;$i++){
		if($tab[$i] == null){
			echo '-';
		}
		else{
			$req_genre->execute(array('genre' => $tab[$i]));
			echo $liste_genre['id'].' - Ajout '.$tab[$i].'<br/>';
		}
	}
	var_dump($tab);
}
?>
