<?php require_once("funcoes.php"); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">    
        <title>Painel Administrativo</title>   
        <!-- Google Font -->
  		<link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">     
        <?php 
        loadCSS('reset');
        loadCSS('style');
		//AdminLTE
		loadCSS('AdminLTE.min');
		loadCSS('bootstrap.min');
		loadCSS('font-awesome.min');
		loadCSS('ionicons.min');
		loadCSS('ionicons.min');
		loadCSS('skin-blue.min');
				
        loadJS('jquery');
        loadJS('geral');
		loadJS('adminlte.min');
		loadJS('bootstrap.min');
		
        ?>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <?php loadmodulo('usuarios','login'); ?>
    </body>
</html>