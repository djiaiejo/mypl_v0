<?php

require_once 'ControleurPersonnalise.php';
require_once 'Modele/League.php';

/**
 * Contrôleur de la page d'accueil
 * 
 */
class ControleurLeague extends ControleurPersonnalise {

    private $league;
    
    public function __construct() {
        $this->league = new League();
    }
    
    public function index() {
		
        $this->genererVue();
		
    }
	
	public function createorjoinleague(){
		$author = 1;
		if ($this->requete->existeParametre("nameleaguetocreate")) {
			$nameleaguetocreate = $this->requete->getParametre("nameleaguetocreate");
			$idleaguetojoin=$this->league->createLeague($nameleaguetocreate);
		}else if($this->requete->existeParametre("idleaguetojoin")) {
			$idleaguetojoin = $this->requete->getParametre("idleaguetojoin");
			$author = 0;	
		}else{
			$this->genererVue(array('msgErreur' => 'No choice'),"index");
		}
		$this->joinleague($idleaguetojoin, $author);
	}
	
	private function joinleague($idleague, $author=0){
		$user = $this->requete->getSession()->getAttribut("user");
        $iduser = $user['ID'];
		
		if($this->league->alreadyjoin($iduser, $idleague)){
			$this->genererVue(array('msgErreur' => 'You are already in this league'),"index");
		}else if($this->league->isblocked($idleague)){
			$this->genererVue(array('msgErreur' => "It's impossible to join this league, it's closed"),"index");
		}else{
			if ($this->requete->existeParametre("nameteam")) {
				$nameteam = $this->requete->getParametre("nameteam");
				$this->league->joinLeague($iduser, $idleague, $nameteam, $author);
				$this->gotonewleague($idleague);
			}
		}
	}
	
	private function gotonewleague($idleague){
		$league = $this->league->getLeague($idleague);
        $this->requete->getSession()->setAttribut("league", $league);
        $this->rediriger("accueil");
	}
	
}
