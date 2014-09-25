<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NosotrosController
 *
 * @author edinson
 */
class NosotrosController extends ControllerBase {
    
    public function index () {
        $this->config->set('Template', 'nosotros.php');
        $params = array ();
        
        $params['content'] = $this->getModel('pagina')->select(array (
            'idpagina' => 1
        ));
        
        $this->view->show('nosotros/index.php', $params);
    }
}
