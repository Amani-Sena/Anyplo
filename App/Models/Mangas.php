<?php 

    namespace App\Models;

    use MF\Model\Model;

    class Mangas extends Model { 
        private $id;
        private $nome;
        private $genero1;
        private $genero2;
        private $genero3;
        private $ano_lanc;
        private $path;
        private $sinopse;

        public function __get($attr) {
            return $this->$attr;
        }

        public function __set($attr, $value) {
            $this->$attr = $value;
        }

        //getAll Pesquisa
        public function getAll() {
            $query = "select m.id, m.nome, m.genero1, m.genero2, m.genero3, m.ano_lanc, m.path, m.sinopse, (select count(*) from usuarios_fila as ul where ul.id_manga = m.id and ul.id_usuario = :id) as listando_sn from mangas as m where m.nome like :nome";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->bindValue(':nome', '%'.$this->__get('nome').'%');
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function getNome() {
            $query = "select id, nome, tipo from mangas order by nome asc";
            $stmt = $this->db->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        //Recuperar com paginação
        public function getWithLimit($limit, $offset) {
            $query = "select m.id, m.nome, m.path, m.class, (select count(*) from usuarios_fila as ul where ul.id_manga = m.id and ul.id_usuario = :id) as listando_sn from mangas as m where m.nome like :nome limit $limit offset $offset";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->bindValue(':nome', '%'.$this->__get('nome').'%');
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function count_manga_search() {
            $query = "select count(*) as count_manga from mangas where nome like :nome";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':nome', '%'.$this->__get('nome').'%');
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        public function getDestaque() {
            $query = "select m.id, m.nome, m.genero1, m.genero2, m.genero3, m.ano_lanc, m.path, m.sinopse, m.tipo, m.class, (select count(*) from usuarios_fila as ul where ul.id_manga = m.id and ul.id_usuario = :id) as listando_sn, (select sum(stars) from avals as av where av.id_manga = m.id) as sum_aval, (select count(*) from avals as av where av.id_manga = m.id) as count_aval, (select sum(views) from capitulos as ca where ca.id_manga = m.id) as count_visu from mangas as m where status = 'Destaque' limit 10";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function getScans() {
            $query = "select id, nome from scans";
            $stmt = $this->db->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function getLanc() {
            $query = "select id, nome, path, class from mangas where status = 'Lançamentos' limit 30";
            $stmt = $this->db->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function getPopular() {
            $query = "select id, nome, path, class from mangas where status = 'Populares' limit 30";
            $stmt = $this->db->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function getMeAv() {
            $query = "select m.id, m.nome, m.path, m.class, (select sum(stars) from avals as av where av.id_manga = m.id order by av.id_manga desc) as sum_aval, (select count(*) from avals as av where av.id_manga = m.id) as count_aval from mangas as m limit 30";
            $stmt = $this->db->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }   

        public function getRecem() {
            $query = "select id, nome, path, class from mangas where statusAlt = 'Recém Atualizados' order by id desc limit 30";
            $stmt = $this->db->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function getAdult() {
            $query = "select id, nome, path from mangas where class = '1' order by id desc limit 30";
            $stmt = $this->db->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        
        

        //getAll ID Manga
        public function getManga() {
            $query = "select m.id, m.nome, m.genero1, m.genero2, m.genero3, m.ano_lanc, m.path, m.pathB, m.sinopse, m.tipo, m.class, (select count(*) from usuarios_fila as ul where ul.id_manga = m.id and ul.id_usuario = :id) as listando_sn, (select sum(stars) from avals as av where av.id_manga = m.id) as sum_aval, (select count(*) from avals as av where av.id_manga = m.id) as count_aval from mangas as m where m.id = :id_manga";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->bindValue(':id_manga', $this->__get('id_manga'));
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        public function getForName() {
            $query = "select nome from mangas where id = :id_manga";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_manga', $this->__get('id_manga'));
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        public function saveHist() {
            $query = "insert into hist(nome, id_usuario, id_manga, cap) values(:nome, :id, :id_manga, :n_cap)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->bindValue(':id_manga', $this->__get('id_manga'));
            $stmt->bindValue(':n_cap', $this->__get('n_cap'));
            $stmt->execute();

            return true;
        }

        public function getUserHist() {
            $query = "select h.id, h.nome, h.id_manga, h.cap, h.data, m.path, m.class from hist as h left join mangas as m on (h.id_manga = m.id) where id_usuario = :id order by h.id desc limit 30 ";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function delete_hist() {
            $query = "delete from hist where id_usuario = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();

            return true;
        }

        public function checkHist() {
            $query = "select count(*) as count from hist where id_manga = :id_manga and cap = :n_cap and id_usuario = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->bindValue(':id_manga', $this->__get('id_manga'));
            $stmt->bindValue(':n_cap', $this->__get('n_cap'));
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        public function countHist() {
            $query = "select count(*) as count from hist where id_usuario = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        //recuperar SE o usuario logado está listando o manga
        public function getUserFila() {
            $query = "select count(*) as listando_sn from usuarios_fila as ul where ul.id_manga = :id_manga and ul.id_usuario = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->bindValue(':id_manga', $this->__get('id_manga'));
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }   

        //getAllLista
        public function getAllFila($limit, $offset) {
            $query = "select m.id, m.nome, m.genero1, m.genero2, m.genero3, m.ano_lanc, m.path, m.sinopse, m.class from mangas as m where m.id in (select id_manga from usuarios_fila where id_manga = m.id and id_usuario = :id) limit $limit offset $offset";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function countFila() {
            $query = "select count(*) as count from usuarios_fila where id_usuario = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        //adicionarLista
        public function adicionarFila($id_manga) {
            $query = "insert into usuarios_fila(id_usuario, id_manga) values(:id_usuario, :id_manga)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario', $this->__get('id'));
            $stmt->bindValue(':id_manga', $id_manga);
            $stmt->execute();
            
            return true;
        }

        //removerLista
        public function removerFila($id_manga) {
            $query = "delete from usuarios_fila where id_usuario = :id_usuario and id_manga = :id_manga";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario', $this->__get('id'));
            $stmt->bindValue(':id_manga', $id_manga);
            $stmt->execute();

            return true;
        }

//------------------------------------------------------------------------------------------------------


        //Recuperar informações de todos os capitulos
        public function getAllCap() {
            $query = "select n_cap, id_manga, (select sum(views) from capitulos where id_manga = :id_manga) as views, (select count(*) from capitulos where id_manga = :id_manga) as nCap from capitulos where id_manga = :id_manga order by n_cap asc";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_manga', $this->__get('id_manga'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function addView() {
            $query = "update capitulos set views = views + 1 where id_manga = :id_manga and n_cap = :n_cap";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_manga', $this->__get('id_manga'));
            $stmt->bindValue(':n_cap', $this->__get('n_cap'));
            $stmt->execute();
        }

        public function getCap() {
            $query = "select c.id, c.n_cap, c.id_manga, s.nome from capitulos as c left join scans as s on(s.id = c.fansub) where id_manga = :id_manga and n_cap = :n_cap";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':n_cap', $this->__get('n_cap'));
            $stmt->bindValue(':id_manga', $this->__get('id_manga'));
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        public function getCapPrev() {
            $query = "select c.id, c.n_cap, c.id_manga, s.nome from capitulos as c left join scans as s on(s.id = c.fansub) where id_manga = :id_manga and n_cap < :n_cap order by n_cap desc limit 1";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':n_cap', $this->__get('n_cap'));
            $stmt->bindValue(':id_manga', $this->__get('id_manga'));
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        public function getCapNext() {
            $query = "select c.id, c.n_cap, c.id_manga, s.nome from capitulos as c left join scans as s on(s.id = c.fansub) where id_manga = :id_manga and n_cap > :n_cap order by n_cap asc limit 1";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':n_cap', $this->__get('n_cap'));
            $stmt->bindValue(':id_manga', $this->__get('id_manga'));
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        public function getCapF() {
            $query = "select n_cap from capitulos where id_manga = :id_manga order by n_cap desc limit 1";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_manga', $this->__get('id_manga'));
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        public function getLei() {
            $query = "select leitura from usuarios where id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();
            
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        //Recuperar numero de capitulos do manga
        public function getNCap() {
            $query = "select count(*) as n_cap from capitulos where id_manga = :id_manga";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_manga', $this->__get('id_manga'));
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        //Recuperar paginas do capitulo
        public function getPages($cap) {
            $query = "select paths from paginas where id_manga = :id_manga and n_cap = $cap";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_manga', $this->__get('id_manga'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        //Avaliacões
        public function countAval() {
            $query = "select count(*) as count_aval from avals where id_manga = :id_manga and id_usuario = :id_usuario";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario', $this->__get('id'));
            $stmt->bindValue(':id_manga', $this->__get('id_manga'));
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        public function addAval() {
            $query = "insert into avals(id_usuario, id_manga, stars) values(:id_usuario, :id_manga, :stars)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario', $this->__get('id'));
            $stmt->bindValue(':id_manga', $this->__get('id_manga'));
            $stmt->bindValue(':stars', $this->__get('stars'));
            $stmt->execute();
            
            return true;
        }

        public function updateAval() {
            $query = "update avals set stars = :stars where id_usuario = :id_usuario and id_manga = :id_manga";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario', $this->__get('id'));
            $stmt->bindValue(':id_manga', $this->__get('id_manga'));
            $stmt->bindValue(':stars', $this->__get('stars'));
            $stmt->execute();
            
            return true;
        }

        //Aleatório
        public function aleatorio() {
            $query = "select id from mangas";
            $stmt = $this->db->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function getCountManga() {
            $query = "select count(*) as count_manga from mangas";
            $stmt = $this->db->prepare($query);
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        //Categorias

        public function getCountGenero() {
            $query = "select count(*) as count_manga from mangas where genero1 = :categoria or genero2 = :categoria or genero3 = :categoria";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':categoria', $this->__get('categoria'));
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        public function getGenero($limit, $offset) {
            $query = "select id, nome, genero1, genero2, genero3, path, class from mangas where genero1 = :categoria or genero2 = :categoria or genero3 = :categoria limit $limit offset $offset";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':categoria', $this->__get('categoria'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function getCountStatus() {
            $query = "select count(*) as count_manga from mangas where status = :categoria";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':categoria', $this->__get('categoria'));
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        public function getAllCategorias() {
            $query = "select id, nome, descricao from categorias";
            $stmt = $this->db->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function getAllStatus() {
            $query = "select id, nome, descricao from categorias where tipo = 1";
            $stmt = $this->db->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function getAllGeneros() {
            $query = "select id, nome, descricao from categorias where tipo = 2";
            $stmt = $this->db->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function getStatus($limit, $offset) {
            $query = "select id, nome, path, class from mangas where status = :categoria limit $limit offset $offset";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':categoria', $this->__get('categoria'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function getStatusAlt($limit, $offset) {
            $query = "select id, nome, path, class from mangas where statusAlt = :categoria limit $limit offset $offset";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':categoria', $this->__get('categoria'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function getCategoria() {
            $query = "select id, nome, descricao from categorias where nome = :categoria";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':categoria', $this->__get('categoria'));
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }  

            
}       
    
?>