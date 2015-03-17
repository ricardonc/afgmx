<?php
    header('Access-Control-Allow-Origin: *');
    session_start();
    if(!isset($_SESSION["username"]) && !isset($_SESSION["level"])){
        echo "<script>document.location='../index.html'</script>";
    }else{
        $username= $_SESSION["username"];
        $level= $_SESSION["level"];
        $image= $_SESSION["image"];
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
        <link rel="shortcut icon" href="styles/images/favicon.ico">     

        <link rel="stylesheet" href="styles/stilo.css">
        <link rel="stylesheet" href="styles/menu.css"/>
        <link rel="stylesheet" href="styles/responsive.css"/>
        <link rel="stylesheet" href="styles/normalize.css"/>
        <link rel="stylesheet" href="boostrapv3/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="styles/fonts/font-awesome/css/font-awesome.css">
        <link rel="stylesheet" href="styles/component.css"/>
        <link rel="stylesheet" href="styles/normalize1.css"/>
        <link rel="stylesheet" href="styles/animate.min.css"/>
        

        <script type="text/javascript" src="js/html5.js"></script>
        <script type="text/javascript" src="js/modernizr-1.5.min.js"></script>
        <script type="text/javascript" src="js/customs/modernizr.custom.js"></script>
        <script type="text/javascript">
            function cerrarSesion(){
                document.frmCerrarSesion.submit();
            }
        </script>
        <!--[if IE]>
            <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>
    <form name="frmCerrarSesion" method="post" action="../controller/exitSession.php"></form>
    <body class="animated fadeInUp">
        <div class="container">
            <!--Cabecera del documento html-->
            <header id="banner" class='animated slideInLeft'>
                <div id="logo">
                <img src="styles/images/LOGO3.png" width="80px"/>
                </div>
                <hgroup>
                    <h1 id="title">Agro Finder Ground</h1>
                    <h2>Sistema de consulta de suelos de cultivo</h2>
                </hgroup>
            </header>
            <section id="content">
                <div id="actions">
                    <ul class="breadcrumb animated fadeInRight">
                        <li>
                            <p>TÚ ESTAS AQUÍ</p>
                        </li>
                        <li><a href="#" class="active"><span class="fa fa-home"></span>Inicio</a></li>
                    </ul>
                    <div id="zoomlevel" class="control-background">
                        <legend>Zoom</legend>
                        <div class="box">
                            <button class="cbutton cbutton--effect-ivana" id="more">
                                <i class="cbutton__icon fa fa-1x fa-plus-circle"></i>
                                <span class="cbutton__text">Más</span>
                            </button>
                            <button class="cbutton cbutton--effect-ivana" id="less">
                                <i class="cbutton__icon fa fa-1x fa-minus-circle"></i>
                                <span class="cbutton__text">Menos</span>
                            </button>
                        </div>
                    </div>
                    <div id="addresses" class="control-background">
                        <legend>Buscar dirección</legend>
                        <input type="text" id="address" placeholder="ingrese dirección o ciudad"/>
                        <button type="button" class="btn-ui" id="btnlivesearch" onclick="codeAddress()">
                            <span class="btn-icon fa fa-search"></span>
                            <small>Buscar</small>
                        </button>
                    </div>
                    <div id="simbology" class="control-background">
                        <legend>Simbología</legend>
                        <nav>
                            <ul>
                                <li><span class="fa fa-square vertisol"></span></i>Vertisol</li>
                                <li><span class="fa fa-square fluvisol"></span></i>Fluvisol</li>
                                <li><span class="fa fa-square leptosol"></span></i>Leptosol</li>
                                <li><span class="fa fa-square n-a"></span></i>No aplica</li>
                                <li><span class="fa fa-square s-e"></span></i>Aún sin especificar</li>
                                <li><span class="fa fa-square a-h"></span></i>Asentamientos humanos</li>
                                <li><span class="fa fa-road v-t"></span></i>Vias de tránsito</li>
                            </ul>
                        </nav>
                    </div>
                    <div id="description" class="control-background">
                        <button class="cbutton cbutton--effect-ivana" id="close_infowindow">
                            <i class="cbutton__icon fa fa-times-circle" title="cerrar"></i>
                            <span class="cbutton__text">Cerrar</span>
                        </button>
                        <div id="header-window"></div>
                        <div id="image-window"></div>
                        <div id="content-window"></div>
                    </div>
                    <div id="map">
                    </div>
                </div>
                <aside class="menu animated fadeInUpBig">
                    <nav class="menu-content">
                        <div id="user_active" style="z-index: 5!important">
                            <?
                                if($image!=""){
                                    echo "<img src='../".$image."'/>";
                                }else{
                                    echo '<img src="styles/images/alt_img_user.png" alt="" class="user_icon"/>';
                                }
                            ?>
                            <a href="" id="user-info-active"><span class="user-name"><small class="user-info-name">Usuario:</small>&nbsp; <? echo $username ?></span></a>
                            <br/>
                            <br/>
                            <br/>
                            <small class="normal small" id="perfil-user">Perfil: </small><span class="bold medium" id="perfil-user"><? echo $level ?></span>
                        </div>
                        <ul class="ca-menu">
                            <li id='op_clima'>
                                <img id="op_c_icon" src="styles/images/weather.png" width="32px" class="ca-icon"/>
                                    <div class="ca-content">
                                        <h5 class="ca-main" id="op_clima_t">Clima</h5>
                                    </div>
                            </li>
                            <li id='op_humedad'>
                                <img src="styles/images/weat.png" width="32px" class="ca-icon"/>
                                    <div class="ca-content">
                                        <h5 class="ca-main" id="op_humedad_t">Humedad</h5>
                                    </div>
                            </li>
                            <li id="op_viento">
                                <img src="styles/images/wind.png" width="32px" class="ca-icon"/>
                                    <div class="ca-content">
                                        <h5 class="ca-main" id="op_viento_t">Viento</h5>
                                    </div>
                            </li>
                            <li id="op_alture">
                                <img src="styles/images/ruler.png" alt="sin imagen" width="32px" class="ca-icon"/>
                                    <div class="ca-content">
                                        <h5 class="ca-main">Altura</h5>
                                    </div>
                            </li>
                            <li id="op_cloudy">
                                <img src="styles/images/cloud.png" width="32px" class="ca-icon"/>
                                    <div class="ca-content">
                                        <h5 class="ca-main" id="op_cloudy_t">Nubosidad</h5>
                                    </div>
                            </li>
                            <li>
                                <a href="admafg/manager.php">
                                    <img src="styles/images/security.png" width="32px" class="ca-icon"/>
                                        <div class="ca-content">
                                             <h5 class="ca-main">Administración</h5>
                                        </div>
                                </a>
                            </li>
                        </ul>
                        <div id="footer-menu">
                            <table>
                                <th>
                                    <tr>
                                        <td title="Suspender"><a href=""><img src="styles/images/hibernate.png" alt="" width="15px"><span class="normal small-grey">&nbsp; Suspender</span></a></td>
                                        <td title="Cerrar sesión">&nbsp;&nbsp;&nbsp;<a href="javascript:cerrarSesion()"><img src="styles/images/logout.png" alt="" width="15px"><span class="normal small-grey">&nbsp; Cerrar sesión</span></a></td>
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
        <script type="text/javascript" src="js/plugins/jquery.min.js"></script>
        <script type="text/javascript" src="js/plugins/jquery.nicescroll.min.js"></script>
        <script type="text/javascript">
            var nice = false;
            $(document).ready(function(){
                  nice = $("html").niceScroll({cursorcolor: "#328d6e", cursorborder: "#328d6e",cursoropacitymax:0.9,boxzoom:true,touchbehavior:false});
                  $(".ca-menu").niceScroll({cursorcolor: "#747575",cursorborder:"#747575", cursoropacitymax:0.9, boxzoom: true});
            });
        </script>

        <script src="js/customs/classie.js"></script>
        <script>
            (function() {

                // http://stackoverflow.com/a/11381730/989439
                function mobilecheck() {
                    var check = false;
                    (function(a){if(/(android|ipad|playbook|silk|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4)))check = true})(navigator.userAgent||navigator.vendor||window.opera);
                    return check;
                }

                var support = { animations : Modernizr.cssanimations },
                    animEndEventNames = { 'WebkitAnimation' : 'webkitAnimationEnd', 'OAnimation' : 'oAnimationEnd', 'msAnimation' : 'MSAnimationEnd', 'animation' : 'animationend' },
                    animEndEventName = animEndEventNames[ Modernizr.prefixed( 'animation' ) ],
                    onEndAnimation = function( el, callback ) {
                        var onEndCallbackFn = function( ev ) {
                            if( support.animations ) {
                                if( ev.target != this ) return;
                                this.removeEventListener( animEndEventName, onEndCallbackFn );
                            }
                            if( callback && typeof callback === 'function' ) { callback.call(); }
                        };
                        if( support.animations ) {
                            el.addEventListener( animEndEventName, onEndCallbackFn );
                        }
                        else {
                            onEndCallbackFn();
                        }
                    },
                    eventtype = mobilecheck() ? 'touchstart' : 'click';

                [].slice.call( document.querySelectorAll( '.cbutton' ) ).forEach( function( el ) {
                    el.addEventListener( eventtype, function( ev ) {
                        classie.add( el, 'cbutton--click' );
                        onEndAnimation( classie.has( el, 'cbutton--complex' ) ? el.querySelector( '.cbutton__helper' ) : el, function() {
                            classie.remove( el, 'cbutton--click' );
                        } );
                    } );
                } );

            })();
        </script>
        <script type="text/javascript" src="map/mapcontents.js"></script>
    </body>
</html>