<?php
	class csConexion{
	 	private $con;

	 	public function connect(){
	 		$this->con= mysql_connect("localhost","root","AgroFG090_$") or die("Error al intentar conectar ".mysql_error());
	 		mysql_select_db("AgroFG",$this->con) or die("Error al intentar conectar con la base dedatos ".mysql_error());
	 	}
	 	public function disconnect(){
	 		$res= mysql_close($this->con) or die("Error al cerrar la conexión verifique que no se ejecute un proceso en segundo plano ".mysql_error());
	 	}
	 	public function execute($query){
	 		$res= mysql_query($query,$this->con);
	 		if(!$res){
	 			die("Error en la ejecución de sintáxis SQL=".$query);
	 		}
	 		return $res;
	 	}
	}
?>