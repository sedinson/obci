<div id="mapflow"></div>

<div class="column">
    <h2 id ="titulo"></h2>
    <div id="desc"></div>
    <div id="grafica1"></div>
</div>

<?php 
    //Link::loadScript('Scripts/load.php?file=js/Comflow.js&type=text/javascript');
    Link::loadStyle('Resource/load.php?file=jquery-jvectormap-1.2.2.css&type=text/css');
    Link::loadScript('Scripts/load.php?file=js/Highcharts-3.0.7/js/highcharts.js&type=text/javascript');
    Link::loadScript('Scripts/load.php?file=js/Highcharts-3.0.7/js/modules/exporting.js&type=text/javascript');
    Link::loadScript('Scripts/load.php?file=js/graficaFlujos.js&type=text/javascript');
    Link::loadScript('Scripts/load.php?file=js/jquery-jvectormap-1.2.2.min.js&type=text/javascript');
    Link::loadScript('Scripts/load.php?file=js/jquery-jvectormap-world-mill-en.js&type=text/javascript');
    Link::loadScript('Scripts/load.php?file=js/jquery.vmap.sampledata.js&type=text/javascript');
    //Link::loadScript('Scripts/load.php?file=js/jqvmap/jquery.vmap.min.js&type=text/javascript');
    //Link::loadScript('Scripts/load.php?file=js/jqvmap/maps/jquery.vmap.world.js&type=text/javascript');
    //Link::loadScript('Scripts/load.php?file=js/jqvmap/data/jquery.vmap.sampledata.js&type=text/javascript');
?>
<script>
    var LinkServer = new Linker('<?php echo Link::Absolute() ?>');
    LinkServer.setExtension('.json?');
    var _countrydata = [];

    $(function () {
        uget({
            type: 'GET',
            url: LinkServer.Url('flujos', 'get', [])
        }).done(function (data) {
            //Establecer la data del mapa
            _countrydata = data._response;
        });
        
        function testDevice(){
            if(/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent)) {
                return true;
            }else{
                return false;
            }
        }
        
        function isIOS(){
            if(/iPhone|iPad|iPod/i.test(navigator.userAgent)) {
                return true;
            }else{
                return false;
            }
        }

        var _map = new jvm.WorldMap({
            container: $('#mapflow'),
            map: 'world_mill_en',
            backgroundColor: '#fefefe',
            regionsSelectable: true,
            regionStyle: {
                initial: {
                    'stroke'        : '#666',
                    'stroke-width'  : 1,
                    'stroke-opacity': '0.5'
                },
                selected: {
                  fill: '#E30613'
                }
            },
            series: {
              regions: [{
                values: sample_data,
                scale: ['#f7f7f7', '#dadada'],
                normalizeFunction: 'polynomial'
              }]
            },
            onRegionClick: function(e, code){
                if(!testDevice()) { //Not a Mobile
                    _map.clearSelectedRegions();
                    for(var i=0; i<_countrydata.length; i++) {
                        var data = _countrydata[i];
                        code = code.toUpperCase();
                        if(data.codigo.toUpperCase() === code) {
                            var gra = new graficaFlujos("#grafica1", data.pais); 
                            $("#titulo").html(data.pais);
                            $("#desc").html("<p><b>Importado: </b>" + data.importado + "</p>");
                            $("#desc").append("<p><b>Exportado: </b>" + data.exportado + "</p>");
                            $("body, html").animate({
                                scrollTop: $(window).height()-220
                            }, 500);
                        }
                    }
                }
            },
            onRegionOver: function(e, code) {
                if(testDevice()) {  //Mobile
                    _map.clearSelectedRegions();
                    if(isIOS()) {
                        _map.setSelectedRegions(code);
                    }
                    for(var i=0; i<_countrydata.length; i++) {
                        var data = _countrydata[i];
                        code = code.toUpperCase();
                        if(data.codigo.toUpperCase() === code) {
                            var gra = new graficaFlujos("#grafica1", data.pais); 
                            $("#titulo").html(data.pais);
                            $("#desc").html("<p><b>Importado: </b>" + data.importado + "</p>");
                            $("#desc").append("<p><b>Exportado: </b>" + data.exportado + "</p>");
                            
                            $("body, html").animate({
                                scrollTop: $(window).height()-220
                            }, 500);
                        }
                    }
                }
            }
          });
                
//        .vectorMap({
//            map: 'world_en',
//            backgroundColor: '#f7f7f7',
//            borderColor: '#666666',
//            color: '#ffffff',
//            hoverOpacity: 0.7,
//            selectedColor: '#E30613',
//            enableZoom: true,
//            showTooltip: true,
//            values: sample_data,
//            scaleColors: ['#f7f7f7', '#dadada'],
//            normalizeFunction: 'polynomial',
//            onRegionClick: function(element, code, region) {
//                if(!testDevice()) { //Not a Mobile
//                    for(var i=0; i<_countrydata.length; i++) {
//                        var data = _countrydata[i];
//                        code = code.toUpperCase();
//                        if(data.codigo.toUpperCase() === code) {
//                            var gra = new graficaFlujos("#grafica1", data.pais); 
//                            $("#titulo").html(data.pais + " " + data.ano);
//                            $("#desc").html("<p><b>Importado: </b>" + data.importado + "</p>");
//                            $("#desc").append("<p><b>Exportado: </b>" + data.exportado + "</p>");
//                            $("body, html").animate({
//                                scrollTop: $(window).height()-220
//                            }, 500);
//                        }
//                    }
//                }
//            },
//            onRegionOver: function(element, code, region) {
//                if(testDevice()) {  //Mobile
//                    for(var i=0; i<_countrydata.length; i++) {
//                        var data = _countrydata[i];
//                        code = code.toUpperCase();
//                        if(data.codigo.toUpperCase() === code) {
//                            var gra = new graficaFlujos("#grafica1", data.pais); 
//                            $("#titulo").html(data.pais + " " + data.ano);
//                            $("#desc").html("<p><b>Importado: </b>" + data.importado + "</p>");
//                            $("#desc").append("<p><b>Exportado: </b>" + data.exportado + "</p>");
//                            $("body, html").animate({
//                                scrollTop: $(window).height()-220
//                            }, 500);
//                        }
//                    }
//                }
//            }
//        });

        function resize () {
            var H = $(window).height(), W = $(window).width();
        }
        
        $(window).resize(function () {
            resize();
        });
        
        /*Crear mapa de flujos*/
//        comflow = new Comflow(false, 'mapflow', '.icon-zoom-in', 
//            '.icon-zoom-out', false, function (data, i) {
//                $("body, html").animate({
//                    scrollTop: $(window).height()-220
//                }, 500);
//                var gra = new graficaFlujos("#grafica1",data.pais); 
//                $("#titulo").html(data.pais + " " + data.ano);
//                $("#desc").html("<p><b>Importado: </b>" + data.importado + "</p>");
//                $("#desc").append("<p><b>Exportado: </b>" + data.exportado + "</p>");
//            });
//            
//        uget({
//            type: 'GET',
//            url: LinkServer.Url('flujos', 'get', [])
//        }).done(function (data) {
//            //Establecer la data del mapa
//            comflow.setData(data._response);
//        });
});
</script>
