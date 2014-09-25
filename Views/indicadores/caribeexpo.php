<div id="paises" class="listView">
    <h2>Exportaciones Caribe</h2>
    <div class="superior">
        <div class="B2 items-alarge supercolumn">

            <div class="column">
                <label>Seleccionar Indicador</label>
                <select id="mySelect" >
                    <option value="expocaribe" selected>Exportaciones Por Capitulos</option>
                    <option value="expocaribe_fob" >Exportaciones Por pais</option>
                    <option value="expocaribe_part" >Participacion</option>

                </select>
            </div>

            <div class="column" >
                <label>Seleccionar Departamento</label>
                <select id="mySelectD">
                    <?php echo
                        Partial::fetchRows($_VARS['dept'], '<option value=":departamento">:departamento</option>');
                    ?>
                </select>
            </div>

            <div class="column">
                <label>Seleccionar Año</label>
                <select id="mySelectA">
                    <?php echo
                        Partial::fetchRows($_VARS['ano'], '<option value=":ano">:ano</option>');
                    ?>
                </select>
            </div>
            <div class="column">
                <label>Seleccionar Paises</label>
                <select id="mySelectP" name="mySelectP">
                    <?php echo
                        Partial::fetchRows($_VARS['pais'], '<option value=":pais">:pais</option>');
                    ?>
                </select>
            </div>
        </div>
    
        <div class="supercolumn">
            <button id="checkPais" class="social-engine"></button>
        </div>
    </div>
</div>

<div>
    <div id="grafica1"></div>
    <!--<div id="grafica2"></div>-->
</div>
<p id="legend"></p>
<?php
Link::loadScript('Scripts/load.php?file=js/graficaexpocaribe.js&type=text/javascript');
Link::loadScript('Scripts/load.php?file=js/graficaPie2.js&type=text/javascript');
?>

<script>
    var LinkServer = new Linker('<?php echo Link::Absolute() ?>');
    LinkServer.setExtension('.json?');
    var indicador, unidad, titulo;
    var ano,pais,dept;
    var cnt = 0;
    $( "#mySelect" ).change(function () {
        var str = "";
        str = $('#mySelect option:selected' ).text();
        console.log(str);
        if(str === 'Exportaciones Por Capitulos'){
            if(cnt > 0){
               $('#mySelectP').removeAttr("multiple");
                $("#mySelectP").multiselect("destroy");
            }
        }else{
            cnt = 1;
            $('#mySelectP').attr("multiple","multiple");
            $("#mySelectP").multiselect().multiselectfilter();
        }
        
      }).change();
    
    $(document).ready(function() {
        
    });
    $(function() {
        $("#checkPais").click(function() {
            ano = $('#mySelectA option:selected').val();
            //pais = $('#mySelectP option:selected').val();
            pais = _Utils.getChecks($("#mySelectP"));
            dept = _Utils.getChecks($("#mySelectD"));
            indicador = $('#mySelect option:selected').val();
            switch (indicador) {
                    case 'expocaribe':
                        unidad = '';
                        $("#leyenda").html("Total de exportaciones por capítulo del departamento seleccionado al país destino seleccionado.");
                        titulo = 'Exportaciones departamento (EJ: Atlántico) – País destino (EJ: Alemania) – Año (EJ: 2011)';
                        tipo = 0;
                        $("#legend").html('');
                        break;

                    case 'expocaribe_fob':
                        unidad = '';
                        $("#leyenda").html("Total de exportaciones del departamento seleccionado al país destino seleccionado.");
                        titulo = 'Exportaciones departamento (EJ: Atlántico) – País destino (EJ: Alemania) – Año (EJ: 2011)';
                        tipo = 1;
                        $( "#grafica2" ).hide( "fast" );
                        $("#legend").html('');
                        break;
                     
                    case 'expocaribe_part':
                        unidad = '';
                        $("#leyenda").html("Participación de las exportaciones del departamento seleccionado al país destino en el total de exportaciones del departamento seleccionado al resto del mundo.");
                        titulo = 'Participación del departamento (EJ: Atlántico) – País destino (EJ: Alemania) – Año (EJ: 2011)';
                        tipo = 2;
                        $( "#grafica2" ).hide( "fast" );
                        $("#legend").html('<b>En este gráfico se muestra la participación de las exportaciones hacia determinado destino sobre el total de las exportaciones del departamento en cuestión.En el gráfico de torta sale al pasar el cursor sobre el porcentaje expo caribe.</br>');
                        break;
                }
            if (dept.length > 0) {
                if(tipo === 0){
                    var gr = new GraficaExpo('#grafica1', '#grafica2', dept,pais,ano, indicador, 'ExpoPaises', indicador);
                }else if(tipo === 1 ){
                    var gr = new GraficaExpo('#grafica1', '#grafica2', dept,pais,ano, indicador, 'ExpoPaises', indicador);
                }else{
                    var gr = new Grafica6('#grafica1', dept, indicador, ano,unidad, pais);
                    //(container,dept,indicador,ano,titulo,pais){
                    $( "#grafica2" ).empty();
                }
            } else {
                alert('Recuerde escoger al menos un Departamento y escoger un Indicador!');
            }

        });
    });
</script>


