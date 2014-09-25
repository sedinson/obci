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
    isFirst = true;
    var indicador, unidad, titulo,fuente;
    
    $(document).ready(function() {
        $("#example").multiselect().multiselectfilter();
    });

    $(function() {
        $("#checkPais").click(function() {
            indicador = $('#mySelect option:selected').val();
            switch (indicador) {
                case 'deptimpo':
                    unidad = 'COP';
                    titulo = 'Importacion en COP';
                    fuente = 'DANE';
                    $( "#grafica1" ).show( "fast" );
                    break;

                case 'deptexpo':
                    unidad = 'COP';
                    titulo = 'Exportacion en COP';
                    fuente = 'DANE';
                    $( "#grafica1" ).show( "fast" );
                    break;

                case 'deptpib':
                    unidad = 'COP';
                    titulo = 'Producto Interno Bruto';
                    fuente = 'DANE';
                    $( "#grafica1" ).show( "fast" );
                    break;

                case 'deptbalanza':
                    unidad = 'COP';
                    titulo = 'Balanza Comercial';
                    fuente = 'Cálculos OBCI con base en DANE';
                    $( "#grafica1" ).hide( "fast" );
                    break;

                case 'deptimp_varia':
                    unidad = '%';
                    titulo = 'Variación de importaciones (anual)';
                    fuente = 'Cálculos OBCI con base en DANE';
                    $( "#grafica1" ).hide( "fast" );
                    break;

                case 'deptexp_varia':
                    unidad = '%';
                    titulo = 'Variación de exportaciones (anual)';
                    fuente = 'Cálculos OBCI con base en DANE';
                    $( "#grafica1" ).hide( "fast" );
                    break;

                case 'deptcoef':
                    unidad = '%';
                    titulo = 'Coeficiente de Apertura';
                    fuente = 'Cálculos OBCI con base en DANE.';
                    $( "#grafica1" ).show( "fast" );
                    break;

                case 'deptimpus':
                    unidad = 'Valores CIF';
                    titulo = 'Importaciones en USD (Valores CIF)';
                    fuente = 'Elaboración OBCI con base en DANE.';
                    $( "#grafica1" ).show( "fast" );
                    break;

                case 'deptexpus':
                    unidad = 'Valores FOB';
                    titulo = 'Exportaciones en USD (valores FOB)';
                    fuente = 'Elaboración OBCI con base en DANE.';
                    $( "#grafica1" ).show( "fast" );
                    break;

                case 'deptimp_pib':
                    unidad = '%';
                    titulo = 'Importaciones como % del PIB';
                    fuente = 'Cálculos OBCI con base en DANE.';
                    $( "#grafica1" ).show( "fast" );
                    break;

                case 'deptexp_pib':
                    unidad = '%';
                    titulo = 'Exportaciones como % del PIB';
                    fuente = 'Cálculos OBCI con base en DANE.';
                    $( "#grafica1" ).show( "fast" );
                    break;
                    
                case 'deptvarexpus':
                unidad = '%';
                titulo = 'Variacion Anual Exportación en USD';
                fuente = 'Cálculos OBCI con base en DANE.';
                $( "#grafica1" ).hide( "fast" );
                break;

                case 'deptvarimpus':
                unidad = '%';
                titulo = 'Variacion Anual Importación en USD';
                fuente = 'Cálculos OBCI con base en DANE.';
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