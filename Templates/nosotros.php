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
        <link rel="apple-touch-icon" href="<?php echo Link::Absolute('Resource/imgs/icon.jpg'); ?>" />
        <link rel="apple-touch-startup-image" href="<?php echo Link::Absolute('Resource/imgs/icon.jpg'); ?>" />
        <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,300,600,700,200' rel='stylesheet' type='text/css'>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        
        <?php
            Link::loadStyle('Resource/load.php?file=fonts/font-awesome.min.css&type=text/css', 'text/css', 'stylesheet', 'screen');
            Link::loadStyle('Resource/load.php?file=social.css&type=text/css', 'text/css', 'stylesheet', 'screen');
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
            Link::loadProjectBase();
        ?>
        <script>
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
                        <li><a href="<?php echo Link::Url('socios'); ?>">Socios Comerciales</a></li>
                        <li><a class="select" href="<?php echo Link::Url('nosotros'); ?>">Nosotros</a></li>
                    </ul>
                </div>
            </div>
            
            <div id="news">
                <?php echo $display->show(); ?>
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
            var timmerHide = null, ismobile = true;
            
            $(function () {
                function resize () {
                    ismobile = ($(window).width()<=750);
                    
                    $("ul.menu").css({
                        display: (ismobile)? 'none' : 'block'
                    });
                    
                    $("#menu-button").css({
                        display: (ismobile)? 'block' : 'none'
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
                
                resize();
            });
        </script>
    </body>
</html>