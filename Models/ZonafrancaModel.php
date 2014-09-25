<?php

/**
 * Description of ZonafrancaModel
 *
 * @author Jairo Geovanny Pimentel
 */
class ZonafrancaModel extends ModelBase{
        public function __construct($table) {
        parent::__construct($table);
    }
    
    public function zf_imp($zf){
         $tmp = array();
        
        for($i=0;$i<count($zf);$i++)
        {
            array_push($tmp, "zona_franca='{$zf[$i]}'");
        }
        $str_zf = join(' OR ',$tmp);
        
        $query = "SELECT zona_franca AS nombre, ano, importado AS valor FROM zf_imp_exp WHERE {$str_zf} ORDER BY ano ASC";
        
        return QueryFactory::query($query);
    }
    
    public function zf_exp($zf){
        $tmp = array();
        
        for($i=0;$i<count($zf);$i++)
        {
            array_push($tmp, "zona_franca='{$zf[$i]}'");
        }
        $str_zf = join(' OR ',$tmp);
        
        $query = "SELECT zona_franca AS nombre, ano, exportado AS valor FROM zf_imp_exp WHERE {$str_zf} ORDER BY ano ASC";
        
        return QueryFactory::query($query);
    }
    
     public function zf_dest_exp($zf){
         $tmp = array();
        
        for($i=0;$i<count($zf);$i++)
        {
            array_push($tmp, "pais='{$zf[$i]}'");
        }
        $str_zf = join(' OR ',$tmp);
        
        $query = "SELECT pais AS nombre, ano, exportado AS valor FROM zf_od_imp_exp WHERE {$str_zf} ORDER BY ano ASC";
        
        return QueryFactory::query($query);
    }
    
    public function zf_ori_imp($zf){
         $tmp = array();
        
        for($i=0;$i<count($zf);$i++)
        {
            array_push($tmp, "pais='{$zf[$i]}'");
        }
        $str_zf = join(' OR ',$tmp);
        
        $query = "SELECT pais AS nombre, ano, importado AS valor FROM zf_od_imp_exp WHERE {$str_zf} ORDER BY ano ASC";
        
        return QueryFactory::query($query);
    }
    
    public function zf_imp_var($zf,$ano){
        $max_ano = $ano;
        $min_ano = $ano-1;
        
        $tmp = array();
        
        for($i=0;$i<count($zf);$i++)
        {
            array_push($tmp, "i2.pais='{$zf[$i]}'");
        }
        $str_zf = join(' OR ',$tmp);
        
        $query = "SELECT i2.pais AS nombre, i2.ano, ((i2.importado/i1.importado)-1)*100 AS valor
                FROM
                (SELECT pais, ano, importado FROM zf_od_imp_exp WHERE ano={$min_ano})AS i1, 
                (SELECT pais, ano, importado FROM zf_od_imp_exp WHERE ano={$max_ano}) AS i2
                WHERE i1.pais = i2.pais AND ({$str_zf}) ORDER BY i2.ano ASC";
                
        return QueryFactory::query($query);
    }
    
    public function zf_exp_var($zf,$ano){
        $max_ano = $ano;
        $min_ano = $ano-1;
        
        $tmp = array();
        
        for($i=0;$i<count($zf);$i++)
        {
            array_push($tmp, "i2.pais='{$zf[$i]}'");
        }
        $str_zf = join(' OR ',$tmp);
        
        $query = "SELECT i2.pais AS nombre, i2.ano, ((i2.exportado/i1.exportado)-1)*100 AS valor
                FROM
                (SELECT pais, ano, exportado FROM zf_od_imp_exp WHERE ano={$min_ano})AS i1, 
                (SELECT pais, ano, exportado FROM zf_od_imp_exp WHERE ano={$max_ano}) AS i2
                WHERE i1.pais = i2.pais AND ({$str_zf}) ORDER BY i2.ano ASC";
                
        return QueryFactory::query($query);
    }
    
    public function zf_imp_par($zf){
        $tmp = array();
        
        for($i=0;$i<count($zf);$i++)
        {
            array_push($tmp, "pais='{$zf[$i]}'");
        }
        $str_zf = join(' OR ',$tmp);
        
        $query = "SELECT tabla2.pais, tabla1.ano, (importado/suma)*100 AS valor FROM
        (SELECT SUM(importado) AS suma, ano FROM zf_od_imp_exp GROUP BY ano) AS tabla1,
        (SELECT pais, importado, ano FROM zf_od_imp_exp WHERE {$str_zf} ORDER BY ano, pais) AS tabla2
        WHERE tabla1.ano=tabla2.ano ORDER BY tabla1.ano ASC";
        
        return QueryFactory::query($query);
    }
    
    public function zf_imp_par_cir($ano){
        $query = "SELECT tabla2.pais AS nombre, tabla1.ano, (importado/suma)*100 AS valor FROM
        (SELECT SUM(importado) AS suma, ano FROM zf_od_imp_exp WHERE ano={$ano}) AS tabla1,
        (SELECT pais, importado, ano FROM zf_od_imp_exp WHERE ano={$ano}) AS tabla2
        WHERE tabla1.ano=tabla2.ano AND ((importado/suma)*100)>=1 ORDER BY tabla1.ano ASC";
        
        return QueryFactory::query($query);
    }
    
    public function zf_exp_par($zf){
        $tmp = array();
        
        for($i=0;$i<count($zf);$i++)
        {
            array_push($tmp, "pais='{$zf[$i]}'");
        }
        $str_zf = join(' OR ',$tmp);
        
        $query = "SELECT tabla2.pais, tabla1.ano, (exportado/suma)*100 AS valor FROM
        (SELECT SUM(exportado) AS suma, ano FROM zf_od_imp_exp GROUP BY ano) AS tabla1,
        (SELECT pais, exportado, ano FROM zf_od_imp_exp WHERE {$str_zf} ORDER BY ano, pais) AS tabla2
        WHERE tabla1.ano=tabla2.ano ORDER BY tabla1.ano ASC";
        
        return QueryFactory::query($query);
    }
    
    public function zf_exp_par_cir($ano){
        $query = "SELECT tabla2.pais AS nombre, tabla1.ano, (exportado/suma)*100 AS valor FROM
        (SELECT SUM(exportado) AS suma, ano FROM zf_od_imp_exp WHERE ano={$ano}) AS tabla1,
        (SELECT pais, exportado, ano FROM zf_od_imp_exp WHERE ano={$ano}) AS tabla2
        WHERE tabla1.ano=tabla2.ano AND ((exportado/suma)*100)>=1 ORDER BY tabla1.ano ASC";
        
        return QueryFactory::query($query);
    }
}

