<?php 

    namespace App\Models;

    use MF\Model\Model;

    class Admin extends Model { 
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


        //salvar
        public function salvar() {
            $query = "insert into mangas(nome, path, pathB, genero1, genero2, genero3, ano_lanc, sinopse, status, class, tipo) values(:nome, :path, :pathB, :genero1, :genero2, :genero3, :ano_lanc, :sinopse, :status, :class, :tipo)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->bindValue(':path', $this->__get('path'));
            $stmt->bindValue(':pathB', $this->__get('pathB'));
            $stmt->bindValue(':genero1', $this->__get('genero1'));
            $stmt->bindValue(':genero2', $this->__get('genero2'));
            $stmt->bindValue(':genero3', $this->__get('genero3'));
            $stmt->bindValue(':ano_lanc', $this->__get('ano_lanc'));
            $stmt->bindValue(':sinopse', $this->__get('sinopse'));
            $stmt->bindValue(':status', $this->__get('status'));
            $stmt->bindValue(':class', $this->__get('class'));
            $stmt->bindValue(':tipo', $this->__get('tipo'));
            $stmt->execute();

            return $this;
            
        }

        public function selectPathsManga() {
            $query = "select path, pathB from mangas where id = :id_manga";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_manga', $this->__get('id_manga'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function selectLogoScan() {
            $query = "select logo from scans where id = :idLogo";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':idLogo', $this->__get('idLogo'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function selectPagesManga() {
            $query = "select paths from paginas where id_manga = :id_manga";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_manga', $this->__get('id_manga'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function updatePath() {
            $query = "update mangas set path = :path where id = :id_manga";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_manga', $this->__get('id_manga'));
            $stmt->bindValue(':path', $this->__get('path'));
            $stmt->execute();
        }

        public function updateLogo() {
            $query = "update scans set logo = :path where id = :idLogo";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':idLogo', $this->__get('idLogo'));
            $stmt->bindValue(':path', $this->__get('path'));
            $stmt->execute();
        }

        public function updateSiteScan() {
            $query = "update scans set site = :siteN where id = :idScan";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':idScan', $this->__get('idScan'));
            $stmt->bindValue(':siteN', $this->__get('siteN'));
            $stmt->execute();
        }

        public function updateFacebookScan() {
            $query = "update scans set facebook = :facebookN where id = :idScan";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':idScan', $this->__get('idScan'));
            $stmt->bindValue(':facebookN', $this->__get('facebookN'));
            $stmt->execute();
        }

        public function updateDiscordScan() {
            $query = "update scans set discord = :discordN where id = :idScan";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':idScan', $this->__get('idScan'));
            $stmt->bindValue(':discordN', $this->__get('discordN'));
            $stmt->execute();
        }

        public function updateTwitterScan() {
            $query = "update scans set twitter = :twitterN where id = :idScan";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':idScan', $this->__get('idScan'));
            $stmt->bindValue(':twitterN', $this->__get('twitterN'));
            $stmt->execute();
        }

        public function updateDoarScan() {
            $query = "update scans set doar = :doarN where id = :idScan";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':idScan', $this->__get('idScan'));
            $stmt->bindValue(':doarN', $this->__get('doarN'));
            $stmt->execute();
        }

        public function updatePathB() {
            $query = "update mangas set pathB = :pathB where id = :id_manga";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_manga', $this->__get('id_manga'));
            $stmt->bindValue(':pathB', $this->__get('pathB'));
            $stmt->execute();
        }

        public function updateNome() {
            $query = "update mangas set nome = :nomeN where id = :id_manga";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_manga', $this->__get('id_manga'));
            $stmt->bindValue(':nomeN', $this->__get('nomeN'));
            $stmt->execute();
        }

        public function updateGenero() {
            $query = "update mangas set genero1 = :genero1N, genero2 = :genero2N, genero3 = :genero3N where id = :id_manga";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_manga', $this->__get('id_manga'));
            $stmt->bindValue(':genero1N', $this->__get('genero1N'));
            $stmt->bindValue(':genero2N', $this->__get('genero2N'));
            $stmt->bindValue(':genero3N', $this->__get('genero3N'));
            $stmt->execute();
        }

        public function updateStatus() {
            $query = "update mangas set status = :statusN where id = :id_manga";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_manga', $this->__get('id_manga'));
            $stmt->bindValue(':statusN', $this->__get('statusN'));
            $stmt->execute();
        }

        public function updateAno_lanc() {
            $query = "update mangas set ano_lanc = :ano_lancN where id = :id_manga";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_manga', $this->__get('id_manga'));
            $stmt->bindValue(':ano_lancN', $this->__get('ano_lancN'));
            $stmt->execute();
        }

        public function updateSinopse() {
            $query = "update mangas set sinopse = :sinopseN where id = :id_manga";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_manga', $this->__get('id_manga'));
            $stmt->bindValue(':sinopseN', $this->__get('sinopseN'));
            $stmt->execute();
        }

        public function updateTipo() {
            $query = "update mangas set tipo = :tipo where id = :id_manga";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_manga', $this->__get('id_manga'));
            $stmt->bindValue(':tipo', $this->__get('tipo'));
            $stmt->execute();
        }


        public function removerManga() {
            $query = "delete from mangas where id = :id_manga";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_manga', $this->__get('id_manga'));
            $stmt->execute();
        }

        public function removerMangaCap() {
            $query = "delete from capitulos where id_manga = :id_manga";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_manga', $this->__get('id_manga'));
            $stmt->execute();
        }

        public function removerMangaPag() {
            $query = "delete from paginas where id_manga = :id_manga";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_manga', $this->__get('id_manga'));
            $stmt->execute();
        }

        public function removerMangaAvals() {
            $query = "delete from avals where id_manga = :id_manga";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_manga', $this->__get('id_manga'));
            $stmt->execute();
        }

        public function removerMangaListas() {
            $query = "delete from itens_listas where id_manga = :id_manga";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_manga', $this->__get('id_manga'));
            $stmt->execute();
        }

        public function removerMangaFila() {
            $query = "delete from usuarios_fila where id_manga = :id_manga";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_manga', $this->__get('id_manga'));
            $stmt->execute();
        }

        //-----------------------------------------------------------------------------------------------

        //Salvar Paginas
        public function salvarP() {
            $query = "insert into paginas(n_cap, id_manga, paths) values(:n_cap, :id_manga, :paths)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':n_cap', $this->__get('n_cap'));
            $stmt->bindValue(':id_manga', $this->__get('id_manga'));
            $stmt->bindValue(':paths', $this->__get('paths'));

            $stmt->execute();

            return $this;
            
        }

        public function addRecem() {
            $query = "update mangas set statusAlt = 'Recém Atualizados' where id = :id_manga";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_manga', $this->__get('id_manga'));
            $stmt->execute();

            return $this;
        }

        public function getCapCount() {
            $query = "select count(*) as countCap from capitulos  where n_cap = :n_cap and id_manga = :id_manga";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':n_cap', $this->__get('n_cap'));
            $stmt->bindValue(':id_manga', $this->__get('id_manga'));
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        public function getCapAdmin() {
            $query = "select n_cap from capitulos where id_manga = :id_manga order by n_cap asc";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_manga', $this->__get('id_manga'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        

        public function addTitle() {
            $query = "insert into titulos(nome, nivel) values(:nome, :nivel)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->bindValue(':nivel', $this->__get('nivel'));
            $stmt->execute();

        }

        public function addScan() {
            $query = "insert into scans(nome, logo, site, facebook, discord, twitter, doar) values(:nome, :logo, :site, :facebook, :discord, :twitter, :doar)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->bindValue(':logo', $this->__get('path'));
            $stmt->bindValue(':site', $this->__get('site'));
            $stmt->bindValue(':facebook', $this->__get('facebook'));
            $stmt->bindValue(':discord', $this->__get('discord'));
            $stmt->bindValue(':twitter', $this->__get('twitter'));
            $stmt->bindValue(':doar', $this->__get('doar'));
            $stmt->execute();

        }

        public function getScans() {
            $query = "select id, nome from scans";
            $stmt = $this->db->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function updateNomeScan() {
            $query = "update scans set nome = :nomeN where id = :idScan";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':idScan', $this->__get('idScan'));
            $stmt->bindValue(':nomeN', $this->__get('nomeN'));

            $stmt->execute();
        }

        public function editTitle() {
            $query = "update titulos set nome = :tituloN where id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':tituloN', $this->__get('tituloN'));
            $stmt->bindValue(':id', $this->__get('id'));

            $stmt->execute();
        }

        public function editNivel() {
            $query = "update titulos set nivel = :nivelN where id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':nivelN', $this->__get('nivelN'));
            $stmt->bindValue(':id', $this->__get('id'));

            $stmt->execute();
        }

        public function removerTitle() {
            $query = "delete from titulos where id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();
        }

        //Salvar Capitulos
        public function salvarC() {
            $query = "insert into capitulos(n_cap, id_manga, fansub) values(:n_cap, :id_manga, :fansub)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':n_cap', $this->__get('n_cap'));
            $stmt->bindValue(':id_manga', $this->__get('id_manga'));
            $stmt->bindValue(':fansub', $this->__get('fansub'));

            $stmt->execute();

            return $this;
            
        }

        public function editCap() {
            $query = "update capitulos set n_cap = :n_capN where id_manga = :id_manga and n_cap = :n_cap";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_manga', $this->__get('id_manga'));
            $stmt->bindValue(':n_cap', $this->__get('n_cap'));
            $stmt->bindValue(':n_capN', $this->__get('n_capN'));
            $stmt->execute();
        }

        public function editPagCap() {
            $query = "update paginas set n_cap = :n_capN where id_manga = :id_manga and n_cap = :n_cap";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_manga', $this->__get('id_manga'));
            $stmt->bindValue(':n_cap', $this->__get('n_cap'));
            $stmt->bindValue(':n_capN', $this->__get('n_capN'));
            $stmt->execute();
        }

        public function removerCap() {
            $query = "delete from capitulos where n_cap = :n_cap and id_manga = :id_manga";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_manga', $this->__get('id_manga'));
            $stmt->bindValue(':n_cap', $this->__get('n_cap'));
            $stmt->execute();
        }

        //Select Cap
        public function selectCapPags() {
            $query = "select paths from paginas where n_cap = :n_cap and id_manga = :id_manga";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_manga', $this->__get('id_manga'));
            $stmt->bindValue(':n_cap', $this->__get('n_cap'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function removerCapPags() {
            $query = "delete from paginas where n_cap = :n_cap and id_manga = :id_manga";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_manga', $this->__get('id_manga'));
            $stmt->bindValue(':n_cap', $this->__get('n_cap'));
            $stmt->execute();
        }

        //-----------------------------------------------------------------------------------------------

        //salvarIcone
        public function salvarIcone() {
            $query = "insert into icones(nome, path) values(:nome, :path)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->bindValue(':path', $this->__get('path'));
            $stmt->execute();

            return $this; 
        }

        //Select Icone 
        public function selectIcone() {
            $query = "select path from icones where id = :id_icone";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_icone', $this->__get('id_icone'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        //RemoverIcone
        public function removerIcone() {
            $query = "delete from icones where id = :id_icone";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_icone', $this->__get('id_icone'));
            $stmt->execute();
        }

        


        //salvarBackground
        public function salvarBack() {
            $query = "insert into backgrounds(nome, path) values(:nome, :path)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->bindValue(':path', $this->__get('path'));
            $stmt->execute();

            return $this;
            
        }

        //Select Back
        public function selectBack() {
            $query = "select path from backgrounds where id = :id_back";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_back', $this->__get('id_back'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        //RemoverIcone
        public function removerBack() {
            $query = "delete from backgrounds where id = :id_back";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_back', $this->__get('id_back'));
            $stmt->execute();
        }

        //salvarCategoria
        public function addCategoria() {
            $query = "insert into categorias(nome, tipo, descricao) values(:nome, :tipo, :descricao)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->bindValue(':tipo', $this->__get('tipo'));
            $stmt->bindValue(':descricao', $this->__get('descricao'));
            $stmt->execute();

            return $this;
            
        }

        public function updateNomeCategoria() {
            $query = "update categorias set nome = :nomeN where id = :id_categoria";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_categoria', $this->__get('id_categoria'));
            $stmt->bindValue(':nomeN', $this->__get('nomeN'));
            $stmt->execute();
        }

        public function updateDescricaoCategoria() {
            $query = "update categorias set descricao = :descricaoN where id = :id_categoria";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_categoria', $this->__get('id_categoria'));
            $stmt->bindValue(':descricaoN', $this->__get('descricaoN'));
            $stmt->execute();
        }

        public function removerCategoria() {
            $query = "delete from categorias where id = :id_categoria";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_categoria', $this->__get('id_categoria'));
            $stmt->execute();
        }

        public function removerScan() {
            $query = "delete from scans where id = :idScan";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':idScan', $this->__get('idScan'));
            $stmt->execute();
        }

        public function getDenuncias() {
            $query = "select d.id as id_d, d.id_conteudo, d.conteudo, d.id_usuario_denunciado, d.tipo, u.id ,u.nome from denuncias as d left join usuarios as u on (d.id_usuario_denunciado = u.id)";
            $stmt = $this->db->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function deleteComment($tipo) {
            if($tipo == 0) {
                $query = "delete from comentarios where id = :id";
            } else if ($tipo == 1) {
                $query = "delete from respostas where id = :id";
            }
            
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();
        }

        public function deleteDenuncia() {
            $query = "delete from denuncias where id_conteudo = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();
        }

        public function deleteResposta() {
            $query = "delete from respostas where id_comentario_respondido = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();
        }
    }