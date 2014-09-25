<div id="paises" class="listView">
    <h2>Exportaciones por Departamentos</h2>

    <div class="superior">
        <div class="B2 items-alarge supercolumn">
            <div class="column">
                <label>Seleccionar Indicador</label>
                <select id="mySelect">
                    <option value="fob_rca" selected>Exportaciones</option>
                    <option value="indice_rca" >índice de Ventaja Comaparativa Revelada</option>
                    <option value="indice_lnrca" >LN índice</option>

                </select>
            </div>

            <div class="column">
                <label>Seleccionar Departamento</label>
                <select id="mySelectD" name="mySelectD">
                    <?php echo
                    Partial::fetchRows($_VARS['dept'], '<option value=":departamento">:departamento</option>');
                    ?>
                </select>
            </div>

            <div class="column">
                <label>Seleccionar Año</label>
                <select id="example" name="example">
                    <?php echo
                    Partial::fetchRows($_VARS['ano'], '<option value=":ano">:ano</option>');
                    ?>
                </select>
            </div>

            <div id ="div1"class="column">
                <label>Seleccionar Capitulos</label>
                <select id="cap" name="cap" multiple="multiple">
                    <?php echo
                    Partial::fetchRows($_VARS['cap'], '<option value=":idcapitulo">:descripcion</option>');
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
    <div id="grafica2"></div>
</div>
<?php
Link::loadScript('Scripts/load.php?file=js/graficaRca.js&type=text/javascript');
Link::loadScript('Scripts/load.php?file=js/grafica4.js&type=text/javascript');
?>
<script>
    var LinkServer = new Linker('<?php echo Link::Absolute() ?>');
    LinkServer.setExtension('.json?');
    var indicador, unidad, titulo,dept;
    
    $( "#mySelect" ).change(function () {
        var str = "";
        str = $('#mySelect option:selected' ).text();
        console.log(str);
        if(str === 'índice de Ventaja Comaparativa Revelada' || str === 'LN índice'){
            console.log('entre');
            $( "#div1" ).hide( "fast" );
        }else{
            $( "#div1" ).show( "fast" );
        }
        
      }).change();
      
    $(document).ready(function() {
        $("#cap").multiselect().multiselectfilter();
    });


    $(function() {
        $("#checkPais").click(function() {
            indicador = $('#mySelect option:selected').val();
            dept = $('#mySelectD option:selected').val();
            var cap = _Utils.getChecks($("#cap"));
            var ano = $('#example option:selected').val();
            var tipo;
            switch (indicador) {
                    case 'fob_rca':
                        unidad = '';
                        $("#leyenda").html("Total de exportaciones del departamento seleccionado por capítulo de Arancel seleccionado.");
                        titulo = 'Exportaciones del Departamento';
                        tipo = 0;
                        break;

                    case 'indice_rca':
                        unidad = '';
                        $("#leyenda").html("El índice de ventaja comparativa revelada muestra la especialización exportadora de cada departamento colombiano. El IVCR es igual al cociente entre la participación de las exportaciones por capítulo del departamento en las exportaciones totales del departamento y la participación de las exportaciones por capítulo de Colombia en las exportaciones totales de Colombia. Un valor mayor que 1 representa ventaja comparativa y uno menor que 1 representa ausencia de ventaja comparativa.");
                        titulo = 'Índice de ventaja comparativa revelada';
                        tipo = 1;
                        $( "#grafica2" ).hide( "fast" );
                        break;
                     
                    case 'indice_lnrca':
                        unidad = '';
                        $("#leyenda").html("el logaritmo natural del IVCR facilita la interpretación gráfica del índice. Valores mayores a 0 indican Ventaja Comparativa Revelada.");
                        titulo = 'LN Índice de ventaja comparativa revelada';
                        tipo = 2;
                        $( "#grafica2" ).hide( "fast" );
                        break;
                }
            if (ano.length > 0) {
                if(tipo === 0){
                    var gr = new GraficaRca('#grafica1', '#grafica2', dept,ano, cap,indicador, 'ExpoPaises', 'USD');
                }else if(tipo === 1){
                    var gr = new Grafica4('#grafica1', dept, indicador, ano, titulo, 'Cálculos OBCI con base en DIAN','Capitulos');
                }else{
                     var gr = new Grafica4('#grafica1', dept, indicador, ano, titulo, 'Cálculos OBCI con base en DIAN','Capitulos');
                }
                
            } else {
                alert('Recuerde escoger al menos un Pais y escoger un Indicador!');
            }

        });
    });
</script>