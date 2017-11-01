<?php
require_once(dirname(__FILE__).'/autoload.php');
protegeArquivo(basename(__FILE__));
class sessao
{
	protected $id; //id da sessão
	protected $nvars; //nº de campos que nossa sessão tem
	
	public function __construct($inicia=true)
	{
		//quando constuir a class inicia a função start	
		if ($inicia==true) 		
			$this->start();
		
	}
	
	public function start()
	{
		//iniciando a sessão	
		session_start();	
		
		//setando ID e numero de variaveis da sessão
		$this->id = session_id();
		$this->setNvars();		
	}
	
	private function setNvars()
	{
		//seta a propriedade nvar com o tamanho da sessão	
		$this->nvars = sizeof($_SESSION);
	}
	
	public function getNvars()
	{
		//retorna o numero de variáveis da sessão	
		return $this->nvars;
	}

	//utilizado para setar o valor de uma variavel
	public function setVar($var, $valor)
	{
		$_SESSION[$var] = $valor;
		$this->setNvars();
	}
	
	//ao contrario da anterior, serve para excluir um valor de um campo
	public function unsetVar($var)
	{
		unset($_SESSION[$var]);
		$this->setNvars();		
	}
	
	//retorna o valor de uma variável, da sessão se  
	public function getVar($var)
	{
		if (isset($_SESSION[$var]))		
			return $_SESSION[$var];
		else
			return null;
	}
	
	//obviamente destroi a sessão e seta os paramentros, mas se passado true
	//além de destruir a sessão atual ele vai criar uma nova limpa
	public function destroy($inicia=false)
	{
		session_unset();
		session_destroy();
		$this->setNvars();
		if ($inicia==true)
			$this->start();
	}
	
	//so para testes
	public function printAll()
	{
		foreach ($_SESSION as $k => $v) 
		{
			printf("%s = %s<br/>",$k, $v);	
		}
	}
}

?>
