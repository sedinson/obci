<?php

class PrController extends ControllerBase{
    
    function aloha22() {
        
        $pais = $this->get['dept'];
        $db_pais = $this->getModel('prueba');
        $result = $db_pais->depart($pais);
        $response = Partial::arrayNames($result);
        HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
    }
    
}

?>
