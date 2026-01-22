<?php
    namespace App\models; // aqui é onde indico para o composer onde a classe está.

    use MF\model\Model;
    class Tweet extends Model {
        private $id;
        private $id_usuario;
        private $tweet;
        private $data_tweet;

        public function __get($atributo){
            return $this->$atributo;

        }
        public function __set($atributo, $valor){
            $this->$atributo = $valor;
        }

        //salvar 
        public function salvarTweet(){//salva os tweets de  acordo com o usuario em questao
            $query = "
                insert into tweets(id_usuario, tweet)values(:id_usuario, :tweet)
            ";
            $stmt = $this->bD->prepare($query);
            $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
            $stmt->bindValue(':tweet', $this->__get('tweet'));
            $stmt->execute();
            
            return $this;

        }

        //recuperar
        public function getTodosTweets(){//recupera os tweets, como também quem os faz 
            $query = "
                select
                t.id, t.id_usuario, u.nome, t.tweet, date_format(t.data_tweet, '%d/%m/%y %H:%i') as data
                from tweets as t 
                left join usuarios as u on(t.id_usuario = u.id)
                where 
                t.id_usuario = :id_usuario
                or t.id_usuario in (SELECT id_usuario_seguindo from seguirUsuario WHERE id_usuario = :id_usuario_t) 
                order by t.data_tweet desc
            ";
            $stmt = $this->bD->prepare($query);
            $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));//atravez da super session faz um  filtro para so aparecer tweets do usuario em questao
            $stmt->bindValue(':id_usuario_t', $this->__get('id_usuario'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        public function removerTweet(){//remove os tweets do banco de dados 
            $query = "
                delete from tweets where id = :id and id_usuario = :id_usuario
            ";$stmt = $this->bD->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
            $stmt->execute();

        }

    }