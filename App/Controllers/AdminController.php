<?php

namespace App\Controllers;

use App\Models\Usuario;
use MF\Controller\Action;
use MF\Model\Container;

class AdminController extends Action {

    public function addManga() {
        $manga = Container::getModel('Admin');
        if(isset($_FILES['arquivo']) && isset($_FILES['back'])) {

            $arquivo = $_FILES['arquivo'];
            $back = $_FILES['back'];

            if($arquivo['error'] || $back['error']) {
                die('Falha ao enviar Arquivo!');
            }
        
            if($arquivo['size'] > 2097152 || $back['size'] > 2097152) {
                die('Arquivo Muito grande, Máx: 2MB');
            }

            $pasta = "img/arquivos/mangas/";
            $nomeDoArquivo = $arquivo['name'];
            $nomeDoBack = $back['name'];
            $novoNomeDoArquivo = uniqid();
            $novoNomeDoBack = uniqid();
            $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));
            $extensaoBack = strtolower(pathinfo($nomeDoBack, PATHINFO_EXTENSION));
            
            if($extensao != 'webp' && $extensao != 'avif' && $extensao != 'jpg' && $extensao != 'jpeg' && $extensaoBack != 'webp' && $extensaoBack != 'avif' && $extensaoBack != 'jpg' && $extensaoBack != 'jpeg') {
                die('Extensão não suportada! (Apenas .webp | .avif | .jpg | .jpeg)');
            } 

            $path = $pasta . $novoNomeDoArquivo . '.avif';
            $pathBack = $pasta . $novoNomeDoBack . '.avif';
            
            switch($extensao):
                case "webp":
                    $image = imagecreatefromwebp($arquivo['tmp_name']);
                    imageavif($image, $path, 72, 4);
                    break;
                case "avif":
                    $image = imagecreatefromavif($arquivo['tmp_name']);
                    imageavif($image, $path, 72, 4);
                    break;
                case "jpg":
                    $image = imagecreatefromjpeg($arquivo['tmp_name']);
                    imageavif($image, $path, 72, 4);
                    break;
                case "jpeg":
                    $image = imagecreatefromjpeg($arquivo['tmp_name']);
                    imageavif($image, $path, 72, 4);
                    break;
            endswitch;

            //Liberar memória
            imagedestroy($image);

            switch($extensaoBack):
                case "webp":
                    $image = imagecreatefromwebp($back['tmp_name']);
                    imageavif($image, $pathBack, 72, 4);
                    break;
                case "avif":
                    $image = imagecreatefromavif($back['tmp_name']);
                    imageavif($image, $pathBack, 72, 4);
                    break;
                case "jpg":
                    $image = imagecreatefromjpeg($back['tmp_name']);
                    imageavif($image, $pathBack, 72, 4);
                    break;
                case "jpeg":
                    $image = imagecreatefromjpeg($back['tmp_name']);
                    imageavif($image, $pathBack, 72, 4);
                    break;
            endswitch;

            //Liberar memória
            imagedestroy($image);

