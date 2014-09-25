<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ImportarController
 *
 * @author edinson
 */

class ImportarController extends ControllerBase {
    public function _Always() {
        if (!isset($_SESSION['admin'])) {
            HTTP::JSON(401);
        }
    }

    public function index () {
        HTTP::JSON(200);
    }
    
    public function delete () {
        $_filled = Partial::_filled($this->post, array (
            'tipo', 'ano'
        ));
        
        if($_filled) {
            $tipo = $this->post['tipo'];
            $ano = $this->post['ano'];

            switch ($tipo){
                case 'dept_imp_exp':
                    QueryFactory::query("DELETE FROM dept_imp_exp WHERE ano = :ano", array (
                        ':ano' => $ano
                    ));
                    break;
                case 'pais_imp_exp':
                    QueryFactory::query("DELETE FROM pais_imp_exp WHERE ano = :ano", array (
                        ':ano' => $ano
                    ));
                    break;
                case 'puerto_imp_exp':
                    QueryFactory::query("DELETE FROM puertos_imp_exp WHERE ano = :ano", array (
                        ':ano' => $ano
                    ));
                    break;
                case 'zf_imp_exp':
                    QueryFactory::query("DELETE FROM zf_imp_exp WHERE ano = :ano", array (
                        ':ano' => $ano
                    ));
                    break;
                case 'zf_od_imp_exp':
                    QueryFactory::query("DELETE FROM zf_od_imp_exp WHERE ano = :ano", array (
                        ':ano' => $ano
                    ));
                    break;
                case 'caribe_exp':
                    QueryFactory::query("DELETE FROM caribe_exp WHERE ano = :ano", array (
                        ':ano' => $ano
                    ));
                    break;
                case 'dept_capitulo':
                    QueryFactory::query("DELETE FROM dept_capitulo WHERE ano = :ano", array (
                        ':ano' => $ano
                    ));
                    break;
                case 'rca_index':
                    QueryFactory::query("DELETE FROM rca_index WHERE ano = :ano", array (
                        ':ano' => $ano
                    ));
                    break;
                case 'ihh':
                    QueryFactory::query("DELETE FROM ihh WHERE ano = :ano", array (
                        ':ano' => $ano
                    ));
                    break;
            }

            HTTP::JSON(200);
        }
        
        HTTP::JSON(400);
    }
    
    public function add() {
        $_filled = Partial::_filled($this->post, array (
            'tipo', 'archivo'
        ));
        
        if($_filled) {
            $tipo = $this->post['tipo'];
            $archivo = $this->post['archivo'];
            //$archivo = str_replace(Link::Absolute()."/","", $archivo);
            $archivo = str_replace(Link::Absolute(),"", $archivo);

            switch ($tipo){
                case 'dept_imp_exp':
                    $this->impoexpo_depart($archivo);
                    break;
                case 'pais_imp_exp':
                    $this->impoexpo_paises($archivo);
                    break;
                case 'puerto_imp_exp':
                    $this->puertos_impexp($archivo);
                    break;
                case 'zf_imp_exp':
                    $this->expoimpo_zonasfrancas($archivo);
                    break;
                case 'zf_od_imp_exp':
                    $this->zf_expo_impo_od($archivo);
                    break;
                case 'caribe_exp':
                    $this->expoCaribe($archivo);
                    break;
                case 'dept_capitulo':
                    $this->depart_capt($archivo);
                    break;
                case 'rca_index':
                    $this->RCA_index($archivo);
                    break;
                case 'capitulo':
                    $this->capitulos($archivo);
                    break;
                case 'ihh':
                    $this->ihh($archivo);
                    break;
            }

            HTTP::JSON(200);
        }
        
        HTTP::JSON(400);
    }

