<?php 
	require 'vendor/autoload.php';
	require_once('config.php');

	use GuzzleHttp\Client;
	use GuzzleHttp\Handler\MockHandler;
	use GuzzleHttp\HandlerStack;
	use GuzzleHttp\Psr7\Response;
	use GuzzleHttp\Psr7\Request;
	use GuzzleHttp\Exception\RequestException;

	class PaymentsGuzzle{
        private $baseUrl = '';

		public function __construct($url){
            $this->baseUrl = $url;
        }


         public function payC2B(){
			$cliente = new Client([
				'base_uri' => $baseUrl,
			]);

			$resposta = $cliente->request('POST', '/oauth/token', [
			   'form_params' => [
			       'grant_type' => 'client_credentials',
			        'client_id' => constant('CLID'),
			        'client_secret' => constant('CLSSECRET') 
			    ]
			]);

			return $resposta->getBody();
         }
	}
?>