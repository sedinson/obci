<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Rca_indexModel
 *
 * @author Jairo Geovanny Pimentel
 */
class Rca_indexModel extends ModelBase{
    public function __construct($table) {
        parent::__construct($table);
    }
    
    public function get_rca($pais, $ano){
        $query = "SELECT c.descripcion AS valor1, r.rca AS valor2
        FROM rca_index r, capitulo c
        WHERE ano = {$ano} 
        AND r.product_code = c.idcapitulo
        AND reporter_name = '{$pais}'";
        
        return QueryFactory::query($query);
    }
    
    public function get_lnrca($pais,$ano){
        $query = "SELECT product_code AS valor1, LN(rca) AS valor2
        FROM rca_index
        WHERE ano = {$ano}
        AND reporter_name = '{$pais}'";
        
        return QueryFactory::query($query);
    }
    
    public function get_fob($departamento, $ano, $capitulos){
        $tmp = array ();
        for($i=0; $i<count($capitulos); $i++) {
            array_push($tmp, "capitulo='{$capitulos[$i]}'");
        }
        $str_capitulos = join(' OR ', $tmp);
            
        $query = "SELECT c.descripcion AS nombre, ano, valor "
                . "FROM dept_capitulo d, capitulo c "
                . "WHERE departamento='{$departamento}' "
                . "AND c.idcapitulo = d.capitulo "
                . "AND ano={$ano} AND ($str_capitulos) ORDER BY ano ASC";
        
        return QueryFactory::query($query);
    }
    
    //Falta terminar la consulta, apenas suma por departamento
    public function get_indice($departamento, $ano){
                
        $query = "SELECT tabla.ano, tabla.capitulo AS valor1, ((tabla.valor/total.suma)/(Colombia.suma/SUM(Colombia2.suma))) AS valor2 FROM
        (SELECT SUM(valor) AS suma, ano FROM dept_capitulo WHERE departamento='{$departamento}' AND ano={$ano} GROUP BY ano) AS total,
        (SELECT departamento, ano, valor, capitulo FROM dept_capitulo WHERE departamento='{$departamento}' AND ano={$ano}) AS tabla,
        (SELECT SUM(valor) AS suma, ano, capitulo FROM dept_capitulo WHERE ano={$ano} GROUP BY ano, capitulo) AS Colombia,
        (SELECT SUM(valor) AS suma, ano, capitulo FROM dept_capitulo WHERE ano={$ano} GROUP BY ano, capitulo) AS Colombia2
        WHERE total.ano=tabla.ano AND total.ano=Colombia.ano AND total.ano=Colombia2.ano AND Colombia.capitulo=tabla.capitulo GROUP BY tabla.ano, tabla.capitulo ORDER BY tabla.ano ASC";
        
        return QueryFactory::query($query);
    }
    
    public function get_ln_indice($departamento, $ano){
                
        $query = "SELECT tabla.ano, tabla.capitulo AS valor1, ln((tabla.valor/total.suma)/(Colombia.suma/SUM(Colombia2.suma))) AS valor2 FROM
        (SELECT SUM(valor) AS suma, ano FROM dept_capitulo WHERE departamento='{$departamento}' AND ano={$ano} GROUP BY ano) AS total,
        (SELECT departamento, ano, valor, capitulo FROM dept_capitulo WHERE departamento='{$departamento}' AND ano={$ano}) AS tabla,
        (SELECT SUM(valor) AS suma, ano, capitulo FROM dept_capitulo WHERE ano={$ano} GROUP BY ano, capitulo) AS Colombia,
        (SELECT SUM(valor) AS suma, ano, capitulo FROM dept_capitulo WHERE ano={$ano} GROUP BY ano, capitulo) AS Colombia2
        WHERE total.ano=tabla.ano AND total.ano=Colombia.ano AND total.ano=Colombia2.ano AND Colombia.capitulo=tabla.capitulo GROUP BY tabla.ano, tabla.capitulo ORDER BY tabla.ano ASC";
        
        return QueryFactory::query($query);
    }
}
