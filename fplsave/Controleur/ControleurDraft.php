<?php

require_once 'ControleurPersonnalise.php';
require_once 'Modele/Player.php';
require_once 'Modele/Team.php';
require_once 'Modele/League.php';
require_once 'Modele/User.php';

/**
 * Contrôleur de la page d'accueil
 * 
 */
class ControleurDraft extends ControleurPersonnalise {

    private $player;
    private $league;
    private $team;
    private $user;
    
    public function __construct() {
        $this->player = new Player();
        $this->league = new League();
        $this->user = new User();
        $this->team = new Team();
    }
    
    /**
     * Affiche la page d'accueil
     */
    public function index() {
		$user = $this->requete->getSession()->getAttribut("user");
        $iduser = $user['ID'];
		
		$league = $this->requete->getSession()->getAttribut("league");
		$idleague = $league['idleague'];
		
		$wave = $this->getwave($idleague);
		
		$budget = $this->getbudget($iduser, $idleague);
		
		$players = $this->initplayers($iduser, $wave['waveEnCours'], $idleague);

		// On récupère son équipe
		$team = $this->team->getTeamByUserSimple($iduser, $idleague);	
		
		
        $this->genererVue(array('players' => $players, 'wave' => $wave, 'budget' => $budget, 'team' => $team));
		
    }
	
	public function savedraft(){
		
		$user = $this->requete->getSession()->getAttribut("user");
        $iduser = $user['ID'];
		
		$league = $this->requete->getSession()->getAttribut("league");
		$idleague = $league['idleague'];

		$wave = $this->getwave($idleague);
		
		$player_price = $this->requete->getParametre("player_price");
		$player_id = $this->requete->getParametre("player_id");

		$this->player->delproposition($iduser, $wave['wave'], $idleague);
	
		foreach($player_price as $i => $price) {
			if ($price != ''){
				$this->player->addproposition($player_id[$i],$price, $wave['wave'], $iduser, $idleague);
			}
		}
		$this->rediriger("draft");
	}

	private function getwave($idleague){
		$wave = $this->league->getlastwave($idleague);
        if ($this->requete->existeParametre("id")) {
			$wave['waveEnCours'] = $this->requete->getParametre("id");
		}else{
			$wave['waveEnCours'] = $wave['wave'];
		}
		return $wave;
	}
	
	private function getbudget($iduser, $idleague){
		$budgets = $this->league->getbudget($iduser, $idleague);	
		$budget = $budgets;
		if ($budget['tot']=='') $budget['tot']=0;

		$budgets = $this->league->getBudgetLimit($iduser, $idleague);

		$budget['totmax'] = $budgets['budget'];
		$budget['nbmax'] = $budgets['maxplayer'];

		return $budget;
	}
	
	private function initplayers($iduser, $wave, $idleague){
		$players['GK'] = array();
		$players['DEF'] = array();
		$players['MID'] = array();
		$players['FWD'] = array();
		$players['MYLIST'] = array();
		
		$tabWave = $this->getwave($idleague);
		$players['MYLIST'] = $this->player->getmydraft($iduser, $wave, $idleague);

		// Si c'est la wave en cours
		if($tabWave['wave']==$wave){
			$listplayers = $this->player->getPlayers($idleague);
			$listmyplayer = $this->player->getlistmyplayer($iduser, $wave, $idleague);

			$i=0;
			while($player = $listplayers->fetch()){
				

				if (array_key_exists($player['ID'], $listmyplayer)) {
					$player['priceAsked'] = $listmyplayer[$player['ID']][0]['price'];
				}else{
					$player['priceAsked'] = null;
				}

				//var_dump($player);

				switch ($player['position']) {
					case 'GK':
						$players['GK'][$i] = $player;
						break;
					case 'DEF':
						$players['DEF'][$i] = $player;
						break;
					case 'MID':
						$players['MID'][$i] = $player;
						break;
					default:
					$players['FWD'][$i] = $player;
						break;
				}
				$i++;
			}
		}

		

		

		
		return $players;
	}
}
