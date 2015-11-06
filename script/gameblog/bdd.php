php
try{
    $bdd = new PDO('mysqlhost=localhost;dbname=gameblog;charset=utf8', 'root', '');
}catch (Exception $e){
    die('Erreur  ' . $e-getMessage());
}
