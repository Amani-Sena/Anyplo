<?php

namespace App\Controllers;


//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;
use Google\Client as GoogleClient;

	use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;


class IndexController extends Action {

	public function index() {
		session_start();
		$manga = Container::getModel('Mangas');
		$user = Container::getModel('Usuario');
		if(isset($_SESSION['id'])) {
			$manga->__set('id', $_SESSION['id']);
			$user->__set('id', $_SESSION['id']);
			$this->view->class = $user->getClass();

			if($this->view->class['class'] == 1) {
				$this->view->Adult = $manga->GetAdult();
			}
		}
		
		$this->view->destaque = $manga->getDestaque();
		$this->view->lanc = $manga->getLanc();
		$this->view->popular = $manga->getPopular();
		$this->view->MeAv = $manga->getMeAv();
		$this->view->Recem = $manga->getRecem();

		$this->render('index');
	}

	public function login() {
		$this->view->login = isset($_GET['login']) ? $_GET['login'] : '';
		$this->view->usuario = array (
			'nome' => '',
			'email' => '',
			'senha' => ''
		);

		$nBG = rand(1, 30);
        $bg = 'bg-' . $nBG . '.avif';

        $this->view->bg = $bg;

		$this->render('login');
	}

	public function login_google() {

		//Verifica se os valores existem
		if(!isset($_POST['credential']) || !isset($_POST['g_csrf_token'])) {
			header('Location: /login');
		}

		//Cookie CSRF
		$cookie = $_COOKIE['g_csrf_token'] ?? '';

		//Verifica o valor do cookie e post
		if($_POST['g_csrf_token'] != $cookie) {
			header('Location: /login');
		}

		
		//Verificação secundária do token
		//Instancia do cliente google
		$client = new GoogleClient(['client_id' => "1096694795774-8rnonr531bi05i337emsstfvqjpmd6e3.apps.googleusercontent.com"]);

		//obtem dados do usuário
		$payload = $client->verifyIdToken($_POST['credential']);

		//Verifica dados do payload
		if (isset($payload['email'])) {
			$user = Container::getModel('Usuario');

			$user->__set('email', $payload['email']);
			$userR = $user->searchGoogleId();

			if($userR['countGoogle'] == 0) {
				$user->__set('nome', $payload['given_name']);
				$user->__set('icone', 'img/icones/64d7eb6b0fe28.avif');
				$user->updateIcone();
				$user->__set('back', 'img/backgrounds/64d7eab1b0a3f.avif');
				$user->updateBack();
				$chave = null;
				$user->__set('chave', $chave);
				$id_situ = 1;
				$user->__set('id_situ', $id_situ);
				$user->__set('tipo', 1);
				$user->__set('nivel', 1);
				$user->__set('class', 0);
				
				$user->salvarGoogle();

				$user->__set('login', $payload['name']);
        		$user->autenticarGoogle();

			
				if($user->__get('id') != '' && $user->__get('nome') != '') {
					session_start();
					$_SESSION['id'] = $user->__get('id');
					$_SESSION['nome'] = $user->__get('nome');
					$_SESSION['email'] = $user->__get('email');
					$_SESSION['icone'] = $user->__get('icone');
					$_SESSION['bg'] = $user->__get('back');
					$_SESSION['tipo'] = $user->__get('tipo');
					$_SESSION['class'] = $user->__get('class');
		
					header('Location: /');
				} else {
					header('Location: /login?login=erro');
				}

			} else {
				$user->autenticarGoogle();

				if($user->__get('id') != '' && $user->__get('nome') != '') {
					session_start();
					$_SESSION['id'] = $user->__get('id');
					$_SESSION['nome'] = $user->__get('nome');
					$_SESSION['email'] = $user->__get('email');
					$_SESSION['icone'] = $user->__get('icone');
					$_SESSION['bg'] = $user->__get('back');
					$_SESSION['tipo'] = $user->__get('tipo');
					$_SESSION['class'] = $user->__get('class');
		
					header('Location: /');
				} else {
					header('Location: /login?login=erro');
				}
			}

		}



	}

