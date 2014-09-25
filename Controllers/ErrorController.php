<?php

class ErrorController extends ControllerBase {

    public function index() {
        HTTP::JSON(Partial::createResponse(HTTP::Value(404), "Vaya, al parecer esto ya no existe. Asegurate de haberlo escrito bien."));
    }

}

?>
