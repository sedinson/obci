<div id="paises" class="listView">
    <h2>Importacion / Exportacion Por Zona Franca</h2>
    
    <div class="superior">
        <div class="B2 items-alarge supercolumn">
            <div class="column">
                <label>Seleccionar Zona Franca</label>
                <select id="example" name="example" multiple="multiple">
                    <?php echo
                    Partial::fetchRows($_VARS['zf'], '<option value=":zona_franca">:zona_franca</option>');
                    ?>
                </select>
            </div>

            <div class="column">
                <label>Seleccionar Indicador</label>
                <select id="mySelect">
                    <option value="zfimp" selected>Importaciones</option>
                    <option value="zfexp" >Exportaciones</option>
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
            switch (indicador) {
                case 'zfimp':
                    unidad = 'Miles de USD';
                    $("#leyenda").html("Total de importaciones colombianas en USD (United States Dollar) por la zona franca seleccionada en valor CIF (Cost, insurance and freight – Costo, seguro y flete).");
                    titulo = 'Importaciones de Zonas Francas en USD (CIF)';
                    fuente = 'Elaboración OBCI con base en DANE';
                    break;

                case 'zfexp':
                    unidad = 'Miles de USD';
                    $("#leyenda").html("Total de exportaciones colombianas en USD (United States Dollar) por la zona franca seleccionada en valor FOB (Free on board – Franco a bordo).");
                    titulo = 'Exportaciones de Zonas Francas en USD por (EJ: ZFP Barranquilla) (FOB)';
                    fuente = 'Elaboración OBCI con base en DANE';
                    break;

            }

            var paises = _Utils.getChecks($("#example"));
            if (paises.length > 0) {
                var gr = new Grafica3('#grafica1', '#grafica2', paises, indicador, titulo, unidad, fuente);
            } else {
                alert('Recuerde escoger al menos una ZF y escoger un Indicador!');
            }

        });
    });
</script>
