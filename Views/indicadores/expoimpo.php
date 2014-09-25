<div id="paises" class="listView">
    <h2>Importacion / Exportacion Por Departamentos</h2>

    <div class="superior">
        <div class="B2 items-alarge supercolumn">
            <div class="column">
                <label>Seleccionar Departamentos</label>
                <select id="example" name="example" multiple="multiple">
                    <?php echo
                    Partial::fetchRows($_VARS['dept'], '<option value=":departamento">:departamento</option>');
                    ?>
                </select>
            </div>

            <div class="column">
                <label>Seleccionar Indicador</label>
                <select id="mySelect">
                    <option value="deptexpo" selected>Exportado</option>
                    <option value="deptimpo" >Importado</option>
                    <option value="deptpib" >PIB</option>
                    <option value="deptbalanza" >Balanza Comercial</option>
                    <option value="deptimp_varia" >Variacion Importacion</option>
                    <option value="deptexp_varia" >Variacion Exportado</option>
                    <option value="deptimp_pib" >Importacion como % PIB</option>
                    <option value="deptexp_pib" >Exportacion como % PIB</option>
                    <option value="deptcoef" >Coeficiente de Apertura</option>
                    <option value="deptimpus" >Importaciones en USD</option>
                    <option value="deptexpus" >Exportaciones en USD</option>
                    <option value="deptvarexpus" >Variacion Exportación en USD</option>
                    <option value="deptvarimpus" >Variacion importación en USD</option>
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
            $("#leyenda").html("");
            switch (indicador) {
                case 'deptimpo':
                    unidad = 'COP';
                    $("#leyenda").html("Total importado del departamento en Pesos Colombianos Corrientes (COP).");
                    titulo = 'Total Importaciones del departamento';
                    fuente = 'Elaboración OBCI con base en DANE';
                    $( "#grafica1" ).show( "fast" );
                    break;

                case 'deptexpo':
                    unidad = 'COP';
                    $("#leyenda").html("Total exportado del departamento en Pesos Colombianos Corrientes (COP).");
                    titulo = 'Total Exportaciones del departamento seleccionado';
                    fuente = 'Elaboración OBCI con base en DANE';
                    $( "#grafica1" ).show( "fast" );
                    break;

                case 'deptpib':
                    unidad = 'COP';
                    $("#leyenda").html("Total del Producto Interno Bruto del departamento en Pesos Colombianos Constantes (base 2005).");
                    titulo = 'Producto Interno Bruto del departamento';
                    fuente = 'Elaboración OBCI con base en DANE';
                    $( "#grafica1" ).show( "fast" );
                    break;

                case 'deptbalanza':
                    unidad = 'COP';
                    $("#leyenda").html("La balanza comercial es la diferencia entre las exportaciones e importaciones. Una balanza comercial positiva indica que las ventas de bienes del departamento al exterior superan las importaciones. En caso contrario, la balanza comercial es deficitaria.");
                    titulo = 'Balanza Comercial';
                    fuente = 'Cálculos OBCI con base en DANE';
                    $( "#grafica1" ).hide( "fast" );
                    break;

                case 'deptimp_varia':
                    unidad = '%';
                    $("#leyenda").html("La variación en las importaciones corresponde al cambio porcentual anual presentado.");
                    titulo = 'Variación anual de importaciones';
                    fuente = 'Cálculos OBCI con base en DANE';
                    $( "#grafica1" ).hide( "fast" );
                    break;

                case 'deptexp_varia':
                    unidad = '%';
                    $("#leyenda").html("La variación en las exportaciones corresponde al cambio porcentual anual presentado.");
                    titulo = 'Variación anual de exportaciones';
                    fuente = 'Cálculos OBCI con base en DANE';
                    $( "#grafica1" ).hide( "fast" );
                    break;

                case 'deptcoef':
                    unidad = '%';
                    $("#leyenda").html("El coeficiente de apertura se calcula como el cociente de las exportaciones más importaciones en relación con el producto interno bruto del país. Este indicador es una medida de internacionalización de la economía, toda vez que muestra la importancia relativa  respecto a la producción agregada.");
                    titulo = 'Coeficiente de apertura del departamento';
                    fuente = 'Cálculos OBCI con base en DANE';
                    $( "#grafica1" ).show( "fast" );
                    break;

                case 'deptimpus':
                    unidad = 'Valores CIF';
                    $("#leyenda").html("Importaciones en valor CIF (Cost, insurance and freight – Costo, seguro y flete) en USD (United States Dollar)");
                    titulo = 'Importaciones CIF del departamento en USD';
                    fuente = 'Elaboración OBCI con base en DANE';
                    $( "#grafica1" ).show( "fast" );
                    break;

                case 'deptexpus':
                    unidad = 'Valores FOB';
                    $("#leyenda").html("Importaciones en valor FOB (Free on board – Franco a bordo) en USD (United States Dollar)");
                    titulo = 'Exportaciones FOB del departamento en USD';
                    fuente = 'Elaboración OBCI con base en DANE';
                    $( "#grafica1" ).show( "fast" );
                    break;

                case 'deptimp_pib':
                    unidad = '%';
                    $("#leyenda").html("La participación se calcula como el cociente de las importaciones del departamento en relación con el PIB del país, por cien");
                    titulo = 'Importaciones del departamento como porcentaje del PIB';
                    fuente = 'Cálculos OBCI con base en DANE';
                    $( "#grafica1" ).show( "fast" );
                    break;

                case 'deptexp_pib':
                    unidad = '%';
                    $("#leyenda").html("La participación se calcula como el cociente de las exportaciones del departamento en relación con el PIB del país, por cien.");
                    titulo = 'Exportaciones del departamento como porcentaje del PIB';
                    fuente = 'Cálculos OBCI con base en DANE';
                    $( "#grafica1" ).show( "fast" );
                    break;
                    
                case 'deptvarexpus':
                unidad = '%';
                $("#leyenda").html("La variación en las exportaciones corresponde al cambio porcentual anual presentado.");
                titulo = 'Variación anual de exportaciones del departamento en USD';
                fuente = 'Cálculos OBCI con base en DANE';
                $( "#grafica1" ).hide( "fast" );
                break;

                case 'deptvarimpus':
                unidad = '%';
                $("#leyenda").html("La variación en las importaciones corresponde al cambio porcentual anual presentado.");
                titulo = 'Variación anual de importaciones del departamento en USD';
                fuente = 'Cálculos OBCI con base en DANE';
                $( "#grafica1" ).hide( "fast" );
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