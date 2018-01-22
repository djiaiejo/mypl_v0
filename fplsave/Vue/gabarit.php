<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <base href="<?= $racineWeb ?>" >

        <!-- Feuilles de style -->
        <!--<link rel="stylesheet" href="Librairies/bootstrap/css/bootstrap.min.css">-->
        <link rel="stylesheet" href="Contenu/style.css">
		
		<!-- Bootstrap -->
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<script src="js/jquery.searchable.js"></script>

        <!-- Favicon -->
        <link rel="icon" href="Contenu/Images/favicon.png">

        <!-- Titre -->
        <title>FPL - <?= $titre ?></title>
    </head>
    <body>
        <div class="container">
            <?= $contenu ?>
        </div>
        
        <!-- jQuery -->
        <!--<script src="Librairies/jquery/jquery-1.10.1.min.js"></script>-->
        <!-- Plugin JavaScript Boostrap -->
        <!--<script src="Librairies/bootstrap/js/bootstrap.min.js"></script>-->
    </body>
</html>