    private function puertos_impexp ($url) {

        $excel = new PHPExcel();
        $excel_reader = new PHPExcel_Reader_Excel2007();
        $excel = $excel_reader->load($url);
        $excel->setActiveSheetIndex(0);

        $fila=4;
        $indice_año=1;
        $col_importaciones=1;
        $col_exportaciones=2;
        $años = array();

        $puertos = $this->getModel('puertos_imp_exp');

        while(($año = $excel->getActiveSheet()->getCellByColumnAndRow($indice_año, 2)->getValue())!= ""){
            $fila=4;
            while(($puerto = $excel->getActiveSheet()->getCellByColumnAndRow(0, $fila)->getValue())!= ""){
                $importacion = $excel->getActiveSheet()->getCellByColumnAndRow($col_importaciones, $fila)->getValue();
                $exportacion = $excel->getActiveSheet()->getCellByColumnAndRow($col_exportaciones, $fila)->getValue();

                $params = array();
                
                if($importacion != '' && $importacion != 0 && $exportacion != '' && $exportacion != 0){
                    $params = array (
                        ':grupo' => 'Puerto',
                        ':puerto' => $puerto,
                        ':ano' => $año,
                        ':importado' => $importacion,
                        ':exportado' => $exportacion
                    );
                    $puertos->insert($params);
                }else{
                    if($importacion != '' && $importacion != 0)
                    {
                        $params = array (
                            ':grupo' => 'Puerto',
                            ':puerto' => $puerto,
                            ':ano' => $año,
                            ':importado' => $importacion
                        );
                        $puertos->insert($params);
                    }
                    elseif($exportacion != '' && $exportacion != 0)
                    {
                        $params = array (
                            ':grupo' => 'Puerto',
                            ':puerto' => $puerto,
                            ':ano' => $año,
                            ':exportado' => $exportacion
                        );
                        $puertos->insert($params);
                    }
                }
                $fila++;
            }
            $col_importaciones += 3;
            $col_exportaciones += 3;
            $indice_año += 3;
        }
    }

    private function impoexpo_paises($url){
        $excel = new PHPExcel();
        $excel_reader = new PHPExcel_Reader_Excel2007();
        $excel = $excel_reader->load($url);
        $excel->setActiveSheetIndex(0);

        $paises = $this->getModel('pais_imp_exp');

        $y=0;//valor de la columna pais

        $i=2;//Valor de la fila año
        $j=1;//Valor de la columna año

        $l = $j;
        do{
            $año = $excel->getActiveSheet()->getCellByColumnAndRow($l,$i)->getValue();
            $l++;
            $año_nuevo = $excel->getActiveSheet()->getCellByColumnAndRow($l,$i)->getValue();
        }while(($año_nuevo-$año)==1);

        while(($año = $excel->getActiveSheet()->getCellByColumnAndRow($l,$i)->getValue()) != ""){
            $x=3;//Valor de las filas de departamento
            while(($pais = $excel->getActiveSheet()->getCellByColumnAndRow($y,$x)->getValue()) != "") {
                $exportacion=$excel->getActiveSheet()->getCellByColumnAndRow($j,$x)->getValue();
                $importacion=$excel->getActiveSheet()->getCellByColumnAndRow($l,$x)->getValue();

                if($importacion != '' && $exportacion != ''){
                    $params = array (
                        ':grupo' => 'ZFP',
                        ':nombre' => $pais,
                        ':ano' => $año,
                        ':importado' => $importacion,
                        ':exportado' => $exportacion
                    );
                }else{
                    if($exportacion != ''){
                        $params = array (
                            ':grupo' => 'ZFP',
                            ':nombre' => $pais,
                            ':ano' => $año,
                            ':exportado' => $exportacion
                        );
                    }
                    if($importacion != ''){
                        $params = array (
                            ':grupo' => 'ZFP',
                            ':nombre' => $pais,
                            ':ano' => $año,
                            ':importado' => $importacion
                        );
                    }
                }
                $paises->insert($params);
                $x++;
            }
            $j++;
            $l++;
        }
    }
    
    private function ihh ($url) {
        $excel = new PHPExcel();
        $excel_reader = new PHPExcel_Reader_Excel2007();
        $excel = $excel_reader->load($url);
        $excel->setActiveSheetIndex(0);
        
        $ihh = $this->getModel('ihh');
        $x = 0;     //Columna fija de departamento
        $y = 1;     //Fila fija de años
        $i = 0;     //Cursor de columna
        $j = $y+2;  //Cursor de fila
        
        while(($dpto = $excel->getActiveSheet()->getCellByColumnAndRow($x, $j)->getValue()) != "") {
            $i = $x+1;
            while(($year = $excel->getActiveSheet()->getCellByColumnAndRow($i, $y)->getValue()) != "") {
                $value = $excel->getActiveSheet()->getCellByColumnAndRow($i, $j)->getValue();
                $ihh->insert(array (
                    ':departamento' => $dpto,
                    ':ano' => $year,
                    ':valor' => ($value == '')? '0.0' : $value
                ));
                $i++;
            }
            $j++;
        }
    }