	public function register() {
		$this->view->login = isset($_GET['login']) ? $_GET['login'] : '';
		$this->view->usuario = array (
			'nome' => '',
			'email' => '',
			'senha' => ''
		);

		$nBG = rand(1, 30);
        $bg = 'bg-' . $nBG . '.avif';

        $this->view->bg = $bg;

		$this->render('register');
	}

	public function registrar() {
		//Receber dados do formulário de registro
		
		$usuario = Container::getModel('Usuario');
		$usuario->__set('nome', $_POST['nome']);
		$usuario->__set('email', $_POST['email']);
		$usuario->__set('senha', password_hash($_POST['senha'], PASSWORD_DEFAULT));
		$usuario->__set('icone', 'img/icones/64d7eb6b0fe28.avif');
		$usuario->updateIcone();
		$usuario->__set('back', 'img/backgrounds/64d7eab1b0a3f.avif');
		$usuario->updateBack();
		$chave = password_hash($_POST['email'] . date("Y-m-d H:i:s") , PASSWORD_DEFAULT);
		$usuario->__set('chave', $chave);
		$usuario->__set('tipo', 1);
		$usuario->__set('nivel', 1);
		$usuario->__set('class', 0);
		$usuario->__set('id_situ', 3);
		$email = $_POST['email'];

		if($usuario->validarCadastro() && count($usuario->getUsuarioEmail()) == 0 && filter_var($email, FILTER_VALIDATE_EMAIL)) {
			
			if(count($usuario->getUserName()) == 0) {
				//Sucesso
				$usuario->salvar();

				//PHPMAILER
				$mail = new PHPMailer(true);

				try { 
					//Server settings
					//$mail->SMTPDebug = SMTP::DEBUG_SERVER;   
					$mail->CharSet = "utf-8";               
					$mail->isSMTP();                                            
					$mail->Host       = 'smtp.gmail.com';                     
					$mail->SMTPAuth   = true;                                   
					$mail->Username   = 'noreply.anyplo@gmail.com';                     
					$mail->Password   = 'xgxrjkznwtsmsmqk';                               
					$mail->SMTPSecure = 'tls';            
					$mail->Port       = 587;
	
					//Recipients
					$mail->setFrom('noreply.anyplo@gmail.com', 'Anyplo');
					$mail->addAddress($email, $_POST['nome']);     
					//$mail->addAddress('ellen@example.com');               
					//$mail->addReplyTo('info@example.com', 'Information');
					//$mail->addCC('cc@example.com');
					//$mail->addBCC('bcc@example.com');

					//Content
					$mail->isHTML(true);                                  
					$mail->Subject = 'Anyplo - Confirmar E-mail';
					$mail->Body    = $_POST['nome'] . ", agradecemos pelo cadastro!<br><br>Agora só precisamos confirmar seu email, basta clicar no link abaixo para que saibamos que você é você...<br><br>
					<a style='color: #329542; font-size: 1.2rem; text-decoration: none;' href='http://localhost:8080/conf_email?chave=$chave'>Clique aqui!</a><br><br>Se você não realizou o cadastro para uma conta Anyplo e acredita que houve algum engano, por favor entre em contato conosco!<br><br>Você está recebendo este email de Anyplo pois se encontra cadastrado no banco de dados da mesma, nenhum email enviado pela Anyplo
	 				tem arquivos anexados ou solicita dados pessoais ou informações cadastrais!";

					$mail->AltBody = $_POST['nome'] . ", agradecemos pelo cadastro!\n\nAgora só precisamos confirmar seu email, basta clicar no link abaixo para que saibamos que você é você...\n\n
					http://localhost:8080/conf_email?chave=$chave\n\nSe você não realizou o cadastro para uma conta Anyplo e acredita que houve algum engano, por favor entre em contato conosco!\n\nVocê está recebendo este email de Anyplo pois se encontra cadastrado no banco de dados da mesma, nenhum email enviado pela Anyplo
	 				tem arquivos anexados ou solicita dados pessoais ou informações cadastrais!";

					$this->view->msgSuccess = true;
					$this->render('login');

					$mail->send();

					$this->render('login');

					} catch (Exception $e) {
						echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
					}
			} else {
				$this->view->msgErrorName = true;

				$this->view->usuario = array (
					'nome' => $_POST['nome'],
					'email' => $_POST['email'],
					'senha' => $_POST['senha']
				);
				$this->render('register');
			}

			} else {
				$this->view->msgErrorEmail = true;
				
				$this->view->usuario = array (
					'nome' => $_POST['nome'],
					'email' => $_POST['email'],
					'senha' => $_POST['senha']
				);
				$this->render('register');
			}
				
		}
	

