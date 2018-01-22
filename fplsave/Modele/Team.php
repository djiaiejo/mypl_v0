<?php

require_once 'Framework/Modele.php';

class Team extends Modele{

	public function getTeams($idleague) {
		$sql = "select t.name as teamname, u.username, t.id as id, u.ID as iduser from team t, user u where t.iduser=u.ID and t.idleague=?";
        return $this->executerRequete($sql, array($idleague));
	}
	
	public function getTeamByUserSimple($iduser, $idleague) {
		$sql = "select t.iduser as iduser, t.name as teamname, t.id as idteam, t.authorLeague as author from team t where t.iduser=? and t.idleague=?";
        return $this->executerRequete($sql, array($iduser, $idleague))->fetch();
	}

	public function getTeamByUser($iduser, $idleague) {
		$sql = "select t.iduser as iduser, t.name as teamname, t.id as idteam, p.ID as playerid, p.name as playername, p.team as club, mp.price as price, po.position as position, mp.starter as starter, mp.captain as captain, t.authorLeague as author from team t, myplayer mp, player p, position po where t.id=mp.idteam and mp.idplayer=p.ID and p.idposition=po.id and t.iduser=? and t.idleague=?";
        return $this->executerRequete($sql, array($iduser, $idleague));
	}
	
	public function getTeam($idteam, $idleague) {
		$sql = "select t.iduser as iduser, t.name as teamname, t.id as idteam, p.ID as playerid, p.name as playername, p.team as club, mp.price as price, po.position as position, mp.starter as starter from team t, myplayer mp, player p, position po where t.id=mp.idteam and mp.idplayer=p.ID and p.idposition=po.id and t.id=? and t.idleague=?";
        return $this->executerRequete($sql, array($idteam, $idleague));
	}
	
	public function dropPlayer($iduser, $idplayer, $idleague){
		$sql="delete from myplayer where idteam=(select id from team where iduser=? and idleague=?) and idplayer=?";
		$this->executerRequete($sql, array($iduser, $idleague, $idplayer));
		$this->tracedrop($iduser, $idplayer);
	}
	
	public function addPlayer($iduser, $idleague, $idplayer, $price){
		$sql="insert into myplayer (idteam, idplayer, price) values ((select id from team where iduser=? and idleague=?),?,?);";
		$this->executerRequete($sql, array($iduser, $idleague, $idplayer, $price));
	}
	
	private function tracedrop($iduser, $idplayer, $idleague){
		$sql="insert into trace (idplayer, iduser, idleague) values (?,?,?)";
		$this->executerRequete($sql, array($idplayer, $iduser, $idleague));
	}
	
	public function getResult($idleague, $wave){
		$sql="select name, Pr.price, user, win, Pl.ID as PID, username, po.position as position from proposition Pr,player Pl, user U, position po where Pl.idposition=po.id and Pr.player=Pl.ID and Pr.user=U.ID and wave=? and Pr.idleague=?;";
		return $this->executerRequete($sql, array($wave,$idleague));
	}
	
	public function changeto($idleague, $iduser, $idplayer, $starter){
		$sql="update myplayer set starter=? where idplayer=? and idteam=(select id from team where iduser=? and idleague=?)";
		$this->executerRequete($sql, array($starter, $idplayer, $iduser, $idleague));
	}
	public function isthenewcaptain($idleague, $iduser, $idplayer){
		$this->dropcaptain($idleague, $iduser);
		$sql="update myplayer set captain=1 where idplayer=? and idteam=(select id from team where iduser=? and idleague=?)";
		$this->executerRequete($sql, array($idplayer, $iduser, $idleague));
	}
	private function dropcaptain($idleague, $iduser){
		$sql="update myplayer set captain=0 where idteam=(select id from team where iduser=? and idleague=?)";
		$this->executerRequete($sql, array($iduser, $idleague));
	}

	public function sellplayer($idleague, $iduser, $idplayer){
		$sql="delete from myplayer where idplayer=? and idteam=(select id from team where iduser=? and idleague=?)";
		$this->executerRequete($sql, array($idplayer, $iduser, $idleague));
	}
}
?>