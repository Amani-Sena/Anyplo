<?php

namespace App\Controllers;

//os recursos do miniframework

use App\Models\Usuario;
use MF\Controller\Action;
use MF\Model\Container;

class AppController extends Action {

    public function profile() {
        session_start();
        if($_SESSION['id'] != '' && $_SESSION['nome'] != '') {
            $user = Container::getModel('Usuario');
            $user->__set('id', $_SESSION['id']);
            $this->view->icones = $user->getIcones();
            $this->view->back = $user->getBack();
            $this->view->title = $user->getTitle();
            $this->view->user_info = $user->getUser();

            $this->render('profile');
        } else {
            header('Location: /login');
        }
    }

    public function grupos() {
        session_start();
        $scan = Container::getModel('Usuario');
        $this->view->scan_info = $scan->getScans();

        $this->render('grupos');
    }

    public function gerenciar_home() {
        session_start();

        if($_SESSION['tipo'] == 0 && $_SESSION['nome'] != '') {
            $this->render('gerenciar_home');
        } else {
            header('Location: /login');
        }
    }

    public function pesquisar() {
        $this->view->manga_count['count_manga'] = -1;
        $this->render('pesquisar');
    }

    //acao
    public function acao() {
        
            $acao = isset($_GET['acao']) ? $_GET['acao'] : '';
            $red = isset($_GET['red']) ? $_GET['red'] : '';
            //------------------------------------------------
            $id_manga = isset($_GET['id_manga']) ? $_GET['id_manga'] : '';
            $n_cap = isset($_GET['n_cap']) ? $_GET['n_cap'] : '';
            $id_lista = isset($_GET['id_lista']) ? $_GET['id_lista'] : '';
            $stars = isset($_GET['stars']) ? $_GET['stars'] : '';

            session_start();
            if(isset($_SESSION['id'])) {
                $lista = Container::getModel('Usuario');
                $lista->__set('id', $_SESSION['id']);
                $manga = Container::getModel('Mangas');
                $manga->__set('id', $_SESSION['id']);
            }
            

            if($acao == "adicionar") {
                $manga->adicionarFila($id_manga);

            } else if ($acao == "remover") {
                $manga->removerFila($id_manga);

            } else if ($acao == "addlist") {
                $lista->adicionarLista($id_manga, $id_lista);

            } else if ($acao == "removerLista") {
                $lista->removerLista($id_lista);
                $lista->removerMangasListas($id_lista);
                header('Location: /lista');

            } else if ($acao == "editarLista") {
                $lista = Container::getModel('Usuario');
                $lista->__set('nome', $_POST['nome']);
                $lista->__set('id', $_SESSION['id']);
                $count_lista = $lista->checkLista();

                if($count_lista['count'] > 0) {
                    $resp =  ['status' => false, 'msg'=> "Lista já existe!"];
                } else {
                    $lista->editarLista($id_lista);
                    $resp =  ['status' => true, 'msg'=> "Lista Editada com Sucesso!"];
                    
                }
                echo json_encode($resp);
            
            } else if ($acao == "removerMangaLista") {
                $lista->removerMangaLista($id_lista, $id_manga);
                
            } else if ($acao == "addAval") {
                $manga->__set('stars', $stars);
                $manga->__set('id_manga', $id_manga);
                $countAval = $manga->countAval();

                if($countAval['count_aval'] == 0) {
                    echo "Entrou aqui!";
                    $manga->addAval();
                } else if($countAval['count_aval'] >= 1) {
                    $manga->updateAval();
                }
            }
    }

    public function lista() {
        session_start();
        if($_SESSION['id'] != '' && $_SESSION['nome'] != '') {
            $lista = Container::getModel('Usuario');
            
            $lista->__set('id', $_SESSION['id']);
            $lista->__set('id_manga', '');

            $this->view->lista = $lista->getListas();
            $this->view->count_listas = $lista->countListas();

            $this->render('minhas_listas');

        } else {
            header('Location: /login');
        }
    }

