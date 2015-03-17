<?
	include_once("../../model/csConexion.php");
	$con= new csConexion();

	if($_POST["query"]){
		$con->connect();
		$query= "select*from users where idUser=".$_POST["query"];
		$result= $con->execute($query);
		$con->disconnect();
		$active;
		if(mysql_num_rows($result)>0){
			while($row= mysql_fetch_array($result)){
				$active= $row["active"];
			}
			if($active==1){
				$con->connect();
				$con->execute("update users set active=0 where idUser=".$_POST["query"]);
				$con->disconnect();
			}else if($active==0){
				$con->connect();
				$con->execute("update users set active=1 where idUser=".$_POST["query"]);
				$con->disconnect();
			}	
		}
	}
?>