    private function impoexpo_depart($url){
        $excel = new PHPExcel();
        $excel_reader = new PHPExcel_Reader_Excel2007();
        $excel = $excel_reader->load($url);
        $excel->setActiveSheetIndex(0);

        $importar = $this->extraerInfo($excel, 0);
        $exportar = $this->extraerInfo($excel, 1);
        $PIB = $this->extraerInfo($excel, 2);
        $imp_US = $this->extraerInfo($excel, 3);
        $exp_US = $this->extraerInfo($excel, 4);

        $años_imp = array_keys($importar);
        $años_exp = array_keys($exportar);
        $años_PIB = array_keys($PIB);
        $años_imp_US = array_keys($imp_US);
        $años_exp_US = array_keys($exp_US);

        $minimo = min($años_imp[0],$años_exp[0],$años_PIB[0],$años_imp_US[0],$años_exp_US[0]);
        $maximo = max($años_imp[count($años_imp)-1],$años_exp[count($años_exp)-1],$años_PIB[count($años_PIB)-1],$años_imp_US[count($años_imp_US)-1],$años_exp_US[count($años_exp_US)-1]);

        $departamento = $this->getModel('dept_imp_exp');

        for($i = $minimo;$i<=$maximo;$i++)
        {
            for($j = 1;$j<=count($importar[$i]);$j++)
            {
                if(array_key_exists($i, $importar)){
                    $row['importar'] = $importar[$i][$j]['valor'];
                }else{
                    $row['importar'] = 0;
                }
                if(array_key_exists($i, $exportar)){
                    $row['exportar'] = $exportar[$i][$j]['valor'];
                }else{
                    $row['exportar'] = 0;
                }
                if(array_key_exists($i, $PIB)){
                    $row['PIB'] = $PIB[$i][$j]['valor'];
                }else{
                    $row['PIB'] = 0;
                }
                if(array_key_exists($i, $imp_US)){
                    $row['imp_US'] = $imp_US[$i][$j]['valor'];
                }else{
                    $row['imp_US'] = 0;
                }
                if(array_key_exists($i, $exp_US)){
                    $row['exp_US'] = $exp_US[$i][$j]['valor'];
                }else{
                    $row['exp_US'] = 0;
                }
                $params = array (
                    ':departamento' => $importar[$i][$j]['departamento'],
                    ':ano' => $i,
                    ':imp_pesos' => str_replace(',', '.', $row['importar']),
                    ':exp_pesos' => str_replace(',', '.', $row['exportar']),
                    ':pib' => str_replace(',', '.', $row['PIB']),
                    ':imp_dolar' => str_replace(',', '.', $row['imp_US']),
                    ':exp_dolar' => str_replace(',', '.', $row['exp_US'])
                );
                $departamento->insert($params);
            }
        }
    }

    private function extraerInfo($excel, $indice){
        $excel->setActiveSheetIndex($indice);//Primera pestaña

        $y=0;//valor de la columna departamento
        $i=2;//Valor de la final año
        $j=1;//Valor de la columna año

        while(($año = $excel->getActiveSheet()->getCellByColumnAndRow($j,$i)->getValue()) != ""){
            $x=3;//Valor de las filas de departamento

            while(($departamento = $excel->getActiveSheet()->getCellByColumnAndRow($y,$x)->getValue()) != ""){
                $row['departamento']=$departamento;
                $row['año']=$año;
                $row['valor']=$excel->getActiveSheet()->getCellByColumnAndRow($j,$x)->getValue();

                $x++;
                $registros[$x-3]=$row;
            }
            $años[$año]=$registros;
            $j++;
        }

        return $años;
    }