    public function requestPartial() {
        $partial = isset($_GET['partial']) ? $_GET['partial'] : '';
        session_start();
            if($partial == 'preferences') {
                $user = Container::getModel('Usuario');
                $user->__set('id', $_SESSION['id']);
                $this->view->title = $user->getTitle();
                $this->view->user_info = $user->getUser();

                $this->render('partials/preferences');

            } else if ($partial == 'altEmail') {
                $user = Container::getModel('Usuario');
                $user->__set('id', $_SESSION['id']);
                $this->view->user_info = $user->getUser();

                $this->render('partials/altEmail');

            } else if ($partial == 'title') {
                $user = Container::getModel('Usuario');
                $user->__set('id', $_SESSION['id']);
                $this->view->user_info = $user->getUser();

                $this->render('partials/title');

            } else if ($partial == 'altSenha') {
                $user = Container::getModel('Usuario');
                $user->__set('id', $_SESSION['id']);
                $this->view->user_info = $user->getUser();

                $this->render('partials/altSenha');

            } else if ($partial == 'user_icon') {
                $user = Container::getModel('Usuario');
                $user->__set('id', $_SESSION['id']);
                $this->view->user_info = $user->getUser();

                $this->render('partials/user_icon');

            } else if ($partial == 'user_bg') {
                $user = Container::getModel('Usuario');
                $user->__set('id', $_SESSION['id']);
                $this->view->user_info = $user->getUser();

                $this->render('partials/user_bg');

            } else if($partial == 'row') {
                $manga = Container::getModel('Mangas');
                $user = Container::getModel('Usuario');

                if(isset($_SESSION['id'])) {
                    $manga->__set('id', $_SESSION['id']);
                    $user->__set('id', $_SESSION['id']);

                    $this->view->class = $user->getClass();
                }
                

                //variaveis de paginação
                $limit = 30;
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $offset = ($page - 1) * $limit;

                $this->view->mangas = $manga->getAllFila($limit, $offset);
                $this->view->count_fila = $manga->countFila();
                $this->view->limitF = ceil($this->view->count_fila['count'] / $limit);
                $this->view->active = $page;

                $this->render('partials/row');

            } else if($partial == 'list') {
                $lista = Container::getModel('Usuario');
            
                $lista->__set('id', $_SESSION['id']);
                $lista->__set('id_manga', '');

                $this->view->lista = $lista->getListas();
                $this->view->count_listas = $lista->countListas();

                $this->render('partials/list');

            } else if($partial == 'history') {
                $manga = Container::getModel('Mangas');
                $user = Container::getModel('Usuario');
                
                
                if(isset($_SESSION['id'])) {
                    $manga->__set('id', $_SESSION['id']);
                    $user->__set('id', $_SESSION['id']);

                    $this->view->class = $user->getClass();
                }

                $this->view->hist = $manga->getUserHist();
                $this->view->count_hist = $manga->countHist();
                
                $this->render('partials/history');

            } else if($partial == "addList") { 
                
                $id_manga = isset($_GET['id_manga']) ? $_GET['id_manga'] : '';

                $lista = Container::getModel('Usuario');
                $manga = Container::getModel('Mangas');
                $manga->__set('id_manga', $id_manga);
                if(isset($_SESSION['id'])) {
                    $lista->__set('id', $_SESSION['id']);
                    $manga->__set('id', $_SESSION['id']);
                }
                $lista->__set('id_manga', $id_manga);
                $this->view->lista = $lista->getListas();
                $this->view->count = $lista->countListas();
                //$this->view->listando = $manga->getUserFila();
                $this->view->mangaI = $manga->getManga();
                $this->view->capI = $manga->getAllCap();
                $this->view->capN = $manga->getNCap();


                $this->render('partials/addList');

            } else if($partial == "addRow") {
                $id_manga = isset($_GET['id_manga']) ? $_GET['id_manga'] : '';
        
                $manga = Container::getModel('Mangas');
                
                $manga->__set('id_manga', $id_manga);

                if($_SESSION['id'] != '') {
                    $manga->__set('id', $_SESSION['id']);
                }

                $this->view->mangaI = $manga->getManga();
                $this->render('partials/addRow');

            } else if($partial == "addRow_index") {
                $id_manga = isset($_GET['id_manga']) ? $_GET['id_manga'] : '';
                $manga = Container::getModel('Mangas');

                if(isset($_SESSION['id'])) {
                    $manga->__set('id', $_SESSION['id']);
                }

                $this->view->destaque = $manga->getDestaque();

                $this->render('partials/addRow_index');

            } else if($partial == "user_icon_header") {
                $this->render('partials/user_icon_header');

            } else if($partial == 'header_list_home') {
                if($_SESSION['id'] != '' && $_SESSION['nome'] != '') {
                    $id_lista = isset($_GET['id_lista']) ? $_GET['id_lista'] : '';

                    $lista = Container::getModel('Usuario');
                    $lista->__set('id', $_SESSION['id']);
                    $lista->__set('id_lista', $id_lista);

                    $this->view->count_itens = $lista->countItens();
                    $this->view->lista = $lista->getLista();

                    $this->render('partials/header_list_home');
                }

            } else if($partial == 'con_pesquisar') {

                $pesquisarPor = isset($_GET['pesquisarPor']) ? $_GET['pesquisarPor'] : '';

                $this->view->manga_count['count_manga'] = -1;
      
                $manga = Container::getModel('Mangas');
                $user = Container::getModel('Usuario');

                if(isset($_SESSION['id'])) {
                    $user->__set('id', $_SESSION['id']);
                    $this->view->class = $user->getClass();
                }

                $manga->__set('nome', $pesquisarPor);
                $this->view->pesquisa = $pesquisarPor;

                //variaveis de paginação
                $limit = 30;
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $offset = ($page - 1) * $limit;;
           
                $this->view->mangas = $manga->getWithLimit($limit, $offset);
                $this->view->manga_count = $manga->count_manga_search();
                $this->view->limitF = ceil($this->view->manga_count['count_manga'] / $limit);
                $this->view->active = $page;

                $this->render('partials/con_pesquisar');

            } else if($partial == 'addRowC') {
                $id_manga = isset($_GET['id_manga']) ? $_GET['id_manga'] : '';

                $manga = Container::getModel('Mangas');

                $manga->__set('id_manga', $id_manga);

                if($_SESSION['id'] != '') {
                    $manga->__set('id', $_SESSION['id']);
                    $this->view->listando = $manga->getUserFila();
                    $this->view->mangaI = $manga->getManga();
                    
                    $this->render('partials/addRowC');
                } else {
                    header('Location: /login');
                }
            } else if($partial == 'comments') {
                $id_manga = isset($_GET['id_manga']) ? $_GET['id_manga'] : '';
                $n_cap = isset($_GET['n_cap']) ? $_GET['n_cap'] : '';

                $comment = Container::getModel('Usuario');
                $comment->__set('id_manga', $id_manga);
                $comment->__set('n_cap', $n_cap);
                $this->view->comments = $comment->getComments();
                $this->view->respostas = $comment->getRespostas();

                $this->render('partials/comments');

            } else if($partial == 'error_404') {
                header('Location: /error_404');
            }
    }

