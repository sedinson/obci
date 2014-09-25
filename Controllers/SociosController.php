<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SociosController
 *
 * @author edinson
 */
class SociosController extends ControllerBase {
    
    public function _Always() {
        $this->config->set('Template', 'socios.php');
        
        if(in_array(ActionName, array ('add', 'delete'))) {
            if(!isset($_SESSION['admin'])) {
                HTTP::JSON(401);
            }
        }
    }
    
    public function index () {
        $params = array ();
        
        $params['socios'] = QueryFactory::query("SELECT idacuerdo, tipo, bandera, nombre, acuerdo FROM acuerdo WHERE tipo='socios' ORDER BY nombre ASC;");
        $params['titulo'] = "Socios Comerciales Bilaterales";
        
        $this->view->show('socios/index.php', $params);
    }
    
    public function bloques () {
        $params = array ();
        
        $params['socios'] = QueryFactory::query("SELECT idacuerdo, tipo, bandera, nombre, acuerdo FROM acuerdo WHERE tipo='bloques' ORDER BY nombre ASC;");
        $params['titulo'] = "Bloques Regionales";
        
        $this->view->show('socios/bloques.php', $params);
    }
    
    public function ver () {
        $params = array ();
        
        $params['info'] = $this->getModel('acuerdo')->select(array (
            ':idacuerdo' => $this->get['id']
        ));
        
        $this->view->show('socios/ver.php', $params);
    }
    
    public function get () {
        if(empty($this->get['idacuerdo'])) {
            $result = QueryFactory::query("SELECT idacuerdo, tipo, bandera, nombre, acuerdo FROM acuerdo ORDER BY nombre ASC;");
        } else {
            $result = $this->getModel('acuerdo')->select(array (
                ':idacuerdo' => $this->get['idacuerdo']
            ));
        }
        
        $response = Partial::arrayNames($result);
        
        HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
    }
    
    public function add () {
        $_filled = Partial::_filled($this->post, array (
            'tipo', 'nombre', 'acuerdo', 'enlace', 'historia', 'objetivo', 'perfil', 'desgraviacion'
        ));
        
        $_empty = Partial::_empty($this->post, array ('idacuerdo'));
        
        if($_filled && $_empty) {
            $params = Partial::prefix($this->post, ':');
            
            $this->getModel('acuerdo')->insert($params);
            
            HTTP::JSON(200);
        }
        
        HTTP::JSON(400);
    }
    
    public function delete () {
        if(!empty($this->get['idacuerdo'])) {
            $this->getModel('acuerdo')->delete($this->get['idacuerdo']);
            
            HTTP::JSON(200);
        }
        
        HTTP::JSON(400);
    }
}
