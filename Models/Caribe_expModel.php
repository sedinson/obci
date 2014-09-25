<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Caribe_exp_impModel
 *
 * @author Geovanny
 */
class Caribe_expModel extends ModelBase {
    public function __construct($table) {
        parent::__construct($table);
    }
    
    public function fob($departamento, $pais, $año){
        $query = "SELECT descripcion AS nombre, ano, exportado AS valor FROM caribe_exp, capitulo WHERE departamento='{$departamento}' AND pais='{$pais}' AND ano={$año} AND caribe_exp.capitulo=capitulo.idcapitulo ORDER BY ano ASC";
        
        return QueryFactory::query($query);
    }
    
    public function fobUS($departamento, $ano, $paises){
        $tmp = array ();
        for($i=0; $i<count($paises); $i++) {
            array_push($tmp, "pais='{$paises[$i]}'");
        }
        $str_paises = join(' OR ', $tmp);
        
        $query = "SELECT pais AS nombre, ano, SUM(exportado) AS valor FROM caribe_exp WHERE departamento='$departamento' AND ano=$ano AND ({$str_paises}) GROUP BY departamento, ano, pais ORDER BY departamento, ano, valor DESC";
        
        return QueryFactory::query($query);
    }
    
    public function part_fobUS($departamento, $ano, $paises){
        $tmp = array ();
        for($i=0; $i<count($paises); $i++) {
            array_push($tmp, "pais='{$paises[$i]}'");
        }
        $str_paises = join(' OR ', $tmp);
        
        $query = "SELECT departamento, ano, pais, (valor/total.total)*100 AS valor FROM 
        (SELECT departamento, ano, pais, SUM(exportado) AS valor FROM caribe_exp WHERE departamento='$departamento' AND ano=$ano GROUP BY pais ORDER BY valor DESC) AS paises,
        (SELECT SUM(valor) AS total FROM (SELECT departamento, ano, pais, SUM(exportado) AS valor FROM caribe_exp WHERE departamento='$departamento' AND ano=$ano GROUP BY pais ORDER BY valor DESC) AS dept) AS total
        WHERE $str_paises ORDER BY valor DESC";
        
        return QueryFactory::query($query);
    }
}
