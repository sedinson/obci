<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FlujosController
 *
 * @author edinson
 */
class FlujosController extends ControllerBase {
    
    public function _Always() {
        if(in_array(ActionName, array ('add', 'delete'))) {
            if(!isset($_SESSION['admin'])) {
                HTTP::JSON(401);
            }
        }
    }
    
    function add () {
        $_filled = Partial::_filled($this->post, array (
            'codigo', 'pais'
        ));
        
        $_empty = Partial::_empty($this->post, array ('idflujos_comerciales'));
        
        if($_filled && $_empty) {
            $params = Partial::prefix($this->post, ':');
            $this->getModel('flujos_comerciales')->insertorupdate($params);
            
            HTTP::JSON(200);
        }
        
        HTTP::JSON(400);
    }
    
    function get () {
        $result = QueryFactory::query("SELECT nombre AS pais, importado, exportado, ano, codigo
            FROM pais_imp_exp, flujos_comerciales
            WHERE ano = ( 
            SELECT MAX( ano ) 
            FROM pais_imp_exp ) 
            AND nombre = pais");
        
        $response = Partial::arrayNames($result);
        
        HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
    }
    
    function delete () {
        if(!empty ($this->get['idflujos_comerciales'])) {
            $this->getModel('flujos_comerciales')->delete($this->get['idflujos_comerciales']);
            
            HTTP::JSON(200);
        }
        
        HTTP::JSON(400);
    }
}
