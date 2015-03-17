<?php
include_once("csConexion.php");
class csSession{
	private $iduser;
	private $username;
	private $password;
	private $level;
	private $name;
	private $lastName;
	private $image;

	public function __construct($args){
		$this->username= $args[0];
		$this->password= $args[1];
		$this->level= $args[2];
		$this->image= $args[3];
		$this->name= $args[4];
		$this->lastName= $args[5];
		$this->iduser= $args[6];

		$this->con= new csConexion();
	}
	public function setUsername($username){
		$this->username= $username;
	}
	public function getUsername(){
		return $this->username;
	}
	public function setPassword($password){
		$this->password= $password;
	}
	public function getPassword(){
		return $this->password;
	}
	public function setLevel($level){
		$this->level= $level;
	}
	public function getLevel(){
		return $this->level;
	}
	public function setImage($image){
		$this->image= $image;
	}
	public function getImage(){
		return $this->image;
	}
	public function setName($name){
		$this->name= $name;
	}
	public function getName(){
		return $this->name;
	}
	public function setLastName($lastName){
		$this->lastName= $lastName;
	}
	public function getLastName(){
		return $this->lastName;
	}
	public function setIduser($iduser){
		$this->iduser= $iduser;
	}
	public function getIduser(){
		return $this->iduser;
	}
	public function userExist(){
		$query="select*from users where ";
		$query.="username= '".$this->username."' and ";
		$query.="password= '".$this->password."' and active=1;";
		$this->con->connect();
		$result =$this->con->execute($query);
		$this->con->disconnect();
		if(mysql_num_rows($result)>0){
				$row = mysql_fetch_array($result);
				$users = array();
				$tmp = new csSession(array($row["username"], $row["password"], $row["level"],$row["image"],$row["name"],$row["lastName"],$row["iduser"]));
				array_push($users, $tmp);
			}
			return $users;
	}

}
?>