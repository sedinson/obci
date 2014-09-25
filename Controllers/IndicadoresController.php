<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class IndicadoresController extends ControllerBase {
    
    public function _Always() {
        $this->config->set('Template', 'indicadores.php');
    }

    public function index () {
        $params = array ();

        $params['dept'] = QueryFactory::query("SELECT DISTINCT departamento  FROM dept_imp_exp");

        $this->view->show('indicadores/index.php', $params);
    }
    
    public function ihh () {
        $params = array ();
        $params['dept'] = QueryFactory::query("SELECT DISTINCT departamento  FROM ihh");
        
        $this->view->show('indicadores/ihh.php', $params);
    }

    public function expoimpo () {
        $params = array ();
        $params['dept'] = QueryFactory::query("SELECT DISTINCT departamento  FROM dept_imp_exp");

        $this->view->show('indicadores/expoimpo.php', $params);
    }
    
    public function expoimpopaises () {
        $params = array ();

        $params['paises'] = QueryFactory::query("SELECT DISTINCT nombre  FROM pais_imp_exp");

        $this->view->show('indicadores/expoimpopaises.php', $params);
    }
    
    public function zonafranca () {
        $params = array ();

        $params['zf'] = QueryFactory::query("SELECT DISTINCT zona_franca  FROM zf_imp_exp");

        $this->view->show('indicadores/zf.php', $params);
    }
    
    public function puertos () {
        $params = array ();

        $params['ptos'] = QueryFactory::query("SELECT DISTINCT puerto  FROM puertos_imp_exp");

        $this->view->show('indicadores/puertos.php', $params);
    }
    
    public function zfpaises () {
        $params = array ();

        $params['pais'] = QueryFactory::query("SELECT DISTINCT pais  FROM zf_od_imp_exp");

        $this->view->show('indicadores/zfpaises.php', $params);
    }
    
    
    public function aperturabalanza () {
        $params = array ();

        $params['pais'] = QueryFactory::query("SELECT distinct reporter_name FROM rca_index ");
        $params['ano'] = QueryFactory::query("SELECT distinct ano FROM rca_index ");
        
        $this->view->show('indicadores/aperturabalanza.php', $params);
        
    }
    
    public function caribeexpo () {
        $params = array ();

        $params['pais'] = QueryFactory::query("SELECT distinct pais FROM caribe_exp ");
        $params['dept'] = QueryFactory::query("SELECT distinct departamento FROM caribe_exp ");
        $params['cap'] = QueryFactory::query("SELECT idcapitulo, descripcion FROM capitulo");
        $params['ano'] = QueryFactory::query("SELECT distinct ano FROM caribe_exp ORDER BY ano ASC");
        
        $this->view->show('indicadores/caribeexpo.php', $params);
        
    }
    
    
    public function rca () {
        $params = array ();

        $params['dept'] = QueryFactory::query("SELECT DISTINCT departamento  FROM dept_capitulo");
        $params['ano'] = QueryFactory::query("SELECT DISTINCT ano  FROM dept_capitulo ORDER BY ano ASC");
        $params['cap'] = QueryFactory::query("SELECT idcapitulo, descripcion FROM capitulo");
        $this->view->show('indicadores/rca.php', $params);
    }
}
