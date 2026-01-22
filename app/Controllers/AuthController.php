<?php
    namespace App\Controllers;// aqui é onde indico para o composer onde a classe está.

    use MF\Controller\Action;
    use MF\model\Comteiner;

    class AuthController extends Action {

        public function autenticar(){
            $usuario = Comteiner::getModelo('Usuario');
            $usuario->__set('email', $_POST['email']);
            $usuario->__set('senha', $_POST['senha']);

            $retono = $usuario->autenticar();
            if($usuario->__get('id') != '' && $usuario->__get('nome') != ''){
                session_start();
                $_SESSION['id'] = $usuario->__get('id');
                $_SESSION['nome'] = $usuario->__get('nome');
                header('Location: /timeline');
                exit;
                
                
            }else{
                
                header('Location: /?login=erro');
            }

        }

    }


?>