<?php


require_once 'Framework/Modele.php';

class Trace extends Modele{

    public function getTraces($idleague) {
		$sql = "select p.name as playername, u.username as username, DATE_FORMAT(t.date, '%d/%m/%Y') as date from trace t, player p, user u where t.idplayer=p.ID and t.iduser=u.ID and t.idleague=? order by date desc";
        return $this->executerRequete($sql, array($idleague));
	}

}
?>