    public function criarLista() {
        session_start();
        if(isset($_SESSION['id'])) {
            $lista = Container::getModel('Usuario');
            $lista->__set('id', $_SESSION['id']);
            $lista->__set('nome', $_POST['nome']);
            
            $count = $lista->countListas(); 

            if($count['count'] < '5') {
                $lista->criarLista();
                $resp =  ['status' => true, 'msg'=> "Lista Criada com Sucesso!"];
            } else {
                $resp =  ['status' => false, 'msg'=> "Limite de Listas Alcançado!"];
            }
            echo json_encode($resp);

        } else {
            header('Location: /login');
        }
    }

    public function lista_home() {
        session_start();
        if($_SESSION['id'] != '' && $_SESSION['nome'] != '') {
            $id_lista = isset($_GET['id_lista']) ? $_GET['id_lista'] : '';

            $lista = Container::getModel('Usuario');

            if(isset($_SESSION['id'])) {
                $lista->__set('id', $_SESSION['id']);
            }

            
            $lista->__set('id_lista', $id_lista);

            //variaveis de paginação
            $this->view->max_links = $max_links = 2;
            $limit = 30;
            $this->view->page_atual = $page = isset($_GET['page']) ? $_GET['page'] : 1;
            $offset = ($page - 1) * $limit;
        

            $this->view->itens = $lista->getItens($limit, $offset);
            $this->view->count_itens = $lista->countItens();
            $this->view->limitF = ceil($this->view->count_itens['count_itens'] / $limit);
            $this->view->active = $page;

            $this->view->lista = $lista->getLista();

            if(!isset($this->view->lista['id'])) {
                header('Location: /error_404');
            } else {
                $this->render('lista_home');
            }
            
        } else {
            header('Location: /login');
        }
    }

    public function delete_hist() {
        session_start();
        if($_SESSION['id'] != '' && $_SESSION['nome'] != '') {
            $manga = Container::getModel('Mangas');
            $manga->__set('id', $_SESSION['id']);
            $manga->delete_hist();
        } else {
            header('Location: /login');
        }

    }

