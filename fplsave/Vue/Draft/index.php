<?php $this->titre = "Draft"; ?>

<?php require 'Vue/_Commun/barreNavigation.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-header">
                <h1>Draft your team</h1>
            </div>
			<p></p>
        </div>
		
		<?php if (isset($msg)) : ?>
			<div class="col-sm-12">
				<div class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<strong>Success !</strong> <?= $this->nettoyer($msg) ?>
				</div>
			</div>
		<?php endif; ?>
	
		<div class="col-sm-4">
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
						echo '<a href="draft/'.$i.'" class="'.$classButton.'">'.$i.'</a>';
						$i++;
					}
				?>
			</div>
			<div class="page-header">
			
			<input type='hidden' id='budgetinitial' value="<?php echo $budget['tot'];?>"/>
			<input type='hidden' id='nbplinitial' value="<?php echo $budget['nb'];?>"/>
			<input type='hidden' id='budgetmax' value="<?php echo $budget['totmax'];?>"/>
			<input type='hidden' id='nbmax' value="<?php echo $budget['nbmax'];?>"/>

			<p><h3>Budget utilisé : <span id="spanbudget"><?php echo $budget['tot'];?></span>M€</h3></p>
			<p><h3>Nombre de joueur : <span id="spannbpl"><?php echo $budget['nb'];?></span></h3></p>
			
			</div>
			<?php if($wave['waveEnCours']==$wave['wave']) {?>
				<button id="btnsave" onClick="save()" type="button" class="btn btn-success btn-block">Save wave <?php echo $wave['wave']; ?></button>
				<div id="errorMessage" class="alert alert-danger"><strong>Opopo!</strong> You want cheat?</div>		
				<br>
				<?php if ($team['author'] == 1) { ?>
					<button onClick="launchResult()" type="button" class="btn btn-info  btn-block">Lauch result for the wave <?php echo $wave['wave']; ?></button>
				<?php }?>
			<?php }?>
<br>
		</div>
		<br>
		<div class="col-sm-8">				
			<table class='table'>
				<thead>
					<tr>
						<th>Player</th>
						<th>Position</th>
						<th>M€</th>
						<th>My price</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($players['MYLIST'] as $player){ ?>
						<tr>
							<td><?php echo $player['name'];?></td>
							<td><?php echo $player['position'];?></td>
							<td><?php echo $player['price'];?></td>
							<td><?php echo $player['myprice'];?></td>
						</tr>
					<?php }?>
				</tbody>
			</table>
		</div>

		<?php if($wave['waveEnCours']==$wave['wave']) {?>
	        <div class="col-sm-12">
	            <input type="search" id="search" value="" class="form-control" placeholder="Search">
				<form class='formplayer' name="form1" method="post" role="form" action="draft/savedraft" onsubmit="return validateForm()">
					<table class="table" id="table">
						<thead>
							<tr>
								<th>Player</th>
								<th>Position</th>
								<th>Team</th>
								<th>M€</th>
								<th>Add</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($players['GK'] as $player){ ?>
								<tr>
									<td>
										<?php echo $player['name'];?>
										<input type="hidden" name="player_id[]" value="<?php echo $player['ID'];?>"/>
									</td>
									<td><?php echo $player['position'];?></td>
									<td><image src="Contenu\Images\team\<?php echo str_replace(' ','',$player['team']);?>.png" alt="<?php echo $player['team'];?>" width="10%" data-toggle="tooltip" title="<?php echo $player['team'];?>"/></td>
									<td><?php echo $player['price'];?></td>
									<?php if($wave['waveEnCours']==$wave['wave']) {?>
										<td><input class="form-control" type="number" min="<?php echo $player['price'];?>" name="player_price[]" value="<?php echo $player['priceAsked'];?>"></td>
									<?php }?>
								</tr>
							<?php }?>
							<?php foreach($players['DEF'] as $player){ ?>
								<tr>
									<td>
										<?php echo $player['name'];?>
										<input type="hidden" name="player_id[]" value="<?php echo $player['ID'];?>"/>
									</td>
									<td><?php echo $player['position'];?></td>
									<td><image src="Contenu\Images\team\<?php echo str_replace(' ','',$player['team']);?>.png" alt="<?php echo $player['team'];?>" width="10%" data-toggle="tooltip" title="<?php echo $player['team'];?>"/></td>
									<td><?php echo $player['price'];?></td>
									<?php if($wave['waveEnCours']==$wave['wave']) {?>
										<td><input class="form-control" type="number" min="<?php echo $player['price'];?>" name="player_price[]" value="<?php echo $player['priceAsked'];?>"></td>
									<?php }?>
								</tr>
							<?php }?>
							<?php foreach($players['MID'] as $player){ ?>
								<tr>
									<td>
										<?php echo $player['name'];?>
										<input type="hidden" name="player_id[]" value="<?php echo $player['ID'];?>"/>
									</td>
									<td><?php echo $player['position'];?></td>
									<td><image src="Contenu\Images\team\<?php echo str_replace(' ','',$player['team']);?>.png" alt="<?php echo $player['team'];?>" width="10%" data-toggle="tooltip" title="<?php echo $player['team'];?>"/></td>
									<td><?php echo $player['price'];?></td>
									<?php if($wave['waveEnCours']==$wave['wave']) {?>
										<td><input class="form-control" type="number" min="<?php echo $player['price'];?>" name="player_price[]" value="<?php echo $player['priceAsked'];?>"></td>
									<?php }?>
								</tr>
							<?php }?>
							<?php foreach($players['FWD'] as $player){ ?>
								<tr>
									<td>
										<?php echo $player['name'];?>
										<input type="hidden" name="player_id[]" value="<?php echo $player['ID'];?>"/>
									</td>
									<td><?php echo $player['position'];?></td>
									<td><image src="Contenu\Images\team\<?php echo str_replace(' ','',$player['team']);?>.png" alt="<?php echo $player['team'];?>" width="10%" data-toggle="tooltip" title="<?php echo $player['team'];?>"/></td>
									<td><?php echo $player['price'];?></td>
									<?php if($wave['waveEnCours']==$wave['wave']) {?>
										<td><input class="form-control" type="number" min="<?php echo $player['price'];?>" name="player_price[]" value="<?php echo $player['priceAsked'];?>"></td>
									<?php }?>
								</tr>
							<?php }?>
						</tbody>
					</table>
					<button style="visibility: hidden;" name="Submit" id="submitLI" class="btn btn-lg btn-primary btn-block" type="submit">Save</button>
				</form>
	        </div>
	    <?php } ?>
    </div>
