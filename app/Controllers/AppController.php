<?php
    namespace App\Controllers;// aqui é onde indico para o composer onde a classe está.

    use MF\Controller\Action;
    use MF\model\Comteiner;

    class AppController extends Action {


        public function loginValido(){
            session_start();
            if(!isset($_SESSION['id'])){
                header('Location: /?login=erro');
            }
        }

        public function timeline(){//responsável por renderizar a timeline
            $this->loginValido();
            $tweets = Comteiner::getModelo('Tweet');
            $tweets->__set('id_usuario', $_SESSION['id']);
            $arrayTweet = $tweets->getTodosTweets();
            $this->view->tweet = $arrayTweet;
            $usuario = Comteiner::getModelo('Usuario');
            $usuario->__set('id', $_SESSION['id']);
            $this->view->info_user = $usuario->getNomeUsuario();
            $this->view->total_tweets = $usuario->getTotalTweets();
            $this->view->total_seguindo = $usuario->getTotalSeguindo();
            $this->view->total_seguidores = $usuario->getTotalSeguidores();

            $this->render('timeline');
        
        }
        public function sair(){// ao clicar um botao que esteja com essa rota ele vai redireciona para a index

            session_start();
            session_destroy();
            header('Location: /');
            exit;

        }
        public function Tweet(){//envia os dados dos twittes para o banco
            $this->loginValido();
            $tweet = Comteiner::getModelo('Tweet');
            $tweet->__set('tweet', $_POST['tweet']);
            $tweet->__set('id_usuario', $_SESSION['id']);
            $tweet->salvarTweet();
            header('Location: /timeline');
        }
        public function quemSeguir(){//renderiza as pesquisas de usuarios
            $this->loginValido();
            $pesquisaPor = isset($_GET['pesquisarPor']) ? $_GET['pesquisarPor'] : '';//se o parametro estiver setado e for diferente de ''

            if($pesquisaPor != ''){
                $usuarios = Comteiner::getModelo('Usuario');
                $usuarios->__set('nome', $_GET['pesquisarPor']);
                $usuarios->__set('id', $_SESSION['id']);
                $resultadoPesquisa = $usuarios->pesquisarPorNome();
                $this->view->usuario = $resultadoPesquisa;
                
            };
            $this->render('quemSeguir');
        }
        public function acaoUser(){//responsavel pela ação de seguir e deixar de seguir
            $this->loginValido();
            if($acaoUser = isset($_GET['acao']) ? $_GET['acao'] : ''){//verificar e centraliza a ação que é recebida via get
                $id_usuario = $_GET['id_usuario'];
                $usuario = Comteiner::getModelo('UsuarioSeguidor');
                $usuario->__set('id_usuario_seguindo', $id_usuario);
                $usuario->__set('id_usuario', $_SESSION['id']);
                if($acaoUser == 'seguir'){
                    $usuario->seguirUsuario();
                }else if ($acaoUser == 'deixar_seguir'){
                    $usuario->deixarSeguirUsuario();
                }
            }
                header('Location: /quemSeguir');
        }
        public function remover(){//remove o twitter com base no id da sessao e dos proprios tweets
            $this->loginValido();
            if(isset($_POST['id_tweet'])){
                $id_tweet = $_POST['id_tweet'];
                $tw_usuario = Comteiner::getModelo('Tweet');
                $tw_usuario->__set('id', $id_tweet);
                $tw_usuario->__set('id_usuario', $_SESSION['id']);
                $tw_usuario->removerTweet();
                header('Location: /timeline');
            }
            

        }

    }