    private function RCA_index($url){
        $excel = new PHPExcel();
        $excel_reader = new PHPExcel_Reader_Excel2007();
        $excel = $excel_reader->load($url);
        $excel->setActiveSheetIndex(0);

        $col_Nomencode = 0;
        $col_ReporterISO3 = 1;
        $col_ReporterName = 2;
        $col_Year = 3;
        $col_Productcode = 4;
        $col_RCA = 5;
        $col_LNRCA = 6;

        $fila = 2;
        $tabla = $this->getModel('rca_index');

        while(($code = $excel->getActiveSheet()->getCellByColumnAndRow($col_Nomencode,$fila)->getValue()) != ""){
            $row = array();
            $row['ReporterISO3'] = $excel->getActiveSheet()->getCellByColumnAndRow($col_ReporterISO3,$fila)->getValue();
            $row['ReporterName'] = $excel->getActiveSheet()->getCellByColumnAndRow($col_ReporterName,$fila)->getValue();
            $row['Year'] = $excel->getActiveSheet()->getCellByColumnAndRow($col_Year,$fila)->getValue();
            $row['Productcode'] = $excel->getActiveSheet()->getCellByColumnAndRow($col_Productcode,$fila)->getValue();
            $row['RCA'] = $excel->getActiveSheet()->getCellByColumnAndRow($col_RCA,$fila)->getValue();
            $row['LNRCA'] = $excel->getActiveSheet()->getCellByColumnAndRow($col_LNRCA,$fila)->getValue();

            $params = array(
                ':name_code' => $code,
                ':reporter_iso3' => $row['ReporterISO3'],
                ':reporter_name' => $row['ReporterName'],
                ':ano' => $row['Year'],
                ':product_code' => $row['Productcode'],
                ':rca' => $row['RCA'],
                ':lnrca' => $row['LNRCA']
            );

            $tabla->insert($params);
            $fila++;
        }
    }

    private function capitulos($url){
        $excel = new PHPExcel();
        $excel_reader = new PHPExcel_Reader_Excel2007();
        $excel = $excel_reader->load($url);
        $excel->setActiveSheetIndex(0);

        $col_Product = 0;
        $col_Description = 1;

        $tabla = $this->getModel('capitulo');

        $fila = 2;
        while(($product = $excel->getActiveSheet()->getCellByColumnAndRow($col_Product,$fila)->getValue()) != ""){
            $descripcion = $excel->getActiveSheet()->getCellByColumnAndRow($col_Description,$fila)->getValue();
            $params = array(
                ':idcapitulo' => $product,
                ':descripcion' => $descripcion
            );
            $tabla->insert($params);
            $fila++;

        }
    }
    
    private function expoCaribe($url){
        $excel = new PHPExcel();
        $excel_reader = new PHPExcel_Reader_Excel2007();
        $excel = $excel_reader->load($url);

        $expo_caribe = $this->getModel('caribe_exp');
        
        $hoja = 0;
        $hojas = $excel->getSheetCount();
        while ($hoja < $hojas){
            $nombre_hoja = $excel->setActiveSheetIndex($hoja)->getTitle();
            if((stristr($nombre_hoja,'Hoja'))===FALSE)
            {
                $col_departamento=0;
                $col_pais=0;
                $col_capitulo=1;
                $col_fob=2;
                while(($departamento = $excel->setActiveSheetIndex($hoja)->getCellByColumnAndRow($col_departamento,1)->getValue())!='')
                {
                    $fila = 3;
                    while(($pais = $excel->setActiveSheetIndex($hoja)->getCellByColumnAndRow($col_pais, $fila)->getValue())!='')
                    {
                        $capitulo = $excel->setActiveSheetIndex($hoja)->getCellByColumnAndRow($col_capitulo, $fila)->getValue();
                        $fob = $excel->setActiveSheetIndex($hoja)->getCellByColumnAndRow($col_fob, $fila)->getValue();
                        $params = array(
                            ':departamento' => $departamento,
                            ':pais' => $pais,
                            ':ano' => $nombre_hoja,
                            ':capitulo' => $capitulo,
                            ':exportado' => $fob
                        );
                        $expo_caribe->insert($params);
                        $fila++;
                    }
                    $col_departamento+=4;
                    $col_pais+=4;
                    $col_capitulo+=4;
                    $col_fob+=4;
                }
            }
            $hoja++;
        }
    }
    