	public function conf_email() {
		$chave = filter_input(INPUT_GET, "chave");
		$user = Container::getModel('Usuario');
        $user->__set('chave', $chave);

		if(!empty($chave)) { 
			$select = $user->select_email();
			$id_user = $select['id'];
			$user->conf_email($id_user);
		}
    
		$this->view->select = $select;

		$nBG = rand(1, 30);
        $bg = 'bg-' . $nBG . '.avif';

        $this->view->bg = $bg;

		$this->render('conf_email');
	}

	public function sendEmail() {
		$email = isset($_GET['email']) ? $_GET['email'] : '';
		$nome = isset($_GET['nome']) ? $_GET['nome'] : '';		
		$chave = isset($_GET['chave']) ? $_GET['chave'] : '';	
		
		//PHPMAILER
		$mail = new PHPMailer(true);

		try { 
			//Server settings
			//$mail->SMTPDebug = SMTP::DEBUG_SERVER;   
			$mail->CharSet = "utf-8";               
			$mail->isSMTP();                                            
			$mail->Host       = 'smtp.gmail.com';                     
			$mail->SMTPAuth   = true;                                   
			$mail->Username   = 'noreply.anyplo@gmail.com';                     
			$mail->Password   = 'xgxrjkznwtsmsmqk';                               
			$mail->SMTPSecure = 'tls';            
			$mail->Port       = 587;

			//Recipients
			$mail->setFrom('noreply.anyplo@gmail.com', 'Anyplo');
			$mail->addAddress($email, $nome);   
			//$mail->addAddress('ellen@example.com');               
			//$mail->addReplyTo('info@example.com', 'Information');
			//$mail->addCC('cc@example.com');
			//$mail->addBCC('bcc@example.com');

			//Content
			$mail->isHTML(true);                                  
			$mail->Subject = 'Anyplo - Confirmar E-mail';
			$mail->Subject = 'Anyplo - Confirmar E-mail';
			$mail->Body    = $nome . ", agradecemos pelo cadastro!<br><br>Agora só precisamos confirmar seu email, basta clicar no link abaixo para que saibamos que você é você...<br><br>
			<a style='color: #329542; font-size: 1.2rem; text-decoration: none;' href='http://localhost:8080/conf_email?chave=$chave'>Clique aqui!</a><br><br>Se você não realizou o cadastro para uma conta Anyplo e acredita que houve algum engano, por favor entre em contato conosco!<br><br>Você está recebendo este email de Anyplo pois se encontra cadastrado no banco de dados da mesma, nenhum email enviado pela Anyplo
	 		tem arquivos anexados ou solicita dados pessoais ou informações cadastrais!";

			$mail->AltBody = $nome . ", agradecemos pelo cadastro!\n\nAgora só precisamos confirmar seu email, basta clicar no link abaixo para que saibamos que você é você...\n\n
			http://localhost:8080/conf_email?chave=$chave\n\nSe você não realizou o cadastro para uma conta Anyplo e acredita que houve algum engano, por favor entre em contato conosco!\n\nVocê está recebendo este email de Anyplo pois se encontra cadastrado no banco de dados da mesma, nenhum email enviado pela Anyplo
	 		tem arquivos anexados ou solicita dados pessoais ou informações cadastrais!";

			$mail->send();

			} catch (Exception $e) {
				echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
			}

	}

}


