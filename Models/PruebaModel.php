<?php

class PruebaModel extends ModelBase{
     public function __construct($table) {
        parent::__construct($table);
     }
     
     function depart($dept){
        $sql = "SELECT departamento,ano,imp_pesos FROM  dept_imp_exp WHERE  departamento = '$dept' ORDER BY ano ASC";
                
        return QueryFactory::query($sql);
    }
}
?>
