<?php

include_once('../script/jvc/bdd.php');

set_time_limit(3600);

$url_bdd = $bdd->query('SELECT * FROM liste_jeux_jvc GROUP BY id');
echo '<table>';

foreach($url_bdd as $listing){
	echo '<tr>
		<td>'.$listing['id'].'</td>
		<td><a href="'.$listing['url'].'" target="_blank">'.$listing['titre'].'</td>
		</tr>';
}

echo '</table>';

?>