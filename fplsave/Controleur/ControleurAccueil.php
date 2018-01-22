<?php

require_once 'ControleurPersonnalise.php';
require_once 'Modele/Trace.php';
require_once 'Modele/League.php';
require_once 'Modele/Team.php';
require_once 'Modele/Schedule.php';

/**
 * Contrôleur de la page d'accueil
 * 
 */
class ControleurAccueil extends ControleurPersonnalise {

    private $trace;
    private $league;
    private $team;
    private $schedule;
    
    public function __construct() {
        $this->trace = new Trace();
        $this->league = new League();
        $this->team = new Team();
        $this->schedule = new Schedule();
    }
    
    /**
     * Affiche la page d'accueil
     */
    public function index() {
		
        if ($this->requete->getSession()->existeAttribut("user")) {

			$user = $this->requete->getSession()->getAttribut("user");
			$iduser = $user['ID'];

			if ($this->requete->existeParametre("id")) {
				$idleague = $this->requete->getParametre("id");
			}else if($user['lastvisite']==''){
				$idleague=0;
			}else{
				$idleague=$user['lastvisite'];
			}

			if ($user['admin']==1){
				$this->rediriger("admin");
			}

			$this->getleagues();
			$idleague = $this->getidleague($idleague);

			// On save qu'on a visité cette ligue en dernier
			$this->league->lastvisite($iduser, $idleague);
						
			// On récupère la liste des équipes
			$teams = $this->team->getTeams($idleague);
			// On récupère les traces
			$traces = $this->trace->getTraces($idleague);
			// On récupère son équipe
			$team = $this->team->getTeamByUserSimple($iduser, $idleague);
			
			$this->genererVue(array('traces' => $traces, 'teams' => $teams, 'team' => $team));
			
		}else{
			$this->rediriger("connexion");
		}
        
    }
	
	public function startleague(){
		$idleague = $this->getidleague();
		$teams = $this->team->getTeams($idleague);
		
		$i=0;
		while($team = $teams->fetch()){
			$listteams[$i]=$team;
			$i++;
		}
		
		// gestion nb pair des teams
		$tailletab = count($listteams);
		if($tailletab % 2 != 0){
			$teamsupp['teamname']='League average';
			$teamsupp['id']=0;
			array_push($listteams, $teamsupp);
		}
		
		$schedule = $this->scheduler($listteams);
		$this->createcalendar($schedule, $idleague);
		
		$this->league->blockinvit($idleague);
		
		$this->rediriger("accueil");
	}
		 
		 
	private function scheduler ( $teams ){
		$away = array_splice ( $teams ,( count ( $teams )/ 2 ));
		$home = $teams ;
		for ( $i = 0 ; $i < count ( $home )+ count ( $away )- 1 ; $i ++){
			for ( $j = 0 ; $j < count ( $home ); $j ++){
				if (( $i % 2 != 0 ) && ( $j % 2 == 0 )){
					$schedule [ $i ][ $j ][ "Home" ]= $away [ $j ];
					$schedule [ $i ][ $j ][ "Away" ]= $home [ $j ];
				} else {
					$schedule [ $i ][ $j ][ "Home" ]= $home [ $j ];
					$schedule [ $i ][ $j ][ "Away" ]= $away [ $j ];
				}
			}
			if( count ( $home )+ count ( $away )- 1 > 2 ){
			array_unshift ( $away , array_shift ( array_splice ( $home , 1 , 1 )));
			array_push ( $home , array_pop ( $away ));
			}
		}
		return $schedule ;
	}

	private function createcalendar($schedule, $idleague){
		$gameweek=0;
		$pair=0;
		while ($gameweek<38){
			shuffle($schedule);
			foreach($schedule AS $round => $games){
				$gameweek++;
				foreach($games AS $play){
					if($gameweek<=38){
						if($pair==0){
							$this->schedule->setMatch($idleague, $gameweek, $play["Away"]['id'], $play["Home"]['id']);
						}else{
							$this->schedule->setMatch($idleague, $gameweek, $play["Home"]['id'], $play["Away"]['id']);
						}
					}
				}
			}
			if($pair==0){$pair=1;}else{$pair=0;}
		}
	}
 

		

		

	
	////////////////////////////////////////////////////////////////
	// Private functions
	////////////////////////////////////////////////////////////////
	
	private function getleagues(){
		if(!$this->requete->getSession()->existeAttribut("leagues")){
			$user = $this->requete->getSession()->getAttribut("user");
			$iduser = $user['ID'];
			$leagues = $this->league->getLeaguesByUser($iduser);
			$i=0;
			while($league = $leagues->fetch()){
				$listleagues[$i]=$league;
				$i++;
			}
			$this->requete->getSession()->setAttribut("leagues", $listleagues);
		}
	}
	
	private function getidleague($idleague){
		if($idleague!=0){
			$league = $this->league->getLeague($idleague);
			$this->requete->getSession()->setAttribut("league", $league);
		}else if ($this->requete->existeParametre("id")) {
			$idleague = $this->requete->getParametre("id");
			$league = $this->league->getLeague($idleague);
			$this->requete->getSession()->setAttribut("league", $league);
		}else if($this->requete->getSession()->existeAttribut("league")){
			$league = $this->requete->getSession()->getAttribut("league");
			$idleague = $league['idleague'];
		}else{
			$this->rediriger("league");
		}
		return $idleague;
	}
}