    public function mangas() {
            session_start();
            $manga = Container::getModel('Mangas');
            $user = Container::getModel('Usuario');
		    
            if(isset($_SESSION['id'])) {
                $user->__set('id', $_SESSION['id']);
                $this->view->class = $user->getClass();
            }

            //variaveis de paginação
            $this->view->max_links = $max_links = 2;
            $limit = 30;
            $this->view->page_atual = $page = isset($_GET['page']) ? $_GET['page'] : 1;
            $offset = ($page - 1) * $limit;;
            
            $this->view->mangas = $manga->getWithLimit($limit, $offset);
            $mangaCount = $manga->getCountManga();
            $this->view->limitF = ceil($mangaCount['count_manga'] / $limit);
            $this->view->active = $page;

            $this->render('mangas');
    }

    public function manga() {
        session_start();
        $id_manga = isset($_GET['id_manga']) ? $_GET['id_manga'] : '';

        $lista = Container::getModel('Usuario');
        $manga = Container::getModel('Mangas');
        $manga->__set('id_manga', $id_manga);
        if(isset($_SESSION['id'])) {
            $lista->__set('id', $_SESSION['id']);
            $manga->__set('id', $_SESSION['id']);
        }
        $lista->__set('id_manga', $id_manga);
        $this->view->lista = $lista->getListas();
        $this->view->mangaI = $manga->getManga();
        $this->view->capI = $manga->getAllCap();

        if(!isset($this->view->mangaI['id'])) {
            header('Location: /error_404');
        } else {
            $this->render('manga');
        }  
    }

    public function paginas() {
        $id_manga = isset($_GET['id_manga']) ? $_GET['id_manga'] : '';
        $n_cap = isset($_GET['n_cap']) ? $_GET['n_cap'] : '';

        
        $manga = Container::getModel('Mangas');
        $user = Container::getModel('Usuario');
        session_start();
        
        if(isset($_SESSION['id'])) {
            $manga->__set('id', $_SESSION['id']);
            $user->__set('id', $_SESSION['id']);
        }

        $manga->__set('id_manga', $id_manga);
        $user->__set('id_manga', $id_manga);
        $manga->__set('n_cap', $n_cap);
        $user->__set('n_cap', $n_cap);

        $manga->addView();

        if(isset($_SESSION['id'])) {
            $mangaI = $manga->getForName();
            $manga->__set('nome', $mangaI['nome']);
            $mangaCountH = $manga->checkHist();

            if($mangaCountH['count'] == 0) {
                $manga->saveHist();
                $nivel = $user->getNivel();
                if($nivel['nivel'] < 50) {
                    $nivel['nivel'] += 0.6;

                } else if($nivel['nivel'] < 200) {
                    $nivel['nivel'] += 0.4;

                } else if($nivel['nivel'] < 400) {
                    $nivel['nivel'] += 0.2;

                } else if($nivel['nivel'] < 600) {
                    $nivel['nivel'] += 0.1;

                } else if($nivel['nivel'] < 800) {
                    $nivel['nivel'] += 0.05;

                } else if($nivel['nivel'] < 1000) {
                    $nivel['nivel'] += 0.05;
                }

                $user->sumNivel($nivel['nivel']);
            }
           
        }

        $this->view->lei = $manga->getLei();
        $this->view->capTotal = $manga->getAllCap();
        $this->view->capF = $manga->getCapF();
        $this->view->capI = $manga->getCap();

        if(!isset($this->view->capI['n_cap'])) {
            header('Location: /error_404');
        } else {
            $this->view->pagesI = $manga->getPages($this->view->capI['n_cap']);
            $this->view->mangaI = $manga->getManga();
            $this->view->listando = $manga->getUserFila();

            $this->render('paginas');
        }

       
    }