    private function depart_capt($url){
        $excel = new PHPExcel();
        $excel_reader = new PHPExcel_Reader_Excel2007();
        $excel = $excel_reader->load($url);

        $tabla = $this->getModel('dept_capitulo');
        
        $hoja = 0;
        
        $hojas = $excel->getSheetCount();
        while ($hoja < $hojas){
            if((stristr($nombre_hoja = $excel->setActiveSheetIndex($hoja)->getTitle(),'Hoja'))===FALSE)
            {
                $col_departamento=1;
                $col_capitulo=0;
                while(($departamento = $excel->setActiveSheetIndex($hoja)->getCellByColumnAndRow($col_departamento,2)->getValue())!='')
                {
                    $fila = 3;
                    while(($capitulo = $excel->setActiveSheetIndex($hoja)->getCellByColumnAndRow($col_capitulo, $fila)->getValue())!='')
                    {
                        $valor = $excel->setActiveSheetIndex($hoja)->getCellByColumnAndRow($col_departamento, $fila)->getValue();
                        if($valor != null && $valor != ''){
                            $params = array(
                                ':departamento' => $departamento,
                                ':capitulo' => $capitulo,
                                ':ano' => $nombre_hoja,
                                ':valor' => $valor
                            );
                            $tabla->insert($params);
                        }
                        $fila++;
                    }
                    $col_departamento++;
                }
            }
            $hoja++;
        }
    }
    
