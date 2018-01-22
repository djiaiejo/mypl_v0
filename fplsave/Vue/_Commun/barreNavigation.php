<!-- Barre de navigation en haut de la page -->
<div class="navbar navbar-default navbar-default navbar-fixed-top" role="navigation">
    <!-- Partie de la barre toujours affichée -->
    <div class="navbar-header">
        <!-- Bouton affiché à droite si la zone d'affichage est trop petite -->
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Activer la navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <!-- Lien de retour à la page d'accueil -->
        <a class="navbar-brand" href="">FPL</a>
    </div>
    <!-- Partie de la barre masquée en fonction de la zone d'affichage -->
    <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav navbar-left">
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">League <?php if (isset($league)) echo ' - '.$league['nameleague'] ?><b class="caret"></b></a>
				<ul class="dropdown-menu">
                    <?php if(!empty($leagues)){?>
    					<?php foreach($leagues as $lg): ?>
    						<li><a href="accueil/<?php echo $lg['idleague'];?>"><?php echo $lg['nameleague'];?></a></li>
    					<?php endforeach; ?>

                        <li class="divider"></li>
					<?php } ?>
					<li><a href="league/">Create or join a league</a></li>
				</ul>
			</li>
			<?php if (isset($league)): ?>
                <?php if ($_SESSION['league']['blockinvit']!=0){ ?>
    				<li class="dropdown">
    					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Team management<b class="caret"></b></a>
    					<ul class="dropdown-menu">
    						<li><a href="team/">Teams</a></li>
    						<li><a href="budget/">Budget</a></li>
    						<li class="divider"></li>
    						<li><a href="draft/">Draft</a></li>
    						<li><a href="result/">Result draft</a></li>
    					</ul>
    				</li>
    				<li><a href="match/">Matchs</a></li>
                <?php } ?>
				<li><a href="players/">Players</a></li>
			<?php endif; ?>
			
		</ul>
        <ul class="nav navbar-nav navbar-right">
            <?php if (isset($user)): ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-user"></span> <?= $this->nettoyer($user['username']) ?> <b class="caret"></b>&nbsp&nbsp&nbsp&nbsp</a>
                    <ul class="dropdown-menu">
                        <li><a href="connexion/deconnecter">Log out</a></li>
                    </ul>
                </li>
            <?php else: ?>
                <li><a href="connexion/">Log In &nbsp&nbsp</a></li>
            <?php endif; ?>
        </ul>
    </div>
</div>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-81012686-2', 'auto');
  ga('send', 'pageview');

</script>