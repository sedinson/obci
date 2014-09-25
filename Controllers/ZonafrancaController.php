<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ZonafrancaController
 *
 * @author edinson
 */
class ZonafrancaController extends ControllerBase {
    
    public function _Always() {
        if(in_array(ActionName, array ('add', 'delete'))) {
            if(!isset($_SESSION['admin'])) {
                HTTP::JSON(401);
            }
        }
    }
    
    function posiciones () {
        if(!empty($this->get['tipo'])) {
            $tipo = array (':tipo' => urldecode($this->get['tipo']));

            $result = $this->getModel('zf_pt')->select($tipo);
            $response = Partial::arrayNames($result);

            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        }
        
        HTTP::JSON(400);
    }
    
    function delete () {
        if(!empty($this->get['idzf_pt'])) {
            $this->getModel('zf_pt')->delete($this->get['idzf_pt']);
            
            HTTP::JSON(200);
        }
        
        HTTP::JSON(400);
    }
    
    function add () {
        $_filled = Partial::_filled($this->post, array (
            'nombre', 'tipo', 'departamento', 'latitud', 'longitud'
        ));
        
        $_empty = Partial::_empty($this->post, array ('idzf_pt'));
        
        if($_filled && $_empty) {
            $params = Partial::prefix($this->post, ':');
            $this->getModel('zf_pt')->insert($params);
            
            HTTP::JSON(200);
        }
        
        HTTP::JSON(400);
    }
}
