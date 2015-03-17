<?php
	//Se incluye la clase csConexion para interactuar con la base de datos
	include_once("csConexion.php");
	//Clase csUsers define los usuarios que entraran en el sistema así como las interacciones que se 
	//harán con estos en la base de datos
	class csUsers{
		//Variables
		private $idUser;
		private $name;
		private $lastName;
		private $userName;
		private $password;
		private $level;
		private $email;
		private $image;
		private $active;
		

		//Constructor de la clase csUsers
		public function __construct($args){
			$this->userName= $args[0];
			$this->password= $args[1];
			$this->level= $args[2];
			$this->name= $args[3];
			$this->lastName= $args[4];
			$this->email= $args[5];
			$this->image= $args[6];
			$this->active= $args[7];
			$this->idUser= $args[8];
			//Variable de conexión
			$this->con= new csConexion();
		}
		//Setters and Getters
		public function setIdUser($idUser){
			$this->idUser= $idUser;
		}
		public function getIdUser(){
			return $this->idUser;
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
		public function setUserName($userName){
			$this->userName= $userName;
		}
		public function getUserName(){
			return $this->userName;
		}
		public function setPassword($password){
			$this->password= $password;
		}
		public function getPassword(){
			return $this->password;
		}
		public function setLevel($level){
			$this->level=$level;
		}
		public function getLevel(){
			return $this->level;
		}
		public function setEmail($email){
			$this->email= $email;
		}
		public function getEmail(){
			return $this->email;
		}
		public function setImage($image){
			$this->image= $image;
		}
		public function getImage(){
			return $this->image;
		}
		public function setActive($active){
			$this->active= $active;
		}
		public function getActive(){
			return $this->active;
		}
		public function addUser(){
			$query="insert into users values(default, ";
			$query.="'".mb_strtoupper($this->name,'UTF-8')."', ";
			$query.="'".mb_strtoupper($this->lastName,'UTF-8')."', ";
			$query.="'".$this->userName."', ";
			$query.="'".$this->password."', ";
			$query.="'usuario', ";
			$query.="'".$this->email."', ";
			$query.="'".$this->image."', 1)";
			$this->con->connect();
			$result= $this->con->execute($query);
			$this->con->disconnect();
		}
		public function listUsers($query){
			$list= array();
			$this->con->connect();
			$result= $this->con->execute($query);
			$this->con->disconnect();
			if(mysql_num_rows($result)>0){
				while ($row= mysql_fetch_array($result)) {
					$users= new csUsers(Array(
											$row['username'],
									    $row['password'],
									    $row['level'],
									    $row['name'],
									    $row['lastname'],
									    $row['email'],
									    $row['image'],
									    $row['active'],
									    $row['idUser']));	
					array_push($list, $users);
				}
			}
			return $list;
		}

	}//Fin de la clase csUsers
?>