    public function prev_page() {
        session_start();
        $id_manga = isset($_GET['id_manga']) ? $_GET['id_manga'] : '';
        $n_cap = isset($_GET['n_cap']) ? $_GET['n_cap'] : '';

        $manga = Container::getModel('Mangas');
        $user = Container::getModel('Usuario');

        if($_SESSION['id'] != '') {
            $manga->__set('id', $_SESSION['id']);
            $user->__set('id', $_SESSION['id']);
        }

        $manga->__set('id_manga', $id_manga);
        $user->__set('id_manga', $id_manga);
        $manga->__set('n_cap', $n_cap);

        if($_SESSION['id'] != '') {
            $mangaI = $manga->getForName();
            $manga->__set('nome', $mangaI['nome']);
            $mangaCountH = $manga->checkHist();

            if($mangaCountH['count'] == 0) {
                $manga->saveHist();

                $nivel = $user->getNivel();
                if($nivel['nivel'] < 50) {
                    $nivel['nivel'] += 0.6;

                } else if($nivel['nivel'] < 200) {
                    $nivel['nivel'] += 0.4;

                } else if($nivel['nivel'] < 400) {
                    $nivel['nivel'] += 0.2;

                } else if($nivel['nivel'] < 600) {
                    $nivel['nivel'] += 0.1;

                } else if($nivel['nivel'] < 800) {
                    $nivel['nivel'] += 0.05;

                } else if($nivel['nivel'] < 1000) {
                    $nivel['nivel'] += 0.05;
                }

                $user->sumNivel($nivel['nivel']);
            } 
        }

        $this->view->lei = $manga->getLei();
        $this->view->capTotal = $manga->getAllCap();
        $this->view->capF = $manga->getCapF();
        $this->view->capI = $manga->getCapPrev();

        if(!isset($this->view->capI['n_cap'])) {
            header('Location: /error_404');
        } else {
            $this->view->pagesI = $manga->getPages($this->view->capI['n_cap']);
            $this->view->mangaI = $manga->getManga();
            $this->view->listando = $manga->getUserFila();

            $user->__set('n_cap', $this->view->capI['n_cap']);

            $this->render('paginas');
        }
    }

    public function next_page() {
        session_start();
        $id_manga = isset($_GET['id_manga']) ? $_GET['id_manga'] : '';
        $n_cap = isset($_GET['n_cap']) ? $_GET['n_cap'] : '';

        $manga = Container::getModel('Mangas');
        $user = Container::getModel('Usuario');

        if($_SESSION['id'] != '') {
            $manga->__set('id', $_SESSION['id']);
            $user->__set('id', $_SESSION['id']);
        }

        $manga->__set('id_manga', $id_manga);
        $user->__set('id_manga', $id_manga);
        $manga->__set('n_cap', $n_cap);

        if($_SESSION['id'] != '') {
            $mangaI = $manga->getForName();
            $manga->__set('nome', $mangaI['nome']);
            $mangaCountH = $manga->checkHist();

            if($mangaCountH['count'] == 0) {
                $manga->saveHist();

                $nivel = $user->getNivel();
                if($nivel['nivel'] < 50) {
                    $nivel['nivel'] += 0.6;

                } else if($nivel['nivel'] < 200) {
                    $nivel['nivel'] += 0.4;

                } else if($nivel['nivel'] < 400) {
                    $nivel['nivel'] += 0.2;

                } else if($nivel['nivel'] < 600) {
                    $nivel['nivel'] += 0.1;

                } else if($nivel['nivel'] < 800) {
                    $nivel['nivel'] += 0.05;

                } else if($nivel['nivel'] < 1000) {
                    $nivel['nivel'] += 0.05;
                }

                $user->sumNivel($nivel['nivel']);

            } 
        }

        
        $this->view->lei = $manga->getLei();
        $this->view->capTotal = $manga->getAllCap();
        $this->view->capF = $manga->getCapF();
        $this->view->capI = $manga->getCapNext();

        if(!isset($this->view->capI['n_cap'])) {
            header('Location: /error_404');
        } else {
            $this->view->pagesI = $manga->getPages($this->view->capI['n_cap']);
            $this->view->mangaI = $manga->getManga();
            $this->view->listando = $manga->getUserFila();

            $user->__set('n_cap', $this->view->capI['n_cap']);

            $this->render('paginas');
        }
    }

    public function updateLei() {
        session_start();
        $lei = isset($_GET['leitura']) ? $_GET['leitura'] : '';
        $usuario = Container::getModel('Usuario');
        
        $usuario->__set('id', $_SESSION['id']);
        $usuario->__set('leitura', $lei);

        $usuario->updateLei();
        
    }

    public function updateClass() {
        session_start();
        $class = isset($_GET['class']) ? $_GET['class'] : '';
        $usuario = Container::getModel('Usuario');

        $usuario->__set('id', $_SESSION['id']);
        $usuario->__set('class', $class);

        $usuario->updateClass();


    }

    public function updateTitle() {
        session_start();
        $title = isset($_GET['titulo']) ? $_GET['titulo'] : '';
        $usuario = Container::getModel('Usuario');
        
        $usuario->__set('id', $_SESSION['id']);

        if($title == "null") {
            $usuario->__set('titulo', null);
        } else {
            $usuario->__set('titulo', $title);
        }
        
        $usuario->updateTitle();
        
    }

