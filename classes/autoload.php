<?php
	/*Arquivo será responsável por carregar as classes do diretório 'classes' conforme o nome a medida 
	 em que instanciarmos um objeto sem a necessidade de ficarmos usado o require/include*/
	$pathlocal = dirname(__FILE__);
	    
	/*requerendo o arquivo funcoes.php pois nas demais não sera incluido o funcoes.php, somente o autoload*/
	require_once(dirname($pathlocal)."/funcoes.php");
	
	function __autoload($classe)
	{
		$classe = str_replace('..','',$classe);        
		require_once($pathlocal."/{$classe}.class.php");	
	}
?>