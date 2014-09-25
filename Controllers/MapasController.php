<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MapasController
 *
 * @author edinson
 */
class MapasController extends ControllerBase {
    //put your code here
    public function _Always() {
        $this->config->set('Template', 'mapas.php');
    }
    
    public function  index () {
        $this->view->show('mapas/index.php');
    }
    
    public function paises () {
        $this->view->show('mapas/paises.php');
    }
}
