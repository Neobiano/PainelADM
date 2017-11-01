<?php 
	require_once("funcoes.php");
	protegeArquivo(basename(__FILE__));
	verificaLogin();
	$sessao = new sessao();
?>
<!DOCTYPE html>
<html lang="pt">
	<head>
		<meta charset="utf-8">

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title>Painel Administrativo</title>
		<meta name="description" content="">
		<meta name="author" content="Fabiano">

		<meta name="viewport" content="width=device-width; initial-scale=1.0">

		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="shortcut icon" href="/favicon.ico">
		<link rel="apple-touch-icon" href="/apple-touch-icon.png">
		<?php
			loadCSS('reset');
			loadCSS('style');
			loadJS('jquery');
			loadJS('geral');
		?>
	</head> 

	<body class="painel">
		<div id="wrapper">
			<div id="header">
				<h1>Controle de Tarefas</h1>
			</div><!-- header -->	
			<div id="wrap-content">
					
			
