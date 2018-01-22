<?php

require_once 'ControleurPersonnalise.php';
require_once 'Modele/Schedule.php';

/**
 * Contrôleur de la page d'accueil
 * 
 */
class ControleurMatch extends ControleurPersonnalise {

    private $schedule;
    
    public function __construct() {
        $this->schedule = new Schedule();
    }
    
   
    public function index() {
		$league = $this->requete->getSession()->getAttribut("league");
		$idleague = $league['idleague'];
		
		$gameweek = $this->getgameweek($idleague);
		
		$schedule=$this->schedule->getSchedule($idleague, $gameweek);
		$i=0;
		while($match = $schedule->fetch()){
			$matchs[$i]=$match;
			$i++;
		}
		/*
		echo '<pre>';
		print_r($matchs);
		echo '</pre>';
		*/
        $this->genererVue(array('matchs' => $matchs, 'gameweek' => $gameweek));
		
    }
	
	private function getgameweek($idleague){
		if ($this->requete->existeParametre("id")) {
			$id = $this->requete->getParametre("id");
		}else{
			$id=1;
		}
		return $id;
	}
	
	
}
