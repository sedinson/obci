<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CodeController
 *
 * @author edinson
 */
class CodeController extends ControllerBase {
    //put your code here
    private function returnIfNumber($number, $default) {
        if (!empty($number)) {
            if (is_numeric($number)) {
                return $number;
            } else {
                HTTP::JSON(400);
            }
        } else {
            return $default;
        }
    }
    
    public function generate () {
        $_filled = Partial::_filled($this->post, array (
            'iddistribuidor', 'idzona', 'idtipovehiculo', 'firmware', 'codigos'
        ));
        
        $_empty = Partial::_empty($this->post, array ('idcodigo_activacion'));
        
        if($_filled && $_empty) {
            $n = $this->returnIfNumber($this->post['codigos'], 0);
            $codigos = $this->getModel('codigo_activacion');
            $params = Partial::prefix($this->post, ':');
            $time = time();
            $cod = 0;
            
            unset($params[':codigos']);
            $file = $this->config->get('code_base') . 'Code_Generator ' . date('D d M Y H:i:s') . '.csv';
            $str = "{$this->post['firmware']}, {$this->post['idzona']}, {$this->post['idtipovehiculo']}, ";
            
            for($i=0; $i<$n; $i++) {
                $md5 = md5("{$time}-{$i}");
                $params[':codigo'] = strtoupper(substr($md5, 0, 10));
                file_put_contents($file, $str . $params[':codigo'] . PHP_EOL, FILE_APPEND | LOCK_EX);
                
                $result = $codigos->insert($params);
                
                if($result) {
                    $cod++;
                }
            }
            
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), array (
                'ins' => $cod,
                'file' => str_replace($file, $this->config->get('code_base'), '')
            )));
        }
        
        HTTP::JSON(400);
    }
}
