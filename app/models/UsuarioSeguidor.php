<?php
    namespace App\models;
    use MF\model\Model;
    class UsuarioSeguidor extends Model{//sera o responsável por seguir ou deixar de seguir
        private $id_usuario_seguindo;
        private $id_usuario;


        public function __get($atribulto){
            return $this->$atribulto;
        }
        public function __set($atribulto, $valor){
            $this->$atribulto = $valor;
        }
        public function seguirUsuario(){//se a ação for de seguir inserer no banco o id da pessoa e o id de quem ela quer seguir
            
            $query = "
                insert into seguirUsuario (id_usuario, id_usuario_seguindo)values(:id_usuario, :id_usuario_seguindo)
            ";
            $stmt = $this->bD->prepare($query);
            $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
            $stmt->bindValue(':id_usuario_seguindo', $this->__get('id_usuario_seguindo'));
            $stmt->execute();

            return true;
        }
        public function deixarSeguirUsuario(){//se a ação for deixar de seguir ele deleta do banco de dados
            $query = "
                delete from seguirUsuario where id_usuario = :id_usuario and id_usuario_seguindo = :id_usuario_seguindo
            
            ";
            $stmt = $this->bD->prepare($query);
            $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
            $stmt->bindValue(':id_usuario_seguindo', $this->__get('id_usuario_seguindo'));
            $stmt->execute();

            return true;
        }
    }