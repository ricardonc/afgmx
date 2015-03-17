<?php
	session_start();
	$defecto = "../styles/images/inputfileimg.gif";
	$Ok = isset($_FILES["imagen"]);
	$url = ($Ok) ? $_FILES["imagen"]["tmp_name"] : $defecto;
	list($anchura, $altura, $tipoImagen, $atributos) = getimagesize($url);
	$error = (isset($atributos)) ? 0 : 1;
	$los_tipos = array("gif", "jpg", "png");
	$tipo = ($Ok) ? "image/".$los_tipos[$tipoImagen - 1] : "image/gif";
	$fichero = ($Ok && ($error == 0)) ? $_FILES["imagen"]["name"] : $defecto;
	$tam = filesize($url);
	$maxTam = ($OkTam) ? 0 : 200000;
	$maxAncho = ($OkAncho) ? 0 : 1000;
	$maxAlto = ($OkAlto) ? 0 : 1000;
	$error += ($tam <= $maxTam) ? 0 : 2;
	$ancho = ($error == 1) ? 0 : $anchura;
	$alto = ($error == 1) ? 0 : $altura;
	$error += ($ancho <= $maxAncho) ? 0 : 4;
	$error += ($alto <= $maxAlto) ? 0 : 8;
	$datos = ($error == 0) ? $url : $defecto;
	$onload = ($Ok) ? "onload='parent.datosImagen($tam, $ancho, $alto, $error)'": '';
	$datos_imagen = fread(fopen($datos, "rb"), filesize($datos));
	$_SESSION["cont"] = $datos_imagen;
	$_SESSION["tipo"] = ($error == 0) ? $tipo : "image/gif";
?>
<html >
<head>
<style type="text/css" >
html	{
	height: 100%;
	padding: 0px;
	margin: 0px;
}
body	{
	height: 80px;
	overflow: hidden;
	background-color: #ededed;
	background-repeat: no-repeat;
	background-position: center center;
	padding:0px;
	margin: 0px;
}
</style>
</head>
<body <?=$onload;?>>
	<img src="preview.php?dato=<?=$fichero;?>" style="width:90px!important; margin: auto 0px"/>
</body>
</html>