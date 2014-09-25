<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of pais_imp_exp
 *
 * @author edinson
 */
class Pais_imp_expModel extends ModelBase {
    //put your code here
    public function __construct($table) {
        parent::__construct($table);
    }
    
    function obtain ($ano, $paises) {
        $max_ano = $ano;
        $min_ano = $ano-1;
        
        $tmp = array ();
        for($i=0; $i<count($paises); $i++) {
            array_push($tmp, "i2.nombre='{$paises[$i]}'");
        }
        $str_paises = join(' OR ', $tmp);
        
        $sql = "SELECT i2.nombre, i2.ano, i2.importado / i1.importado -1 AS var_imp, i2.exportado / i1.exportado -1 AS var_exp, i2.importado, i2.exportado
                FROM (
                SELECT nombre, ano, importado, exportado
                FROM pais_imp_exp
                WHERE ano ={$min_ano}
                ) AS i1, (
                SELECT nombre, ano, importado, exportado
                FROM pais_imp_exp
                WHERE ano ={$max_ano}
                ) AS i2
                WHERE i1.nombre = i2.nombre AND ({$str_paises}) ORDER BY i2.ano ASC";
                
        return QueryFactory::query($sql);
    }

    function obtain_imp($paises) {
        $tmp = array ();
        for($i=0; $i<count($paises); $i++) {
            array_push($tmp, "nombre='{$paises[$i]}'");
        }
        $str_paises = join(' OR ', $tmp);
        
         $sql = "SELECT nombre, ano, importado AS valor FROM pais_imp_exp WHERE {$str_paises} ORDER BY ano ASC";
                
        return QueryFactory::query($sql);
    }
    
    function obtain_exp($paises) {
        $tmp = array ();
        for($i=0; $i<count($paises); $i++) {
            array_push($tmp, "nombre='{$paises[$i]}'");
        }
        $str_paises = join(' OR ', $tmp);
        
         $sql = "SELECT nombre, ano, exportado AS valor FROM pais_imp_exp WHERE {$str_paises} ORDER BY ano ASC";
                
        return QueryFactory::query($sql);
    }
    
    function obtain_var_exp($paises,$ano)
    {
        $max_ano = $ano;
        $min_ano = $ano-1;
        
        $tmp = array ();
        for($i=0; $i<count($paises); $i++) {
            array_push($tmp, "i2.nombre='{$paises[$i]}'");
        }
        $str_paises = join(' OR ', $tmp);
        
        $query = "SELECT i2.nombre, i2.ano, ((i2.exportado/i1.exportado)-1) AS valor
                FROM 
                (SELECT nombre, ano, exportado FROM pais_imp_exp WHERE ano={$min_ano}) AS i1, 
                (SELECT nombre, ano, exportado FROM pais_imp_exp WHERE ano={$max_ano}) AS i2
                WHERE i1.nombre = i2.nombre AND ({$str_paises}) ORDER BY i2.ano ASC";
                
         return QueryFactory::query($query);
    }
    
        function obtain_var_imp($paises,$ano)
    {
        $max_ano = $ano;
        $min_ano = $ano-1;
        
        $tmp = array ();
        for($i=0; $i<count($paises); $i++) {
            array_push($tmp, "i2.nombre='{$paises[$i]}'");
        }
        $str_paises = join(' OR ', $tmp);
        
        $query = "SELECT i2.nombre, i2.ano, ((i2.importado/i1.importado)-1) AS valor
                FROM 
                (SELECT nombre, ano, importado FROM pais_imp_exp WHERE ano={$min_ano}) AS i1, 
                (SELECT nombre, ano, importado FROM pais_imp_exp WHERE ano={$max_ano}) AS i2
                WHERE i1.nombre = i2.nombre AND ({$str_paises}) ORDER BY i2.ano ASC";
                
        return QueryFactory::query($query);
    }
    
    function obtain_part_imp($paises) {
        $tmp = array ();
        for($i=0; $i<count($paises); $i++) {
            array_push($tmp, "nombre='{$paises[$i]}'");
        }
        $str_paises = join(' OR ', $tmp);
        
        $sql = "SELECT tabla2.nombre, tabla1.ano, (importado/suma)*100 AS valor FROM
        (SELECT SUM(importado) AS suma, ano FROM pais_imp_exp GROUP BY ano) AS tabla1,
        (SELECT nombre, importado, ano FROM pais_imp_exp WHERE {$str_paises} ORDER BY ano, nombre) AS tabla2
        WHERE tabla1.ano=tabla2.ano ORDER BY tabla1.ano ASC";
                
        return QueryFactory::query($sql);
    }
    
    function obtain_part_exp($paises) {
        $tmp = array ();
        for($i=0; $i<count($paises); $i++) {
            array_push($tmp, "nombre='{$paises[$i]}'");
        }
        $str_paises = join(' OR ', $tmp);
        
        $sql = "SELECT tabla2.nombre, tabla1.ano, (exportado/suma)*100 AS valor FROM
        (SELECT SUM(exportado) AS suma, ano FROM pais_imp_exp GROUP BY ano) AS tabla1,
        (SELECT nombre, exportado, ano FROM pais_imp_exp WHERE {$str_paises} ORDER BY ano, nombre) AS tabla2
        WHERE tabla1.ano=tabla2.ano ORDER BY tabla1.ano ASC";
                
        return QueryFactory::query($sql);
    }
    
    function obtain_part_imp_cir($ano) {
        $query = "SELECT tabla2.nombre, tabla1.ano, (importado/suma)*100 AS valor FROM
        (SELECT SUM(importado) AS suma, ano FROM pais_imp_exp WHERE ano={$ano}) AS tabla1,
        (SELECT nombre, importado, ano FROM pais_imp_exp WHERE ano={$ano}) AS tabla2
        WHERE tabla1.ano=tabla2.ano AND ((importado/suma)*100)>=1 ORDER BY tabla1.ano ASC";
        
        return QueryFactory::query($query);
    }
    
    function obtain_part_exp_cir($ano) {
        $query = "SELECT tabla2.nombre, tabla1.ano, (exportado/suma)*100 AS valor FROM
        (SELECT SUM(exportado) AS suma, ano FROM pais_imp_exp WHERE ano={$ano}) AS tabla1,
        (SELECT nombre, exportado, ano FROM pais_imp_exp WHERE ano={$ano}) AS tabla2
        WHERE tabla1.ano=tabla2.ano AND ((exportado/suma)*100)>=1 ORDER BY tabla1.ano ASC";
        
        return QueryFactory::query($query);
    }
    
}
