<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AdminController
 *
 * @author edinson
 */
class AdminController extends ControllerBase {
    //put your code here
    public function _Always() {
        $this->config->set('Template', 'admin.php');
    }
            
    function index () {
        $params = array ();
        
        $params['departamentos'] = QueryFactory::query("SELECT DISTINCT departamento FROM dept_imp_exp");
        $params['paises'] = QueryFactory::query("SELECT DISTINCT nombre FROM pais_imp_exp");
        
        $this->view->show('admin/index.php', $params);
    }
    
    function main_page () {
        if(!isset($_SESSION['admin'])) {
            HTTP::JSON(401);
        }
            
        if(!empty($this->post['content'])) {
            $this->getModel('pagina')->update(1, array (
                ':content' => $this->post['content']
            ));
            
            HTTP::JSON(Partial::CreateResponse(HTTP::Value(200), $this->post['content']));
        }
        
        $content = $this->getModel('pagina')->select(array (
            ':idpagina' => 1
        ));

        $result = Partial::arrayNames($content, array ('idpagina'));
        HTTP::JSON(Partial::createResponse(HTTP::Value(200), $result[0]));
    }
}
