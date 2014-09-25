<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InstallationController
 *
 * @author edinson
 */
class InstallationController extends ControllerBase {
    //put your code here
    public function _Always() {
        if(!in_array(ActionName, array ('get'))) {
            if(!isset($_SESSION['admin'])) {
                HTTP::JSON(401);
            }
        }
    }
    
    public function get () {
        $result = $this->getModel('instalacion')->select();
        
        $response = Partial::arrayNames($result);
        HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
    }
    
    public function create () {
        $filled = Partial::_filled($this->post, array ('imagen'));
        $empty = Partial::_empty($this->post, array ('idinstalacion'));
        
        if($filled && $empty) {
            $tmp = Partial::prefix($this->post, ':');
            $this->getModel('instalacion')->insert($tmp);
            
            HTTP::JSON(200);
        }
        
        HTTP::JSON(400);
    }
    
    public function delete () {
        if(!empty ($this->get['idinstalacion'])) {
            $this->getModel('instalacion')->delete($this->get['idinstalacion']);
            
            HTTP::JSON(200);
        }
        
        HTTP::JSON(400);
    }
}
