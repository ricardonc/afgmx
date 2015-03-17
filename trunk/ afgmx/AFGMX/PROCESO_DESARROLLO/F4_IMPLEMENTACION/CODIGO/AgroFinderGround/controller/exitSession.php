<?php
	session_start();
	$_SESSION['username']=null;
	$_SESSION['level']=null;
	$_SESSION['image']=null;
	session_destroy();
	echo '<script type="text/javascript">document.location="../index.html"</script>';
?>