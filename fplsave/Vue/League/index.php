<?php $this->titre = "League"; ?>

<?php require 'Vue/_Commun/barreNavigation.php'; ?>


<?php if (isset($msgErreur)) : ?>
	<div class="alert alert-danger alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<strong>Error !</strong> <?= $this->nettoyer($msgErreur) ?>
	</div>
<?php endif; ?>
		
<div class="container">
    <div class="row">
        <div class="col-sm-12">
			<div class="col-sm-3"></div>
			<div class="col-sm-6">
				<h1>Create your league ...</h1>
				<form class='formplayer' name="form1" method="post" role="form" action="league/createorjoinleague">
					<input class="form-control" type="text" name="nameleaguetocreate" placeholder="League's name" required>
					<input class="form-control" type="text" name="nameteam" placeholder="Team's name" required>
					<input type="submit" class="btn btn-success btn-block"value='Create'>
				</form>
			</div>
			<div class="col-sm-3"></div>
		</div>
		<div class="col-sm-12">
            <div class="page-header"></div>
        </div>
		<div class="col-sm-12">
			<div class="col-sm-3"></div>
			<div class="col-sm-6">
				<h1 class='text-right'> ...or join league</h1>
				<form class='formplayer' name="form1" method="post" role="form" action="league/createorjoinleague">
					<input class="form-control" type="text" name="nameteam" placeholder="Team's name" required>
					<input class="form-control" type="text" name="idleaguetojoin" placeholder="Enter league's code" required>
					<input type="submit" class="btn btn-success btn-block" value='Join'>
				</form>
			</div>
			<div class="col-sm-3"></div>
        </div>
	</div>
</div>

