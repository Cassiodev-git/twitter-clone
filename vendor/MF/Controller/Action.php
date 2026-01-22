<?php
    namespace MF\Controller;

use Exception;

    abstract class Action{
        protected $view;//isto se transforma em um objeto por causa da classe nativa do php

        public function __construct(){
            $this->view = new \stdClass();//aqui uso uma classe nativa do php que transforma a view em um obj manipulavel
        }
        protected function render($view, $layout = 'Layout'){
            $this->view->page = $view;// crio um novo atributo ao objeto view, elevando o escopo do parametro
            try{
                if(file_exists("../app/views/".$layout.".phtml")){//verifica a existencia do arquivo requirido no file_exist
                    require_once "../app/views/".$layout.".phtml";
                }else{
                    throw new \Exception('Layout não encontrado');
                }


            }catch(\Exception $error){
                echo 'Sinto muito:'.$error->getMessage().'.';
            }
            
        }

        protected function content(){
            $className =  get_class($this);//capturo a rota da minha classe
            $className =  str_replace('App\\Controllers\\', '', $className);//limpo app\controllers\ 
            $className = strtolower(str_replace('Controller', '', $className));//Limpo o nome controller ja que é uma constante da pasta Controllers

            require_once "../app/views/".$className."/".$this->view->page.".phtml";

        }
    }


?>