    private function expoimpo_zonasfrancas($url){
        $excel = new PHPExcel();
        $excel_reader = new PHPExcel_Reader_Excel2007();
        $excel = $excel_reader->load($url);

        $excel->setActiveSheetIndex(0);

        $año_j=1;//valor de la columna año
        $año_l=$año_j;//valor columna año importacion
        $col_zonafranca=0;//valor columna zona franca

        $fila_año=2;//Valor de la fila año
        do{
            $año = $excel->getActiveSheet()->getCellByColumnAndRow($año_l,$fila_año)->getValue();
            $año_l++;
            $año_nuevo = $excel->getActiveSheet()->getCellByColumnAndRow($año_l,$fila_año)->getValue();
        }while(($año_nuevo-$año)==1);

        $tabla = $this->getModel('zf_imp_exp');
        
        while(($año = $excel->setActiveSheetIndex(0)->getCellByColumnAndRow($año_l,$fila_año)->getValue())!='')
        {
            $fila = 3;
            while(($zona_franca = $excel->setActiveSheetIndex(0)->getCellByColumnAndRow($col_zonafranca, $fila)->getValue())!='')
            {
                $importado = $excel->setActiveSheetIndex(0)->getCellByColumnAndRow($año_j, $fila)->getValue();
                $exportado = $excel->setActiveSheetIndex(0)->getCellByColumnAndRow($año_l, $fila)->getValue();
                if($importado != '' && $exportado != '')
                {
                    $params = array(
                        ':grupo' => 'ZFP',
                        ':zona_franca' => $zona_franca,
                        ':ano' => $año,
                        ':importado' => $importado,
                        ':exportado' => $exportado
                    );
                    $tabla->insert($params);
                }else{
                    if($exportado != '')
                    {
                        $params = array(
                            ':grupo' => 'ZFP',
                            ':zona_franca' => $zona_franca,
                            ':ano' => $año,
                            ':exportado' => $exportado
                        );
                        $tabla->insert($params);

                    }elseif($importado != '')
                    {
                        $params = array(
                            ':grupo' => 'ZFP',
                            ':zona_franca' => $zona_franca,
                            ':ano' => $año,
                            ':importado' => $importado,
                        );
                        $tabla->insert($params);
                    }
                }
                $fila++;
            }
            $año_j++;
            $año_l++;
        }
    }
    private function zf_expo_impo_od($url){
        $excel = new PHPExcel();
        $excel_reader = new PHPExcel_Reader_Excel2007();
        $excel = $excel_reader->load($url);

        $importacion = $this->obtenerImpoExpoOD($excel,0);
        $exportacion = $this->obtenerImpoExpoOD($excel,1);

        $cont=0;
        for ($i=0;$i<count($importacion);$i++)
        {
            $sw=0;
            $j=-1;
            while($j<count($exportacion)-1 && $sw==0)
            {
                $j++;
                if($importacion[$i]['pais']==$exportacion[$j]['pais'] && $importacion[$i]['ano']==$exportacion[$j]['ano'])
                {
                    $sw=1;
                }
            }
            if($sw==1){
                $row[$cont]['pais']=$importacion[$i]['pais'];
                $row[$cont]['grupo']=$importacion[$i]['grupo'];
                $row[$cont]['ano']=$importacion[$i]['ano'];
                $row[$cont]['importacion']=$importacion[$i]['valor'];
                $row[$cont]['exportacion']=$exportacion[$j]['valor'];
            }else{
                $row[$cont]['pais']=$importacion[$i]['pais'];
                $row[$cont]['grupo']=$importacion[$i]['grupo'];
                $row[$cont]['ano']=$importacion[$i]['ano'];
                $row[$cont]['importacion']=$importacion[$i]['valor'];
                $row[$cont]['exportacion']=0;
            }
            $cont++;
        }

        for ($i=0;$i<count($exportacion);$i++)
        {
            $sw=0;
            $j=-1;
            while($j<count($row)-1 && $sw==0)
            {
                $j++;
                if($exportacion[$i]['pais']===$row[$j]['pais'] && $exportacion[$i]['ano']===$row[$j]['ano'])
                {
                    $sw=1;
                }
            }
            if($sw==0){
                $row[$cont]['pais']=$exportacion[$i]['pais'];
                $row[$cont]['grupo']=$exportacion[$i]['grupo'];
                $row[$cont]['ano']=$exportacion[$i]['ano'];
                $row[$cont]['importacion']=0;
                $row[$cont]['exportacion']=$exportacion[$i]['valor'];

                $cont++;
            }
        }
        $tabla = $this->getModel('zf_od_imp_exp');
        for($i = 0;$i<count($row);$i++)
        {
            if($row[$i]['exportacion'] != 0 && $row[$i]['importacion']!= 0){
                $params = array(
                    ':pais' => $row[$i]['pais'],
                    ':grupo' => $row[$i]['grupo'],
                    ':ano' => $row[$i]['ano'],
                    ':importado' => $row[$i]['exportacion'],
                    ':exportado' => $row[$i]['importacion']
                );
                $tabla->insert($params);
            }else{
                if($row[$i]['exportacion'] != 0)
                {
                    $params = array(
                        ':pais' => $row[$i]['pais'],
                        ':grupo' => $row[$i]['grupo'],
                        ':ano' => $row[$i]['ano'],
                        ':exportado' => $row[$i]['importacion']
                    );
                    $tabla->insert($params);
                }elseif ($row[$i]['importacion'] != 0) {
                    $params = array(
                        ':pais' => $row[$i]['pais'],
                        ':grupo' => $row[$i]['grupo'],
                        ':ano' => $row[$i]['ano'],
                        ':importado' => $row[$i]['exportacion']
                    );
                    $tabla->insert($params);
                }
            }
        }
    }

    private function obtenerImpoExpoOD($excel,$hoja){
        $col_paises=0;//valor de la columna pais
        $col_grupo=1;//valor de la columna grupa
        $col_año=2;//valor columna año
        $fila_año=2;//valor fila año

        $array = array();

        while(($año = $excel->setActiveSheetIndex($hoja)->getCellByColumnAndRow($col_año,$fila_año)->getValue())!='')
        {
            $fila = 4;    
            while(($pais = trim($excel->setActiveSheetIndex($hoja)->getCellByColumnAndRow($col_paises, $fila)->getValue()))!='')
            {
                $grupo = $excel->setActiveSheetIndex($hoja)->getCellByColumnAndRow($col_grupo, $fila)->getValue();
                $valor = $excel->setActiveSheetIndex($hoja)->getCellByColumnAndRow($col_año, $fila)->getValue();
                    $años['ano']=$año;
                    $años['pais']=$pais;
                    $años['grupo']=$grupo;
                    $años['valor']=$valor;
                $fila++;
                array_push($array, $años);
            }
            $col_año++;
        }
        return $array;
    }
}
