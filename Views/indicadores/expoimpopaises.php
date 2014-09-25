<div id="paises" class="listView">
    <h2>Importacion / Exportacion Por Paises</h2>
    
    <div class="superior">
        <div class="B2 items-alarge supercolumn">
            <div class="column">
                <label>Seleccionar Paises</label>
                <select id="example" name="example" multiple="multiple">
                    <?php echo
                        Partial::fetchRows($_VARS['paises'], '<option value=":nombre">:nombre</option>');
                    ?>
                </select>
            </div>

            <div class="column">
                <label>Seleccionar Indicador</label>
                <select id="mySelect">
                    <option value="paisimpo" selected>Importaciones</option>
                    <option value="paisexpo" >Exportaciones</option>
                    <option value="paisvarimp" >Variacion Importación</option>
                    <option value="paisvarexp" >Variacion Exportación</option>
                    <option value="paispartimp" >Participacion Importación</option>
                    <option value="paispartexp" >Participacion Exportación</option>
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
    <div id="grafica2"></div>
</div>
<!--<p id = "legend"></p>-->
<script>
    var LinkServer = new Linker('<?php echo Link::Absolute() ?>');
    LinkServer.setExtension('.json?');
    var indicador, unidad, titulo,fuente;
    $(document).ready(function() {
        $("#example").multiselect().multiselectfilter();
    });

    $(function() {
        $("#checkPais").click(function() {
            indicador = $('#mySelect option:selected').val();
            switch (indicador) {
                case 'paisimpo':
                    unidad = 'USD';
                    $("#leyenda").html("Total de importaciones colombianas provenientes del país seleccionado en United States Dollar y en valor CIF (Cost, insurance and freight – Costo, seguro y flete).");
                    titulo = 'Importaciones colombianas por país de origen en USD (CIF)';
                    fuente = 'Elaboración OBCI con base en DIAN';
                    $( "#grafica1" ).show( "fast" );
                    $('#legend').html('<b>En este gráfico se muestra la evolución de las importaciones colombianas procedentes de los países con los que mantiene relaciones comerciales.</b>');
                    break;

                case 'paisexpo':
                    unidad = 'USD';
                    $("#leyenda").html("Total de exportaciones colombianas hacia el país seleccionado en United States Dollar y en valor FOB (Free on board – Franco a bordo).");
                    titulo = 'Exportaciones colombianas por país de destino en USD (FOB)';
                    fuente = 'Elaboración OBCI con base en DIAN';
                    $( "#grafica1" ).show( "fast" );
                    $('#legend').html('<b>En este gráfico se muestra la evolución de las exportaciones colombianas hacia los países con los que mantiene relaciones comerciales.</b>');
                    break;

                case 'paisvarimp':
                    unidad = '%';
                    $("#leyenda").html("La variación en las importaciones corresponde al cambio porcentual anual presentado.");
                    titulo = 'Variación importaciones colombianas por país de origen';
                    fuente = 'Cálculos OBCI con base en DIAN';
                    $( "#grafica1" ).hide( "fast" );
                    $('#legend').html('');
                    break;

                case 'paisvarexp':
                    unidad = '%';
                    $("#leyenda").html("La variación en las exportaciones corresponde al cambio porcentual anual presentado.");
                    titulo = 'Variación exportaciones colombianas por país de destino';
                    fuente = 'Cálculos OBCI con base en DIAN';
                    $( "#grafica1" ).hide( "fast" );
                    $('#legend').html('');
                    break;

                case 'paispartimp':
                    unidad = '%';
                    $("#leyenda").html("Participación de las importaciones por país de origen dentro del total de importaciones colombianas.");
                    titulo = 'Participacion Importación';
                    fuente = 'Cálculos OBCI con base en DIAN';
                    $( "#grafica1" ).show( "fast" );
                    $('#legend').html('<b>En este gráfico se muestra la participación de las importaciones dentro del total de importaciones.</b>');
                    break;

                case 'paispartexp':
                    unidad = '%';
                    $("#leyenda").html("Participación de las exportaciones por país de destino dentro del total de exportaciones colombianas.");
                    titulo = 'Participacion Exportación';
                    fuente = 'Cálculos OBCI con base en DIAN';
                    $( "#grafica1" ).show( "fast" );
                    $('#legend').html('<b>En este gráfico se muestra la participación de las exportaciones dentro del total de exportaciones.</b>');
                    break;
            }
            var paises = _Utils.getChecks($("#example"));
            if (paises.length > 0) {
                var gr = new Grafica3('#grafica1', '#grafica2', paises, indicador, titulo, unidad, fuente);
            } else {
                alert('Recuerde escoger al menos un Pais y escoger un Indicador!');
            }

        });
    });
</script>
