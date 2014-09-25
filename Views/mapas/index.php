<div class="column">
    <div id="map_canvas"></div>
</div>

<div class="column">
    <div class="checkboxes">
        <label><input type="checkbox" name="zf" id="zf" value="zona franca" checked ="checked"> Zonas Francas</label>
        <label><input type="checkbox" name="pto" id="pto" value="puerto" checked ="checked"> Zonas Portuarias</label> 
    </div>
    <h2 id ="titulo"></h2>
    <div id ="txt"></div>

    <div id="grafica1"></div>
</div>
<?php 
    Link::loadScript('Scripts/load.php?file=js/Highcharts-3.0.7/js/highcharts.js&type=text/javascript');
    Link::loadScript('Scripts/load.php?file=js/grafica3.js&type=text/javascript');
?>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBcolSfvTtbbMXBANh9SMhOcxYGTOIowtU&sensor=true"></script>
<?php Link::loadScript('Scripts/load.php?file=js/maps.js&type=text/javascript'); ?>
<script>
    var LinkServer = new Linker('<?php echo Link::Absolute() ?>');
    LinkServer.setExtension('.json?');

    $(function () {
        $("#zf").click(function () {
            if($(this).is(':checked')){
                map.mostrar_puntos('zona franca');
            }else{
                map.ocultar_puntos('zona franca');
            }
        });

        $("#pto").click(function () {
            if($("#pto").is(':checked')){
            map.mostrar_puntos('puerto');
            }else{
                map.ocultar_puntos('puerto');
            }
        });
    
        function resize () {
            var H = $(window).height();

            $("#map_canvas").height(H-180);
        }
        
        $(window).resize(function () {
            resize();
        });
        
        var map = new  mapa("map_canvas","#grafica1"), H = 0;
        map.mostrar_puntos('zona franca');

        resize();
    });
</script>
