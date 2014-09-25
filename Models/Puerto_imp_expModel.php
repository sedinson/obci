<?php

/**
 * Description of Puerto_imp_exp
 *
 * @author Jairo Geovanny Pimentel
 */
class Puerto_imp_expModel extends ModelBase{
    
    public function __construct($table) {
        parent::__construct($table);
    }
    
    public function puerto_imp($puertos){
         $tmp = array();
        
        for($i=0;$i<count($puertos);$i++)
        {
            array_push($tmp, "puerto='{$puertos[$i]}'");
        }
        $str_puertos = join(' OR ',$tmp);
        
        $query = "SELECT puerto AS nombre, ano, importado AS valor FROM puertos_imp_exp WHERE {$str_puertos} ORDER BY ano ASC";
        
        return QueryFactory::query($query);
    }
    
    public function puerto_exp($puertos){
        $tmp = array();
        
        for($i=0;$i<count($puertos);$i++)
        {
            array_push($tmp, "puerto='{$puertos[$i]}'");
        }
        $str_puertos = join(' OR ',$tmp);
        
        $query = "SELECT puerto AS nombre, ano, exportado AS valor FROM puertos_imp_exp WHERE {$str_puertos} ORDER BY ano ASC";
        
        return QueryFactory::query($query);
    }
    
    public function puerto_total($puertos){
        $tmp = array();
        
        for($i=0;$i<count($puertos);$i++)
        {
            array_push($tmp, "puerto='{$puertos[$i]}'");
        }
        $str_puertos = join(' OR ',$tmp);
        
        $query = "SELECT puerto AS nombre, ano, (importado+exportado) AS valor FROM puertos_imp_exp WHERE {$str_puertos} ORDER BY ano ASC";
        
        return QueryFactory::query($query);
    }
}
