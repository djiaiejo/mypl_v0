<?php $this->titre = "Home"; ?>

<?php require 'Vue/_Commun/barreNavigation.php'; ?>

<div class="container">
	<div class="row">
	
		<div class="col-sm-12">
			<h1><small>League - </small><?php echo $_SESSION['league']['nameleague'];?></h1>
			<?php if ($_SESSION['league']['blockinvit']==0){?>

				<?php if ($team['author'] == 1) { ?>

					<h1><small>Admin your league</small></h3>
					<div class="col-sm-12">
						<p>Your league isn't start. Only invitations are open.</p>
						<p>
							When launch your league :
							<ul>
								<li>The draft is open</li>
								<li>The calendar is generate</li>
							</ul>
						</p>
						<button type="button" onClick='startyourleague()'class="btn btn-success  btn-block">Start your league <span class="glyphicon glyphicon-circle-arrow-right"></span></button>
					</div>
					
				<?php } ?>
			<?php }?>

		</div>
		
		<div class="col-sm-12">
			<div class="page-header"></div>
			<h1><small>Classement</small></h3>
			<table class="table">
				<thead>
					<tr>
						<th>Position</th>
						<th>Team</th>
						<th>user</th>
						<th>w-d-l</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($teams as $team): ?>
						<tr>
							<td></td>
							<td>
								<?php echo $team['teamname']; 
								if($team['iduser']==$user['ID']){?>
									<span class="glyphicon glyphicon-edit"></span>
								<?php }?>
							</td>
							<td><?php echo $team['username'];?></td>
							<td></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		
		<div class="col-sm-12">
			<div class="page-header"></div>
			<h1><small>Last actions</small></h1>
			<table class="table">
				<thead>
					<tr>
						<th>user</th>
						<th>action</th>
						<th>player</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$date='';
						foreach($traces as $trace):
							if($date!=$trace['date'] || $date==''){
								$date=$trace['date'];?>
								<tr class="info"><th colspan=3><?php echo $trace['date'];?></th></tr>
							<?php } ?>
						<tr>
							<td><?php echo $trace['username']; ?></td>
							<td>droped</td>
							<td><?php echo $trace['playername']; ?></td>
						</tr>
						
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>


<script>

function startyourleague(){
	var r = confirm("Are you sure to start your league? No one will can join");
		if (r == true) {
			document.location.href="accueil/startleague"
		}
}
</script>