    public function altEmail() {
        session_start();
        $usuario = Container::getModel('Usuario');

        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        $usuario->__set('id', $_SESSION['id']);
        $usuario->__set('emailN', $dados['emailN']);
        $usuario->__set('senha', $dados['senha']);
        $usuario->altEmail();
        
    }

    public function altSenha() {
        session_start();
        $usuario = Container::getModel('Usuario');

        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if($dados['senhaN'] == $dados['senhaR']) {
            $usuario->__set('id', $_SESSION['id']);
            $usuario->__set('senha', $dados['senha']);
            $usuario->__set('senhaN', password_hash($dados['senhaN'], PASSWORD_DEFAULT));
            $usuario->altSenha();
        } else {
            $resp =  ['status' => false, 'msg'=> "Senhas Diferentes!"];
            echo json_encode($resp);
        }
        
    }

    public function updateIcone() {
        session_start();
        $icone = isset($_GET['icone']) ? $_GET['icone'] : '';

        $usuario = Container::getModel('Usuario');

        $usuario->__set('id', $_SESSION['id']);
        $usuario->__set('icone', $icone);
        $usuario->updateIcone();
        $_SESSION['icone'] = $icone;

        header('Location: /profile');
    }


    public function updateBack() {
        session_start();
        $back = isset($_GET['back']) ? $_GET['back'] : '';

        $usuario = Container::getModel('Usuario');

        $usuario->__set('id', $_SESSION['id']);
        $usuario->__set('back', $back);
        $usuario->updateBack();
        $_SESSION['bg'] = $back;

        header('Location: /profile');
    }

    public function aleatorio() {
        $manga = Container::getModel('Mangas');
        $mangaT = $manga->aleatorio();
        $mangaCount = $manga->getCountManga();

        $key_mangaT = rand(0, $mangaCount['count_manga'] - 1);
        
        do {
            $check = 0;
            if($mangaT[$key_mangaT]) {
                $mangaI = $mangaT[$key_mangaT];
                $check = 1;
            } else {
                $key_mangaT = rand(0, $mangaCount['count_manga'] - 1);
            }
        } while($check == 0);

        header("Location: /manga?id_manga=$mangaI[id]");
    }

    public function error_404() {
        session_start();
        
        $nBG = rand(1, 30);
        $bg = 'bg-' . $nBG . '.avif';

        $this->view->bg = $bg;

        $this->render('error_404');
    }

    public function categorias() {
        session_start();
        $status = isset($_GET['status']) ? $_GET['status'] : '';
        $genero = isset($_GET['genero']) ? $_GET['genero'] : '';

        $manga = Container::getModel('Mangas');
        $user = Container::getModel('Usuario');

        //variaveis de paginação
        $this->view->max_links = $max_links = 2;
        $limit = 30;
        $this->view->page_atual = $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page - 1) * $limit;;
    
        $this->view->active = $page;
        
        if($status != '') {
            if($status == "MeAv") {
                $statusAlt = "Melhores Avaliados";
                $manga->__set('categoria', $statusAlt);
                $mangaCount = $manga->getCountStatus();
                $this->view->limitF = ceil($mangaCount['count_manga'] / $limit);
                $this->view->mangaI = $manga->getMeAv();
                $this->view->categoriaI = $manga->getCategoria();

                if(isset($_SESSION['id'])) {
                    $user->__set('id', $_SESSION['id']);
                    $this->view->class = $user->getClass();
                }
                
            } else if($status == "Recem") {
                $statusAlt = "Recém Atualizados";
                $manga->__set('categoria', $statusAlt);
                $mangaCount = $manga->getCountStatus();
                $this->view->limitF = ceil($mangaCount['count_manga'] / $limit);
                $this->view->mangaI = $manga->getStatusAlt($limit, $offset);
                $this->view->categoriaI = $manga->getCategoria();

                if(isset($_SESSION['id'])) {
                    $user->__set('id', $_SESSION['id']);
                    $this->view->class = $user->getClass();
                }

            } else {
                $this->view->status = $status;
                $manga->__set('categoria', $status);
            
                $mangaCount = $manga->getCountStatus();
                $this->view->limitF = ceil($mangaCount['count_manga'] / $limit);
                $this->view->mangaI = $manga->getStatus($limit, $offset);
                $this->view->categoriaI = $manga->getCategoria();
    
                if(isset($_SESSION['id'])) {
                    $user->__set('id', $_SESSION['id']);
                    $this->view->class = $user->getClass();
                }
            }

        } else if($genero != '') {
            $this->view->genero = $genero;
            $manga->__set('categoria', $genero);
            
            $mangaCount = $manga->getCountGenero();
            $this->view->limitF = ceil($mangaCount['count_manga'] / $limit);

            $this->view->mangaI = $manga->getGenero($limit, $offset);
            $this->view->categoriaI = $manga->getCategoria();
            $this->view->class = $user->getClass();

            if(isset($_SESSION['id'])) {
                $user->__set('id', $_SESSION['id']);
                $this->view->class = $user->getClass();
            }
        }
        
