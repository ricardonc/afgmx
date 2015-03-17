<?php
	include_once('csConexion.php');
	class csCitys{
		private $idCity;
		private $name;

		public function __construct($args){
			$this->idCity= $args[0];
			$this->name= $args[1];

			$this->con= new csConexion();
		}
		public function setIdCity($idCity){
			$this->idCity= $idCity;
		}
		public function getIdCity(){
			return $this->idCity;
		}
		public function setName($name){
			$this->name= $name;
		}
		public function getName(){
			return $this->name;
		}
		public function listCitys($query){
			$list= array();
			$this->con->connect();
			$result= $this->con->execute($query);
			$this->con->disconnect();
			if(mysql_num_rows($result)>0){
				while ($row= mysql_fetch_array($result)) {
					$citys= new csCitys(Array(
							$row['idCity'],
							$row['name']
						));
					array_push($list, $citys);
				}
			}
			return $list;
		}
	}
	
?>