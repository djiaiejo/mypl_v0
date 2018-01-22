<?php $this->titre = "Result"; ?>

<?php require 'Vue/_Commun/barreNavigation.php'; ?>


<div class="container">
	<div class="row">
        <div class="col-sm-12">
            <div class="page-header">
                <h1>Result page</h1>
            </div>
			<p></p>
        </div>
        <div class="col-sm-12">

			<div class="btn-group" role="group" aria-label="...">
				<span class="label label-info">Wave</span>
				<?php 
					$i=1;
					while($i<=$wave['wave']){
					if($wave['waveEnCours']==$i) {
							$classButton = 'btn btn-primary';
						}else {
							$classButton = 'btn btn-default';
						}
						echo '<a href="result/'.$i.'" class="'.$classButton.'">'.$i.'</a>';
						$i++;
					}
				?>
			</div>
		</div>
		<div class="col-sm-12">
			<?php if($wave['waveEnCours']<$wave['wave']){ ?>
				<table class="table">
					<thead>
						<tr>
							<th>player's name</th>
							<?php foreach($propositions as $proposition){ 
								echo "<th>".$proposition['name']."</th>";
							} ?>
						</tr>
					</thead>
					<tbody>
						<tr class="info"><th colspan=<?php echo $statpage['nbCol']; ?>>GK</th></tr>
						<?php foreach($players['GK'] as $player){ ?>
							<tr>
								<td>
									<?php echo $player['name'];?>
								</td>
								<?php foreach($propositions as $proposition){ 
									if (array_key_exists($proposition['ID'], $player)) {
										if ($proposition['ID'] == $user['ID']){
											$case='th';
										}else{
											$case='td';
										}
										echo "<".$case."";
										if($player[$proposition['ID']]['win']==1){
											echo ' class="success"';
										}
										
										echo ">".$player[$proposition['ID']]['price']."</".$case.">";
									}else{
										echo "<td></td>";
									}
								}?>
							</tr>
						<?php }?>
						<tr class="info"><th colspan=<?php echo $statpage['nbCol']; ?>>DEF</th></tr>
						<?php foreach($players['DEF'] as $player){ ?>
							<tr>
								<td>
									<?php echo $player['name'];?>
								</td>
								<?php foreach($propositions as $proposition){ 
									if (array_key_exists($proposition['ID'], $player)) {
										if ($proposition['ID'] == $user['ID']){
											$case='th';
										}else{
											$case='td';
										}
										echo "<".$case."";
										if($player[$proposition['ID']]['win']==1){
											echo ' class="success"';
										}
										echo ">".$player[$proposition['ID']]['price']."</".$case.">";
									}else{
										echo "<td></td>";
									}
								}?>
							</tr>
						<?php }?>
						<tr class="info"><th colspan=<?php echo $statpage['nbCol']; ?>>MID</th></tr>
						<?php foreach($players['MID'] as $player){ ?>
							<tr>
								<td>
									<?php echo $player['name'];?>
								</td>
								<?php foreach($propositions as $proposition){ 
									if (array_key_exists($proposition['ID'], $player)) {
										if ($proposition['ID'] == $user['ID']){
											$case='th';
										}else{
											$case='td';
										}
										echo "<".$case."";
										if($player[$proposition['ID']]['win']==1){
											echo ' class="success"';
										}
										echo ">".$player[$proposition['ID']]['price']."</".$case.">";
									}else{
										echo "<td></td>";
									}
								}?>
							</tr>
						<?php }?>
						<tr class="info"><th colspan=<?php echo $statpage['nbCol']; ?>>FWD</th></tr>
						<?php foreach($players['FWD'] as $player){ ?>
							<tr>
								<td>
									<?php echo $player['name'];?>
								</td>
								<?php foreach($propositions as $proposition){ 
									if (array_key_exists($proposition['ID'], $player)) {
										if ($proposition['ID'] == $user['ID']){
											$case='th';
										}else{
											$case='td';
										}
										echo "<".$case."";
										if($player[$proposition['ID']]['win']==1){
											echo ' class="success"';
										}
										echo ">".$player[$proposition['ID']]['price']."</".$case.">";
									}else{
										echo "<td></td>";
									}
								}?>
							</tr>
						<?php }?>
					</tbody>
				</table>
	
			<?php }else{ ?>
				<div class="text-center"><h2>Wave in progress<small>...</small></h2></div>
			<?php }?>	
		</div>
	</div>
</div>
		

