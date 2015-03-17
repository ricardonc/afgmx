<?
	include_once('../../model/csConexion.php');

	$con= new csConexion();
	if($_REQUEST){
		list($level,$username)= split("/", $_REQUEST["datos"]);	
		$query="update users set level='".$level."' where username='".$username."'";
		$con->connect();
		$result=  $con->execute($query);
		$con->disconnect();

		if($result==false){
			echo '<style>.perfilinfo{
				color: #de2121;
				background: #ebeaea;
				padding: 3px;
				border-radius: 0.3em;
			}</style>';
			echo 'El perfil del usuario '.$username.' no se modificó con éxito intente nuevamente';
		}else{
			echo '<style>.perfilinfo{
				color: #408b67;
				background: #ebeaea;
				padding: 3px;
				border-radius: 0.3em;
			}</style>';
			echo 'El perfil del usuario '.$username.' ha sido modificado';
		}
	}	
?>