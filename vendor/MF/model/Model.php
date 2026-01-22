<?php
    namespace MF\model;
    //aqui eu abstraio um comportamento repetitivo que identifiquei na info e produtos na pasta models 
    abstract class Model{
        protected $bD;
        public function __construct(\PDO $bD){//cria uma istancia de pdo
            $this->bD = $bD;
        }

    }


?>