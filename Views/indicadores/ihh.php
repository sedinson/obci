<div id="paises" class="listView">
    <h2>IHH</h2>

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
        </div>
    
        <div class="supercolumn">
            <button id="checkPais" class="social-engine"></button>
        </div>
    </div>
</div>

<div>
    <div id="grafica1"></div>
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
            var departamentos = _Utils.getChecks($("#example"));
            if (departamentos.length > 0) {
                $("#leyenda").html("El índice IHH mide la concentración de las exportaciones del departamento. Los valores están entre 0 y 1, donde valores cercanos a 1 muestran concentración y valores cercanos a 0 indican diversificación.");
                var gr = new Grafica3('#grafica1', '#grafica2', departamentos, 'ihh', 'Indice de concentración IHH', '', 'Cálculos OBCI con base en DIAN');
            } else {
                alert('Recuerde escoger al menos un Pais y escoger un Indicador!');
            }

        });
    });
</script>