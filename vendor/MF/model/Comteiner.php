<?php
    namespace MF\model;
    use App\Connection;

    abstract class Comteiner {

        public static function getModelo($model){
            $class = "\\App\\models\\".ucfirst($model);//isto é so a rota do model
            $conec = Connection::getDb();//e isto é a instancia do objeto pfdo

            return new $class($conec);//aqui é feito o retorno do model junto a instancia de pdo
        }
    }



?>