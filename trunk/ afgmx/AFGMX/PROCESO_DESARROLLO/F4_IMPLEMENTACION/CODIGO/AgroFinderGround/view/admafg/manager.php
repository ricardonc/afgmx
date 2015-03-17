<?php
    session_start();
    if(!isset($_SESSION["username"]) && !isset($_SESSION["level"])){
        echo "<script>document.location='../../index.html'</script>";
    }else if($_SESSION["level"]=="administrador"){
        $username= $_SESSION["username"];
        $level= $_SESSION["level"];
        $image= $_SESSION["image"];
    }else{
        echo "<script>document.location='../../index.html'</script>";
    }
?>
<!DOCTYPE html>
<!--[if lt IE7]><html lang="es" class="no-js ie6 lt8"><![endif]-->
<!--[if IE 7]>  <html lang="es" class="no-js ie7 lt8"><![endif]-->
<!--[if IE 8]>  <html lang="es" class="no-js ie8 lt8"><![endif]-->
<!--[if IE 9]>  <html lang="es" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> 
<html lang="es"> 
<!--<![endif]-->
    <head>
        <meta charset="UTF-8"/>
        <!--<meta http-equiv= "X-UA-Compatible" content="IE=edge, chrome=1"> -->
        <title>***Agro Finder Ground***</title>
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
        <meta name="description" content="Aplicación de consulta de tipos de suelo y de cultivo">
        <meta name="keywords" content="agro finder ground","agro","finder","ground","consulta","cultivos","consulta de suelos",
        "consulta","suelos","consulta de cultivos">
        <link rel="shortcut icon" href="../styles/images/favicon.ico">     

        <link rel="stylesheet" href="../styles/stilo.css"/>
        <link rel="stylesheet" href="../styles/menu.css"/>
        <link rel="stylesheet" href="../styles/responsive.css" media="screen" />
        <link rel="stylesheet" href="../styles/normalize.css"/>
        <link rel="stylesheet" href="../boostrapv3/css/bootstrap.min.css" media="screen" />
        <link rel="stylesheet" href="../boostrapv3/css/bootstrap-theme.min.css" media="screen" />
        <link rel="stylesheet" href="../styles/fonts/font-awesome/css/font-awesome.css"/>
        <link rel="stylesheet" href="../styles/ios7-switches.min.css"/>
        <link rel="stylesheet" href="../styles/dataTable.css"/>
        <link rel="stylesheet" type="text/css" href="../styles/animate.min.css"/>

        <script  src="../js/classie.js"></script>
        <script  src="../js/html5.js"></script>
        <script  src="../js/modernizr-1.5.min.js"></script>
        <script  src="../js/functions.js"></script>

        <!--[if IE]>
            <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>
    <script type="text/javascript">
        function cerrarSesion(){
            document.frmCerrarSesion.submit();
        }
    </script>
    <form name="frmCerrarSesion" method="post" action="../../controller/exitSession.php"></form>
    <body class="animated fadeInUp">
        <div class="container">
            <!--Cabecera del documento html-->
            <header id="banner" class='animated slideInLeft'>
                <div id="logo">
                <img src="../styles/images/LOGO3.png" width="80px"/>
                </div>
                <hgroup>
                    <h1 id="title">Agro Finder Ground</h1>
                    <h2>Sistema de consulta de suelos de cultivo</h2>
                </hgroup>
            </header>
            <section id="content">
                <div id="actions">
                    <ul class="breadcrumb animated slideInRight">
                        <li>
                            <p>TÚ ESTAS AQUÍ</p>
                        </li>
                        <li><a href="../content.php"><span class="fa fa-home"></span>Inicio</a></li>
                        <li><a href="#" class="active"><span class="fa fa-gears"></span>Administración</a></li>
                    </ul>
                    <!---->
                    <div class="actions-container">
                        <div class="col-md-11 animate fadeIn" id="admusers">
                            <div class="grid simple">
                                <div class="grid-title no-border">
                                    <h4>Administrar  <span class="semi-bold">usuarios</span></h4>
                                    <div class="tools"> <a href="javascript:;" class="collapse"></a></div>
                                </div>
                            <div class="grid-body no-border">
                                <?
                                    include_once('../../model/csUsers.php');
                                    $users= new csUsers(NULL);
                                    $userstable= $users->listUsers('select*from Users order by iduser');
                                    echo '<table class="data-table" id="userstable">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th id="image"></th>
                                                    <th id="name">Nombre</th>
                                                    <th id="lastname">Apellido(s)</th>
                                                    <th id="username">Usuario</th>
                                                    <th id="level">Perfil</th>
                                                    <th id="email">e-mail</th>
                                                    <th id="active">Activo</th>   
                                                </tr>
                                            </thead>
                                            <tbody>';
                                            foreach ($userstable as $row) {
                                                if($row->getUsername()==$username){
                                                }else{
                                                echo '<tr>';
                                                echo '<td></td>';
                                                if($row->getImage()!=""){
                                                    echo '<td id="rowimage"><img src="../../'.$row->getImage().'" class="perfil-image"/></td>';
                                                }else{
                                                    echo '<td id="rowimage"><img src="../styles/images/alt_img_user.png" alt="" class="perfil-image"/></td>';
                                                }
                                                    echo '<td id="rowname">'.$row->getName().'</td>';
                                                    echo '<td id="rowlastname">'.$row->getLastName().'</td>';
                                                    echo '<td id="rowusername">'.$row->getUsername().'</td>';
                                                    echo '<td id="rowlevel">'.$row->getLevel().'</td>';
                                                    echo '<td id="rowemail">'.$row->getEmail().'</td>';
                                                    if($row->getActive()==1){
                                                        echo '<td><div class="switch"><input type="checkbox" name="cbxeliminar" id="cb'.$row->getIdUser().'" 
                                                                    onclick="userDelete('.$row->getIdUser().')" /><label for="cb'.$row->getIdUser().'"><span id="check">NO &nbsp&nbsp SI</span></label>
                                                                </div></td>';
                                                    }else if($row->getActive()==0){
                                                        echo '<td><div class="switch"><input type="checkbox" name="cbxeliminar" checked="checked" id="cb'.$row->getIdUser().'" 
                                                                    onclick="userDelete('.$row->getIdUser().')" /><label for="cb'.$row->getIdUser().'"><span id="check">NO &nbsp&nbsp SI</span></label>
                                                                </div></td>';   
                                                            }
                                                        echo '</tr>';
                                                    } 
                                            }                
                                            echo '</tbody>
                                            </table>';
                                ?>
                                    </div>
                            </div>
                        </div>
                        <div class="col-md-11 animate fadeIn" id="admweather">
                            <div class="grid simple">
                                <div class="grid-title no-border">
                                    <h4>Historial  <span class="semi-bold">climático</span></h4>
                                    <div class="tools"> <a href="javascript:;" class="collapse"></a></div>
                                </div>
                                <div class="grid-body no-border">
                                    <div>
                                        <div class="col-md-4">
                                            <label>Elija una cuidad</label>
                                        </div class="row">
                                        <div class="col-md-4">
                                            <select id="cmb-citys" name="cmb-citys">
                                                <?
                                                    include_once('../../model/csCitys.php');
                                                    $citys= new csCitys(NULL);
                                                    $cmbcitys= $citys->listCitys("select*from citys");
                                                    foreach ($cmbcitys as $option) {
                                                        echo "<option value='".$option->getIdCity()."'>".$option->getName()."</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>    
                    </div>
                    </div>
                <aside class="menu animated fadeInUpBig">
                    <nav class="menu-content">
                        <div id="user_active">
                            <?
                                if($image!=""){
                                    echo "<img src='../../".$image."'/>";
                                }else{
                                    echo '<img src="../styles/images/alt_img_user.png" alt="" class="user_icon"/>';
                                }
                            ?>
                            <a href="" id="user-info-active"><span class="user-name"><small class="user-info-name">Usuario:</small>&nbsp; <? echo $username ?></span></a>
                            <br/>
                            <br/>
                            <br/>
                            <small class="normal small" id="perfil-user">Perfil: </small><span class="bold medium" id="perfil-user"><? echo $level ?></span>
                        </div>
                        <ul class="ca-menu">
                            <li>
                                <a href="../content.php">
                                    <img src="../styles/images/previous.png" width="32px" class="ca-icon"/>
                                    <div class="ca-content">
                                        <h5 class="ca-main">Regresar</h5>
                                    </div>
                                </a>
                            </li>
                            <li id="m-users">
                                <img src="../styles/images/users.png" width="32px" class="ca-icon"/>
                                    <div class="ca-content">
                                        <h5 class="ca-main">Usuarios</h5>
                                    </div>
                            </li>
                            <li id="m-weather">
                                <img src="../styles/images/weatherhistory.png" width="32px" class="ca-icon"/>
                                    <div class="ca-content">
                                        <h5 class="ca-main">Historial climático</h5>
                                    </div>
                            </li>
                            <li id="m-humidity">
                                <img src="../styles/images/weathistory.png" alt="" width="32px" class="ca-icon"/>
                                    <div class="ca-content">
                                        <h5 class="ca-main">Historial de humedad</h5>
                                    </div>
                            </li>
                            <li id="m-wind">
                                <img src="../styles/images/windhistory.png" width="32px" class="ca-icon"/>
                                    <div class="ca-content">
                                        <h5 class="ca-main">Historial del viento</h5>
                                    </div>
                            </li>
                        </ul>
                        <div id="footer-menu">
                            <table>
                                <th>
                                    <tr>
                                        <td title="Suspender"><a href=""><img src="../styles/images/hibernate.png" alt="" width="15px"><span class="normal small-grey">&nbsp; Suspender</span></a></td>
                                        <td title="Cerrar sesión">&nbsp;&nbsp;&nbsp;<a href="javascript:cerrarSesion()"><img src="../styles/images/logout.png" alt="" width="15px"><span class="normal small-grey">&nbsp; Cerrar sesión</span></a></td>
                                    </tr>
                                </th>
                            </table>
                        </div>
                    </nav>      
                </aside>
            </section>
            <footer id="pagefooter">
                <div id="pagefooter_container">
                    
                </div>            
            </footer>
        </div>
        <script  src="../js/plugins/jquery.min.js"></script>        
        <script  src="../js/plugins/jquery-1.11.1.min.js"></script>
        <script  src="../js/plugins/jquery.nicescroll.min.js"></script>
        <script src="../js/plugins/jquery.dataTables.min.js" ></script>
        <script>
             $(document).ready(function(){
                $("#admweather").fadeIn(100).hide();

                $("#m-users").click(function(){
                    $("#admusers").fadeOut(100).slideDown();
                    $("#admweather").fadeIn(100).slideUp();
                });    
                $("#m-weather").click(function(){
                    $("#admweather").fadeOut(100).slideDown();
                    $("#admusers").fadeIn(100).slideUp();
                });
            });
        </script>
        <script >
        function format(d) {
            return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
            '<tr class="tr-details">'+
                '<td class="td-level">Perfil de usuario: </td>'+
                '<td><form name="frmedituser" action="../ajax/editUsers.php">'+
                            '<input type="hidden" value="'+d.Usuario+'" name="hdnusuario" id="hdnusuario"/>'+
                            '<select id="cbxperfil"  class="cs-select cbx-skin-underline" name="cbxperfil" onchange=userEdit()>'+
                            '<option value="" disabled selected>Elija un perfil de usuario</option>'+
                            '<option value="administrador">Administrador</option>'+
                            '<option value="usuario">Usuario</option>'+
                            '</select></form></td>'+
                            '<td><label class="perfilinfo"></label></td></tr>';
        }
        var nice = false;
        $(document).ready(function(){
              nice = $("html").niceScroll({cursorcolor: "#328d6e", cursorborder: "#328d6e",cursoropacitymax:0.9,boxzoom:true});
              $(".ca-menu").niceScroll({cursorcolor: "#747575",cursorborder:"#747575", cursoropacitymax:0.9, boxzoom: true});
            var table=  $("#userstable").DataTable({
                    "iDisplayLength": 6,  
                    "paging": true ,
                    "scrollY": 450,
                    "columns":[
                        {
                            "className": 'details-control',
                             "orderable":      false,
                             "data":           null,
                            "defaultContent": ''
                        },
                         { "data": "" },
                        { "data": "Nombre" },
                        { "data": "Apellidos" },
                        { "data": "Usuario" },
                        { "data": "Perfil" },
                        { "data": "e-mail" },
                        { "data": "Activo" }
                    ],
              });
            $(window).bind('resize', function () {
                    table.columns.adjust().draw();
                } );

              $("#userstable tbody").on('click', 'td.details-control', function(){
                     var tr = $(this).closest('tr');
                    var row = table.row( tr );
 
                        if ( row.child.isShown() ) {
                                row.child.hide();
                                tr.removeClass('shown');
                        }
                    else {
                        row.child( format(row.data()) ).show();
                        tr.addClass('shown');
                        }
                });
        });
        </script>        
        <script >
            function userEdit(){
                        if($(".cbx-skin-underline").val()==""){
                            $(".perfilinfo").html("elija un perfil diferente");
                        }
                        else{
                            var datos= "datos="+$(".cbx-skin-underline").val()+"/"+$("#hdnusuario").val();
                            $.ajax({
                                type: "POST",
                                url: "../ajax/userUpdate.php",
                                data: datos,
                                success: function(data){
                                    $(".perfilinfo").html(data);
                                    javascript:location.reload();
                                }
                            });
                        }
                    };
        </script>
    </body>
</html>