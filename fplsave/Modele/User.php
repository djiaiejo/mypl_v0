<?php

require_once 'Framework/Modele.php';

class User extends Modele
{
    private $sql = "select ID, username, password, admin, lastvisite from user";

    /**
     * Vérifie q'un user existe dans la BD
     * 
     * @param type $login
     * @param type $mdp
     * @return type
     */
    public function connect($login, $mdp)
    {
        $sql = "select ID from user where username=? and password=?";
        $user = $this->executerRequete($sql, array($login, md5($mdp)));
        return ($user->rowCount() == 1);
    }

    /**
     * Renvoie les infos sur un user
     * 
     * @param type $login
     * @param type $mdp
     * @return type
     * @throws Exception
     */
    public function getUser($login, $mdp)
    {
        $sql = $this->sql . " where username=? and password=?";
        $user = $this->executerRequete($sql, array($login, md5($mdp)));
        if ($user->rowCount() == 1)
            return $user->fetch();  // Accès à la première ligne de résultat
        else
            throw new Exception("kek retard alert");
    }

    /**
     * Renvoie les infos sur un user
     * 
     * @param type $idUser
     * @return type
     * @throws Exception
     */
    public function getuserParId($idUser)
    {
        $sql = $this->sql . " where ID=?";
        $user = $this->executerRequete($sql, array($idUser));
        if ($user->rowCount() == 1)
            return $user->fetch();  // Accès à la première ligne de résultat
        else
            throw new Exception("kek retard alert");
    }

    /**
     * Ajoute un nouveau user
     * 
     * @param type $login
     * @param type $password
     */
    public function setNewUser($login, $password)
    {
        $sql = "insert into user(username, password)
            values (?, ?)";
        $this->executerRequete($sql,
                array($login, md5($password)));
    }

    /**
     * Modifie un user existant
     * 
     * @param type $idUser
     * @param type $username
     * @param type $password
     */
    public function setUser($idUser, $username, $password)
    {
        $sql = "update user set username=?, password=? where ID=?";
        $this->executerRequete($sql,
                array($username, md5($password), $idUser));
    }
	
	public function getalluser(){
		return $this->executerRequete($this->sql);
	}

}
