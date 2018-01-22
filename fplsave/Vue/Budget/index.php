<?php $this->titre = "Budgets"; ?>

<?php require 'Vue/_Commun/barreNavigation.php'; ?>



<div class="container">
	<div class="row">
        <div class="col-sm-12">
            <div class="page-header">
                <h1>Budget</h1>
            </div>
			<p></p>
        </div>
        <div class="col-sm-12">
		
			<table class="table">
				<thead>
					<tr>
						<th>user</th>
						<th>Player</th>
						<th>Budget</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($listbudget as $budget){ ?>
						<tr>
							<td><?php echo $budget['name'];?></td>
							<td><?php echo $budget['nb'];?></td>
							<td><?php echo $budget['price']?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		
		</div>
	</div>
</div>
