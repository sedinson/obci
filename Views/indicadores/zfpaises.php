<div id="paises" class="listView">
    <h2>Importacion / Exportacion Por Zona Franca (Origen/Destino)</h2>
    
    <div class="superior">
        <div class="B2 items-alarge supercolumn">
            <div class="column">
                <label>Seleccionar Indicador</label>
                <select id="mySelect">
                    <option value="">Seleccione...</option>
                    <option value="zf_destexp">Exportación Por Destino</option>
                    <option value="zf_oriimp" >Importación por Origen</option>
                    <option value="zf_odexp_var" >Variacion Exportación por Destino</option>
                    <option value="zf_odimp_var" >Variacion Importación por Destino</option>
                    <option value="zfparexpcir" >Participacion Exportación por Destino</option>
                    <option value="zfparimpcir" >Participaion Importación por Destino</option>
                </select>
            </div>

            <div class="column">
                <div id ="div1">
                    <label id="txtT" ></label>
                    <select id="example" name="example" multiple="multiple">
                        <?php echo
                        Partial::fetchRows($_VARS['pais'], '<option value=":pais">:pais</option>');
                        ?>
                    </select>
                </div>
                
                <div id ="div2">
                    <label>Seleccionar Año</label>
                    <select id="mySelectA">
                        <option value="2011" selected>2011</option>
                        <option value="2012" selected>2012</option>
                    </select>
                </div>
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
Link::loadScript('Scripts/load.php?file=js/graficaPie.js&type=text/javascript');
?>
<script>
    var LinkServer = new Linker('<?php echo Link::Absolute() ?>');
    LinkServer.setExtension('.json?');
    var indicador, unidad, titulo,ano,tipo,fuente;
    
    $( "#mySelect" ).change(function () {
        var str = "";
        str = $('#mySelect option:selected' ).text();
        console.log(str);
        if(str === 'Exportación Por Destino' || str === 'Variacion Exportación por Destino'){
            $( "#txtT" ).text( "Seleccionar destino" );
        }else{
             $( "#txtT" ).text( "Seleccionar origen" );
        }
        if(str === 'Participaion Importación por Destino' || str === 'Participacion Exportación por Destino'){
            console.log('entre');
            $( "#div1" ).hide( "fast" );
           $( "#div2" ).show( "fast" );
           
        }else{
            $( "#div2" ).hide( "fast" );
            $( "#div1" ).show( "fast" );
        }
        
      }).change();
  
    $(document).ready(function() {
        $( "#div1" ).hide( "fast" );
        $( "#div2" ).hide( "fast" );
        $("#example").multiselect().multiselectfilter();
    });



    $(function() {
        $("#checkPais").click(function() {
            ano = $('#mySelectA option:selected').val();
            indicador = $('#mySelect option:selected').val();
            switch (indicador) {
                case 'zf_destexp':
                    unidad = 'Miles USD';
                    $("#leyenda").html("Total exportaciones en USD (United States Dollar) de todas las zonas francas hacia el destino seleccionado en valor FOB (Free on board – Franco a bordo).");
                    titulo = 'Exportaciones colombianas en USD hacia (EJ: ALADI) (FOB)';
                    tipo = 0;
                    fuente = 'Elaboración OBCI con base en DANE';
                    break;

                case 'zf_oriimp':
                    unidad = 'Miles USD';
                    $("#leyenda").html("Total importaciones en USD (United States Dollar) de todas las zonas francas desde el origen seleccionado en valor CIF (Cost, insurance and freight – Costo, seguro y flete).");
                    titulo = 'Importaciones colombianas en USD desde (EJ: ALADI) (CIF)';
                    tipo = 0;
                    fuente = 'Elaboración OBCI con base en DANE';
                    break;
                    
                case 'zf_odexp_var':
                unidad = '%';
                $("#leyenda").html("La variación en las exportaciones corresponde al cambio porcentual anual presentado.");
                titulo = 'Variación Exportaciones';
                tipo = 0;
                fuente = 'Cálculos OBCI con base en DANE';
                break;

                case 'zf_odimp_var':
                unidad = '%';
                $("#leyenda").html("La variación en las importaciones corresponde al cambio porcentual anual presentado.");
                titulo = 'Variación Importaciones';
                tipo = 0;
                fuente = 'Cálculos OBCI con base en DANE';
                break;
                
                case 'zfparexpcir':
                unidad = '%';
                $("#leyenda").html("Participación de cada destino dentro del total de exportaciones realizadas por todas las zonas francas.");
                titulo = 'Participación Exportación por destino';
                tipo = 1;
                fuente = 'Cálculos OBCI con base en DANE';
                
                break;
                
                case 'zfparimpcir':
                unidad = '%';
                $("#leyenda").html("Participación de cada origen dentro del total de importaciones realizadas por todas las zonas francas.");
                titulo = 'Participación Importación por origen';
                tipo = 1;
                fuente = 'Cálculos OBCI con base en DANE';
                break;
            }
            var paises = _Utils.getChecks($("#example"));
            
                if(tipo === 0) {
                    if (paises.length > 0) {
                        var gr = new Grafica3('#grafica1', '#grafica2', paises, indicador, titulo, unidad, fuente);
                    }else{
                        alert('Recuerde escoger al menos un Pais y escoger un Indicador!');
                    }
                    
                }else{
                    var gr = new Grafica5('#grafica1', ano, indicador, unidad, fuente);
                    $( "#grafica2" ).empty();
                }
                
           
                
            

        });
    });
</script>