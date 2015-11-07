<meta charset="utf-8">
<?php

include_once('../script/jvc/00-bdd.php');

$url_bdd = $bdd->query('SELECT * FROM liste_jeux_jvc GROUP BY id');
echo '<table border="1px">';

foreach($url_bdd as $listing){
/*
SELECT ljj.titre, lg.genre
FROM genre_jeux gj
JOIN liste_genre lg
ON lg.id = gj.genre_id
JOIN liste_jeux_jvc ljj
ON ljj.id = gj.jeux_id
ORDER BY `gj`.`jeux_id` ASC*/
	echo '<tr>
		<td>'.$listing['id'].'</td>
		<td><a href="'.$listing['url'].'" target="_blank">'.$listing['titre'].'</td>
		<td>'.$listing['date_sortie'].'</td>
		<td>'.$listing['pegi'].'</td>
		</tr>';
}

echo '</table>';

?>