<?php
    //indicar a pasta que a rota vai acessar
    namespace App;
    use MF\init\Bootstrap;

    //classe que fará o acesso as rotas 
    class Route extends Bootstrap {
        
        protected function initRoutes() {
            //indica a ação a ser tomada de acordo com a rota solicitada
            $routes['home'] = array(
                'route' => '/',
                'controller' => 'IndexController',//este é o controller que será acionado
                'action' => 'index'
            );
            $routes['inscreverse'] = array(
                'route' => '/inscreverse',
                'controller' => 'IndexController',//este é o controller que será acionado
                'action' => 'inscreverse'
            );
            $routes['registrar'] = array(
            'route' => '/registrar',
            'controller' => 'IndexController',//este é o controller que será acionado
            'action' => 'registrar'
            );
            $routes['autenticar'] = array(
            'route' => '/autenticar',
            'controller' => 'AuthController',//este é o controller que será acionado
            'action' => 'autenticar'
            );
            $routes['timeline'] = array(
            'route' => '/timeline',
            'controller' => 'AppController',//este é o controller que será acionado
            'action' => 'timeline'
            );
            $routes['sair'] = array(
            'route' => '/sair',
            'controller' => 'AppController',//este é o controller que será acionado
            'action' => 'sair'
            );
            $routes['Tweet'] = array(
            'route' => '/Tweet',
            'controller' => 'AppController',//este é o controller que será acionado
            'action' => 'Tweet'
            );
            $routes['quemSeguir'] = array(
            'route' => '/quemSeguir',
            'controller' => 'AppController',//este é o controller que será acionado
            'action' => 'quemSeguir'
            );
            $routes['acaoUser'] = array(
            'route' => '/acaoUser',
            'controller' => 'AppController',//este é o controller que será acionado
            'action' => 'acaoUser'
            );
            $routes['remover'] = array(
            'route' => '/remover',
            'controller' => 'AppController',//este é o controller que será acionado
            'action' => 'remover'
            );
            $this->setRouters($routes);//aqui passo o parametro que é um array lá para o atributo privado Routers 
        }
    }
?>