<?php

require_once 'Framework/Controleur.php';

/**
 * Contrôleur abstrait pour les vues devant afficher les infos user
 * 
 */
abstract class ControleurPersonnalise extends Controleur
{
    /**
     * Redéfinition permettant d'ajouter les infos clients aux données des vues 
     * 
     * @param type $donneesVue Données dynamiques
     * @param type $action Action associée à la vue
     */
    protected function genererVue($donneesVue = array(), $action = null)
    {
        $user = null;
        $league = null;
        $leagues = null;
		$test=0;
        // Si les infos user sont présente dans la session...
        if ($this->requete->getSession()->existeAttribut("user")) {
            // ... on les récupère ...
            $user = $this->requete->getSession()->getAttribut("user");
        }
		if ($this->requete->getSession()->existeAttribut("league")) {
            $league = $this->requete->getSession()->getAttribut("league");
        }
		if ($this->requete->getSession()->existeAttribut("leagues")) {
            $leagues = $this->requete->getSession()->getAttribut("leagues");
        }
        // ... et on les ajoute aux données de la vue
        parent::genererVue($donneesVue + array('user' => $user, 'leagues' => $leagues, 'league' => $league, 'test' => $test), $action);
    }

}