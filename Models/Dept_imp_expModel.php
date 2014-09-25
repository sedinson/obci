<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Dept_imp_expModel extends ModelBase
{
    public function __construct($table) {
        parent::__construct($table);
    }
    
    function obtain_dept_imp($departamentos)
    {
        $tmp = array();
        
        for($i=0;$i<count($departamentos);$i++)
        {
            array_push($tmp, "departamento='{$departamentos[$i]}'");
        }
        $str_depart = join(' OR ',$tmp);
        
        $query = "SELECT departamento AS nombre, ano, imp_pesos AS valor FROM dept_imp_exp WHERE {$str_depart} ORDER BY ano ASC";
        //$query = "SELECT departamento, ano, imp_pesos FROM dept_imp_exp WHERE departamento='{$departamentos}'";
        
        return QueryFactory::query($query);
    }
    
    function obtain_dept_exp($departamentos)
    {
        $tmp = array();
        for($i=0;$i<count($departamentos);$i++)
        {
            array_push($tmp, "departamento='{$departamentos[$i]}'");
        }
        $str_depart = join(' OR ',$tmp);
        
        $query = "SELECT departamento AS nombre, ano, exp_pesos AS valor FROM dept_imp_exp WHERE {$str_depart} ORDER BY ano ASC";
        
        return QueryFactory::query($query);
    }
    
    function obtain_dept_pib($departamentos)
    {
        $tmp = array();
        for($i=0;$i<count($departamentos);$i++)
        {
            array_push($tmp, "departamento='$departamentos[$i]'");
        }
        $str_depart = join(' OR ',$tmp);
        
        $query = "SELECT departamento AS nombre, ano, pib AS valor FROM dept_imp_exp WHERE $str_depart ORDER BY ano ASC";
        
        return QueryFactory::query($query);
    }
    
    function obtain_dept_balanza($departamentos)
    {
        $tmp = array();
        for($i=0;$i<count($departamentos);$i++)
        {
            array_push($tmp, "departamento='$departamentos[$i]'");
        }
        $str_depart = join(' OR ',$tmp);
        
        $query = "SELECT exp.departamento AS nombre, exp.ano, (exp_pesos-imp_pesos) AS valor FROM 
        (SELECT departamento, ano, exp_pesos FROM dept_imp_exp WHERE $str_depart) AS exp,
        (SELECT departamento, ano, imp_pesos FROM dept_imp_exp WHERE $str_depart) AS imp
        WHERE exp.departamento=imp.departamento AND exp.ano=imp.ano ORDER BY exp.ano ASC";
        
        return QueryFactory::query($query);
    }
    function obtain_imp_variacion($departamentos,$ano)
    {
        $max_ano = $ano;
        $min_ano = $ano-1;
        
        $tmp = array ();
        for($i=0; $i<count($departamentos); $i++) {
            array_push($tmp, "i2.departamento='{$departamentos[$i]}'");
        }
        $str_paises = join(' OR ', $tmp);
        
        $sql = "SELECT i2.departamento AS nombre, i2.ano, ((i2.imp_pesos/i1.imp_pesos)-1)*100 AS valor
                FROM
                (SELECT departamento, ano, imp_pesos FROM dept_imp_exp WHERE ano={$min_ano})AS i1, 
                (SELECT departamento, ano, imp_pesos FROM dept_imp_exp WHERE ano={$max_ano}) AS i2
                WHERE i1.departamento = i2.departamento AND ({$str_paises}) ORDER BY i2.ano ASC";
                
        return QueryFactory::query($sql);
    }
    function obtain_exp_variacion($departamentos,$ano)
    {
        $max_ano = $ano;
        $min_ano = $ano-1;
        
        $tmp = array ();
        for($i=0; $i<count($departamentos); $i++) {
            array_push($tmp, "i2.departamento='{$departamentos[$i]}'");
        }
        $str_paises = join(' OR ', $tmp);
        
        $sql = "SELECT i2.departamento AS nombre, i2.ano, ((i2.exp_pesos/i1.exp_pesos)-1)*100 AS valor
                FROM 
                (SELECT departamento, ano, exp_pesos FROM dept_imp_exp WHERE ano={$min_ano}) AS i1, 
                (SELECT departamento, ano, exp_pesos FROM dept_imp_exp WHERE ano={$max_ano}) AS i2
                WHERE i1.departamento = i2.departamento AND ({$str_paises}) ORDER BY i2.ano ASC";
                
        return QueryFactory::query($sql);        
    }
    
    function obtain_imp_pib($departamentos)
    {
        $tmp = array();
        for($i=0;$i<count($departamentos);$i++)
        {
            array_push($tmp, "departamento='$departamentos[$i]'");
        }
        $str_dept = join(' OR ',$tmp);
        
        $query = "SELECT imp.departamento AS nombre, imp.ano, (imp_pesos/pib)*100 AS valor FROM 
        (SELECT departamento, ano, pib FROM dept_imp_exp WHERE {$str_dept}) AS pib,
        (SELECT departamento, ano, imp_pesos FROM dept_imp_exp WHERE {$str_dept}) AS imp
        WHERE pib.departamento=imp.departamento AND pib.ano=imp.ano ORDER BY imp.ano ASC";
        
        return QueryFactory::query($query);
    }
    
    function obtain_exp_pib($departamentos)
    {
        $tmp = array();
        for($i=0;$i<count($departamentos);$i++)
        {
            array_push($tmp, "departamento='$departamentos[$i]'");
        }
        $str_dept = join(' OR ',$tmp);

        $query = "SELECT exp.departamento AS nombre, exp.ano, (exp_pesos/pib)*100 AS valor FROM 
        (SELECT departamento, ano, pib FROM dept_imp_exp WHERE $str_dept) AS pib,
        (SELECT departamento, ano, exp_pesos FROM dept_imp_exp WHERE $str_dept) AS exp
        WHERE pib.departamento=exp.departamento AND pib.ano=exp.ano ORDER BY exp.ano ASC";

        return QueryFactory::query($query);
    }
    
    function obtain_coef_apertura($departamentos)
    {
        $tmp = array();
        for($i=0;$i<count($departamentos);$i++)
        {
            array_push($tmp, "departamento='$departamentos[$i]'");
        }
        $str_dept = join(' OR ',$tmp);
        
        $query = "SELECT imp.departamento AS nombre, imp.ano, ((imp_pesos+exp_pesos)/pib)*100 AS valor FROM 
        (SELECT departamento, ano, pib FROM dept_imp_exp WHERE {$str_dept}) AS pib,
        (SELECT departamento, ano, imp_pesos FROM dept_imp_exp WHERE {$str_dept}) AS imp,
        (SELECT departamento, ano, exp_pesos FROM dept_imp_exp WHERE {$str_dept}) AS exp
        WHERE pib.departamento=imp.departamento AND imp.departamento=exp.departamento AND pib.ano=imp.ano AND exp.ano=imp.ano ORDER BY imp.ano ASC";
        
        return QueryFactory::query($query);
    }
    
    function obtain_imp_dolares($departamentos)
    {
        $tmp = array();
        for($i=0;$i<count($departamentos);$i++)
        {
            array_push($tmp, "departamento='$departamentos[$i]'");
        }
        $str_dept = join(' OR ',$tmp);
        
        $query = "SELECT departamento AS nombre, ano, imp_dolar AS valor FROM dept_imp_exp WHERE {$str_dept} ORDER BY ano ASC";
        
        return QueryFactory::query($query);
    }
    
    function obtain_exp_dolares($departamentos)
    {
        $tmp = array();
        for($i=0;$i<count($departamentos);$i++)
        {
            array_push($tmp, "departamento='$departamentos[$i]'");
        }
        $str_dept = join(' OR ',$tmp);
        
        $query = "SELECT departamento AS nombre, ano, exp_dolar AS valor FROM dept_imp_exp WHERE {$str_dept} ORDER BY ano ASC";
        
        return QueryFactory::query($query);
    }
    
    function obtain_var_imp_us($departamentos,$ano){
        $max_ano = $ano;
        $min_ano = $ano-1;
        
        $tmp = array ();
        for($i=0; $i<count($departamentos); $i++) {
            array_push($tmp, "i2.departamento='{$departamentos[$i]}'");
        }
        $str_departamentos = join(' OR ', $tmp);
        
        $sql = "SELECT i2.departamento AS nombre, i2.ano, ((i2.imp_dolar/i1.imp_dolar)-1)*100 AS valor
                FROM 
                (SELECT departamento, ano, imp_dolar FROM dept_imp_exp WHERE ano={$min_ano}) AS i1, 
                (SELECT departamento, ano, imp_dolar FROM dept_imp_exp WHERE ano={$max_ano}) AS i2
                WHERE i1.departamento = i2.departamento AND ({$str_departamentos}) ORDER BY i2.ano ASC";
                
        return QueryFactory::query($sql);  
    }
    
    function obtain_var_exp_us($departamentos,$ano){
        $max_ano = $ano;
        $min_ano = $ano-1;
        
        $tmp = array ();
        for($i=0; $i<count($departamentos); $i++) {
            array_push($tmp, "i2.departamento='{$departamentos[$i]}'");
        }
        $str_departamentos = join(' OR ', $tmp);
        
        $sql = "SELECT i2.departamento AS nombre, i2.ano, ((i2.exp_dolar/i1.exp_dolar)-1)*100 AS valor
                FROM 
                (SELECT departamento, ano, exp_dolar FROM dept_imp_exp WHERE ano={$min_ano}) AS i1, 
                (SELECT departamento, ano, exp_dolar FROM dept_imp_exp WHERE ano={$max_ano}) AS i2
                WHERE i1.departamento = i2.departamento AND ({$str_departamentos}) ORDER BY i2.ano ASC";
                
        return QueryFactory::query($sql);
    }
 
}