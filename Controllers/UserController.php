<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserController
 *
 * @author edinson
 */
class UserController extends ControllerBase {

    function login() {
        if(!isset($_SESSION['id'])) {
            $usuario = $this->getModel('usuario');
        
            $usuario->insert(array (
                ':address' => $_SERVER['REMOTE_ADDR']
            ));
            
            if($usuario->lastID() > 0) {
                $_SESSION['id'] = $usuario->lastID();
                
                HTTP::JSON(Partial::createResponse(HTTP::Value(200), array (
                    'id' => $_SESSION['id'],
                    'new' => true
                )));
            } else {
                HTTP::JSON(500);
            }
        } else {
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), array (
                'id' => $_SESSION['id'],
                'new' => false
            )));
        }
    }
    
    function admin () {
    	$filled = Partial::_filled($this->post, array ('user', 'pass'));
    	
    	if($filled) {
    		$usuario = $this->getModel('admin')->select(array (
    			':usuario' => $this->post['user'],
    			':pass' => md5($this->post['pass'])
    		));
    		
    		if(count($usuario) == 1) {
    			$_SESSION['nombre'] = $usuario[0]['nombre'];
    			$_SESSION['admin'] = $usuario[0]['usuario'];
                        $_SESSION['idadmin'] = $usuario[0]['idadmin'];
    			
    			$response = Partial::arrayNames($usuario, array ('pass', 'idadmin'));
        		HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response[0]));
    		}
    		
    		HTTP::JSON(401);
    	}
    	
    	HTTP::JSON(400);
    }
    
    function change () {
        if(isset($_SESSION['idadmin'])) {
            $_filled = Partial::_filled($this->post, array (
                'pass', 'new'
            ));
            
            if($_filled) {
                if($this->post['pass'] == $this->post['new']) {
                    $this->getModel('admin')->update($_SESSION['idadmin'], array (
                        ':pass' => md5($this->post['pass'])
                    ));
                    
                    HTTP::JSON(200);
                }
                
                HTTP::JSON(424);
            }
            
            HTTP::JSON(400);
        }
        
        HTTP::JSON(401);
    }
    
    function add () {
        if($_SESSION['admin'] == 'admin') {
            $_filled = Partial::_filled($this->post, array (
                'nombre', 'usuario', 'pass', 'new'
            ));
            
            $_empty = Partial::_empty($this->post, array ('idadmin'));
            
            if($_filled && $_empty) {
                if($this->post['pass'] == $this->post['new']) {
                    $params = Partial::prefix($this->post, ':');
                    
                    $params[':pass'] = md5($this->post['pass']);
                    unset($params[':new']);
                    
                    $this->getModel('admin')->insert($params);
                    
                    HTTP::JSON(200);
                }
                
                HTTP::JSON(424);
            }
            
            HTTP::JSON(400);
        }
        
        HTTP::JSON(401);
    }

    function logout() {
        session_destroy();

        HTTP::JSON(200);
    }
}

?>
