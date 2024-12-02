<?php

namespace App;

use MF\Init\Bootstrap;

class Route extends Bootstrap {

	protected function initRoutes() {

		$routes['home'] = array(
			'route' => '/',
			'controller' => 'indexController',
			'action' => 'index'
		);

		$routes['gdTeste'] = array(
			'route' => '/gdTeste',
			'controller' => 'indexController',
			'action' => 'gdTeste'
		);
		
		$routes['login'] = array(
			'route' => '/login',
			'controller' => 'indexController',
			'action' => 'login'
		);

		$routes['login_google'] = array(
			'route' => '/login_google',
			'controller' => 'indexController',
			'action' => 'login_google'
		);

		$routes['register'] = array(
			'route' => '/register',
			'controller' => 'indexController',
			'action' => 'register'
		);

		$routes['registrar'] = array(
			'route' => '/registrar',
			'controller' => 'indexController',
			'action' => 'registrar'
		);

		$routes['autenticar'] = array(
			'route' => '/autenticar',
			'controller' => 'AuthController',
			'action' => 'autenticar'
		);

		$routes['profile'] = array(
			'route' => '/profile',
			'controller' => 'AppController',
			'action' => 'profile'
		);

		$routes['requestPartial'] = array(
			'route' => '/requestPartial',
			'controller' => 'AppController',
			'action' => 'requestPartial'
		);

		$routes['requestPartialAdmin'] = array(
			'route' => '/requestPartialAdmin',
			'controller' => 'AppController',
			'action' => 'requestPartialAdmin'
		);

		$routes['sair'] = array(
			'route' => '/sair',
			'controller' => 'AuthController',
			'action' => 'sair'
		);

		$routes['pesquisar'] = array(
			'route' => '/pesquisar',
			'controller' => 'AppController',
			'action' => 'pesquisar'
		);

		$routes['pesquisarCap'] = array(
			'route' => '/pesquisarCap',
			'controller' => 'AdminController',
			'action' => 'pesquisarCap'
		);

		$routes['sendEmail'] = array(
			'route' => '/sendEmail',
			'controller' => 'IndexController',
			'action' => 'sendEmail'
		);

		$routes['gerenciar_home'] = array(
			'route' => '/gerenciar_home',
			'controller' => 'AppController',
			'action' => 'gerenciar_home'
		);

		$routes['grupos'] = array(
			'route' => '/grupos',
			'controller' => 'AppController',
			'action' => 'grupos'
		);

		$routes['addManga'] = array(
			'route' => '/addManga',
			'controller' => 'AdminController',
			'action' => 'addManga'
		);

		$routes['removerManga'] = array(
			'route' => '/removerManga',
			'controller' => 'AdminController',
			'action' => 'removerManga'
		);

		$routes['addCap'] = array(
			'route' => '/addCap',
			'controller' => 'AdminController',
			'action' => 'addCap'
		);

		$routes['editCap'] = array(
			'route' => '/editCap',
			'controller' => 'AdminController',
			'action' => 'editCap'
		);


		$routes['removerCap'] = array(
			'route' => '/removerCap',
			'controller' => 'AdminController',
			'action' => 'removerCap'
		);

		$routes['addIcone'] = array(
			'route' => '/addIcone',
			'controller' => 'AdminController',
			'action' => 'addIcone'
		);

		$routes['removerIcone'] = array(
			'route' => '/removerIcone',
			'controller' => 'AdminController',
			'action' => 'removerIcone'
		);

		$routes['addBack'] = array(
			'route' => '/addBack',
			'controller' => 'AdminController',
			'action' => 'addBack'
		);

		$routes['removerBack'] = array(
			'route' => '/removerBack',
			'controller' => 'AdminController',
			'action' => 'removerBack'
		);

		$routes['addCategoria'] = array(
			'route' => '/addCategoria',
			'controller' => 'AdminController',
			'action' => 'addCategoria'
		);

		$routes['updateIcone'] = array(
			'route' => '/updateIcone',
			'controller' => 'AppController',
			'action' => 'updateIcone'
		);

		$routes['updateBack'] = array(
			'route' => '/updateBack',
			'controller' => 'AppController',
			'action' => 'updateBack'
		);

		$routes['acao'] = array(
			'route' => '/acao',
			'controller' => 'AppController',
			'action' => 'acao'
		);

		$routes['acaoAdmin'] = array(
			'route' => '/acaoAdmin',
			'controller' => 'AdminController',
			'action' => 'acaoAdmin'
		);

		$routes['lista'] = array(
			'route' => '/lista',
			'controller' => 'AppController',
			'action' => 'lista'
		);

		$routes['criarLista'] = array(
			'route' => '/criarLista',
			'controller' => 'AppController',
			'action' => 'criarLista'
		);

		$routes['lista_home'] = array(
			'route' => '/lista_home',
			'controller' => 'AppController',
			'action' => 'lista_home'
		);

		$routes['delete_hist'] = array(
			'route' => '/delete_hist',
			'controller' => 'AppController',
			'action' => 'delete_hist'
		);

		$routes['mangas'] = array(
			'route' => '/mangas',
			'controller' => 'AppController',
			'action' => 'mangas'
		);

		$routes['manga'] = array(
			'route' => '/manga',
			'controller' => 'AppController',
			'action' => 'manga'
		);

		$routes['capitulo'] = array(
			'route' => '/capitulo',
			'controller' => 'AppController',
			'action' => 'capitulo'
		);

		$routes['paginas'] = array(
			'route' => '/paginas',
			'controller' => 'AppController',
			'action' => 'paginas'
		);

		$routes['prev_page'] = array(
			'route' => '/prev_page',
			'controller' => 'AppController',
			'action' => 'prev_page'
		);

		$routes['next_page'] = array(
			'route' => '/next_page',
			'controller' => 'AppController',
			'action' => 'next_page'
		);

		$routes['updateLei'] = array(
			'route' => '/updateLei',
			'controller' => 'AppController',
			'action' => 'updateLei'
		);

		$routes['updateTitle'] = array(
			'route' => '/updateTitle',
			'controller' => 'AppController',
			'action' => 'updateTitle'
		);

		$routes['editTitle'] = array(
			'route' => '/editTitle',
			'controller' => 'AdminController',
			'action' => 'editTitle'
		);

		$routes['editNivel'] = array(
			'route' => '/editNivel',
			'controller' => 'AdminController',
			'action' => 'editNivel'
		);

		$routes['error_404'] = array(
			'route' => '/error_404',
			'controller' => 'AppController',
			'action' => 'error_404'
		);

		$routes['removerTitle'] = array(
			'route' => '/removerTitle',
			'controller' => 'AdminController',
			'action' => 'removerTitle'
		);

		$routes['addTitle'] = array(
			'route' => '/addTitle',
			'controller' => 'AdminController',
			'action' => 'addTitle'
		);

		$routes['addScan'] = array(
			'route' => '/addScan',
			'controller' => 'AdminController',
			'action' => 'addScan'
		);

		$routes['conf_email'] = array(
			'route' => '/conf_email',
			'controller' => 'IndexController',
			'action' => 'conf_email'
		);

		$routes['altEmail'] = array(
			'route' => '/altEmail',
			'controller' => 'AppController',
			'action' => 'altEmail'
		);

		$routes['altSenha'] = array(
			'route' => '/altSenha',
			'controller' => 'AppController',
			'action' => 'altSenha'
		);

		$routes['aval'] = array(
			'route' => '/aval',
			'controller' => 'AppController',
			'action' => 'aval'
		);

		$routes['aleatorio'] = array(
			'route' => '/aleatorio',
			'controller' => 'AppController',
			'action' => 'aleatorio'
		);

		$routes['categorias'] = array(
			'route' => '/categorias',
			'controller' => 'AppController',
			'action' => 'categorias'
		);

		$routes['removerCategoria'] = array(
			'route' => '/removerCategoria',
			'controller' => 'AdminController',
			'action' => 'removerCategoria'
		);

		$routes['removerScan'] = array(
			'route' => '/removerScan',
			'controller' => 'AdminController',
			'action' => 'removerScan'
		);

		$routes['baixar'] = array(
			'route' => '/baixar',
			'controller' => 'AppController',
			'action' => 'baixar'
		);

		$routes['comments'] = array(
			'route' => '/comments',
			'controller' => 'AppController',
			'action' => 'comments'
		);

		$routes['responder'] = array(
			'route' => '/responder',
			'controller' => 'AppController',
			'action' => 'responder'
		);

		$routes['denunciar'] = array(
			'route' => '/denunciar',
			'controller' => 'AppController',
			'action' => 'denunciar'
		);

		$routes['deleteComment'] = array(
			'route' => '/deleteComment',
			'controller' => 'AdminController',
			'action' => 'deleteComment'
		);

		$routes['ignore'] = array(
			'route' => '/ignore',
			'controller' => 'AdminController',
			'action' => 'ignore'
		);

		$routes['updateClass'] = array(
			'route' => '/updateClass',
			'controller' => 'AppController',
			'action' => 'updateClass'
		);

		//Partials -------------------------------------------
		$routes['preferences'] = array(
			'route' => '/preferences',
			'controller' => 'AppController',
			'action' => 'preferences'
		);





		$this->setRoutes($routes);
	}

}

?>