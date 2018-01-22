<?php $this->titre = "Teams"; ?>

<?php require 'Vue/_Commun/barreNavigation.php'; ?>

<div class="container">
  <!-- Trigger the modal with a button -->
  <input type="hidden" id="openmodal" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal"/>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="titlemodal">Which changement</h4>
        </div>
        <div class="modal-body">
        	<button id="btnsellplayer" type="button" class="btn btn-default btn-block" onClick="sellplayer()">Sell the player</button>
			<button id="btnmarrkascaptain" type="button" class="btn btn-default btn-block" onClick="changecaptain()">Mark as captain</button>
			<button id="btnsubstitute" data-toggle="collapse" data-target="#demo" class="btn btn-default btn-block">Substitute</button>
			<div id="demo" class="collapse">
				<div class="list-group" id="tablesubs">	
					<?php foreach($players[1] as $playerbystarter){ ?>
						<?php foreach($playerbystarter as $player){ ?>
							<a onClick="selectplayer(<?php echo $player['playerid'];?>)" class="list-group-item"><?php echo $player['position'].'	- <image src="Contenu/Images/team/'.str_replace(' ','',$player['club']).'.png" title="'.$player['club'].'" width="25" height="25"/> - '.$player['playername'];?></a>
						<?php }?>
					<?php } ?>
				</div>
			</div>
        </div>
        <div class="modal-footer">
          <button type="button" id="closemodal" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>

<div class="container">
	<div class="row">
        <div class="col-sm-12">
            <div class="page-header">
                <h1>Teams details</h1>
            </div>
			<p></p>
        </div>
        <div class="col-sm-12">
			<h3>Check the other team</h3>
			<select class="form-control" onChange="location.href='team/'+this.options[this.selectedIndex].value;">
				<?php foreach($teams as $team):?>
					<option value="<?php echo $team['iduser'];?>" <?php if($team['iduser']==$curentid) echo 'selected';?>><?php echo $team['teamname']; ?></option>
				<?php endforeach; ?>
			</select>
		</div>


        <div class="col-sm-12">
			<?php foreach($players as $isstarter=>$playerbystarter){
				$nb=0;
				if($isstarter==0)
					echo '<h3>Starter</h3>';
				else echo '<h3>Substitute</h3>'; ?>
						
				<table id="table" class="table table-hover">
					<?php foreach($playerbystarter as $playerbyposition){ ?>
						<?php foreach($playerbyposition as $player){ 
							$nb++;?>
							<tr>
								<td>
									<input type="hidden" value="<?php echo $player['playerid'].'|'.$isstarter;?>"/>
									<?php echo $player['playername'];?>
									<?php if ($player['captain']==1){?>
										<span class="label label-info">Captain</span>
									<?php }?>
								</td>
								<td><?php echo $player['position'];?></td>
								<td><image src="Contenu/Images/team/<?php echo str_replace(' ','',$player['club']);?>.png" title="<?php echo $player['club'];?>" width="25" height="25"/></td>
							</tr>
						<?php } ?>
					<?php } ?>
				</table>
				<?php if($isstarter==0 && $nb<11 && $curentid == $user['ID']) {?>
					<button class="btn btn-info btn-block" onClick="addStarter()">Add to starter</button>
				<?php }?>
			<?php } ?>
			
		</div>
	</div>
</div>

<form class='form' name="form1" method="post" role="form" action="team/change">
	<input type="hidden" value="" name="changecaptain" id="changecaptain"/>
	<input type="hidden" value="" name="idplayertosubs" id="idplayertosubs"/>
	<input type="hidden" value="" name="idplayertostart" id="idplayertostart"/>
	<input type="hidden" value="" name="sellplayer" id="sellplayer"/>
	<button style="visibility: hidden;" name="Submit" id="submitLI" class="btn btn-lg btn-primary btn-block" type="submit">Save</button>
</form>



<script>
	$( "#table tbody tr" ).on( "click", function( event ) {

		$( "#btnmarrkascaptain").show();
		var input = $(this).find("input");
		var inputval = input.val();
		var inputsplit = inputval.split("|");
		var idplayer = inputsplit[0];
		var isstarter = inputsplit[1];

		if (isstarter==1){
			$( "#btnsubstitute" ).hide();
			$( "#btnmarrkascaptain" ).hide();
		}else{
			$( "#btnsubstitute" ).show();
			$( "#btnmarrkascaptain" ).show();
		}

		$( "#titlemodal" ).text("Action");
		$( "#idplayertosubs" ).val(idplayer);
		$( "#openmodal" ).click();
	});
	
	
	function selectplayer(id){
		$( "#idplayertostart" ).val(id);
		$( "#changecaptain" ).val("0");
		$( "#sellplayer" ).val("0");
		$( "#closemodal" ).click();
		$( "#submitLI" ).click();
	}
	
	function addStarter(){	
		$( "#btnmarrkascaptain").hide();
		$( "#titlemodal" ).text("Add starter");
		$( "#idplayertosubs" ).val("0");
		$( "#openmodal" ).click();	
	}
	
	function changecaptain(){
		$( "#changecaptain" ).val("1");
		$( "#sellplayer" ).val("0");
		$( "#closemodal" ).click();
		$( "#submitLI" ).click();
	}

	function sellplayer(id){
		// Mettre une demande de confirmation
		if(confirm("Are you sure?")){
			$( "#changecaptain" ).val("0");
			$( "#sellplayer" ).val("1");
			$( "#closemodal" ).click();
			$( "#submitLI" ).click();
		}
		
		
	}
</script>