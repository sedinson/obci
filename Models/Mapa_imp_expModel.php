<?php

class Mapa_imp_expModel extends ModelBase{
     public function __construct($table) {
        parent::__construct($table);
    }
    
    public function obtener_puerto($puerto){
        $query = "SELECT ano, importado, exportado FROM puertos_imp_exp WHERE puerto='{$puerto}' ORDER BY ano ASC";
        
        return QueryFactory::query($query);
    }
    
    public function obtener_zf($zf){
        $query = "SELECT ano, importado, exportado FROM zf_imp_exp WHERE zona_franca='{$zf}' ORDER BY ano ASC";
        
        return QueryFactory::query($query);
    }
    
    public function obtener_impoexpo($pais){
        $query = "SELECT ano, importado, exportado FROM pais_imp_exp WHERE nombre='{$pais}' ORDER BY ano ASC";
        
        return QueryFactory::query($query);
    }
}

?>