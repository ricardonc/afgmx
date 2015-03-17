<?php
	/**
	Código PHP que administra los objetos de tipo csUsers para las
	operaciones CRUD de usuarios.
	Author: Leonardo Luna Ruiz
	versión: 1.1
	**/
	include_once('../model/csUsers.php');

	$password= md5(sha1($_POST['txtcontrasenia1']));
	$image= $_FILES["imagen"]["name"];

	if($image){
		$url='../view/images/perfilimg/'.$image;

		if(COPY($_FILES["imagen"]["tmp_name"], $url)){
				$url='view/images/perfilimg/'.$image;

				$users= new csUsers(Array($_POST['txtusuario1'],
										  $password,
										  'usuario',
										  $_POST['txtnombre'],
										  $_POST['txtapellidos'],
										  $_POST['txtcorreo'],
										  $url));
				$users->addUser();
				echo "
				<link rel='stylesheet' href='../view/styles/normalize.css'/>
				<link rel='stylesheet' href='../view/styles/ns-default.css'/>
				<link rel='stylesheet' href='../view/styles/ns-style-other.css'/>
				<link rel='stylesheet' href='../view/styles/login.css'/>
				<script type='text/javascript'src='../view/js/modernizr.custom.js'></script>
				<script type=text/javascript src='../view/js/jquery-1.7.min.js'></script>
				<script type=text/javascript src='../view/js/jquery.easing.1.3.js'></script>";
				echo "<div id='content' style='width:100%;height:100%; position:absolute'>";
				echo '<div class="notification-shape shape-progress" id="notification-shape">
						<svg width="70px" height="70px"><path d="m35,2.5c17.955803,0 32.5,14.544199 32.5,32.5c0,17.955803 -14.544197,32.5 -32.5,32.5c-17.955803,0 -32.5,-14.544197 -32.5,-32.5c0,-17.955801 14.544197,-32.5 32.5,-32.5z"/></svg>
					</div>';
				echo "<button type='button' id='btntemp' style='display:none'></button></div>";
				echo "<script src='../view/js/classie.js'></script>";
				echo "<script src='../view/js/notificationFx.js'></script>";
				echo '<script>(function(){
					 var bttn= document.getElementById("btntemp");
					 var svgshape = document.getElementById( "notification-shape" );
				 $(document).ready(function(){
						setTimeout( function() {
							var notification = new NotificationFx({';
							echo "wrapper: svgshape,";
							echo "message : '"; echo '<p>Usuario registrado correctamente</p>'; echo "',";
							echo "layout : 'other',
								ttl : 6000,
								effect : 'loadingcircle',
								type : 'notice',
								onClose : function() {
									document.location='../index.html#tologin';
								}
							});
							notification.show();
						}, 300);
					} );
				})();
				</script>";
		}
	}else{
		$users= new csUsers(Array($_POST['txtusuario1'],
								  $password,
							      'usuario',
								   $_POST['txtnombre'],
								   $_POST['txtapellidos'],
								   $_POST['txtcorreo'],''));
		$users->addUser();
		echo "
				<link rel='stylesheet' href='../view/styles/normalize.css'/>
				<link rel='stylesheet' href='../view/styles/ns-default.css'/>
				<link rel='stylesheet' href='../view/styles/ns-style-other.css'/>
				<link rel='stylesheet' href='../view/styles/login.css'/>
				<script type='text/javascript'src='../view/js/modernizr.custom.js'></script>
				<script type=text/javascript src='../view/js/jquery-1.7.min.js'></script>
				<script type=text/javascript src='../view/js/jquery.easing.1.3.js'></script>";
				echo "<div id='content' style='width:100%;height:100%; position:absolute'>";
				echo '<div class="notification-shape shape-progress" id="notification-shape">
						<svg width="70px" height="70px"><path d="m35,2.5c17.955803,0 32.5,14.544199 32.5,32.5c0,17.955803 -14.544197,32.5 -32.5,32.5c-17.955803,0 -32.5,-14.544197 -32.5,-32.5c0,-17.955801 14.544197,-32.5 32.5,-32.5z"/></svg>
					</div>';
				echo "<button type='button' id='btntemp' style='display:none'></button></div>";
				echo "<script src='../view/js/classie.js'></script>";
				echo "<script src='../view/js/notificationFx.js'></script>";
				echo '<script>(function(){
					 var bttn= document.getElementById("btntemp");
					 var svgshape = document.getElementById( "notification-shape" );
				 $(document).ready(function(){
						setTimeout( function() {
							var notification = new NotificationFx({';
							echo "wrapper: svgshape,";
							echo "message : '"; echo '<p>Usuario registrado correctamente</p>'; echo "',";
							echo "layout : 'other',
								ttl : 6000,
								effect : 'loadingcircle',
								type : 'notice',
								onClose : function() {
									document.location='../index.html#tologin';
								}
							});
							notification.show();
						}, 300);
					} );
				})();
				</script>";
	}
	



?>