            $manga->__set('path', $path);
            $manga->__set('pathB', $pathBack);
            $manga->__set('nome', $_POST['nome']);
            $manga->__set('tipo', $_POST['tipo']);
            $manga->__set('genero1', $_POST['genero1']);
            $manga->__set('genero2', $_POST['genero2']);
            $manga->__set('genero3', $_POST['genero3']);
            $manga->__set('ano_lanc', $_POST['ano_lanc']);
            $manga->__set('sinopse', $_POST['sinopse']);
            $manga->__set('status', $_POST['status']);
            $manga->__set('class', $_POST['class']);
            $manga->salvar(); //Função em Admin.php
            header('Location: /gerenciar_home');
            
        }
    }

    public function editTitle() {
        $admin = Container::getModel('Admin');

        $admin->__set('id', $_POST['id_titulo']);
        $admin->__set('tituloN', $_POST['tituloN']);

        $admin->editTitle();

        header('Location: /gerenciar_home');
    }

    public function editNivel() {
        $admin = Container::getModel('Admin');

        $admin->__set('id', $_POST['id_titulo']);
        $admin->__set('nivelN', $_POST['nivelN']);

        $admin->editNivel();

        header('Location: /gerenciar_home');
    }

    public function removerTitle() {
        $admin = Container::getModel('Admin');

        $admin->__set('id', $_POST['id_titulo']);

        $admin->removerTitle();

        header('Location: /gerenciar_home');
    }


    public function acaoAdmin() {
        $manga = Container::getModel('Admin');
        $acaoAdmin = isset($_GET['acaoAdmin']) ? $_GET['acaoAdmin'] : '';
        //--------------------------------------------------------------------


        if($acaoAdmin == "updatePath") {
            $manga->__set('id_manga', $_POST['id_manga']);
            $mangaI = $manga->selectPathsManga();

            foreach($mangaI as $indice_arr => $mangaI) { 
                unlink($mangaI['path']);
            }


            if(isset($_FILES['arquivo'])) {
            
                $arquivo = $_FILES['arquivo'];
                
                if($arquivo['error']) {
                    die('Falha ao enviar Arquivo!');
                }

                if($arquivo['size'] > 1097152) {
                    die('Arquivo muito grande, Máx: 1MB');
                }

                $pasta = "img/arquivos/mangas/";
                $nomeDoArquivo = $arquivo['name'];
                $novoNomeDoArquivo = uniqid();
                $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));
                
                if($extensao != 'webp' && $extensao != 'avif' && $extensao != 'jpg' && $extensao != 'jpeg') {
                    die('Extensão não suportada! (Apenas .webp | .avif | .jpg | .jpeg)');
                }

                $path = $pasta . $novoNomeDoArquivo . '.avif';
                
                switch($extensao):
                    case "webp":
                        $image = imagecreatefromwebp($arquivo['tmp_name']);
                        imageavif($image, $path, 72, 4);
                        break;
                    case "avif":
                        $image = imagecreatefromavif($arquivo['tmp_name']);
                        imageavif($image, $path, 72, 4);
                        break;
                    case "jpg":
                        $image = imagecreatefromjpeg($arquivo['tmp_name']);
                        imageavif($image, $path, 72, 4);
                        break;
                    case "jpeg":
                        $image = imagecreatefromjpeg($arquivo['tmp_name']);
                        imageavif($image, $path, 72, 4);
                        break;
                endswitch;

		        //Liberar memória
		        imagedestroy($image);

                //move_uploaded_file($arquivo['tmp_name'], $path);

                $manga->__set('path', $path);
                $manga->updatePath();
            } 
       
            
    } else if($acaoAdmin == "updatePathB") {
        $manga->__set('id_manga', $_POST['id_manga']);
        $mangaI = $manga->selectPathsManga();

        foreach($mangaI as $indice_arr => $mangaI) { 
            unlink($mangaI['pathB']);
        }

        if(isset($_FILES['back'])) {

            $back = $_FILES['back'];

            if($back['error']) {
                die('Falha ao enviar Arquivo!');
            }

            if($back['size'] > 1097152) {
                die('Arquivo muito grande, Máx: 1MB');
            }

            $pasta = "img/arquivos/mangas/";
            $nomeDoBack = $back['name'];
            $novoNomeDoBack = uniqid();
            $extensaoBack = strtolower(pathinfo($nomeDoBack, PATHINFO_EXTENSION));
            

            if($extensaoBack != 'webp' && $extensaoBack != 'avif' && $extensaoBack != 'jpg' && $extensaoBack != 'jpeg') {
                die('Extensão não suportada! (Apenas .webp | .avif | .jpg | .jpeg)');
            }

            $pathBack = $pasta . $novoNomeDoBack . '.avif';
            
            switch($extensaoBack):
                case "webp":
                    $image = imagecreatefromwebp($back['tmp_name']);
                    imageavif($image, $pathBack, 72, 4);
                    break;
                case "avif":
                    $image = imagecreatefromavif($back['tmp_name']);
                    imageavif($image, $pathBack, 72, 4);
                    break;
                case "jpg":
                    $image = imagecreatefromjpeg($back['tmp_name']);
                    imageavif($image, $pathBack, 72, 4);
                    break;
                case "jpeg":
                    $image = imagecreatefromjpeg($back['tmp_name']);
                    imageavif($image, $pathBack, 72, 4);
                    break;
            endswitch;

            //Liberar memória
            imagedestroy($image);

            //move_uploaded_file($back['tmp_name'], $pathBack);

            $manga->__set('pathB', $pathBack);
            $manga->updatePathB(); //Função em Admin.php
        }

    } else if($acaoAdmin == "updateNome") {
        $manga->__set('id_manga', $_POST['id_manga']);
        $manga->__set('nomeN', $_POST['nomeN']);
        $manga->updateNome();

    } else if($acaoAdmin == "updateGenero") {
        $manga->__set('id_manga', $_POST['id_manga']);
        $manga->__set('genero1N', $_POST['genero1N']);
        $manga->__set('genero2N', $_POST['genero2N']);
        $manga->__set('genero3N', $_POST['genero3N']);
        $manga->updateGenero();

    } else if($acaoAdmin == "updateStatus") {
        $manga->__set('id_manga', $_POST['id_manga']);
        $manga->__set('statusN', $_POST['statusN']);
        $manga->updateStatus();

    } else if($acaoAdmin == "updateAno_lanc") {
        $manga->__set('id_manga', $_POST['id_manga']);
        $manga->__set('ano_lancN', $_POST['ano_lancN']);
        $manga->updateAno_lanc();

    } else if($acaoAdmin == "updateSinopse") {
        $manga->__set('id_manga', $_POST['id_manga']);
        $manga->__set('sinopseN', $_POST['sinopseN']);
        $manga->updateSinopse();

    } else if($acaoAdmin == "updateNomeCategoria") {
        $manga->__set('id_categoria', $_POST['id_categoria']);
        $manga->__set('nomeN', $_POST['nomeN']);
        $manga->updateNomeCategoria();

    } else if($acaoAdmin == "updateDescricaoCategoria") {
        $manga->__set('id_categoria', $_POST['id_categoria']);
        $manga->__set('descricaoN', $_POST['descricaoN']);
        $manga->updateDescricaoCategoria();
    }
    else if($acaoAdmin == "updateTipo") {
        $manga->__set('id_manga', $_POST['id_manga']);
        $manga->__set('tipo', $_POST['tipo']);
        $manga->updateTipo();
    }

    else if($acaoAdmin == "updateNomeScan") {
        $manga->__set('idScan', $_POST['idScan']);
        $manga->__set('nomeN', $_POST['nomeN']);

        $manga->updateNomeScan();
    }

    if($acaoAdmin == "updateLogo") {
        $manga->__set('idLogo', $_POST['idLogo']);
        $logoI = $manga->selectLogoScan();

        foreach($logoI as $indice_arr => $logoI) { 
            unlink($logoI['logo']);
        }


        if(isset($_FILES['arquivo'])) {
        
            $arquivo = $_FILES['arquivo'];
            
            if($arquivo['error']) {
                die('Falha ao enviar Arquivo!');
            }

            if($arquivo['size'] > 1097152) {
                die('Arquivo muito grande, Máx: 1MB');
            }

            $pasta = "img/arquivos/scans/";
            $nomeDoArquivo = $arquivo['name'];
            $novoNomeDoArquivo = uniqid();
            $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));
            
            if($extensao != 'webp' && $extensao != 'avif' && $extensao != 'jpg' && $extensao != 'jpeg' && $extensao != 'png') {
                die('Extensão não suportada! (Apenas .webp | .avif | .jpg | .jpeg | .jpg | .png)');
            }

            $path = $pasta . $novoNomeDoArquivo . '.' . $extensao;

            move_uploaded_file($arquivo['tmp_name'], $path);

            $manga->__set('path', $path);
            $manga->updateLogo();
        }      
}

    if($acaoAdmin == "updateSiteScan") {
        $manga->__set('idScan', $_POST['idScan']);
        $manga->__set('siteN', $_POST['siteN']);
        $manga->updateSiteScan();

    }

    if($acaoAdmin == "updateFacebookScan") {
        $manga->__set('idScan', $_POST['idScan']);
        $manga->__set('facebookN', $_POST['facebookN']);
        $manga->updateFacebookScan();
        
    }

    if($acaoAdmin == "updateDiscordScan") {
        $manga->__set('idScan', $_POST['idScan']);
        $manga->__set('discordN', $_POST['discordN']);
        $manga->updateDiscordScan();
        
    }

    if($acaoAdmin == "updateTwitterScan") {
        $manga->__set('idScan', $_POST['idScan']);
        $manga->__set('twitterN', $_POST['twitterN']);
        $manga->updateTwitterScan();
        
    }

    if($acaoAdmin == "updateDoarScan") {
        $manga->__set('idScan', $_POST['idScan']);
        $manga->__set('doarN', $_POST['doarN']);
        $manga->updateDoarScan();
        
    }
    

    header('Location: /gerenciar_home');
}

    public function removerManga() {
        $manga = Container::getModel('Admin');
        $manga->__set('id_manga', $_POST['id_manga']);

        $pathsI = $manga->selectPathsManga();
        $pagesI = $manga->selectPagesManga();

        foreach($pathsI as $indice_arr => $paths) { 
            unlink($paths['path']);
            unlink($paths['pathB']);
        }

        foreach($pagesI as $indice_arr => $pages) { 
            unlink($pages['paths']);
        }

        $manga->removerManga();
        $manga->removerMangaCap();
        $manga->removerMangaPag();
        $manga->removerMangaAvals();
        $manga->removerMangaFila();
        $manga->removerMangaListas();
        header('Location: /gerenciar_home');
    }

    public function addTitle() {
        $admin = Container::getModel('Admin');

        $admin->__set('nome',$_POST['nome']);
        $admin->__set('nivel',$_POST['nivel']);

        $admin->addTitle();

        header('Location: /gerenciar_home');
    }

    public function addScan() {
        $admin = Container::getModel('Admin');

        if(isset($_FILES['arquivo'])) {

            $arquivo = $_FILES['arquivo'];

            if($arquivo['error']) {
                die('Falha ao enviar Arquivo!');
            }
        
            if($arquivo['size'] > 1097152) {
                die('Arquivo Muito grande, Máx: 1MB');
            }

            $pasta = "img/arquivos/scans/";
            $nomeDoArquivo = $arquivo['name'];
            
            $novoNomeDoArquivo = uniqid();
            
            $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));
            
            

            if($extensao != 'webp' && $extensao != 'avif' && $extensao != 'jpg' && $extensao != 'jpeg' && $extensao != 'png') {
                die('Extensão não suportada! (Apenas .webp | .avif | .jpg | .jpeg | .jpg | .png)');
            }

            $path = $pasta . $novoNomeDoArquivo . '.' . $extensao;

            move_uploaded_file($arquivo['tmp_name'], $path);


        $admin->__set('path', $path); 
        $admin->__set('nome',$_POST['nome']);
        $admin->__set('site',$_POST['site']);
        $admin->__set('facebook',$_POST['facebook']);
        $admin->__set('discord',$_POST['discord']);
        $admin->__set('twitter',$_POST['twitter']);
        $admin->__set('doar',$_POST['doar']);

        $admin->addScan();

        header('Location: /gerenciar_home');
    }
}

    public function addCap() {
            function enviarArquivos($error, $name, $tmp_name) {
                $cap = Container::getModel('Admin');
                
                if($error) {
                    die('Falha ao enviar Arquivo!');
                }
    
                $pasta = "img/arquivos/paginas/";
                $nomeDoArquivo = $name;
                $novoNomeDoArquivo = uniqid();
                $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));
               
                if($extensao != 'webp' && $extensao != 'avif' && $extensao != 'jpg' && $extensao != 'jpeg') {
                    die('Extensão não suportada! (Apenas .webp | .avif | .jpg | .jpeg)');
                }

                $path = "img/arquivos/paginas/" . $novoNomeDoArquivo . '.avif';
                
                switch($extensao):
                    case "webp":
                        $image = imagecreatefromwebp($tmp_name);
                        imageavif($image, $path, 52, 8);
                        imagedestroy($image);
                        break;
                    case "avif":
                        $image = imagecreatefromavif($tmp_name);
                        imageavif($image, $path, 52, 8);
                        imagedestroy($image);
                        break;
                    case "jpg":
                        $image = imagecreatefromjpeg($tmp_name);
                        imageavif($image, $path, 52, 8);
                        imagedestroy($image);
                        break;
                    case "jpeg":
                        $image = imagecreatefromjpeg($tmp_name);
                        imageavif($image, $path, 52, 8);
                        imagedestroy($image);
                        break;
                endswitch;
		        
                //move_uploaded_file($tmp_name, $path);

                $cap->__set('paths', $path);
                $cap->__set('id_manga', $_POST['id_manga']);
                $cap->__set('n_cap', $_POST['n_cap']);

                $cap->salvarP();
                
            }
            
            if(isset($_FILES['arquivo']) && count($_FILES) > 0) {
                $cap = Container::getModel('Admin');
                $arquivo = $_FILES['arquivo'];

                $cap->__set('n_cap', $_POST['n_cap']);
                $cap->__set('id_manga', $_POST['id_manga']);
                $cap->__set('fansub', $_POST['fansub']);

                $capCount = $cap->getCapCount();

                if($capCount['countCap'] == 0) {
                    $cap->salvarC();
                    $cap->addRecem();
                } else {
                    die('Capítulo já existe!');
                }

                foreach($arquivo['name'] as $index => $arq) {
                    enviarArquivos($arquivo['error'][$index], $arquivo['name'][$index], $arquivo['tmp_name'][$index]);
                }
                
            header('Location: /gerenciar_home');
            }
}

    public function editCap() {
        $cap = Container::getModel('Admin');
        $cap->__set('id_manga', $_POST['id_manga']);
        $cap->__set('n_cap', $_POST['n_cap']);
        $cap->__set('n_capN', $_POST['n_capN']);
        $cap->editPagCap();
        $cap->editCap();

        header("Location: /gerenciar_home");
    }

    public function removerCap() {
            $cap = Container::getModel('Admin');
            $cap->__set('id_manga', $_POST['id_manga']);
            $cap->__set('n_cap', $_POST['n_cap']);
    
            $capI = $cap->selectCapPags();

            foreach($capI as $indice_arr => $pages) { 
                unlink($pages['paths']);
            }

            $cap->removerCapPags();
            $cap->removerCap();
            
            header('Location: /gerenciar_home');
    }

    public function pesquisarCap() {
        $pesquisarCap = isset($_GET['pesquisarCap']) ? $_GET['pesquisarCap'] : '';

        $cap = Container::getModel('Admin');

        $cap->__set('id_manga', $pesquisarCap);
        $this->view->cap = $cap->getCapAdmin();


    }

    public function addIcone() {
        $admin = Container::getModel('Admin');
        if(isset($_FILES['arquivo'])) {

            $arquivo = $_FILES['arquivo'];

            if($arquivo['error']) {
                die('Falha ao enviar Arquivo!');
            }

            $pasta = "img/icones/";
            $nomeDoArquivo = $arquivo['name'];
            $novoNomeDoArquivo = uniqid();
            $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));
            
            if($extensao != 'webp' && $extensao != 'avif' && $extensao != 'jpg' && $extensao != 'jpeg') {
                die('Extensão não suportada! (Apenas .webp | .avif | .jpg | .jpeg)');
            }

            $path = $pasta . $novoNomeDoArquivo . '.avif';
            
            switch($extensao):
                case "webp":
                    $image = imagecreatefromwebp($arquivo['tmp_name']);
                    imageavif($image, $path, 72, 4);
                    break;
                case "avif":
                    $image = imagecreatefromavif($arquivo['tmp_name']);
                    imageavif($image, $path, 72, 4);
                    break;
                case "jpg":
                    $image = imagecreatefromjpeg($arquivo['tmp_name']);
                    imageavif($image, $path, 72, 4);
                    break;
                case "jpeg":
                    $image = imagecreatefromjpeg($arquivo['tmp_name']);
                    imageavif($image, $path, 72, 4);
                    break;
            endswitch;

            //Liberar memória
            imagedestroy($image);

            //move_uploaded_file($arquivo['tmp_name'], $path);

            $admin->__set('nome', $_POST['nome']);
            $admin->__set('path', $path);
            $admin->salvarIcone(); //Função em Admin.php
            header('Location: /gerenciar_home');
            
        }
    }

    public function removerIcone() {
        $id_icone = isset($_GET['id_icone']) ? $_GET['id_icone'] : '';
        $icone = Container::getModel('Admin');

        if($id_icone != '') {
            $icone->__set('id_icone', $id_icone);

            $iconeI = $icone->selectIcone();
            $icone->removerIcone();
    
            foreach($iconeI as $indice_arr => $icone) { 
                unlink($icone['path']);
            }
    
            header('Location: /gerenciar_home');
        }

        
    }


    public function addBack() {
        $admin = Container::getModel('Admin');
        if(isset($_FILES['arquivo'])) {

            $arquivo = $_FILES['arquivo'];

            if($arquivo['error']) {
                die('Falha ao enviar Arquivo!');
            }
        
            if($arquivo['size'] > 1097152) {
                die('Arquivo Muito grande, Máx: 2MB');
            }

            $pasta = "img/backgrounds/";
            $nomeDoArquivo = $arquivo['name'];
            $novoNomeDoArquivo = uniqid();
            $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));
            
            if($extensao != 'webp' && $extensao != 'avif' && $extensao != 'jpg' && $extensao != 'jpeg') {
                die('Extensão não suportada! (Apenas .webp | .avif | .jpg | .jpeg)');
            }

            $path = $pasta . $novoNomeDoArquivo . '.avif';
            
            switch($extensao):
                case "webp":
                    $image = imagecreatefromwebp($arquivo['tmp_name']);
                    imageavif($image, $path, 72, 4);
                    break;
                case "avif":
                    $image = imagecreatefromavif($arquivo['tmp_name']);
                    imageavif($image, $path, 72, 4);
                    break;
                case "jpg":
                    $image = imagecreatefromjpeg($arquivo['tmp_name']);
                    imageavif($image, $path, 72, 4);
                    break;
                case "jpeg":
                    $image = imagecreatefromjpeg($arquivo['tmp_name']);
                    imageavif($image, $path, 72, 4);
                    break;
            endswitch;

            //Liberar memória
            imagedestroy($image);

            //move_uploaded_file($arquivo['tmp_name'], $path);

            $admin->__set('nome', $_POST['nome']);
            $admin->__set('path', $path);
            $admin->salvarBack(); //Função em Admin.php
            header('Location: /gerenciar_home');
            
        }
    }

    public function removerBack() {
        $id_bg = isset($_GET['id_bg']) ? $_GET['id_bg'] : '';
        $back = Container::getModel('Admin');

        $back->__set('id_back', $id_bg);
        $backI = $back->selectBack();
        $back->removerBack();

        foreach($backI as $indice_arr => $back) { 
            unlink($back['path']);
        }
        
        header('Location: /gerenciar_home');
    }

    public function addCategoria() {
        $categoria = Container::getModel('Admin');

        $categoria->__set('nome', $_POST['nome']);
        $categoria->__set('tipo', $_POST['tipo']);
        $categoria->__set('descricao', $_POST['descricao']);
        $categoria->addCategoria();

        header('Location: /gerenciar_home');
    }

    public function removerCategoria() {
        $categoria = Container::getModel('Admin');

        $categoria->__set('id_categoria', $_POST['id_categoria']);
        $categoria->removerCategoria();

        header('Location: /gerenciar_home');
    }

    public function removerScan() {
        $categoria = Container::getModel('Admin');

        $categoria->__set('idScan', $_POST['idScan']);
        $categoria->removerScan();

        header('Location: /gerenciar_home');
    }

    public function deleteComment() {
        $id_comment = isset($_GET['id_comentario']) ? $_GET['id_comentario'] : '';
        $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';

        $comments = Container::getModel('Admin');

        if($tipo == 0) {
            $comments->__set('id', $id_comment);
            $comments->deleteDenuncia();
            $comments->deleteComment($tipo);
            $comments->deleteResposta($tipo);
        } else if($tipo == 1) {
            $comments->__set('id', $id_comment);
            $comments->deleteDenuncia();
            $comments->deleteComment($tipo);
        }

        header('Location: /gerenciar_home');
    }

    public function ignore() {
        $id_comment = isset($_GET['id_comentario']) ? $_GET['id_comentario'] : '';
        $comments = Container::getModel('Admin');
        $comments->__set('id', $id_comment);
        $comments->deleteDenuncia();

        header('Location: /gerenciar_home');
    }

}