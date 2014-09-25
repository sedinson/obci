<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NewsController
 *
 * @author edinson
 */
class NewsController extends ControllerBase {
    
    public function _Always() {
        if(!in_array(ActionName, array ('get', 'feed'))) {
            if(!isset($_SESSION['admin'])) {
                HTTP::JSON(401);
            }
        }
    }
    
    private function returnIfNumber($number, $default) {
        if (!empty($number)) {
            if (is_numeric($number)) {
                return $number;
            } else {
                HTTP::JSON(400);
            }
        } else {
            return $default;
        }
    }
    
    public function create () {
        $filled = Partial::_filled($this->post, array ('noticia', 'titulo', 'tags', 'portada', 'resumen'));
        
        if($filled) {
            $params = Partial::prefix($this->post, ':');
            $params[':autor'] = $_SESSION['admin'];
            
            $this->getModel('noticia')->insertorupdate($params);
            
            HTTP::JSON(200);
        }
        
        HTTP::JSON(400);
    }
    
    public function get () {
        $idnoticia = $this->returnIfNumber($this->get['idnoticia'], 0);
        
        $result = $this->getModel('noticia')->select(array (
            ':idnoticia' => $idnoticia
        ));
        
        if(count($result) == 1) {
            $response = Partial::arrayNames($result);
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response[0]));
        }
        
        HTTP::JSON(400);
    }
    
    public function delete () {
        $idnoticia = $this->returnIfNumber($this->get['idnoticia'], 0);
        
        if($idnoticia != 0) {
            $this->getModel('noticia')->delete($idnoticia);
            
            HTTP::JSON(200);
        } else {
            HTTP::JSON(400);
        }
    }
    
    public function feed () {
        $limit = $this->returnIfNumber($this->get['limit'], 2);
        $idnoticia = $this->returnIfNumber($this->get['idnoticia'], 0);
        $order = 'asc';
        $comp = '>';
        
        if(!empty($this->get['order'])) {
            if(in_array($this->get['order'], array ('desc', 'asc'))) {
                $order = $this->get['order'];
            } else {
                HTTP::JSON(400);
            }
        }
        
        if(!empty($this->get['comp'])) {
            if(in_array($this->get['comp'], array ('next', 'back'))) {
                $tmp = array (
                    'next' => array ('>', 'asc'), 
                    'back' => array ('<', 'desc'));
                
                $comp = $tmp[$this->get['comp']][0];
                $order = $tmp[$this->get['comp']][1];
            } else {
                HTTP::JSON(400);
            }
        }
        
        $result = QueryFactory::query("
            SELECT idnoticia, titulo, resumen, portada, creation
            FROM noticia
            WHERE idnoticia {$comp} :idnoticia
            ORDER BY idnoticia {$order}
            LIMIT {$limit};", array (
                ':idnoticia' => $idnoticia
        ));
        
        $response = Partial::arrayNames($result);
        HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
    }
}

?>