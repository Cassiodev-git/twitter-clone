<?php
    namespace MF\init;

    abstract class Bootstrap {


         // Esta classe só pode ser herdada

        private $routers; // Este será o atributo que vai receber o array

        abstract protected function initRoutes(); // Método abstrato que será implementado pelas subclasses

        public function __construct() { // O construtor vai chamar os métodos quando uma classe for instanciada
            $this->initRoutes();  // Inicializa as rotas
            $this->run($this->getUrl());  // Chama o método run passando a URL capturada
        }

        public function getRouters() { // Aqui pego o atributo privado routers
            return $this->routers;
        }

        public function setRouters(array $routers) { // Seta os atributos recebidos ao atributo privado acima
            $this->routers = $routers;
        }

        // Método responsável por executar a lógica de roteamento
        protected function run($url) {
            foreach ($this->getRouters() as $path => $route) { // Para cada path no objeto, recupera um valor
                if ($url == $route['route']) { // Se a URL capturada for igual a rota de route
                    $class = "App\\Controllers\\" . ucfirst($route['controller']); // Instancia o controller correspondente
                    $controller = new $class; // Uma instância de App\Controllers\IndexController

                    $action = $route['action']; // Pega a action que o foreach coletou lá do array
                    $controller->$action(); // Chama o método correspondente da action
                }
            }
        }
        // Método responsável por capturar a rota que o cliente solicitou
        protected function getUrl() {
            return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        }
    }


?>