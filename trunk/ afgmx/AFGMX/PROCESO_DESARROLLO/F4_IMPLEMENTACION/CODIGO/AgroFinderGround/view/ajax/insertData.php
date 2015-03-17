<?php
	include_once('../../model/csConexion.php');
	$con= new csConexion();

	if(isset($_POST["data"])){
		list($city,$humidity,$current_temp,$description,$cloudines,$windspeed,$date)= split("/",$_POST["data"]);

		$con->connect();
		$exist= $con->execute("select*from citys where name='".$city."'");
		$con->disconnect();
		if(mysql_num_rows($exist)<1){
			
			$query="insert into citys values(default,'".$city."')";
			$con->connect();
			$result=$con->execute($query);
			$con->disconnect();	
		}
		
		$query="select w.dateRegistry, c.name from weather w ";
		$query.="join citys c on c.idCity= w.idCity ";
		$query.="where w.dateRegistry='".$date."' and c.name='".$city."'";
		
		$con->connect();
		$exist=$con->execute($query);
		$con->disconnect();
		if(mysql_num_rows($exist)<1){
			
			$query1= "select idCity from citys where name='".$city."'";
			$con->connect();
			$result=$con->execute($query1);
			$con->disconnect();
			if(mysql_num_rows($result)>0){
				while($row= mysql_fetch_array($result)){
					$query2= "insert into weather values(default";
					$query2.=",'".$description."',".$current_temp.",".$cloudines.",".$row['idCity'].",'".$date."',".$windspeed.")";
					$con->connect();
					$con->execute($query2);
					$con->disconnect();
				}

			}
		}
		$query3="select h.dateRegistry, c.name from  humidity h ";
		$query3.="join citys c on c.idCity= h.idCity ";
		$query3.="where h.dateRegistry='".$date."' and c.name='".$city."'";

		$con->connect();
		$exist=$con->execute($query3);
		$con->disconnect();
		echo $query3;
		if(mysql_num_rows($exist)<1){
			
			$query4= "select idCity from citys where name ='".$city."'";
			$con->connect();
			$result=$con->execute($query4);
			$con->disconnect();
			if(mysql_num_rows($result)>0){
				while($row= mysql_fetch_array($result)){
					$query5= "insert into humidity values(default,'".$humidity."',".$row['idCity'].",'".$date."')";
					$con->connect();
					$con->execute($query5);
					$con->disconnect();
				}		
			}
		}
	}	
?>