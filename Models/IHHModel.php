<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of IHHModel
 *
 * @author edinson
 */
class IHHModel extends ModelBase {
    //put your code here
    public function get ($departamentos) {
        $tmp = array();
        
        for($i=0; $i<count($departamentos); $i++) {
            array_push($tmp, "departamento='{$departamentos[$i]}'");
        }
        $str_depart = join(' OR ',$tmp);
        
        $query = "SELECT departamento AS nombre, ano, valor FROM ihh WHERE ({$str_depart}) AND valor > 0 ORDER BY ano ASC";
        
        return QueryFactory::query($query);
    }
}
