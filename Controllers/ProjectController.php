<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProjectController
 *
 * @author edinson
 */
class ProjectController extends ControllerBase {
    //put your code here
    public function view () {
        $params = array ();
        
        $params['project'] = $this->getModel('project')->select(array (
            ':idproject' => $this->get['project']
        ));
        
        $params['slide'] = $this->getModel('slide')->select(array (
            ':idproject' => $this->get['project']
        ));
        
        $this->view->show('index/project.php', $params);
    }
    
    public function get () {
        $idproject = (!empty($this->get['idproject']))? array (
            ':idproject' => $this->get['idproject']
        ) : array ();
        
        $result = $this->getModel('project')->select(
            $idproject,
            " ORDER BY idproject DESC;"
        );
        
        $response = Partial::arrayNames($result);
        HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
    }
}
