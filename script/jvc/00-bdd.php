<?php
try{
    $bdd = new PDO('mysql:host=localhost;dbname=jvc;charset=utf8', 'root', '');
}catch (Exception $e){
    die('Erreur : ' . $e->getMessage());
}

set_time_limit(0);
?>