<?php
//	require_once 'logger.php';
	
	class Pedido
	{
		private $logger;
				
		public $dadosEcNumero;
		public $dadosEcChave;
		
		public $dadosPortadorNumero;
		public $dadosPortadorVal;
		public $dadosPortadorInd;
		public $dadosPortadorCodSeg;
		public $dadosPortadorNome;
		
		public $dadosPedidoNumero;
		public $dadosPedidoValor;
		public $dadosPedidoMoeda = "986";
		public $dadosPedidoData;
		public $dadosPedidoDescricao;
		public $dadosPedidoIdioma = "PT";
		
		public $formaPagamentoBandeira;
		public $formaPagamentoProduto;
		public $formaPagamentoParcelas;
		
		public $urlRetorno;
		public $autorizar;
		public $capturar;
		
		public $tid;
		public $status;
		public $urlAutenticacao;
		
		
		//VARIAVEIS EXTRAS PARA CYBERSOURCE ANTIFRAUDE CIELO-------
		
		public $idPedidoF ;
		public $totalCompraCielo;
	 
		public $cobEndereco;
		public $cobComplemento;
		public $cobCidade;
		public $cobEstado;
		public $cobCep;
			
			
		public $userId;
		public $userSenha;
		public $userCpf	;
		public $userEmail;
		public $userNome;	
		public $userSobrenome;
		public $userTelefone;
		public $userIp;
			
		public $entregaEndereco	;
		public $entregaComplemento;	
		public $entregaCidade;	
		public $entregaEstado;
		public $entregaCep;
		public $entregaTelefone;
		
		
	    //VARIAVEIS EXTRAS PARA CYBERSOURCE ANTIFRAUDE CIELO ------
		
		
		
		//const ENCODING = "ISO-8859-1";
		const ENCODING = "UTF-8";
		
		function __construct()
		{
			// cria um logger
			$this->logger = new Logger();
		}
		
		// Geradores de XML
		private function XMLHeader()
		{
			return '<?xml version="1.4.0" encoding="'.self::ENCODING .'" ?>'; 
		}
		
		private function XMLDadosEc()
		{
			$msg = '<dados-ec>' . "\n      " .
						'<numero>'
							. $this->dadosEcNumero . 
						'</numero>' . "\n      " .
						'<chave>'
							. $this->dadosEcChave .
						'</chave>' . "\n   " .
					'</dados-ec>';
							
			return $msg;
		}
		
		private function XMLDadosPortador()
		{
			$msg = '<dados-portador>' . "\n      " . 
						'<numero>' 
							. $this->dadosPortadorNumero .
						'</numero>' . "\n      " .
						'<validade>'
							. $this->dadosPortadorVal .
						'</validade>' . "\n      " .
						'<indicador>'
							. $this->dadosPortadorInd .
						'</indicador>' . "\n      " .
						'<codigo-seguranca>'
							. $this->dadosPortadorCodSeg .
						'</codigo-seguranca>' . "\n   ";
			
			// Verifica se Nome do Portador foi informado
			if($this->dadosPortadorNome != null && $this->dadosPortadorNome != "")
			{
				$msg .= '   <nome-portador>'
							. $this->dadosPortadorNome .
						'</nome-portador>' . "\n   " ;
			}
			
			$msg .= '</dados-portador>';
			
			return $msg;
		}
		
		private function XMLDadosCartao()
		{
			$msg = '<dados-cartao>' . "\n      " . 
						'<numero>' 
							. $this->dadosPortadorNumero .
						'</numero>' . "\n      " .
						'<validade>'
							. $this->dadosPortadorVal .
						'</validade>' . "\n      " .
						'<indicador>'
							. $this->dadosPortadorInd .
						'</indicador>' . "\n      " .
						'<codigo-seguranca>'
							. $this->dadosPortadorCodSeg .
						'</codigo-seguranca>' . "\n   ";

			// Verifica se Nome do Portador foi informado				
			if($this->dadosPortadorNome != null && $this->dadosPortadorNome != "")
			{
				$msg .= '   <nome-portador>'
							. $this->dadosPortadorNome .
						'</nome-portador>' . "\n   " ;
			}
			
			$msg .= '</dados-cartao>';
			
			return $msg;
		}
		
		private function XMLDadosPedido()
		{
			$this->dadosPedidoData = date("Y-m-d") . "T" . date("H:i:s");
			$msg = '<dados-pedido>' . "\n      " .
						'<numero>'
							. $this->dadosPedidoNumero . 
						'</numero>' . "\n      " .
						'<valor>'
							. $this->dadosPedidoValor .
						'</valor>' . "\n      " .
						'<moeda>'
							. $this->dadosPedidoMoeda .
						'</moeda>' . "\n      " .
						'<data-hora>'
							. $this->dadosPedidoData .
						'</data-hora>' . "\n      ";
			if($this->dadosPedidoDescricao != null && $this->dadosPedidoDescricao != "")
			{
				$msg .= '<descricao>'
					. $this->dadosPedidoDescricao .
					'</descricao>' . "\n      ";
			}
			$msg .= '<idioma>'
						. $this->dadosPedidoIdioma .
					'</idioma>' . "\n   " .
					'';
			
			

			
			
 
				
			$msg .= '</dados-pedido>';
			
						
			return $msg;
		}
		
		private function XMLFormaPagamento()
		{
			$msg = '<forma-pagamento>' . "\n      " .
						'<bandeira>' 
							. $this->formaPagamentoBandeira .
						'</bandeira>' . "\n      " .
						'<produto>'
							. $this->formaPagamentoProduto .
						'</produto>' . "\n      " .
						'<parcelas>'
							. $this->formaPagamentoParcelas .
						'</parcelas>' . "\n   " .
					'</forma-pagamento>';
							
			return $msg;
		}
		 
		private function XMLUrlRetorno()
		{
			$msg = '<url-retorno>' . $this->urlRetorno . '</url-retorno>';
			
			return $msg;
		}
		
		private function XMLAutorizar()
		{
			$msg = '<autorizar>' . $this->autorizar . '</autorizar>';
			
			return $msg;
		}
		
		private function XMLCapturar()
		{
			$msg = '<capturar>' . $this->capturar . '</capturar>';
			
			return $msg;
		}
		
		// Envia Requisi��o
		public function Enviar($vmPost, $transacao)
		{
			$this->logger->logWrite("ENVIO: " . $vmPost, $transacao);
	
 
	       //echo "vmTRANCASAO : $transacao<br/><br/>";
	  
	   
			// ENVIA REQUISI��O SITE CIELO
		    $urlgo = ENDERECO;
			$vmResposta = httprequest($urlgo, "mensagem=" . $vmPost);
			$this->logger->logWrite("RESPOSTA: " . $vmResposta, $transacao);
			//echo "VMPOST : $vmPost<br/><br/>";
		//	echo "VMRESPOSTA : $vmResposta<br/><br/>";
			VerificaErro($vmPost, $vmResposta);
	
			return simplexml_load_string($vmResposta);
		}
		
		
		
		//IF CYBER  CYBERSOURCE-------------------
		public function custom_set_cielo_cybershot(){
			  include('custom-cybersource.php');
			  return  $xmlCyberSource;
		 }
		//IF CYBER  CYBERSOURCE-------------------
		
		
		
		// Requisi��es
		public function RequisicaoTransacao($incluirPortador)
		{
			$msg = $this->XMLHeader() . "\n" .
				   '<requisicao-transacao id="' . md5(date("YmdHisu")) . '" versao="' . VERSAO . '">' . "\n   "
				   		. $this->XMLDadosEc() . "\n   ";
			if($incluirPortador == true)
			{
					$msg .=	$this->XMLDadosPortador() . "\n   ";
			}
			$msg .=		  $this->XMLDadosPedido() . "\n   "
				   		. $this->XMLFormaPagamento() . "\n   "
				   		. $this->XMLUrlRetorno() . "\n   "
				   		. $this->XMLAutorizar() . "\n   "
				   		. $this->XMLCapturar() . "\n" ;
			
			 
			/*SOMENTE  PAGTO BY LOJA
			$msg .= '<avs>
			<![CDATA[
			<dados-avs>
			<endereco>Rua Teste AVS</endereco> <complemento>Casa</complemento> <numero>123</numero>
			<bairro>Vila AVS</bairro> <cep>12345-123</cep>
			</dados-avs>
			]]></avs>';
			 
			*/
	 
		        //IF CYBER  CYBERSOURCE-------------------
				
				$ativaCybersource = get_option('ativaCybersource'); 
		        $ativaCybersourceTeste = get_option('ativaCybersourceTeste'); 
				
				$permitirCYB =   false;
				if( $ativaCybersourceTeste == 'ativaCybersourceTeste'){
					if(current_user_can('manage_options')){
						$permitirCYB = true;
					}else{
					    $permitirCYB = false;
					}
				}else{
					    $permitirCYB = true;
				};
	
	
				if( $ativaCybersource =="ativaCybersource" &&  $permitirCYB == true  ){		
				    $msg .=  $this->custom_set_cielo_cybershot();
				}; 
				
				//IF CYBERSOURCE -------------------
			
			$msg .= '</requisicao-transacao>';
			
			$objResposta = $this->Enviar($msg, "Transacao");
			return $objResposta;
		}
		
		
		
		
		
		
		public function RequisicaoTid()
		{
			$msg = $this->XMLHeader() . "\n" .
				   '<requisicao-tid id="' . md5(date("YmdHisu")) . '" versao ="' . VERSAO . '">' . "\n   "
				        . $this->XMLDadosEc() . "\n   " 
				        . $this->XMLFormaPagamento() . "\n" .
				   '</requisicao-tid>';
				        
			$objResposta = $this->Enviar($msg, "Requisicao Tid");
			return $objResposta;
		}
		
		public function RequisicaoAutorizacaoPortador()
		{
			$msg = $this->XMLHeader() . "\n" .
				   '<requisicao-autorizacao-portador id="' . md5(date("YmdHisu")) . '" versao ="' . VERSAO . '">' . "\n"
				   		. '<tid>' . $this->tid . '</tid>' . "\n   "
				        . $this->XMLDadosEc() . "\n   " 
				        . $this->XMLDadosCartao() . "\n   "
				        . $this->XMLDadosPedido() . "\n   "
				        . $this->XMLFormaPagamento() . "\n   "
				        . '<capturar-automaticamente>' . $this->capturar . '</capturar-automaticamente>' . "\n" .
				   '</requisicao-autorizacao-portador>';
			
			$objResposta = $this->Enviar($msg, "Autorizacao Portador");
			return $objResposta;
		}
		
		public function RequisicaoAutorizacaoTid()
		{
			$msg = $this->XMLHeader() . "\n" .
				 '<requisicao-autorizacao-tid id="' . md5(date("YmdHisu")) . '" versao="' . VERSAO . '">' . "\n  "
				 	. '<tid>' . $this->tid . '</tid>' . "\n  "
				 	. $this->XMLDadosEc() . "\n" .
				 '</requisicao-autorizacao-tid>';
				 	
			$objResposta = $this->Enviar($msg, "Autorizacao Tid");
			return $objResposta;
		}
		
		public function RequisicaoCaptura($PercentualCaptura, $anexo)
		{
			$msg = $this->XMLHeader() . "\n" .
				    '<requisicao-captura id="' . md5(date("YmdHisu")) . '" versao="' . VERSAO . '">' . "\n   "
				   	. '<tid>' . $this->tid . '</tid>' . "\n   "
				   	. $this->XMLDadosEc() . "\n   "
				   	. '<valor>' . $PercentualCaptura . '</valor>' . "\n";
			if($anexo != null && $anexo != "")
			{
				$msg .=	'   <anexo>' . $anexo . '</anexo>' . "\n";
			}
			$msg .= '</requisicao-captura>';
			
			$objResposta = $this->Enviar($msg, "Captura");
			return $objResposta;
		}
		
		public function RequisicaoCancelamento()
		{
			$msg = $this->XMLHeader() . "\n" . 
				   '<requisicao-cancelamento id="' . md5(date("YmdHisu")) . '" versao="' . VERSAO . '">' . "\n   "
				    . '<tid>' . $this->tid . '</tid>' . "\n   "
				    . $this->XMLDadosEc() . "\n" .
				   '</requisicao-cancelamento>';
			
			$objResposta = $this->Enviar($msg, "Cancelamento");
			return $objResposta;
		}
		
		public function RequisicaoConsulta()
		{
			$msg = $this->XMLHeader() . "\n" .
				   '<requisicao-consulta id="' . md5(date("YmdHisu")) . '" versao="' . VERSAO . '">' . "\n   "
				    . '<tid>' . $this->tid . '</tid>' . "\n   "
				    . $this->XMLDadosEc() . "\n" .
				   '</requisicao-consulta>';
			
			$objResposta = $this->Enviar($msg, "Consulta");
			return $objResposta;
		}
		
		
		// Transforma em/l� string
		public function ToString()
		{
			$msg = $this->XMLHeader() .
				   '<objeto-pedido>'
				    . '<tid>' . $this->tid . '</tid>'
				    . '<status>' . $this->status . '</status>'
				   	. $this->XMLDadosEc()
				   	. $this->XMLDadosPedido()
				   	. $this->XMLFormaPagamento() .
				   '';
				 
            $msg .= '</objeto-pedido>'; 	
			return $msg;
		}

			
		public function FromString($Str)
		{
			$DadosEc = "dados-ec";
			$DadosPedido = "dados-pedido";
			$DataHora = "data-hora";
			$FormaPagamento = "forma-pagamento";
			
			$XML = simplexml_load_string($Str);
			
			$this->tid = $XML->tid;
			$this->status = $XML->status;
			$this->dadosEcChave = $XML->$DadosEc->chave;
			$this->dadosEcNumero = $XML->$DadosEc->numero;
			$this->dadosPedidoNumero = $XML->$DadosPedido->numero;
			$this->dadosPedidoData = $XML->$DadosPedido->$DataHora;
			$this->dadosPedidoValor = $XML->$DadosPedido->valor;
			$this->formaPagamentoProduto = $XML->$FormaPagamento->produto;
			$this->formaPagamentoParcelas = $XML->$FormaPagamento->parcelas;
		}
		
		// Traduz c�gigo do Status
		public function getStatus()
		{
			$status;
			
			switch($this->status)
			{
				case "0": $status = "Criada";
						break;
				case "1": $status = "Em andamento";
						break;
				case "2": $status = "Autenticada";
						break;
				case "3": $status = "N�o autenticada";
						break;
				case "4": $status = "Autorizada";
						break;
				case "5": $status = "N�o autorizada";
						break;
				case "6": $status = "Capturada";
						break;
				case "8": $status = "N�o capturada";
						break;
				case "9": $status = "Cancelada";
						break;
				case "10": $status = "Em autentica��o";
						break;
				default: $status = "n/a";
						break;
			}
			
			return $status;
		}
		
	}
	
?>