        $this->render('categoria');
    }

    public function baixar() {
        session_start();
        if($_SESSION['id'] != '' && $_SESSION['nome'] != '') { 
        $n_cap = isset($_GET['n_cap']) ? $_GET['n_cap'] : '';
        $id_manga = isset($_GET['id_manga']) ? $_GET['id_manga'] : '';

        $manga = Container::getModel('Mangas');

        $manga->__set('id_manga', $id_manga);
        $manga->__set('n_cap', $n_cap);
        $pagesI = $manga->getPages($n_cap);

        include_once("DownloadController.php");
        
    } else {
        header("Location: /login");
    }
}

    //Partials -----------------------------

    public function preferences() {
        session_start();
        if($_SESSION['id'] != '' && $_SESSION['nome'] != '') { 

            $this->render('preferences');
        }
    }
            
        
    public function requestPartialAdmin() {
        $partial = isset($_GET['partial']) ? $_GET['partial'] : '';

        session_start();
        if($_SESSION['id'] != '' && $_SESSION['nome'] != '') {
            if($partial == 'imgEdit') {
                $admin = Container::getModel('Mangas');
                $this->view->mangas = $admin->getNome();

                

                $this->render('partials_admin/imgEdit');
            }

            if($partial == 'bgEdit') {
                $admin = Container::getModel('Mangas');
                $this->view->mangas = $admin->getNome();

                $this->render('partials_admin/bgEdit');
            }

            if($partial == 'nomeEdit') {
                $admin = Container::getModel('Mangas');
                $this->view->mangas = $admin->getNome();

                $this->render('partials_admin/nomeEdit');
            }

            if($partial == 'generoEdit') {
                $admin = Container::getModel('Mangas');
                $this->view->generos = $admin->getAllGeneros();
                $this->view->mangas = $admin->getNome();

                $this->render('partials_admin/generoEdit');
            }

            if($partial == 'statusEdit') {
                $admin = Container::getModel('Mangas');
                $this->view->status = $admin->getAllStatus();
                $this->view->mangas = $admin->getNome();
                
                $this->render('partials_admin/statusEdit');
            }

            if($partial == 'anoEdit') {
                $admin = Container::getModel('Mangas');
                $this->view->mangas = $admin->getNome();
                
                $this->render('partials_admin/anoEdit');
            }

            if($partial == 'sinopseEdit') {
                $admin = Container::getModel('Mangas');
                $this->view->mangas = $admin->getNome();
                
                $this->render('partials_admin/sinopseEdit');
            }

            if($partial == 'tipoEdit') {
                $admin = Container::getModel('Mangas');
                $this->view->mangas = $admin->getNome();
                
                $this->render('partials_admin/tipoEdit');
            }

            if($partial == 'nomeCatEdit') {
                $admin = Container::getModel('Mangas');
                $this->view->categorias = $admin->getAllCategorias();
                
                $this->render('partials_admin/nomeCatEdit');
            }

            if($partial == 'descEdit') {
                $admin = Container::getModel('Mangas');
                $this->view->categorias = $admin->getAllCategorias();
                
                $this->render('partials_admin/descEdit');
            }

            if($partial == 'select_cap') {
                $admin = Container::getModel('Admin');

                $pesquisarCap = isset($_GET['pesquisarCap']) ? $_GET['pesquisarCap'] : '';

                $cap = Container::getModel('Admin');

                $cap->__set('id_manga', $pesquisarCap);
                $this->view->cap = $cap->getCapAdmin();

                $this->render('partials_admin/select_cap');
            }

            if($partial == 'addManga') {
                $manga = Container::getModel('Mangas');
                
                $this->view->status = $manga->getAllStatus();
                $this->view->generos = $manga->getAllGeneros();
                $this->render('partials_admin/addManga');
            }

            if($partial == 'denuncias') {
                $admin = Container::getModel('Admin');
                $this->view->denuncias = $admin->getDenuncias();
                $this->render('partials_admin/denuncias');
            }

            if($partial == 'deletManga') {
                $manga = Container::getModel('Mangas');

                $this->view->mangas = $manga->getNome();
                $this->render('partials_admin/deletManga');
            }

            if($partial == 'editManga') {
                $manga = Container::getModel('Mangas');

                $this->view->mangas = $manga->getNome();
                $this->view->status = $manga->getAllStatus();
                $this->view->generos = $manga->getAllGeneros();
                $this->render('partials_admin/editManga');
            }

            if($partial == 'addCap') {
                $manga = Container::getModel('Mangas');
                $this->view->scans = $manga->getScans();
                $this->view->mangas = $manga->getNome();

                $this->render('partials_admin/addCap');
            }

            if($partial == 'editCap') {
                $manga = Container::getModel('Mangas');
                $this->view->mangas = $manga->getNome();

                $this->render('partials_admin/editCap');
            }

            if($partial == 'deletCap') {
                $manga = Container::getModel('Mangas');
                $admin = Container::getModel('Admin');
                $this->view->mangas = $manga->getNome();

                $this->render('partials_admin/deletCap');
            }

            if($partial == 'addIcone') {
                $this->render('partials_admin/addIcone');
            }

            if($partial == 'deletIcone') {
                $user = Container::getModel('Usuario');

                $this->view->icones = $user->getIcones();
                $this->render('partials_admin/deletIcone');
            }
            
            if($partial == 'addBg') {
                $this->render('partials_admin/addBg');
            }

            if($partial == 'deletBg') {
                $user = Container::getModel('Usuario');
                $this->view->back = $user->getBack();
                $this->render('partials_admin/deletBg');
            }

            if($partial == 'addCat') {
                $this->render('partials_admin/addCat');
            }

            if($partial == 'editCat') {
                $this->render('partials_admin/editCat');
            }

            if($partial == 'deletCat') {
                $manga = Container::getModel('Mangas');
                $this->view->categorias = $manga->getAllCategorias();
                $this->render('partials_admin/deletCat');
            }

            if($partial == 'addTitle') {
                $this->render('partials_admin/addTitle');
            }

            if($partial == 'editTitle') {
                $user = Container::getModel('Usuario');
                $this->view->title = $user->getTitle();
                $this->render('partials_admin/editTitle');
            }

            if($partial == 'titleEdit') {
                $user = Container::getModel('Usuario');
                $this->view->title = $user->getTitle();
                $this->render('partials_admin/titleEdit');
            }

            if($partial == 'nivelEdit') {
                $user = Container::getModel('Usuario');
                $this->view->title = $user->getTitle();
                $this->render('partials_admin/nivelEdit');
            }

            if($partial == 'deletTitle') {
                $user = Container::getModel('Usuario');
                $this->view->title = $user->getTitle();
                $this->render('partials_admin/deletTitle');
            }

            if($partial == 'addScan') {
                $this->render('partials_admin/addScan');
            }

            if($partial == 'editScan') {
                $this->render('partials_admin/editScan');
            }

            if($partial == 'nomeScanEdit') {
                $scan = Container::getModel('Admin');
                $this->view->scans = $scan->getScans();

                $this->render('partials_admin/nomeScanEdit');
            }

            if($partial == 'logoScanEdit') {
                $scan = Container::getModel('Admin');
                $this->view->scans = $scan->getScans();

                $this->render('partials_admin/logoScanEdit');
            }

            if($partial == 'siteScanEdit') {
                $scan = Container::getModel('Admin');
                $this->view->scans = $scan->getScans();

                $this->render('partials_admin/siteScanEdit');
            }

            if($partial == 'facebookScanEdit') {
                $scan = Container::getModel('Admin');
                $this->view->scans = $scan->getScans();

                $this->render('partials_admin/facebookScanEdit');
            }

            if($partial == 'discordScanEdit') {
                $scan = Container::getModel('Admin');
                $this->view->scans = $scan->getScans();

                $this->render('partials_admin/discordScanEdit');
            }
            
            if($partial == 'twitterScanEdit') {
                $scan = Container::getModel('Admin');
                $this->view->scans = $scan->getScans();

                $this->render('partials_admin/twitterScanEdit');
            }

            if($partial == 'doarScanEdit') {
                $scan = Container::getModel('Admin');
                $this->view->scans = $scan->getScans();

                $this->render('partials_admin/doarScanEdit');
            }

            if($partial == 'deletScan') {
                $scan = Container::getModel('Admin');
                $this->view->scans = $scan->getScans();

                $this->render('partials_admin/deleteScan');
            }


        }
    }
}

    



?>