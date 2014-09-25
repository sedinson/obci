<div id="paises" class="listView">
    <h2>Importacion / Exportacion Por Puertos</h2>
    
    <div class="superior">
        <div class="B2 items-alarge supercolumn">
            <div class="column">
                <label>Seleccionar Zona Portuaria</label>
                <select id="example" name="example" multiple="multiple">
                    <?php echo
                    Partial::fetchRows($_VARS['ptos'], '<option value=":puerto">:puerto</option>');
                    ?>
                </select>
            </div>

            <div class="column">
                <label>Seleccionar Indicador</label>
                <select id="mySelect">
                    <option value="puertoimp" selected>Importaciones</option>
                    <option value="puertoexp" >Exportaciones</option>
                    <option value="puertototal" >Total</option>
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
    var indicador, unidad, titulo;
    $(document).ready(function() {
        $("#example").multiselect().multiselectfilter();
    });

    $(function() {
        $("#checkPais").click(function() {
            indicador = $('#mySelect option:selected').val();
            switch (indicador) {
                case 'puertoimp':
                    unidad = 'Toneladas';
                    $("#leyenda").html("Total de toneladas importadas por la Zona Portuaria.");
                    titulo = 'Importaciones por  Zona Portuaria';
                    break;

                case 'puertoexp':
                    unidad = 'Toneladas';
                    $("#leyenda").html("Total de toneladas exportadas por la Zona Portuaria.");
                    titulo = 'Exportaciones por Zona Portuaria';
                    break;

                case 'puertototal':
                    unidad = 'Toneladas';
                    $("#leyenda").html("Total de toneladas exportadas e importadas por Zona Portuaria.");
                    titulo = 'Total Exportaciones e Importaciones por Zona Portuaria';
                    break;
            }

            var paises = _Utils.getChecks($("#example"));
            if (paises.length > 0) {
                var gr = new Grafica3('#grafica1', '#grafica2', paises, indicador, titulo, unidad, 'Elaboración OBCI con base en Superintendencia de Puertos y Transportes');
            } else {
                alert('Recuerde escoger al menos una puerto y escoger un Indicador!');
            }

        });
    });
</script>
