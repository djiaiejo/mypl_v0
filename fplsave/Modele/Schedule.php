<?php

require_once 'Framework/Modele.php';

class Schedule extends Modele{

	public function getSchedule($idleague, $gameweek) {
		$sql = "select s.id as id, t1.name as teamname1, t2.name as teamname2 from team t1, team t2, schedule s where t1.id=s.idteamhome and t2.id=s.idteamaway and s.idleague=? and s.gameweek=?";
        return $this->executerRequete($sql, array($idleague, $gameweek));
	}
	
	public function setMatch($idleague, $gameweek, $idteamhome, $idteamaway){
		$sql = "INSERT INTO schedule (idleague,gameweek,idteamhome,idteamaway) VALUES (?,?,?,?)";
        $this->executerRequete($sql, array($idleague,$gameweek,$idteamhome,$idteamaway));
	}
	
}
?>