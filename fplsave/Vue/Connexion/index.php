<?php $this->titre = "Connection"; ?>

<div class="text-center"><img src='Contenu/Images/logo.png' width="20%"/></div>

<div class="well">
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
            <ul class="nav nav-tabs nav-justified">
                <li class="active"><a href="#connexion" data-toggle="tab">Log In</a></li>
                <li><a href="#inscription" data-toggle="tab">Sign In</a></li>
            </ul>
        </div>
    </div>
	<br>
    <div class="tab-content">
        <div class="tab-pane fade in active" id="connexion">
            <form class="form-signin form-horizontal" role="form" action="connexion/connecter" method="post">
                <div class="form-group">
                    <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                        <input name="username" type="text" class="form-control" placeholder="Username" required autofocus>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                        <input name="password" type="password" class="form-control" placeholder="Password" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="text-center">
                        <button type="submit" class="btn btn-default btn-primary"><span class="glyphicon glyphicon-log-in"></span> Log In</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="tab-pane fade" id="inscription">
            <form class="form-horizontal" role="form" action="connexion/inscrire" method="post">
                <div class="form-group">
                    <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                        <input name="username" type="text" class="form-control" placeholder="Username" required autofocus>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                        <input name="password" type="password" class="form-control" placeholder="Password" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                        <input name="password2" type="password" class="form-control" placeholder="Confirm password" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="text-center">
                        <button type="submit" class="btn btn-default btn-primary"><span class="glyphicon glyphicon-edit"></span> Sign in</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php if (isset($msgErreur)) : ?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Erreur !</strong> <?= $this->nettoyer($msgErreur) ?>
    </div>
<?php endif; ?>