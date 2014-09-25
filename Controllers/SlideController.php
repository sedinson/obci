<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SlideController
 *
 * @author edinson
 */
class SlideController extends ControllerBase {
    //put your code here
    function get () {
        $idslide = (!empty($this->get['idslide']))? array (
            ':idslide' => $this->get['idslide']
        ) : array ();
        
        $result = $this->getModel('slide')->select(
            $idslide,
            " ORDER BY idproject ASC;");
        
        $response = Partial::arrayNames($result);
        
        HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
    }
}
