<?php

require_once 'Framework/Controleur.php';
require_once 'Modele/User.php';
require_once 'Modele/League.php';

/**
 * Contrôleur gérant la connexion au site
 *
 */
class ControleurConnexion extends Controleur
{
    private $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function index()
    {
        $this->genererVue();
    }

    public function connecter()
    {
        if ($this->requete->existeParametre("username") && $this->requete->existeParametre("password")) {
            $username = $this->requete->getParametre("username");
            $password = $this->requete->getParametre("password");
            if ($this->user->connect($username, $password)) {
                $this->accueillirClient($username, $password);
            }
            else
                $this->genererVue(array('msgErreur' => 'User inconnu'),
                        "index");
        }
        else
            throw new Exception("Action impossible : courriel ou mot de passe non défini");
    }

    public function deconnecter()
    {
        $this->requete->getSession()->detruire();
        $this->rediriger("accueil");
    }

    public function inscrire()
    {
        if ($this->requete->existeParametre("username") && $this->requete->existeParametre("password") && $this->requete->existeParametre("password2")) {
            $username = $this->requete->getParametre("username");
            $password = $this->requete->getParametre("password");
            $password2 = $this->requete->getParametre("password2");
			if ($password!=$password2){
				$this->genererVue(array('msgErreur' => 'Not the same password?'),"index");
			}

            $this->user->setNewUser($username, $password);
            $this->accueillirClient($username, $password);
        } else
            throw new Exception("Action impossible : tous les paramètres ne sont pas définis");
    }

    /**
     * Enregistre un user connecté dans la session et redirige vers la page d'accueil
     * 
     * @param type $username
     * @param type $password
     */
    private function accueillirClient($username, $password)
    {
        $user = $this->user->getUser($username, $password);
        $this->requete->getSession()->setAttribut("user", $user);
        $this->rediriger("accueil");
    }
	
	

}
