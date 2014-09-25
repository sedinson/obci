<?php

class GraficaController extends ControllerBase {
    //put your code here
    
    function datos () {
        if(!empty($this->get['nombre'])) {
            $tipo = array (':puerto' => urldecode($this->get['nombre']));
            $result = $this->getModel('puertos_imp_exp')->select($tipo);
            $response = Partial::arrayNames($result);

            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        }
        HTTP::JSON(400);
    }
    
    function datos_zf_pt()
    {
        if(!empty($this->get['nombre']))
        {
            $nombre = urldecode($this->get['nombre']);
            $tipo = urldecode($this->get['tipo']);
            if($tipo === 'zona franca')
            {
                $db_zf = $this->getModel('mapa_imp_exp');
                $result = $db_zf->obtener_zf($nombre);
                $response = Partial::arrayNames($result,array());
                HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));                
            }elseif ($tipo === 'puerto') {
                $db_puerto = $this->getModel('mapa_imp_exp');
                $result = $db_puerto->obtener_puerto($nombre);
                $response = Partial::arrayNames($result,array());
                HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
            }
        }
        HTTP::Value(400);
    }
    
    function datosmapapais()
    {
        if(!empty($this->get['dept']))
        {
            $pais = urldecode($this->get['dept']);
            $db_pais = $this->getModel('mapa_imp_exp');
            $result = $db_pais->obtener_impoexpo($pais);
            $response = Partial::arrayNames($result,array());
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        }
        HTTP::Value(400);
    }
    
    function aloha() {
        $pais = explode(',', urldecode($this->get['paises']));
        $db_pais = $this->getModel('pais_imp_exp');
        
        $anos = QueryFactory::query("SELECT DISTINCT ano from pais_imp_exp");
        
        $response = array ();
        for($i=1; $i<count($anos); $i++) {
            $result = $db_pais->obtain($anos[$i][0], $pais);
            array_push($response, Partial::arrayNames($result, array ()));
        }
        HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
    }
    
    function paisimpo(){
        if(!empty($this->get['dept']))
        {
            $paises = explode(',', urldecode($this->get['dept']));
            $db_pais = $this->getModel('pais_imp_exp');
            
            $result = $db_pais->obtain_imp($paises);
            $response = Partial::arrayNames($result, array ());
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        }
         HTTP::Value(400);
    }
    
    function paisexpo(){
        if(!empty($this->get['dept']))
        {
            $paises = explode(',', urldecode($this->get['dept']));
            $db_pais = $this->getModel('pais_imp_exp');
            $response = array();
            $result = $db_pais->obtain_exp($paises);
            $response = Partial::arrayNames($result, array ());
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        }
        HTTP::Value(400);
    }
    
    function paisvarimp()
    {
        if(!empty($this->get['dept']))
        {
            $paises = explode(',', urldecode($this->get['dept']));
            $db_pais = $this->getModel('pais_imp_exp');
            $anos = QueryFactory::query("SELECT DISTINCT ano from pais_imp_exp");
            $response = array();
            $valores = array();
            for($i = 0; $i<count($anos);$i++)
            {
                $result = $db_pais->obtain_var_imp($paises,$anos[$i][0]);
                array_push($valores,Partial::arrayNames($result, array ()));
            }
            for($i = 0;$i<count($valores);$i++)
            {
                for($j = 0;$j<count($valores[$i]);$j++)
                {
                    if($valores[$i][$j]!=null)
                    {
                        array_push($response,$valores[$i][$j]);
                    }
                }
            }
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        }
        HTTP::Value(400);
    }
    
    function paisvarexp()
    {
        if(!empty($this->get['dept']))
        {
            $paises = explode(',', urldecode($this->get['dept']));
            $db_pais = $this->getModel('pais_imp_exp');
            $anos = QueryFactory::query("SELECT DISTINCT ano from pais_imp_exp");
            $response = array();
            $valores = array();
            for($i = 0; $i<count($anos);$i++)
            {
                $result = $db_pais->obtain_var_exp($paises,$anos[$i][0]);
                array_push($valores,Partial::arrayNames($result, array ()));
            }
            for($i = 0;$i<count($valores);$i++)
            {
                for($j = 0;$j<count($valores[$i]);$j++)
                {
                    if($valores[$i][$j]!=null)
                    {
                        array_push($response,$valores[$i][$j]);
                    }
                }
            }
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        }
        HTTP::Value(400);
    }
    
    function paispartimp()
    {
        if(!empty($this->get['dept']))
        {
            $paises = explode(',', urldecode($this->get['dept']));
            $db_pais = $this->getModel('pais_imp_exp');
            $response = array();
            $result = $db_pais->obtain_part_imp($paises);
            $response = Partial::arrayNames($result, array ());
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        }
        HTTP::Value(400);
    }
    
    function paispartimpcircular()
    {
        if(!empty($this->get['dept']))
        {
            $ano = urldecode($this->get['dept']);
            $db_pais = $this->getModel('pais_imp_exp');
            $response = array();
            $result = $db_pais->obtain_part_imp_cir($ano);
            $response = Partial::arrayNames($result, array ());
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        }
        HTTP::Value(400);
    }
    
    function paispartexp()
    {
        if(!empty($this->get['dept']))
        {
            $paises = explode(',', urldecode($this->get['dept']));
            $db_pais = $this->getModel('pais_imp_exp');
            $response = array();
            $result = $db_pais->obtain_part_exp($paises);
            $response = Partial::arrayNames($result, array ());
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        }
        HTTP::Value(400);
    }
    
    function paispartexpcircular()
    {
        if(!empty($this->get['dept']))
        {
            $ano = urldecode($this->get['dept']);
            $db_pais = $this->getModel('pais_imp_exp');
            $response = array();
            $result = $db_pais->obtain_part_exp_cir($ano);
            $response = Partial::arrayNames($result, array ());
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        }
        HTTP::Value(400);
    }
    
    function deptimpo()
    {
        if(!empty($this->get['dept']))
        {
            $departamento = explode(',', urldecode($this->get['dept']));
            $db_dept = $this->getModel('dept_imp_exp');
            $response = array();
            $result = $db_dept->obtain_dept_imp($departamento);
            $response = Partial::arrayNames($result, array ());
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        }
        HTTP::Value(400);
    }
    
    function deptexpo()
    {
        if(!empty($this->get['dept']))
        {
            $departamento = explode(',', urldecode($this->get['dept']));
            $db_dept = $this->getModel('dept_imp_exp');
            $response = array();
            $result = $db_dept->obtain_dept_exp($departamento);
            $response = Partial::arrayNames($result, array ());
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        }
        HTTP::Value(400);
    }
    
    function deptpib()
    {
        if(!empty($this->get['dept']))
        {
            $departamento = explode(',', urldecode($this->get['dept']));
            $db_dept = $this->getModel('dept_imp_exp');
            $response = array();
            $result = $db_dept->obtain_dept_pib($departamento);
            $response = Partial::arrayNames($result, array ());
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        }
        HTTP::Value(400);
    }
    
    function deptbalanza()
    {
        if(!empty($this->get['dept']))
        {
            $departamento = explode(',', urldecode($this->get['dept']));
            $db_dept = $this->getModel('dept_imp_exp');
            $response = array();
            $result = $db_dept->obtain_dept_balanza($departamento);
            $response = Partial::arrayNames($result, array ());
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        }
        HTTP::Value(400);
    }
    
    function deptimp_varia()
    {
        if(!empty($this->get['dept']))
        {
            $departamento = explode(',', urldecode($this->get['dept']));
            $db_dept = $this->getModel('dept_imp_exp');
            $anos = QueryFactory::query("SELECT DISTINCT ano from dept_imp_exp");
            $response = array();
            $valores = array();
            for($i = 0; $i<count($anos);$i++)
            {
                $result = $db_dept->obtain_imp_variacion($departamento,$anos[$i][0]);
                array_push($valores,Partial::arrayNames($result, array ()));
            }
            for($i = 0;$i<count($valores);$i++)
            {
                for($j = 0;$j<count($valores[$i]);$j++)
                {
                    if($valores[$i][$j]!=null)
                    {
                        array_push($response,$valores[$i][$j]);
                    }
                }
            }
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        }
        HTTP::Value(400);
    }
    
    function deptexp_varia()
    {
        if(!empty($this->get['dept']))
        {
            $departamento = explode(',', urldecode($this->get['dept']));
            $db_dept = $this->getModel('dept_imp_exp');
            $anos = QueryFactory::query("SELECT DISTINCT ano from dept_imp_exp");
            $response = array();
            $valores = array();
            for($i = 0; $i<count($anos);$i++)
            {
                $result = $db_dept->obtain_exp_variacion($departamento,$anos[$i][0]);
                array_push($valores,Partial::arrayNames($result, array ()));
            }
            for($i = 0;$i<count($valores);$i++)
            {
                for($j = 0;$j<count($valores[$i]);$j++)
                {
                    if($valores[$i][$j]!=null)
                    {
                        array_push($response,$valores[$i][$j]);
                    }
                }
            }
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        }
        HTTP::Value(400);
    }
    
    function deptimp_pib()
    {
        if(!empty($this->get['dept']))
        {
            $departamento = explode(',', urldecode($this->get['dept']));
            $db_dept = $this->getModel('dept_imp_exp');
            $response = array();
            $result = $db_dept->obtain_imp_pib($departamento);
            $response = Partial::arrayNames($result, array ());
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        }
        HTTP::Value(400);
    }
    
    function deptexp_pib()
    {
        if(!empty($this->get['dept']))
        {
            $departamento = explode(',', urldecode($this->get['dept']));
            $db_dept = $this->getModel('dept_imp_exp');
            $response = array();
            $result = $db_dept->obtain_exp_pib($departamento);
            $response = Partial::arrayNames($result, array ());
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        }
        HTTP::Value(400);
    }
    
    function deptcoef()
    {
        if(!empty($this->get['dept']))
        {
            $departamento = explode(',', urldecode($this->get['dept']));
            $db_dept = $this->getModel('dept_imp_exp');
            $response = array();
            $result = $db_dept->obtain_coef_apertura($departamento);
            $response = Partial::arrayNames($result, array ());
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        }
        HTTP::Value(400);
    }
    
    function deptimpus(){
        if(!empty($this->get['dept']))
        {
            $departamento = explode(',', urldecode($this->get['dept']));
            $db_dept = $this->getModel('dept_imp_exp');
            $response = array();
            $result = $db_dept->obtain_imp_dolares($departamento);
            $response = Partial::arrayNames($result, array ());
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        }
        HTTP::Value(400);
    }
    
    function deptexpus(){
        if(!empty($this->get['dept']))
        {
            $departamento = explode(',', urldecode($this->get['dept']));
            $db_dept = $this->getModel('dept_imp_exp');
            $response = array();
            $result = $db_dept->obtain_exp_dolares($departamento);
            $response = Partial::arrayNames($result, array ());
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        }
        HTTP::Value(400);
    }
    
    function deptvarimpus(){
        if(!empty($this->get['dept']))
        {
            $departamento = explode(',', urldecode($this->get['dept']));
            $db_dept = $this->getModel('dept_imp_exp');
            $anos = QueryFactory::query("SELECT DISTINCT ano from dept_imp_exp");
            $response = array();
            $valores = array();
            for($i = 0; $i<count($anos);$i++)
            {
                $result = $db_dept->obtain_var_imp_us($departamento,$anos[$i][0]);
                array_push($valores,Partial::arrayNames($result, array ()));
            }
            for($i = 0;$i<count($valores);$i++)
            {
                for($j = 0;$j<count($valores[$i]);$j++)
                {
                    if($valores[$i][$j]!=null)
                    {
                        array_push($response,$valores[$i][$j]);
                    }
                }
            }
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        }
        HTTP::Value(400);
    }
    
    function deptvarexpus(){
        if(!empty($this->get['dept']))
        {
            $departamento = explode(',', urldecode($this->get['dept']));
            $db_dept = $this->getModel('dept_imp_exp');
            $anos = QueryFactory::query("SELECT DISTINCT ano from dept_imp_exp");
            $response = array();
            $valores = array();
            for($i = 0; $i<count($anos);$i++)
            {
                $result = $db_dept->obtain_var_exp_us($departamento,$anos[$i][0]);
                array_push($valores,Partial::arrayNames($result, array ()));
            }
            for($i = 0;$i<count($valores);$i++)
            {
                for($j = 0;$j<count($valores[$i]);$j++)
                {
                    if($valores[$i][$j]!=null)
                    {
                        array_push($response,$valores[$i][$j]);
                    }
                }
            }
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        }
        HTTP::Value(400);
    }
    
    function zfimp()
    {
        if(!empty($this->get['dept']))
        {
            $zf = explode(',', urldecode($this->get['dept']));
            $db_zf = $this->getModel('zonafranca');
            $response = array();
            $result = $db_zf->zf_imp($zf);
            $response = Partial::arrayNames($result, array ());
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        }
        HTTP::Value(400);
    }
    
    function zfexp()
    {
        if(!empty($this->get['dept']))
        {
            $zf = explode(',', urldecode($this->get['dept']));
            $db_zf = $this->getModel('zonafranca');
            $response = array();
            $result = $db_zf->zf_exp($zf);
            $response = Partial::arrayNames($result, array ());
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        }
        HTTP::Value(400);
    }
    
     function puertoimp()
    {
        if(!empty($this->get['dept']))
        {
            $puertos = explode(',', urldecode($this->get['dept']));
            $db_puerto = $this->getModel('puerto_imp_exp');
            $response = array();
            $result = $db_puerto->puerto_imp($puertos);
            $response = Partial::arrayNames($result, array ());
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        }
        HTTP::Value(400);
    }
    
    function puertoexp()
    {
        if(!empty($this->get['dept']))
        {
            $puertos = explode(',', urldecode($this->get['dept']));
            $db_puerto = $this->getModel('puerto_imp_exp');
            $response = array();
            $result = $db_puerto->puerto_exp($puertos);
            $response = Partial::arrayNames($result, array ());
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        }
        HTTP::Value(400);
    }
    
    function puertototal()
    {
        if(!empty($this->get['dept']))
        {
            $puertos = explode(',', urldecode($this->get['dept']));
            $db_puerto = $this->getModel('puerto_imp_exp');
            $response = array();
            $result = $db_puerto->puerto_total($puertos);
            $response = Partial::arrayNames($result, array ());
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        }
        HTTP::Value(400);
    }
    
    function zf_destexp(){
        if(!empty($this->get['dept']))
        {
            $pais = explode(',', urldecode($this->get['dept']));
            $db_zf = $this->getModel('zonafranca');
            $response = array();
            $result = $db_zf->zf_dest_exp($pais);
            $response = Partial::arrayNames($result, array ());
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        }
        HTTP::Value(400);
   
    }
    
    function zf_oriimp(){
        if(!empty($this->get['dept']))
        {
            $pais = explode(',', urldecode($this->get['dept']));
            $db_zf = $this->getModel('zonafranca');
            $response = array();
            $result = $db_zf->zf_ori_imp($pais);
            $response = Partial::arrayNames($result, array ());
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        }
        HTTP::Value(400);   
    }    
    
    function zf_odimp_var(){
        if(!empty($this->get['dept']))
        {
            $pais = explode(',', urldecode($this->get['dept']));
            $db_zf = $this->getModel('zonafranca');
            $anos = QueryFactory::query("SELECT DISTINCT ano from zf_od_imp_exp");
            $response = array();
            $valores = array();
            for($i = 0; $i<count($anos);$i++)
            {
                $result = $db_zf->zf_imp_var($pais,$anos[$i][0]);
                array_push($valores,Partial::arrayNames($result, array ()));
            }
            for($i = 0;$i<count($valores);$i++)
            {
                for($j = 0;$j<count($valores[$i]);$j++)
                {
                    if($valores[$i][$j]!=null)
                    {
                        array_push($response,$valores[$i][$j]);
                    }
                }
            }
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        }
        HTTP::Value(400);
    }
    
    function zf_odexp_var(){
        if(!empty($this->get['dept']))
        {
            $pais = explode(',', urldecode($this->get['dept']));
            $db_zf = $this->getModel('zonafranca');
            $anos = QueryFactory::query("SELECT DISTINCT ano from zf_od_imp_exp");
            $response = array();
            $valores = array();
            for($i = 0; $i<count($anos);$i++)
            {
                $result = $db_zf->zf_exp_var($pais,$anos[$i][0]);
                array_push($valores,Partial::arrayNames($result, array ()));
            }
            for($i = 0;$i<count($valores);$i++)
            {
                for($j = 0;$j<count($valores[$i]);$j++)
                {
                    if($valores[$i][$j]!=null)
                    {
                        array_push($response,$valores[$i][$j]);
                    }
                }
            }
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        }
        HTTP::Value(400);
    }
    
    function rcaindex(){
        if(!empty($this->get['pais']))
        {
            $pais = $this->get['pais'];
            $ano = $this->get['ano'];
            $db_rca = $this->getModel('rca_index');
            $response = array();
            $result = $db_rca->get_rca($pais,$ano);
            $response = Partial::arrayNames($result, array ());
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        }
        HTTP::Value(400);
    }
    
    function lnrcaindex(){
        if(!empty($this->get['pais']))
        {
            $pais = $this->get['pais'];
            $ano = $this->get['ano'];
            $db_rca = $this->getModel('rca_index');
            $response = array();
            $result = $db_rca->get_lnrca($pais,$ano);
            $response = Partial::arrayNames($result, array ());
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        }
        HTTP::Value(400);
    }

    function zfvarimp(){
        if(!empty($this->get['dept']))
        {
            $pais = explode(',', urldecode($this->get['dept']));
            $db_zf = $this->getModel('zonafranca');
            $anos = QueryFactory::query("SELECT DISTINCT ano from zf_od_imp_exp");
            $response = array();
            $valores = array();
            for($i = 0; $i<count($anos);$i++)
            {
                $result = $db_zf->zf_var_imp($pais,$anos[$i][0]);
                array_push($valores,Partial::arrayNames($result, array ()));
            }
            for($i = 0;$i<count($valores);$i++)
            {
                if($valores[$i][0]!=null)
                {
                    array_push($response,$valores[$i][0]);
                }
            }
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        }
        HTTP::Value(400);
    }
    
    function zfvarexp(){
        if(!empty($this->get['dept']))
        {
            $pais = explode(',', urldecode($this->get['dept']));
            $db_zf = $this->getModel('zonafranca');
            $anos = QueryFactory::query("SELECT DISTINCT ano from zf_od_imp_exp");
            $response = array();
            $valores = array();
            for($i = 0; $i<count($anos);$i++)
            {
                $result = $db_zf->zf_var_exp($pais,$anos[$i][0]);
                array_push($valores,Partial::arrayNames($result, array ()));
            }
            for($i = 0;$i<count($valores);$i++)
            {
                if($valores[$i][0]!=null)
                {
                    array_push($response,$valores[$i][0]);
                }
            }
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        }
        HTTP::Value(400);
    }
    
    function zfparimp(){
        if(!empty($this->get['dept'])){
            $pais = explode(',', urldecode($this->get['dept']));
            $db_zf = $this->getModel('zonafranca');
            $response = array();
            $result = $db_zf->zf_imp_par($pais);
            $response = Partial::arrayNames($result, array ());
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        }
        HTTP::Value(400);
    }
    
    function zfparexp(){
        if(!empty($this->get['dept'])){
            $pais = explode(',', urldecode($this->get['dept']));
            $db_zf = $this->getModel('zonafranca');
            $response = array();
            $result = $db_zf->zf_exp_par($pais);
            $response = Partial::arrayNames($result, array ());
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        }
        HTTP::Value(400);
    }
    
    function zfparimpcir(){
        if(!empty($this->get['dept'])){
            $ano = urldecode($this->get['dept']);
            $db_zf = $this->getModel('zonafranca');
            $response = array();
            $result = $db_zf->zf_imp_par_cir($ano);
            $response = Partial::arrayNames($result, array ());
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        }
        HTTP::Value(400);
    }
    
    function zfparexpcir(){
        if(!empty($this->get['dept'])){
            $ano = urldecode($this->get['dept']);
            $db_zf = $this->getModel('zonafranca');
            $response = array();
            $result = $db_zf->zf_exp_par_cir($ano);
            $response = Partial::arrayNames($result, array ());
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        }
        HTTP::Value(400);
    }
    
    function expocaribe(){
        if(!empty($this->get['departamento']) && !empty($this->get['pais']) && !empty($this->get['ano'])){
            $departamento = urldecode($this->get['departamento']);
            $pais = urldecode($this->get['pais']);
            $ano = urldecode($this->get['ano']);
            $db_expcaribe = $this->getModel('caribe_exp');
            $response = array();
            $result = $db_expcaribe->fob($departamento,$pais,$ano);
            $response = Partial::arrayNames($result,array());
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        }
        HTTP::Value(400);
    }
    
    function fob_rca(){
        if(!empty($this->get['departamento']) && !empty($this->get['ano']) && !empty($this->get['capitulos'])){
            $departamento = urldecode($this->get['departamento']);
            $anos = urldecode($this->get['ano']);
            $capitulos = explode(',', urldecode($this->get['capitulos']));
            $db_rca = $this->getModel('rca_index');
            $result = $db_rca->get_fob($departamento,$anos, $capitulos);
            $response = Partial::arrayNames($result,array());
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        }
        HTTP::value(400);
    }
    
    function indice_rca(){
        if(!empty($this->get['pais']) && !empty($this->get['ano'])){
            $departamento = urldecode($this->get['pais']);
            //$anos = explode(',', urldecode($this->get['ano']));
            $anos = urldecode($this->get['ano']);
            $db_rca = $this->getModel('rca_index');
            $result = $db_rca->get_indice($departamento,$anos);
            $response = Partial::arrayNames($result,array());
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        }
        HTTP::value(400);
    }
    
    function indice_lnrca(){
        if(!empty($this->get['pais']) && !empty($this->get['ano'])){
            $departamento = urldecode($this->get['pais']);
            $ano = urldecode($this->get['ano']);
            $db_rca = $this->getModel('rca_index');
            $response = array();
            $result = $db_rca->get_ln_indice($departamento,$ano);
            $response = Partial::arrayNames($result,array());
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        }
        HTTP::value(400);
    }
    
    function expocaribe_fob(){
        if(!empty($this->get['departamento']) && !empty($this->get['ano']) && !empty($this->get['pais'])){
            $departamento = urldecode($this->get['departamento']);
            $ano = urldecode($this->get['ano']);
            $paises = explode(',',urldecode($this->get['pais']));
            $db_expocaribe = $this->getModel('caribe_exp');
            $response = array();
            $result = $db_expocaribe->fobUS($departamento,$ano,$paises);
            $response = Partial::arrayNames($result,array());
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        }
        HTTP::value(400);
    }
    
    function expocaribe_part(){
        if(!empty($this->get['departamento']) && !empty($this->get['ano']) && !empty($this->get['pais'])){
            $departamento = urldecode($this->get['departamento']);
            $ano = urldecode($this->get['ano']);
            $paises = explode(',',urldecode($this->get['pais']));
            $db_expocaribe = $this->getModel('caribe_exp');
            
            $result = $db_expocaribe->part_fobUS($departamento,$ano,$paises);
            $response = Partial::arrayNames($result,array());
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        }
        HTTP::value(400);
    }
    
    function ihh () {
        if(!empty ($this->get['dept'])) {
            $departamentos = explode(',', urldecode($this->get['dept']));
            
            $result = $this->getModel('IHH')->get($departamentos);
            $response = Partial::arrayNames($result, array ());
            
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        }
        
        HTTP::JSON(400);
    }
}
?>
