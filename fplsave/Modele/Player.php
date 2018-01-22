<?php

require_once 'Framework/Modele.php';

class Player extends Modele{

	public function getPlayer() {
		$sql = "select t.name as teamname, u.username from team t, user u where t.iduser=u.ID";
        return $this->executerRequete($sql);
	}
	
	public function getPlayers($idleague){
		$sql="select * from player p, position po where p.idposition=po.id and p.id not in (select idplayer from myplayer m, team t where t.id=m.idteam and t.idleague=?) and actif=1 ORDER BY team, name;";
		return $this->executerRequete($sql, array($idleague));
	}

	public function getlistmyplayer($iduser, $wave, $idleague){
		$sql="select player, price from proposition where user=? and wave=? and idleague=?;";
		return $this->executerRequete($sql, array($iduser, $wave, $idleague))->fetchAll(PDO::FETCH_GROUP);
	}

	public function getmydraft($iduser, $wave, $idleague){
		$sql="select pl.name as name, pl.position as position, pl.price as price, pr.price as myprice from player pl, proposition pr where pl.id=pr.player and pr.user=? and pr.wave=? and pr.idleague=?";
		return $this->executerRequete($sql, array($iduser, $wave, $idleague))->fetchAll();
	}
	
	public function delproposition($iduser, $wave, $idleague){
		$sql='DELETE From proposition WHERE user=? and wave=? and idleague=?;';
		$this->executerRequete($sql, array($iduser, $wave, $idleague));
	}
	
	public function addproposition($player_id,$price, $wave, $iduser, $idleague){
		$sql='INSERT INTO proposition (user, player, idleague, price, wave) VALUES(?, ?, ?, ?, ?);';
		$this->executerRequete($sql, array($iduser, $player_id, $idleague, $price, $wave));
	}
	
	public function getPlayersWithStats() {
		$sql = "select p.ID, p.name, (select position from position where id=idposition) as position, count(s.idgameweek) as nbgameweek, sum(passesfailed) as passesfailed, sum(passessuccess) as passessuccess, sum(passesgoalassist) as passesgoalassist, sum(passeschancecreated) as passeschancecreated, sum(shotsofftarget) as shotsofftarget, sum(shotsontarget) as shotsontarget, sum(shotsgoal) as shotsgoal, sum(shotsblocked) as shotsblocked, sum(takeonsfail) as takeonsfail, sum(takeonssuccess) as takeonssuccess, sum(defensivefailedtackle) as defensivefailedtackle, sum(defensivesuccessfultackle) as defensivesuccessfultackle, sum(defensiveinterceptions) as defensiveinterceptions, sum(defensivesuccessfulclearance) as defensivesuccessfulclearance, sum(defensivefailedclearance) as defensivefailedclearance, sum(defensiveballrecoverye) as defensiveballrecoverye, sum(defensiveblockedshot) as defensiveblockedshot, sum(defensiveblockedcross) as defensiveblockedcross, sum(aerialduelswon) as aerialduelswon, sum(aerialduelslost) as aerialduelslost, sum(foulscommited) as foulscommited, sum(foulssuffered) as foulssuffered from player p, playerid pi, stats s where p.id=pi.idplayer and pi.idfft=s.idplayer group by p.ID, p.name";
        return $this->executerRequete($sql);
	}
	
	public function getAllActivePlayers() {
		$sql = "select name, (select position from position where id=idposition) as position, team, price from player where actif=1";
        return $this->executerRequete($sql);
	}

	public function addplayer($team, $id, $name, $position, $price){
		$sql = "INSERT INTO player VALUES(?,?,?,?,?, (select id from position where sousposition=?), 1) ON DUPLICATE KEY UPDATE team=?,price=?, actif=1";
		$price = str_replace(',','.',$price);
		$this->executerRequete($sql, array($id, $name, $position, $team, $price, $position, $team, $price));
	}

	public function initPlayers() {
		$sql = "UPDATE player SET actif=0";
		$this->executerRequete($sql);
	}
}
?>
