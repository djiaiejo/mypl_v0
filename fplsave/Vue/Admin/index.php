<?php $this->titre = "Admin"; ?>

<div class="container">
	<div class="row">
	<div class="col-sm-12">
		<button type="button" onClick="launchplayerupdate()"  class="btn btn-default btn-block">Players update</button>
		<button type="button" class="btn btn-default btn-block">Gameweek update</button>
		<button type="button" class="btn btn-default btn-block">Players stats update</button>
		<div class="page-header"></div>
	</div></div>
</div>


<script>
	function launchplayerupdate(){
		document.location.href="admin/updatePlayer";
	}
</script>