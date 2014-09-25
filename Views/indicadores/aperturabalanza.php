<div id="paises" class="listView">
    <h2>RCA Index Countries</h2>
    
    <div class="superior">
        <div class="B2 items-alarge supercolumn">
            <div class="column">
                <label>Seleccionar Paises</label>
                <select id="example" name="example">
                    <?php echo
                        Partial::fetchRows($_VARS['pais'], '<option value=":reporter_name">:reporter_name</option>');
                    ?>
                </select>
            </div>

            <div class="column">
                <label>Seleccionar Año</label>
                <select id="mySelect">
                    <?php echo
                        Partial::fetchRows($_VARS['ano'], '<option value=":ano">:ano</option>');
                    ?>
                </select>
            </div>

            <div class="column">
                <label>Seleccionar Indicador</label>
                <select id="mySelect2">
                    <option value="lnrcaindex">LNRCA</option>
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
<p>Valores superiores a 1 indican ventaja comparativa revelada.</p>
<?php
Link::loadScript('Scripts/load.php?file=js/grafica4.js&type=text/javascript');
?>

<script>
    var LinkServer = new Linker('<?php echo Link::Absolute() ?>');
    LinkServer.setExtension('.json?');
    var indicador, unidad, titulo;
    var ano;

    $(document).ready(function() {
        $(function() {
            $("#checkPais").click(function() {
                indicador = $('#mySelect2 option:selected').val();
                ano = $('#mySelect option:selected').val();
                var paises = $('#example option:selected').val();
                $("#leyenda").html("El índice de ventaja comparativa revelada muestra la especialización exportadora de cada país. El IVCR es igual al cociente entre la participación de las exportaciones por capítulo del país en las exportaciones totales del país y la participación de las exportaciones por capítulo del mundo en las exportaciones totales del mundo. Un valor mayor que 1 representa ventaja comparativa y uno menor que 1 representa ausencia de ventaja comparativa. El Logaritmo natural facilita la interpretación gráfica del indicador: valores mayores que cero indican ventaja comparativa revelada.");
                switch (indicador) {
                    case 'rcaindex':
                        unidad = '';
                        titulo = 'RCA';
                        break;

                    case 'lnrcaindex':
                        unidad = '';
                        titulo = 'LRCA';
                        break;
                }
                if (paises.length > 0) {
                    var gr = new Grafica4('#grafica1', paises, indicador, ano, titulo,'Cálculos OBCI con base en WITS','Product Code at HS2 nomenclature');
                } else {
                    alert('Recuerde escoger al menos un Pais y escoger un Indicador!');
                }

            });
        });
    });
</script>

