<?php
    namespace App\Controllers;// aqui é onde indico para o composer onde a classe está.

    use MF\Controller\Action;
    use MF\model\Comteiner;

    class IndexController extends Action {
        public function index(){
            $this->view->login = isset($_GET['login']) ? $_GET['login'] : '';
            $this->render('index');

        }
        public function inscreverse(){
            $this->view->usuario = array(//limpa os valores dos campos
                'nome' => '',
                'email' => '',
                'senha' => '',
            );
            $this->view->errorCadastro = false;//indica para a view que o estado original é sem o alerta de erro
            $this->render('inscreverse');//redireciona para a pagina inscreverse 
        }
        public function registrar(){
            $userTwitter =  Comteiner::getModelo('Usuario');//seleciona o modelo a ser associado
            $userTwitter->__set('nome', $_POST['nome']);
            $userTwitter->__set('email', $_POST['email']);
            $userTwitter->__set('senha', $_POST['senha']);

            if($userTwitter->validarUsuario() && count($userTwitter->getUsuarioEmail()) == 0 ){//chama o metodo para validação la de usuario.php, e pega o usuario la do banco de dados 
                $userTwitter->salvarUser();//se todas os requesitos forem atendidos ai sim salva no banco de dados
                $this->render('cadastro');//redireciona o usuario para a pagina de cadastro  de acordo com o controller
                
            }else{
                $this->view->usuario = array(//este array é responsavel por manter os dados nos inputs em caso de erro
                    'nome' => $_POST['nome'],
                    'email' => $_POST['email'],
                );
                $this->view->errorCadastro = true;//retorna paa a view um estado para que ela identifique e mostre um erro
                $this->render('inscreverse');//força a renderização para a pagina inscreverse novamente 
            }
            
        }
    }
?>