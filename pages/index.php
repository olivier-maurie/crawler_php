<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Crawler</title>

    <!-- Bootstrap -->
    <link href="lib/css/bootstrap.min.css" rel="stylesheet">
    <link href="lib/css/custom.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    	<header>
        <div class="container-fluid">
          <div class="row">
        		<h1><a href="index.html">Crawler PHP</a></h1>
          </div>
        </div>
    	</header>
    	
  	<div class="container-fluid">
      <div class="row">

        <div class="col-lg-2 col-lg-offset-2 wrap-menu">
          <h2>Jeuxvideo.com</h2>
          <ol>
            <li><a href="jvc/01-pages-jeux" target="_blank">Page jeux</a></li>
            <li><a href="jvc/02-spider" target="_blank">Spider</a></li>
            <li><a href="jvc/03-liste-jeux" target="_blank">Récupéraion des données</a></li>
            <li><a href="jvc/04-liste-genres" target="_blank">Création liste de genres</a></li>
            <li><a href="jvc/05-link-genre-jeux" target="_blank">Liaison genres - jeux</a></li>
            <li><a href="jvc/06-liste-themes" target="_blank">Création liste de thèmes</a></li>
            <li><a href="jvc/07-link-theme-jeux" target="_blank">Liaison thèmes - jeux</a></li>
            <li><a href="jvc/08-liste-plateformes" target="_blank">Création liste de plateformes</a></li>
            <li><a href="jvc/09-link-plateforme-jeux" target="_blank">Liaison plateforme - jeux</a></li>
            <li><a href="jvc/10-jaquette" target="_blank">Téléchargement des jaquettes</a></li>
          </ol>
          <hr/>
          <ul>
            <li><a href="liste_jeux" target="_blank">Liste des jeux</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-lg-offset-1 wrap-menu">
          <h2>Gameblog</h2>
        </div>

        <div class="col-lg-2 col-lg-offset-1 wrap-menu">
          <h2>Steam</h2>
        </div>

      </div>
    </div>
    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>