<?php $this->titre = "Match"; ?>

<?php require 'Vue/_Commun/barreNavigation.php'; ?>


<div class="container">
	<div class="row">
        <div class="col-sm-12">
            <div class="page-header">
                <h1>Gameweek <?php echo $gameweek;?></h1>
				<ul class="pager">
					<?php if($gameweek>1){?><li class="previous"><a href="match/<?php echo $gameweek-1;?>"><span class="glyphicon glyphicon-menu-left"></span>Gameweek <?php echo $gameweek-1;?></a></li><?php }?>
					<?php if($gameweek<38){?><li class="next"><a href="match/<?php echo $gameweek+1;?>">Gameweek <?php echo $gameweek+1;?><span class="glyphicon glyphicon-menu-right"></span></a></li><?php }?>
				</ul>
            </div>
			<p></p>
        </div>
        <div class="col-sm-12">
			<div class="panel-group" id="accordion">
				<?php foreach($matchs as $i=>$match): ?>
					<div class="panel panel-default">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $i;?>">
						<div class="panel-heading">
							<h4 class="text-center">
								
									<?php echo $match['teamname1'].' - '.$match['teamname2'];?>
								
							</h4>
						</div>
						</a>
						<div id="collapse<?php echo $i;?>" class="panel-collapse collapse">
							<div class="panel-body">In progress..</div>
						</div>
					</div>
				<?php endforeach; ?>
				  
			</div>
		</div>
	</div>
</div>
		

