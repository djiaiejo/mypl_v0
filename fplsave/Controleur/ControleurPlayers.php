<?php

require_once 'ControleurPersonnalise.php';
require_once 'Modele/Player.php';

/**
 * Contrôleur de la page d'accueil
 * 
 */
class ControleurPlayers extends ControleurPersonnalise {

    private $player;
    
    public function __construct() {
        $this->player = new Player();
    }
    
    public function index() {
		
		$players = $this->getplayers();
		
        $this->genererVue(array('players' => $players));
		
    }

	private function getplayers(){
		$players = array();
		// $allplayers = $this->player->getPlayersWithStats();
		$allplayers = $this->player->getAllActivePlayers();
		$i=0;
		while($player = $allplayers->fetch()){
			
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
		return $players;
	}
	
}
