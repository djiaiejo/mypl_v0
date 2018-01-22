<?php

require_once 'ControleurPersonnalise.php';
require_once 'Modele/Team.php';

/**
 * Contrôleur de la page d'accueil
 * 
 */
class ControleurTeam extends ControleurPersonnalise {

    private $team;
    
    public function __construct() {
        $this->team = new Team();
    }
    
    /**
     * Affiche la page d'accueil
     */
    public function index() {
				
        $teams = $this->getTeams();
		$id = $this->getcurentid($teams);
        $theteam = $this->getTeam($id);
		
		$players = $this->initplayers();
	
		$i=0;
		while($player = $theteam->fetch()){
			
			switch ($player['position']) {
				case 'GK':
					$players[$player['starter']]['GK'][$i] = $player;
					break;
				case 'DEF':
					$players[$player['starter']]['DEF'][$i] = $player;
					break;
				case 'MID':
					$players[$player['starter']]['MID'][$i] = $player;
					break;
				default:
					$players[$player['starter']]['FWD'][$i] = $player;
					break;
			}
			$i++;
		}
		$players=array_reverse($players);
		
        $this->genererVue(array('players' => $players, 'teams' => $teams, 'curentid' => $id));
		
    }
	
	public function drop(){
		
		$user = $this->requete->getSession()->getAttribut("user");
        $iduser = $user['ID'];
		
		$idplayer = $this->requete->getParametre("idtodrop");
		
		$this->team->dropPlayer($iduser, $idplayer);
				
		$this->rediriger("team");
	}
	
	public function change(){
		$user = $this->requete->getSession()->getAttribut("user");
        $iduser = $user['ID'];
		
		$league = $this->requete->getSession()->getAttribut("league");
		$idleague = $league['idleague'];
		
		$idplayertosubs = $this->requete->getParametre("idplayertosubs");
		$changecaptain = $this->requete->getParametre("changecaptain");
		$sellplayer = $this->requete->getParametre("sellplayer");
		
		if($changecaptain==1){
			$this->team->isthenewcaptain($idleague, $iduser, $idplayertosubs);
		}else if($sellplayer==1){
			$this->team->sellplayer($idleague, $iduser, $idplayertosubs);
		}else{
			if($idplayertosubs!=0){
				$this->team->changeto($idleague, $iduser, $idplayertosubs, 0);
			}
			
			$idplayertostart = $this->requete->getParametre("idplayertostart");
			$this->team->changeto($idleague, $iduser, $idplayertostart, 1);
		}

		$this->rediriger("team");
	}
	
	// recupere la liste des equipe d'une ligue
	private function getTeams(){
		$league = $this->requete->getSession()->getAttribut("league");
		$idleague = $league['idleague'];
        $teams = $this->team->getTeams($idleague);
		$i=0;
		while($team = $teams->fetch()){
			$teamlist[$i]=$team;
			$i++;
		}
		return $teamlist;
	}
	
	private function getTeam($idUser){
		$league = $this->requete->getSession()->getAttribut("league");
		$idleague = $league['idleague'];
		
		$theteam = $this->team->getTeamByUser($idUser, $idleague);
		
		return $theteam;
	}
	
	private function getcurentid($teams){
		if ($this->requete->existeParametre("id")) {
			$id = $this->requete->getParametre("id");
		}else{
			$user = $this->requete->getSession()->getAttribut("user");
			$id = $user['ID'];
		}
		return $id;
	}
	
	private function initplayers(){
		$poste['GK'] = array();
		$poste['DEF'] = array();
		$poste['MID'] = array();
		$poste['FWD'] = array();
		
		$players[0]=$poste;
		$players[1]=$poste;
		
		return $players;
	}
}