</div>

<script>

$("#errorMessage").hide();

$(function () {
    $( '#table' ).searchable({
        striped: true,
        oddRow: { 'background-color': '#f5f5f5' },
        evenRow: { 'background-color': '#fff' },
        searchType: 'fuzzy'
    });
    
    $( '#searchable-container' ).searchable({
        searchField: '#container-search',
        selector: '.row',
        childSelector: '.col-xs-4',
        show: function( elem ) {
            elem.slideDown(100);
        },
        hide: function( elem ) {
            elem.slideUp( 100 );
        }
    })
});

function validateForm(){
	return true;
}

function save(){
	$( "#submitLI" ).click();
}

majBudget();
			
function majBudget(){
	var nbPl=0;
	var budget=0;
	$(".formplayer input[type='number']").each(function () {
		if($(this).val() != '') {
			nbPl++;
			budget=budget+parseInt($(this).val());
		}
	});
	majUI(nbPl, budget);
}

$( ".form-control" ).change(function() {
	majBudget();
});
			
function majUI(nbpl, budget){
	var budgetinitial = $("#budgetinitial").val();
	var nbplinitial = $("#nbplinitial").val();
	$("#spanbudget").text(parseInt(budgetinitial)+parseInt(budget));
	$("#spannbpl").text(parseInt(nbplinitial)+parseInt(nbpl));

	var budgetmax = $("#budgetmax").val();
	var nbmax = $("#nbmax").val();

	if (parseInt(budgetinitial)+parseInt(budget) > parseInt(budgetmax) || parseInt(nbplinitial)+parseInt(nbpl) > parseInt(nbmax)){
		blockForm(1);
	}else{
		blockForm(0);
	}

}

function blockForm(ok){
	if (ok == 0) {
		$("#btnsave").show();
		$("#errorMessage").hide();
	}else{
		$("#btnsave").hide();
		$("#errorMessage").show();
	}
}


function launchResult(){
	document.location.href="result/launchResult";
}


$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});

</script>




