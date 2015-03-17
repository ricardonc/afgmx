<?php
	session_start();

	include_once("../model/csSession.php");
	$username= $_POST['txtusuario'];
	$password= md5(sha1($_POST['txtcontrasenia']));


	$session= new csSession(null);

	$session->setUsername($username);
	$session->setPassword($password);

	$table= $session->userExist();

	if(isset($table[0])){
		$row= $table[0];

		if($row->getLevel()=='administrador'){
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
						echo "message : '"; echo '<p>Bienvenido: '.$row->getName().'</p>'; echo "',";
						echo "layout : 'other',
							ttl : 6000,
							effect : 'loadingcircle',
							type : 'notice',
							onClose : function() {
								document.location='../view/content.php';
							}
						});
						notification.show();
					}, 300);
				} );
			})();
			</script>";

			$_SESSION["username"]= $row->getUsername();
			$_SESSION["level"]= $row->getLevel();
			$_SESSION["image"]= $row->getImage();
			$_SESSION["name"]= $row->getName();
			$_SESSION["lastname"]= $row->getLastName();

		}else if($row->getLevel()=='usuario'){
			echo "
				<link rel='stylesheet' href='../view/styles/normalize.css'/>
				<link rel='stylesheet' href='../view/styles/ns-default.css'/>
				<link rel='stylesheet' href='../view/styles/ns-style-other.css'/>
				<link rel='stylesheet' href='../view/styles/login.css'/>
				<script type='text/javascript'src='../view/js/modernizr.custom.js'></script>
				<script type=text/javascript src='../view/js/jquery-1.7.min.js'></script>
				<script type=text/javascript src='../view/js/jquery.easing.1.3.js'></script>";
			echo "<div id='content' style='width:100%;height:100%; position:absolute;'>";
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
						echo "message : '"; echo '<p>Bienvenido: '.$row->getName().'</p>'; echo "',";
						echo "layout : 'other',
							ttl : 6000,
							effect : 'loadingcircle',
							type : 'notice',
							onClose : function() {
								document.location='../view/content.php';
							}
						});
						notification.show();
					}, 300);
				} );
			})();
			</script>";	
			$_SESSION["username"]= $row->getUsername();
			$_SESSION["level"]= $row->getLevel();
			$_SESSION["image"]= $row->getImage();
			$_SESSION["name"]= $row->getName();
			$_SESSION["lastname"]= $row->getLastName();
		}else{
			echo "
				<html lang='es'>
				<meta charset='UTF-8'/>
				<link rel='stylesheet' href='../view/styles/normalize.css'/>
				<link rel='stylesheet' href='../view/styles/ns-default.css'/>
				<link rel='stylesheet' href='../view/styles/ns-style-other.css'/>
				<link rel='stylesheet' href='../view/styles/login.css'/>
				<script type='text/javascript'src='../view/js/modernizr.custom.js'></script>
				<script type=text/javascript src='../view/js/jquery-1.7.min.js'></script>
				<script type=text/javascript src='../view/js/jquery.easing.1.3.js'></script>";
			echo "<div id='content' style='width:100%;height:100%; position:absolute;'>";
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
						echo "message : '"; echo '<p>¡Usuario incorrecto por favor verifique!/p>'; echo "',";
						echo "layout : 'other',
							ttl : 6000,
							effect : 'loadingcircle',
							type : 'notice',
							onClose : function() {
								document.location='../index.html';
							}
						});
						notification.show();
					}, 300);
				} );
			})();
			</script></html>";						

		}
	}else{
				echo "
				<html lang='es'>
				<meta charset='UTF-8'/>
				<link rel='stylesheet' href='../view/styles/normalize.css'/>
				<link rel='stylesheet' href='../view/styles/ns-default.css'/>
				<link rel='stylesheet' href='../view/styles/ns-style-other.css'/>
				<link rel='stylesheet' href='../view/styles/login.css'/>
				<script type='text/javascript'src='../view/js/modernizr.custom.js'></script>
				<script type=text/javascript src='../view/js/jquery-1.7.min.js'></script>
				<script type=text/javascript src='../view/js/jquery.easing.1.3.js'></script>";
			echo "<div id='content' style='width:100%;height:100%; position:absolute;'>";
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
						echo "message : '"; echo '<p>¡Usuario incorrecto por favor verifique!</p>'; echo "',";
						echo "layout : 'other',
							ttl : 6000,
							effect : 'loadingcircle',
							type : 'notice',
							onClose : function() {
								document.location='../index.html';
							}
						});
						notification.show();
					}, 300);
				} );
			})();
			</script></html>";									

	}

?>