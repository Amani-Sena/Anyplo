<?php 

    namespace App\Models;
    use MF\Model\Model;

    class Usuario extends Model {
        private $id;
        private $nome;
        private $email;
        private $senha;

        public function __get($attr) {
            return $this->$attr;
        }

        public function __set($attr, $value) {
            $this->$attr = $value;
        }

        //salvar
        public function salvar() {
            $query = "insert into usuarios(nome, email, senha, icone, bg, chave, id_situ, tipo, nivel, class) values(:nome, :email, :senha, :icone, :bg, :chave, :id_situ, :tipo, :nivel, :class)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->bindValue(':email', $this->__get('email'));
            $stmt->bindValue(':senha', $this->__get('senha'));
            $stmt->bindValue(':icone', $this->__get('icone'));
            $stmt->bindValue(':bg', $this->__get('back'));
            $stmt->bindValue(':chave', $this->__get('chave'));
            $stmt->bindValue(':id_situ', $this->__get('id_situ'));
            $stmt->bindValue(':tipo', $this->__get('tipo'));
            $stmt->bindValue(':nivel', $this->__get('nivel'));
            $stmt->bindValue(':class', $this->__get('class'));
            $stmt->execute();
        }

        public function salvarGoogle() {
            $query = "insert into usuarios(nome, email, icone, bg, chave, id_situ, tipo, nivel, class) values(:nome, :email, :icone, :bg, :chave, :id_situ, :tipo, :nivel, :class)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->bindValue(':email', $this->__get('email'));
            $stmt->bindValue(':icone', $this->__get('icone'));
            $stmt->bindValue(':bg', $this->__get('back'));
            $stmt->bindValue(':chave', $this->__get('chave'));
            $stmt->bindValue(':id_situ', $this->__get('id_situ'));
            $stmt->bindValue(':tipo', $this->__get('tipo'));
            $stmt->bindValue(':nivel', $this->__get('nivel'));
            $stmt->bindValue(':class', $this->__get('class'));
            $stmt->execute(); 
        }

        //Procurar Registro do google
        public function searchGoogleId() {
            $query = "select count(*) as countGoogle from usuarios where email = :email";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':email', $this->__get('email'));
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        //Validar se o cadastro pode ser feito
        public function validarCadastro() {
            $valido = true;
            //validadores/condições
            if(strlen($this->__get('nome')) < 2) {
                $valido = false;
            }

            if(strlen($this->__get('email')) < 7) {
                $valido = false;
            }

            if(strlen($this->__get('senha')) < 6) {
                $valido = false;
            }

            
                return $valido;
            
        }

        public function getNivel() {
            $query = "select nivel from usuarios where id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        public function sumNivel($nivel) {
            $query = "update usuarios set nivel = $nivel where id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();
        }

        public function select_email() {
            $query = "select id from usuarios where chave = :chave limit 1";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':chave', $this->__get('chave'));
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        //Confirmar Email
        public function conf_email($id_user) {
            $query = "update usuarios set id_situ = 1, chave = :chave where id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $id_user);
            $chave = null;
            $stmt->bindValue(':chave', $chave);
            $stmt->execute();

        }

        //Recuperar usuário por email
        public function getUsuarioEmail() {
            $query = 'select nome, email from usuarios where email = :email';
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':email', $this->__get('email'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        //Recuperar usuário por nome
        public function getUserName() {
            $query = 'select nome, email from usuarios where nome = :nome';
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function autenticar() {
            $query = "select id, nome, email, senha, icone, tipo from usuarios where email = :login or nome = :login";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':login', $this->__get('login'));
            $stmt->execute();

            $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);

            if(password_verify($this->__get('senha'), $usuario['senha'])) {
                if($usuario['id'] != '' && $usuario['nome'] != '') {
                    $this->__set('id', $usuario['id']);
                    $this->__set('nome', $usuario['nome']);
                    $this->__set('icone', $usuario['icone']);
                    $this->__set('tipo', $usuario['tipo']);
                    $this->__set('class', $usuario['class']);
                }
            }
            

            return $this;
        }

        public function getClass() {
            $query = "select class from usuarios where id = :id limit 1";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        public function updateLei() {
            $query = "update usuarios set leitura = :leitura where id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->bindValue(':leitura', $this->__get('leitura'));
            $stmt->execute();
        }

        public function updateClass() {
            $query = "update usuarios set class = :class where id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->bindValue(':class', $this->__get('class'));
            $stmt->execute();
        }

        public function updateTitle() {
            $query = "update usuarios set titulo = :titulo where id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->bindValue(':titulo', $this->__get('titulo'));
            $stmt->execute();
        }

        public function autenticarGoogle() {
            $query = "select id, nome, email, icone, tipo, class from usuarios where email = :email";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':email', $this->__get('email'));
            $stmt->execute();

            $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);

                if($usuario['id'] != '' && $usuario['nome'] != '') {
                    $this->__set('id', $usuario['id']);
                    $this->__set('nome', $usuario['nome']);
                    $this->__set('icone', $usuario['icone']);
                    $this->__set('tipo', $usuario['tipo']);
                    $this->__set('class', $usuario['class']);
                }
            
            return $this;
        }

        public function getUser() {
            $query = "select id, nome, email, senha, icone, bg, id_situ, chave, leitura, titulo, nivel, class from usuarios where id = :id limit 1";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        public function getTitle() {
            $query = "select id, nome, nivel from titulos order by nivel asc";
            $stmt = $this->db->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function altEmail() {
            $query = "select id, nome, email, senha from usuarios where id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();

            $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);


            if(password_verify($this->__get('senha'), $usuario['senha'])) {
                $query = "update usuarios set email = :emailN where id = :id";
                $stmt = $this->db->prepare($query);
                $stmt->bindValue(':id', $this->__get('id'));
                $stmt->bindValue(':emailN', $this->__get('emailN'));

                if($this->__get('emailN') == $usuario['email']) {
                    $resp =  ['status' => false, 'msg'=> "Digite um e-mail diferente!"];
                } else {
                    $stmt->execute();
                    $resp =  ['status' => true, 'msg'=> "E-mail alterado com sucesso!"];
                }
                
            } else if(!password_verify($this->__get('senha'), $usuario['senha'])) {
                $resp =  ['status' => false, 'msg'=> "Senha Incorreta!"];
            }
            echo json_encode($resp);
        }

        public function altSenha() {
            $query = "select id, senha from usuarios where id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();

            $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);

            if(password_verify($this->__get('senha'), $usuario['senha'])) {
                $query = "update usuarios set senha = :senhaN where id = :id";
                $stmt = $this->db->prepare($query);
                $stmt->bindValue(':id', $this->__get('id'));
                $stmt->bindValue(':senhaN', $this->__get('senhaN'));
                $stmt->execute();

                $resp =  ['status' => true, 'msg'=> "Senha alterada com sucesso!"];
                
            } else {
                $resp =  ['status' => false, 'msg'=> "Senha Incorreta!"];
            }
            echo json_encode($resp);
        }


//------------------------------------------------------------------------------------------------------


        //Listas
        public function criarLista() {
            $query = "insert into listas(id_usuario, nome) values(:id, :nome)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->execute();
        }

        public function getListas() {
            $query = "select l.id, l.id_usuario, l.nome, (select count(*) from listas as l where l.id_usuario = :id) as countL, (select count(*) from itens_listas as il where il.id_usuario = :id and il.id_manga = :id_manga and il.id_lista = l.id) as listando_sn, (select count(*) from itens_listas as il where il.id_lista = l.id and id_usuario = :id) as count_itens from listas as l where l.id_usuario = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->bindValue(':id_manga', $this->__get('id_manga'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function getLista() {
            $query = "select id, id_usuario, nome from listas where id_usuario = :id and id = :id_lista";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->bindValue(':id_lista', $this->__get('id_lista'));
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        public function countListas() {
            $query = "select count(*) as count from listas where id_usuario = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        public function checkLista() {
            $query = "select count(*) as count from listas where nome = :nome and id_usuario = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        public function editarLista($id_lista) {
            $query = "update listas set nome = :nome where id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $id_lista);
            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->execute();
        }


        //Itens_listas
        public function adicionarLista($id_manga, $id_lista) {
            $query = "insert into itens_listas(id_lista, id_usuario, id_manga) values(:id_lista, :id_usuario, :id_manga)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario', $this->__get('id'));
            $stmt->bindValue(':id_manga', $id_manga);
            $stmt->bindValue(':id_lista', $id_lista);
            $stmt->execute();
            
            $resp =  ['status' => true, 'msg'=> "Adicionado na lista com sucesso!"];
            echo json_encode($resp);

            return true;
        }

        public function removerLista($id_lista) {
            $query = "delete from listas where id_usuario = :id_usuario and id = :id_lista";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario', $this->__get('id'));
            $stmt->bindValue(':id_lista', $id_lista);
            $stmt->execute();

            return true;
        }

        public function removerMangasListas($id_lista) {
            $query = "delete from itens_listas where id_usuario = :id_usuario and id_lista = :id_lista";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario', $this->__get('id'));
            $stmt->bindValue(':id_lista', $id_lista);
            $stmt->execute();

            $resp =  ['status' => false, 'msg'=> "Removido da lista com sucesso!"];
            echo json_encode($resp);

            return true;
        }

        public function removerMangaLista($id_lista, $id_manga) {
            $query = "delete from itens_listas where id_usuario = :id_usuario and id_lista = :id_lista and id_manga = :id_manga";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario', $this->__get('id'));
            $stmt->bindValue(':id_lista', $id_lista);
            $stmt->bindValue(':id_manga', $id_manga);
            $stmt->execute();

            return true;
        }

        

        public function getItens($limit, $offset) {
            $query = "select m.id, m.nome, m.genero1, m.genero2, m.genero3, m.ano_lanc, m.path, m.pathB, m.sinopse, m.class from mangas as m where m.id in (select id_manga from itens_listas where id_manga = m.id and id_usuario = :id and id_lista = :id_lista) limit $limit offset $offset";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->bindValue(':id_lista', $this->__get('id_lista'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function countItens() {
            $query = "select count(*) as count_itens from itens_listas where id_usuario = :id and id_lista = :id_lista";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->bindValue(':id_lista', $this->__get('id_lista'));
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }


        //Icones
        public function getIcones() {
            $query = "select id, path from icones";
            $stmt = $this->db->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function updateIcone() {
            $query = "update usuarios set icone = :icone where id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->bindValue(':icone', $this->__get('icone'));
            $stmt->execute();

        }

        public function getScans() {
            $query = "select id, nome, logo, site, facebook, discord, twitter, doar from scans";
            $stmt = $this->db->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        //Backgrounds
        public function getBack() {
            $query = "select id, path from backgrounds";
            $stmt = $this->db->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function updateBack() {
            $query = "update usuarios set bg = :back where id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->bindValue(':back', $this->__get('back'));
            $stmt->execute();

        }

        /*public function salvarComment() {
            $query = "insert into comentarios(comentario, id_manga, n_cap, id_usuario, spoiler) values(:comentario, :id_manga, :n_cap, :id, :spoiler)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->bindValue(':comentario', $this->__get('comentario'));
            $stmt->bindValue(':id_manga', $this->__get('id_manga'));
            $stmt->bindValue(':n_cap', $this->__get('n_cap'));
            $stmt->bindValue(':spoiler', $this->__get('spoiler'));
            $stmt->execute();
        }*/

        /*public function salvarResposta() {
            $query = "insert into respostas(resposta, id_manga, n_cap, id_usuario, spoiler, id_usuario_respondido, id_comentario_respondido) values(:resposta, :id_manga, :n_cap, :id, :spoiler, :id_usuario_respondido, :id_comentario_respondido)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->bindValue(':resposta', $this->__get('resposta'));
            $stmt->bindValue(':id_manga', $this->__get('id_manga'));
            $stmt->bindValue(':n_cap', $this->__get('n_cap'));
            $stmt->bindValue(':spoiler', $this->__get('spoiler'));
            $stmt->bindValue(':id_usuario_respondido', $this->__get('id_usuario_respondido'));
            $stmt->bindValue(':id_comentario_respondido', $this->__get('id_comentario_respondido'));
            $stmt->execute();
        }*/

        /*public function getComments() {
            $query = "select c.id, c.conteudo, c.spoiler, c.id_usuario, c.data, u.nome, u.titulo, u.icone, (select count(*) from comentarios as c where c.id_manga = :id_manga and c.n_cap = :n_cap) as count_comments from comentarios as c left join usuarios as u on (c.id_usuario = u.id) where c.id_manga = :id_manga and c.n_cap = :n_cap order by c.data desc limit 200";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_manga', $this->__get('id_manga'));
            $stmt->bindValue(':n_cap', $this->__get('n_cap'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            
        }*/

        /*public function getRespostas() {
            $query = "select r.id, r.resposta, r.spoiler, r.id_usuario, r.data, r.id_usuario_respondido, r.id_comentario_respondido, u.nome, u.titulo, u.icone, (select count(*) from respostas as r where r.id_manga = :id_manga and r.n_cap = :n_cap) as count_respostas from respostas as r left join usuarios as u on (r.id_usuario = u.id) where r.id_manga = :id_manga and r.n_cap = :n_cap order by r.data desc limit 200";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_manga', $this->__get('id_manga'));
            $stmt->bindValue(':n_cap', $this->__get('n_cap'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }*/

        /*public function salvarDenuncia() {
            $query = "insert into denuncias(id_conteudo, conteudo, id_usuario_denunciado, id_usuario_denuncia, tipo) values(:id_conteudo, :conteudo, :id_usuario_denunciado, :id_usuario_denuncia, :tipo)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_conteudo', $this->__get('id_conteudo'));
            $stmt->bindValue(':conteudo', $this->__get('conteudo'));
            $stmt->bindValue(':id_usuario_denunciado', $this->__get('id_usuario_denunciado'));
            $stmt->bindValue(':id_usuario_denuncia', $this->__get('id_usuario_denuncia'));
            $stmt->bindValue(':tipo', $this->__get('tipo'));
            $stmt->execute();
        }*/

    }


    

?>