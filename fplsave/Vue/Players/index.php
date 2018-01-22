<?php $this->titre = "Players"; ?>

<?php require 'Vue/_Commun/barreNavigation.php'; ?>


<div class="container">
	<div class="row">
        <div class="col-sm-12">
            <div class="page-header">
                <h1>Players</h1>
            </div>
			<p></p>
        </div>
        <div class="col-sm-12">
            <input type="search" id="search" value="" class="form-control" placeholder="Search">
			<table class="table" id="table">
				<thead>
					<tr>
						<th>Player</th>
						<th>Position</th>
						<th>Team</th>
						<th>Price</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($players as $playerbyposition){ ?>
						<?php foreach($playerbyposition as $player){ ?>
							<tr>
								<td><?php echo $player['name'];?></td>
								<td><?php echo $player['position'];?></td>
								<td><?php echo $player['team'];?></td>
								<td><?php echo $player['price'];?></td>
							</tr>
						<?php } ?>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
		

<script>

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
	
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip(); 
	});

</script>




