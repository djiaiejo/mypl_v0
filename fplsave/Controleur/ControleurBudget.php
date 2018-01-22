<?php

require_once 'ControleurPersonnalise.php';
require_once 'Modele/League.php';

/**
 * Contrôleur de la page d'accueil
 * 
 */
class ControleurBudget extends ControleurPersonnalise {

    private $league;
    
    public function __construct() {
        $this->league = new League();
    }
    
    /**
     * Affiche la page d'accueil
     */
    public function index() {
				
		$listbudget=$this->getlistbudget();
        $this->genererVue(array('listbudget' => $listbudget));
    }
	
	private function getlistbudget(){
		$listbudget=array();
		$league = $this->requete->getSession()->getAttribut("league");
		$idleague = $league['idleague'];
        $budgets = $this->league->getBudgets($idleague);	
		$i=0;
		while($budget = $budgets->fetch()){
			$listbudget[$i]['name']=$budget['username'];
			$listbudget[$i]['nb']=$budget['nb'];
			$listbudget[$i]['price']=$budget['sum'];
			$i++;
		}
		return $listbudget;
	}
	

}
