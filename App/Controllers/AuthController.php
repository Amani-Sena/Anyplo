<?php

namespace app\controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class AuthController extends Action {
    public function autenticar() {
        $usuario = Container::getModel('Usuario');
        $usuario->__set('login', $_POST['login']);
        $usuario->__set('senha', $_POST['senha']);
        $usuario->autenticar();
 

        if($usuario->__get('id') != '' && $usuario->__get('nome') != '') {
            session_start();
            $_SESSION['id'] = $usuario->__get('id');
            $_SESSION['nome'] = $usuario->__get('nome');
            $_SESSION['email'] = $usuario->__get('email');
            $_SESSION['icone'] = $usuario->__get('icone');
            $_SESSION['bg'] = $usuario->__get('back');
            $_SESSION['tipo'] = $usuario->__get('tipo');
            $_SESSION['class'] = $usuario->__get('class');

            header('Location: /');
        } else {
            header('Location: /login?login=erro');
        }
    
           
        
    }

    public function sair() {
        session_start();
        session_destroy();
        header('Location: /');
    }
}
?>
