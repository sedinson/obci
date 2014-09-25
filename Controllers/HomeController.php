<?php

class HomeController extends ControllerBase {

    //put your code here
    public function _Always() {
        $this->config->set('Template', 'admin.php');
    }

    function index() {
        $params = array ();
        $params['distribuidores'] = $this->getModel('distribuidor')->select();
        $params['zonas'] = $this->getModel('zona')->select();
        $params['vehiculos'] = $this->getModel('tipovehiculo')->select();
        
        $this->view->show('admin/index.php', $params);
    }
}

?>
