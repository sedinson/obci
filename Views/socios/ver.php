<?php
    Link::loadStyle('Resource/load.php?file=jqvmap.css&type=text/css');
    Link::loadScript('Scripts/load.php?file=js/jqvmap/jquery.vmap.min.js&type=text/javascript');
    Link::loadScript('Scripts/load.php?file=js/jqvmap/jquery.vmap.min.js&type=text/javascript');
    Link::loadScript('Scripts/load.php?file=js/jqvmap/maps/jquery.vmap.world.js&type=text/javascript');
    Link::loadScript('Scripts/load.php?file=js/jqvmap/data/jquery.vmap.sampledata.js&type=text/javascript');
?>
<div class="head-com">
    <?php if(!empty($_VARS['info'][0]['bandera'])): ?>
    <img class="flag" src="<?php echo $_VARS['info'][0]['bandera']; ?>" />
    <?php endif; ?>
    
    <?php if($_VARS['info'][0]['tipo'] == 'bloques'): ?>
    <ul class="acuerdos">
        <?php
            echo Partial::fetchRows($_VARS['info'], 
                    "<li><a href='#' class='bloques select'><h3>:nombre</h3></a></li>");
        ?>
    </ul>
    <?php endif; ?>
    
    <div class="estado-ac">
        <h2>Acuerdo Comercial <?php echo $_VARS['info'][0]['nombre']; ?></h2>
        <p>ESTADO: <?php echo $_VARS['info'][0]['acuerdo']; ?></p>
    </div>
    
    <div id="mapa-ac"></div>
</div>

<div id="perfil">
    <?php echo $_VARS['info'][0]['perfil']; ?>
</div>

<div id="historia">
    <?php echo $_VARS['info'][0]['historia']; ?>
</div>

<?php if(strlen($_VARS['info'][0]['objetivo']) > 100): ?>
<h3>Acceso a mercados:</h3>
<div id="objetivos">
    <?php echo $_VARS['info'][0]['objetivo']; ?>
</div>
<?php endif; ?>

<!--	Próximamente...
<h3>Desgraviacion:</h3>
<div id="desgraviacion">
    <?php echo $_VARS['info'][0]['desgraviacion']; ?>
</div>
-->

<a href="<?php echo $_VARS['info'][0]['enlace']; ?>" target="blank">Ver acuerdo original.</a>

<script>
    $(function () {
        <?php if($_VARS['info'][0]['code'] != 'NREG'): ?>
        $('#mapa-ac').vectorMap({
            map: 'world_en',
            backgroundColor: '#fff',
            borderColor: '#666666',
            color: '#ffffff',
            selectedColor: '#E30613',
            enableZoom: true,
            showTooltip: true,
            values: sample_data,
            scaleColors: ['#f7f7f7', '#dadada'],
            normalizeFunction: 'polynomial'
        });
        $('#mapa-ac').vectorMap('set', 'colors', {<?php echo $_VARS['info'][0]['code']; ?>: '#FFCC00'});
        <?php endif; ?>
    });
</script>