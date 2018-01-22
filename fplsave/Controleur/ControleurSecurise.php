<?php

require_once 'ControleurPersonnalise.php';

/**
 * Contrôleur abstrait pour les actions soumises à authentification du user
 * 
 * @author Baptiste Pesquet
 */
abstract class ControleurSecurise extends ControleurPersonnalise
{

    /**
     * Redéfinition permettant de vérifier qu'un user est connecté
     * 
     * @param type $action
     */
    public function executerAction($action)
    {
        // Si les infos user sont présentes dans la session ...
        if ($this->requete->getSession()->existeAttribut("user")) {
            // ... l'action s'exécute normalement ...
            parent::executerAction($action);
        }
        else {
            // ... ou l'utilisateur est redirigé vers la page de connexion
            $this->rediriger("connexion");
        }
    }

}