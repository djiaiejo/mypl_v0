<?php

require_once 'ControleurPersonnalise.php';
require_once 'Modele/Player.php';
require_once 'Framework/curl/curl.php';

/**
 * http://www.football-data.org/documentation
 */

/**
 * Contrôleur de la page d'accueil
 * 
 */
class ControleurAdmin extends ControleurPersonnalise {

	private $player;
    
    public function __construct() {
        $this->player = new Player();
    }

    public function index() {
		
        $this->genererVue();
		
    }
    
    public function updatePlayer() {

    	$this->player->initPlayers();

    	$listeID='';
		flush();
		ob_flush();

    	$curl = new Curl;
    	$response = $curl->get('http://www.transfermarkt.fr/wettbewerb/startseite/wettbewerb/GB1');

    	preg_match_all('#<a class="vereinprofil_tooltip" href="(/[^/]*/startseite/verein/[^/]*/saison_id/2017)#', $response, $out);

    	foreach($out[1] as $i => $teamurl) {
    		$response2 = $curl->get('http://www.transfermarkt.fr'.$teamurl);
			// Team name
			preg_match('#Effectif de ([^&]*)&body#', $response2, $outclubname);
			
			if(empty($outclubname)){
				$team="Brighton And Hove Albion";
			}else{
				$team = $outclubname[1];
			}

			preg_match_all('#<a title="([^"]*)" class="[^"]*" id="([^"]*)" href="[^"]*">[^<]*</a></span></div>.*</td></tr><tr><td>([^<]*)</td></tr></table></td><td class="[^"]*" itemprop="[^"]*">[^<]*</td><td class="[^"]*">[^<]*</td><td class="[^"]*">.*</td><td class="[^"]*">([^<]*)<#', $response2, $out2);
			
			echo "Récupération de l'équipe de ".$team.' : '.count($out2[1]).' joueurs récupérés<br>';

			for ($i = 0; $i < count($out2[1]); $i++) {
				$name = $out2[1][$i];
				$id = $out2[2][$i];
				$position = $out2[3][$i];
				$price = $out2[4][$i];
				// Price management
				if(preg_match('#mio#',$price)){
					preg_match('#([^ ]*).*#',$price,$outprice);
					$price = $outprice[1];
				}else{
					$price = '1';
				}
				
				try {
					$this->player->addplayer($team, $id, $name, $position, $price);
				} catch (Exception $e) {
					echo 'Errot : '.$e;
					exit;
				}

				if ($listeID==''){
					$listeID = '"'.$id.'"';
				}else{
					$listeID = $listeID.',"'.$id.'"';
				}
				
				flush(); 
				ob_flush();
			}
    	}
    }
}
