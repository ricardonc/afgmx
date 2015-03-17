<?php
	sleep(2);
	include_once('../../model/csConexion.php');	

	$con= new csConexion();
	if($_REQUEST){
		$username= $_REQUEST['username'];
		$query= "select*from users where username='".$username."'";

		$con->connect();
		$result= $con->execute($query);
		$con->disconnect();

		if(mysql_num_rows($result)>0){
			echo '<script src="view/js/classie.js"></script>
				<script src="view/js/notificationFx.js"></script>';
			echo "<script>";
			echo "(function(){
				var txt = document.getElementById( 'txtusuario1' );
				var btn= document.getElementById('btnlogin');
				$(document).ready(function(){
					classie.add( txt, 'active' );
						setTimeout( function() {";
			echo "classie.remove( txt, 'active' );";
			echo "var notification = new NotificationFx({";
			echo "message: '";
			echo '<div class="ns-thumb"><img src="view/styles/images/alert.png"/></div><div class="ns-content"><p>El nombre de usuario no está disponible, elija otro nombre de usuario.</p></div>';
			echo "',";
										echo "layout : 'other',";
										echo "ttl : 4000,
										effect : 'thumbslider',
										type : 'warning',
										onClose : function() {
																					
										}
									});
									notification.show();
									$('#validate-info').fadeIn(1000);
								}, 300 );
				});
			})();</script>";
		}else{
			echo '<script src="view/js/classie.js"></script>
				<script src="view/js/notificationFx.js"></script>';
			echo "<script>";
			echo "(function(){
				var txt = document.getElementById( 'txtusuario1' );
				var btn= document.getElementById('btnlogin');
				$(document).ready(function(){
					classie.add( txt, 'active' );
						setTimeout( function() {";
			echo "classie.remove( txt, 'active' );";
			echo "var notification = new NotificationFx({";
			echo "message: '";
			echo '<div class="ns-thumb"><img src="view/styles/images/ok.png"/></div><div class="ns-content" style="background: #27A88F!important;"><p>¡Usuario disponible!.</p></div>';
			echo "',";
										echo "layout : 'other',";
										echo "ttl : 4000,
										effect : 'thumbslider',
										type : 'warning',
										onClose : function() {
																					
										}
									});
									notification.show();
									$('#validate-info').fadeIn(1000);
								}, 300 );
				});
			})();</script>";
		}
	}
?>