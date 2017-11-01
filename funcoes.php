<?php
inicializa();

function inicializa()
{
	if (file_exists(dirname(__FILE__).'/config.php')) 
	{
		require_once(dirname(__FILE__).'/config.php');
	} 
	else 
	{
		die(utf8_decode('O arquivo de configuração não foi localizado, contate o administrador.'));	
	}
		
	foreach ($constantes as $valor) 
	{
		if (!defined($valor))
		{
			die(utf8_decode('Faltam configurações do sistema: '.$valor.'. Contate o administrador.'));	
		} 
	}
	
	
	require_once(BASEPATH.CLASSPATH.'autoload.php');
	 
	
    if ($_GET['logoff']==true)
    {
		$user = new usuario();
		$user->doLogout();
		exit;
    }	
	
}

function loadCSS($arquivo=null,$media='screen',$import=false)
{
	if ($arquivo!=null) 
	{
		if ($import==true) 
		{
			echo '<style type="text/css">@import url("'.BASEURL.CSSPATH.$arquivo.'.css");</style>'."\n";
		} 
		else 
		{
			echo '<link rel="stylesheet" type="text/css" href="'.BASEURL.CSSPATH.$arquivo.'.css" media="'.$media.'" />'."\n" ;		
		}
		
	} 
	
}

function loadJS($arquivo=null,$remoto=FALSE)
{
	if ($arquivo!=null) 
	{
		if ($remoto == FALSE) 
			$arquivo = BASEURL.JSPATH.$arquivo.'.js';
								
		echo '<script type="text/javascript" src="'.$arquivo.'"></script>'."\n";
	}	
}

function loadModulo($modulo=null,$tela=null)
{
	if ($modulo==null || $tela==null) 	
		echo '<p> Erro na função <strong>'.__FUNCTION__.'</strong>: faltam parâmetros para a execução.</p>';
	else 
	{
		if (file_exists(MODULOSPATH."$modulo.php"))
			include_once(MODULOSPATH."$modulo.php");
		else 
			echo '<p> Módulo inexistente neste sistema!</p>';		
	}
}

function protegeArquivo($nomeArquivo,$redirPara='index.php?erro=3')
{
	$url = $_SERVER["PHP_SELF"];
	if (preg_match("/$nomeArquivo/i", $url))
	{
		redireciona($redirPara);
	}
}

function redireciona($url='')
{
	header("Location: ".BASEURL.$url);
}

function codificaSenha($senha)
{
	return md5($senha);
}

function verificaLogin()
{
	$sessao = new sessao();
	if (($sessao->getNvars()<=0) || ($sessao->getVar('logado')!=TRUE)||($sessao->getVar('ip')!=$_SERVER['REMOTE_ADDR']))
		redireciona('?erro=3');  	
}

function printMSG($msg=null,$tipo=null)
{
	if ($msg!=null)
	{
		switch ($tipo) 
		{
			case 'erro':
				echo '<div class="erro">'.$msg.'</div>';				
				break;
				
			case 'alerta':
				echo '<div class="alerta">'.$msg.'</div>';				
				break;
				
			case 'pergunta':
				echo '<div class="pergunta">'.$msg.'</div>';				
				break;
				
			case 'sucesso':
				echo '<div class="sucesso">'.$msg.'</div>';				
				break;
			default:
				echo '<div class="sucesso">'.$msg.'</div>';				
				break;
				
		}
	}
}

function isAdmin(){
	verificaLogin();
    $sessao = new sessao();        
    $user = new usuario(array(
        'administrador'=>NULL,
    ));
    $iduser = $sessao->getVar('iduser');
    $user->extras_select = "WHERE id=$iduser";
	$user->selecionaCampos($user);	
	
    $res = $user->retornaDados();
    if (strtolower($res->administrador) == 's'):
        return TRUE;
    else:
        return FALSE;
    endif;
}

function antiInject($string)
{
    $string = preg_replace("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/i", "", $string);
    $string = trim($string);//limpa espaços vazios
    $string = strip_tags($string);
    if (!get_magic_quotes_gpc())        
        $string = addcslashes($string);
    
    return $string;    
    
}

?>