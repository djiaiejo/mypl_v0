<?php

require_once 'ControleurPersonnalise.php';
require_once 'Modele/Team.php';
require_once 'Modele/League.php';

/**
 * Contrôleur de la page d'accueil
 * 
 */
class ControleurResult extends ControleurPersonnalise {

    private $team;
    private $league;
    
    public function __construct() {
        $this->team = new Team();
        $this->league = new League();
    }
    
    /**
     * Affiche la page d'accueil
     */
    public function index() {
		
		// gestion wave
		$wave = $this->getwave();
		
		$propositions = array();
		$players = $this->initplayers();
		
		$league = $this->requete->getSession()->getAttribut("league");
		$idleague = $league['idleague'];
		
        $teams = $this->team->getResult($idleague, $wave['waveEnCours']);
		while($player = $teams->fetch()){
			$propositions[$player['user']]['ID']=$player['user'];
			$propositions[$player['user']]['name']=$player['username'];
			switch ($player['position']) {
				case 'GK':
					$players['GK'][$player['PID']]['name'] = $player['name'];
					$players['GK'][$player['PID']][$player['user']]['price'] = $player['price'];
					$players['GK'][$player['PID']][$player['user']]['win'] = $player['win'];
					break;
				case 'DEF':
					$players['DEF'][$player['PID']]['name'] = $player['name'];
					$players['DEF'][$player['PID']][$player['user']]['price'] = $player['price'];
					$players['DEF'][$player['PID']][$player['user']]['win'] = $player['win'];
					break;
				case 'MID':
					$players['MID'][$player['PID']]['name'] = $player['name'];
					$players['MID'][$player['PID']][$player['user']]['price'] = $player['price'];
					$players['MID'][$player['PID']][$player['user']]['win'] = $player['win'];
					break;
				default:
					$players['FWD'][$player['PID']]['name'] = $player['name'];
					$players['FWD'][$player['PID']][$player['user']]['price'] = $player['price'];
					$players['FWD'][$player['PID']][$player['user']]['win'] = $player['win'];
					break;
			}
		}
		$statpage=array();
		$statpage['nbCol'] = count($propositions)+1;
		
        $this->genererVue(array('players' => $players, 'statpage' => $statpage, 'propositions' => $propositions, 'wave' => $wave));
		
    }

    public function launchResult(){
    	$league = $this->requete->getSession()->getAttribut("league");
		$idleague = $league['idleague'];

		$wave = $this->getwave();

		$propositions = $this->league->getProposition($wave['wave'], $idleague);

		if (!empty($propositions)){
			$first=0;

			foreach ($propositions as $proposition) {
				if ($first == 0){
					$winplayer = $proposition;
					$first=1;
				}else {
					if ($winplayer['player'] == $proposition['player']){
						if($proposition['price'] > $winplayer['price']){
							$winplayer = $proposition;
						}
						if($proposition['price'] == $winplayer['price'] && $proposition['date'] < $winplayer['date']){
							$winplayer = $proposition;
						}
					}else{
						$this->league->winProposition($winplayer['user'], $idleague, $winplayer['player']);
						$this->team->addPlayer($winplayer['user'], $idleague, $winplayer['player'], $winplayer['price']);
						$winplayer = $proposition;
					}
				}
			}

			$this->league->winProposition($winplayer['user'], $idleague, $winplayer['player']);
			$this->team->addPlayer($winplayer['user'], $idleague, $winplayer['player'], $winplayer['price']);

			$this->league->nextwave($idleague, $wave['wave']);
		}
    	$this->rediriger("result");
	}
	
	private function getwave(){
		$league = $this->requete->getSession()->getAttribut("league");
		$idleague = $league['idleague'];
		
		$wave = $this->league->getlastwave($idleague);
        if ($this->requete->existeParametre("id")) {
			$wave['waveEnCours'] = $this->requete->getParametre("id");
		}else{
			if($wave['wave']>1){
				$wave['waveEnCours'] = $wave['wave']-1;
			}else{
				$wave['waveEnCours'] = $wave['wave'];
			}
		}
		return $wave;
	}
	
	private function initplayers(){
		$players['GK']=array();
		$players['DEF']=array();
		$players['MID']=array();
		$players['FWD']=array();
		return $players;
	}

}
