<?php
session_start();
$url = ($_SESSION["cont"] == "")
	? fread(fopen("../styles/images/inputfileimg.gif", "rb"), filesize("../styles/images/inputfileimg.gif"))
	: $_SESSION["cont"];
$tip = ($_SESSION["tipo"] == "")
	? "image/gif"
	: $_SESSION["tipo"];
header("Content-type: $tip");
echo $url;
session_destroy();
?>
