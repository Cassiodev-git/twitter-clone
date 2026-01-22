<?php
    namespace App\models;
    use MF\model\Model;
    class Usuario extends Model{
        private $id;
        private $nome;
        private $email;
        private $senha;


        public function __get($atribulto){
            return $this->$atribulto;
        }
        public function __set($atribulto, $valor){
            $this->$atribulto = $valor;
        }
        //metodo de salvar usuarios novos 

        public function salvarUser(){//salva o usuario no banco após a tratativa 
            $query = "
                insert into usuarios (nome, email, senha)values(:nome, :email, :senha)
            ";
            $stmt =  $this->bD->prepare($query);
            $senhaMd5 = md5($this->__get('senha'));//criptografa neste padrão que nao é o correto!
            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->bindValue(':email', $this->__get('email'));
            $stmt->bindValue(':senha', $senhaMd5);
            $stmt->execute();

            return true;
        }
        public function validarUsuario(){//valida se o usuario tem pelo menos 3 caracteres e se o email tem o @
            $valido = true;
            if(strlen($this->__get('nome')) < 3 || strlen($this->__get('email')) < 3 || strlen($this->__get('senha')) < 3){
                $valido = false;
            }
            if(!str_contains($this->__get('email'), '@')){
                $valido = false;
            }
            return $valido;//se tudo der certo retorna true

        }
        public function getUsuarioEmail(){//faz um pesquisa no banco para ver se o email ja existe 
            $query = "
                select nome, email from usuarios where email = :email
            ";
            $stmt = $this->bD->prepare($query);
            $stmt->bindValue(':email', $this->__get('email'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        public function autenticar(){//verifica se o email e senha existem no banco de de dados
            $query =  "
                select id, nome, email, senha from usuarios where email = :email and senha = :senha
            ";
            $stmt = $this->bD->prepare($query);
            $stmt->bindValue(':email', $this->__get('email'));
            $stmt->bindValue(':senha', md5($this->__get('senha')));//busca pelo hash
            $stmt->execute();

            $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);//retorna um array associativo
            if($usuario){
                $this->__set('id', $usuario['id'] );
                $this->__set('nome', $usuario['nome'] );
            }
            return $this;
        }
        public function pesquisarPorNome(){//pesquisa o usuario no banco de acordo com os caracteres informados
            $query = "
                select u.id, u.nome, u.email,(
                    select
                        count(*)
                    from
                        seguirUsuario as us
                    where 
                        us.id_usuario = :id_usuario_us and us.id_usuario_seguindo = u.id
                ) seguir_sn 
                from usuarios as u
                where
                    u.nome like :nome and u.id != :id_usuario
            ";//fiz uma pesquisa dentro de outra para validar se está seguindo ou n 1 esta seguindp 0 nao
            $stmt = $this->bD->prepare($query);
            $stmt->bindValue(':nome', '%'.$this->__get('nome').'%');
            $stmt->bindValue(':id_usuario', $this->__get('id'));
            $stmt->bindValue(':id_usuario_us', $this->__get('id'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);//retorna um array assosiativo para o controller 
        }
        //recuperar nome
        public function getNomeUsuario(){
            $query = "
                select nome from usuarios where id = :id_usuario
            ";
            $stmt = $this->bD->prepare($query);
            $stmt->bindValue(':id_usuario', $this->__get('id'));
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }
        //total de tweets
        public function getTotalTweets(){
        $query = "
            select count(*) as Total_tweet from tweets where id_usuario = :id_usuario
        ";
        $stmt = $this->bD->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id'));
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
        }
        //total seguindo o usuario
        public function getTotalSeguindo(){
        $query = "
            select count(*) as Total_seguindo from seguirUsuario where id_usuario = :id_usuario
        ";
        $stmt = $this->bD->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id'));
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
        }
        //total de seguidores
        public function getTotalSeguidores(){
        $query = "
            select count(*) as Total_seguidores from seguirUsuario where id_usuario_seguindo = :id_usuario
        ";
        $stmt = $this->bD->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id'));
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
        }

    }

?>