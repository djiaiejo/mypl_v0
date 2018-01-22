<?php

require_once 'Framework/Modele.php';

class League extends Modele {
    
	
	public function getlastwave($idleague){
		$sql = "SELECT wave from league where id=?";
        return $this->executerRequete($sql, array($idleague))->fetch();
	}
	
	public function createLeague($name){
		$sql = "INSERT INTO league(LABEL) VALUES (?)";
        $this->executerRequete($sql, array($name));
		return $this->getlastid();
	}
	
	public function updateLeagueName($idleague, $name){
		$sql = "update league set label=? where id=?";
        $this->executerRequete($sql, array($name, $idleague));
	}
	
	public function joinLeague($iduser, $idleague, $name, $author){
		$sql = "INSERT INTO team (iduser, idleague, name, authorLeague) VALUES (?,?,?,?)";
        $this->executerRequete($sql, array($iduser, $idleague, $name, $author));
	}
	
	public function getLeague($idleague){
		$sql = "select id as idleague, label as nameleague, blockinvit, limitebudget, limitnbplayer from league where id=?";
        return $this->executerRequete($sql, array($idleague))->fetch();
	}
	
	public function getLeaguesByUser($iduser){
		$sql = "select l.id as idleague, l.label as nameleague from league l, team t where l.id=t.idleague and iduser=?";
        return $this->executerRequete($sql, array($iduser));
	}
	
	public function blockinvit($idleague){
		$sql = "update league set blockinvit=1 where id=?";
        $this->executerRequete($sql, array($idleague));
	}
	
	public function unblockinvit($id){
		$sql = "update league set blockinvit=0 where id=?";
        $this->executerRequete($sql, array($idleague));
	}
	
	public function alreadyjoin($iduser, $idleague)
    {
        $sql = "select id from team where iduser=? and idleague=?";
        $league = $this->executerRequete($sql, array($iduser, $idleague));
        return ($league->rowCount() == 1);
    }
	
	public function isblocked($idleague){
		$sql = "select id from league where id=? and blockinvit=1";
        $league = $this->executerRequete($sql, array($idleague));
        return ($league->rowCount() == 1);
	}
	
	public function getBudgets($idleague){
		$sql = "SELECT U.username, sum(mp.price) as sum, count(mp.price) as nb FROM team t, myplayer mp, user U where t.iduser=U.id and t.id=mp.idteam and t.idleague=? group by t.iduser;";
        return $this->executerRequete($sql, array($idleague));
	}
	
	public function getBudget($iduser, $idleague){
		$sql = "SELECT COUNT(*) as nb, SUM(mp.price) as tot from team t, myplayer mp where t.id=mp.idteam and t.iduser=? and t.idleague=?";
        return $this->executerRequete($sql, array($iduser, $idleague))->fetch();
	}

	public function getBudgetLimit($iduser, $idleague){
		$sql = "SELECT * from team t where t.iduser=? and t.idleague=?";
        return $this->executerRequete($sql, array($iduser, $idleague))->fetch();
	}

	public function getProposition($wave, $idleague){
		$sql = "SELECT * from proposition where wave=? and idleague=? order by player";
        return $this->executerRequete($sql, array($wave, $idleague))->fetchAll();
	}

	public function winProposition($iduser, $idleague, $idplayer){
		$sql = "UPDATE proposition set win=1 where user=? and idleague=? and player=?";
        $this->executerRequete($sql, array($iduser, $idleague, $idplayer));
	}

	public function nextwave($idleague, $wave){
		$wave++;
		$sql = "UPDATE league set wave=? where id=?";
        $this->executerRequete($sql, array($wave, $idleague));
	}

	public function lastvisite($iduser, $idleague){
		$sql = "INSERT INTO lastvisite(iduser, idleague) VALUES (?,?)";
		$sql = "INSERT INTO lastvisite(iduser, idleague) VALUES(?,?) ON DUPLICATE KEY UPDATE idleague=?";

		$sql = "update user set lastvisite=? where id=?";	
        $this->executerRequete($sql, array($idleague, $iduser));
	}

}
