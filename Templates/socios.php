<?php
header('Content-type: text/html; charset=utf-8');

if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) {
    ob_start("ob_gzhandler");
} else {
    ob_start();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>OBCI</title>
        <link href="<?php echo Link::Absolute('Resource/imgs/icon.jpg'); ?>" type="image/x-icon" rel="shortcut icon" />
        <link rel="apple-touch-icon" href="<?php echo Link::Absolute('Resource/imgs/icon.jpg'); ?>"/>
        <link rel="apple-touch-startup-image" href="<?php echo Link::Absolute('Resource/imgs/icon.jpg'); ?>" />
        <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,300,600,700,200' rel='stylesheet' type='text/css'>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        
        <?php
            Link::loadStyle('http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css');
            Link::loadStyle('Resource/load.php?file=fonts/font-awesome.min.css&type=text/css', 'text/css', 'stylesheet', 'screen');
            Link::loadStyle('Resource/load.php?file=social.css&type=text/css', 'text/css', 'stylesheet', 'screen');
            Link::loadStyle('Resource/load.php?file=css/jquery.multiselect.css&type=text/css');
            Link::loadStyle('Resource/load.php?file=css/jquery.multiselect.filter.css&type=text/css', 'text/css', 'stylesheet', 'screen');
            Link::loadStyle('Resource/load.php?file=style.css&type=text/css', 'text/css', 'stylesheet', 'screen');
        ?>

        <!--[if lt IE 9]>
        <?php
            Link::loadScript('Scripts/js/html5.js');
            Link::loadScript('Scripts/js/coverfix/jquery.backgroundSize.min.js');
        ?>
        <![endif]-->
        
        <?php
            Link::loadScript('Scripts/load.php?file=js/jquery.min.js&type=text/javascript');
            Link::loadScript('http://code.jquery.com/ui/1.10.3/jquery-ui.js');
            
            Link::loadScript('Scripts/load.php?file=js/Highcharts-3.0.7/js/highcharts.js&type=text/javascript');
            Link::loadScript('Scripts/load.php?file=js/Highcharts-3.0.7/js/modules/exporting.js&type=text/javascript');
            Link::loadScript('Scripts/load.php?file=js/grafica3.js&type=text/javascript');
            Link::loadScript('Scripts/load.php?file=js/jquery.multiselect.js&type=text/javascript');
            Link::loadScript('Scripts/load.php?file=js/jquery.multiselect.filter.js&type=text/javascript');
            Link::loadProjectBase();
        ?>
        <script>
            var timmerHide = null, ismobile = true, isFirst = false;
            
            var LinkPage = new Linker('<?php echo Link::Absolute() ?>');
            LinkPage.setExtension('/');
            
            var uget = function (params) {
                return $.ajax({
                    type: (params.type)? params.type : 'GET',
                    url: (params.url)? params.url : '',
                    data: (params.data)? params.data : {},
                    xhrFields: {
                        withCredentials: true
                    },
                    crossDomain: true
                });
            };
        </script>
    </head>
    <body>
        <div id="background">
            <div class="line"></div>
        </div>
        
        <div id="wrapper">
            <div id="header">
                <div class="wrapper B234">
                    <a href="<?php echo Link::Url(); ?>">
                        <h1 class="logo"></h1>
                    </a>
                    
                    <a id="menu-button" class="icon-reorder"></a>
                    <ul class="menu">
                        <li><a href="<?php echo Link::Url('indicadores'); ?>">Indicadores</a></li>
                        <li><a href="<?php echo Link::Url('mapas'); ?>">Mapas Interactivos</a></li>
                        <li><a class="select" href="<?php echo Link::Url('socios'); ?>">Socios Comerciales</a></li>
                        <li><a href="<?php echo Link::Url('nosotros'); ?>">Nosotros</a></li>
                    </ul>
                </div>
            </div>
            
            
                
            <div id="news">
                <div id="selfcontent">
                    <div id="menu-indicador">
                        <div class="leftside-menu">
                            <h2>Socios Comerciales</h2>
                            
                            <ul>
                                <li><a href="<?php echo Link::Url('socios'); ?>">Socios Comerciales</a></li>
                                <li><a href="<?php echo Link::Url('socios', 'bloques'); ?>">Bloques Regionales</a></li>
                            </ul>
                        </div>

                        <a class="icon-angle-right" id="button-indicator"></a>
                    </div>
                    
                    <div class="wrapper semiwrapper">
                        <?php echo $display->show(); ?>
                    </div>
                </div>
                
                <ul class="news">
                    <li><a href="<?php echo Link::Absolute(Noticias); ?>">Noticias</a></li>
                    <li><a href="<?php echo Link::Absolute(Boletin); ?>">Boletin</a></li>
                    <li><a href="<?php echo Link::Absolute(Blog); ?>">Blog</a></li>
                    <li><a href="<?php echo Link::Absolute(Investigacion); ?>">Investigación</a></li>
                    <li><a href="<?php echo Link::Absolute(Contactenos); ?>">Contáctenos</a></li>
                </ul>
            </div>
            
            <div id="footer">
                <div class="wrapper">
                    <ul class="socialnetwork">
                        <li><a href="<?php echo Link::Absolute(Mail); ?>" class="social-mail"></a></li>
                        <li><a href="<?php echo Link::Absolute(Twitter); ?>" class="social-twitter2"></a></li>
                        <li><a href="<?php echo Link::Absolute(Linkdedin); ?>" class="social-linkedin2"></a></li>
                    </ul>
                    <p><a href="<?php echo Link::Absolute(Privacy); ?>">Política de privacidad de información personal</a></p>
                    <p>Km.5 Vía Puerto Colombia - Tel. +57 (5) 3509509 - Barranquilla, Colombia</p>
                    <p>Derechos Reservados © Universidad del Norte</p>
                </div>
            </div>
        </div>
        
        <script>
            $(function () {
                
                function resize () {
                    ismobile = ($(window).width()<=750);
                    
                    $("ul.menu").css({
                        display: (ismobile)? 'none' : 'block'
                    });
                    
                    $("#menu-button").css({
                        display: (ismobile)? 'block' : 'none'
                    });
                    
                    $("#menu-indicador").css({
                        left: (ismobile)? -285 : 0
                    });
                    
                    $("#wrapper").css({
                        left: 0
                    });
                }
                
                $(window).resize(function () {
                    resize();
                });
                
                $(document).click(function () {
                    timmerHide = setTimeout(function () {
                        if(ismobile) {
                            $("ul.menu").css({
                                display: 'none'
                            });
                        }
                    }, 300);
                });

                $("#menu-button").click(function () {
                    $("ul.menu").css({
                        display: 'block'
                    });

                    setTimeout(function () {
                        clearTimeout(timmerHide);
                    }, 150);
                });
                
                function open_menu () {
                    var menu = $("#menu-indicador"),
                        cont = $("#wrapper");
                    
                    
                    if($(window).width() <= 900) {
                        menu.animate({
                            left: (cont.offset().left > 160)? -285 : 0
                        }, {
                            duration: 500,
                            step: function (now, fx) {
                                cont.css({
                                    left: now+285
                                });
                            }, complete: function () {
                                if (cont.offset().left > 160) {
                                    menu.find("#button-indicator")
                                        .removeClass("icon-angle-right")
                                        .addClass("icon-angle-left");
                                    cont.css({
                                        left: 285
                                    });
                                } else {
                                    menu.find("#button-indicator")
                                        .removeClass("icon-angle-left")
                                        .addClass("icon-angle-right");
                                    cont.css({
                                        left: 0
                                    });
                                }
                            }
                        });
                    }
                }
                
                $("#button-indicator").click(function () {
                    open_menu();
                });
                
                resize();
            });
        </script>
    </body>
</html>
