<?php require_once("funcoes.php"); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">    
        <title>PainelCERAT</title>
        <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
         <!-- Font Awesome -->
        <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
         <!-- Ionicons -->
         <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
         <!-- Theme style -->
         <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
         <!-- iCheck -->
         <link rel="stylesheet" href="plugins/iCheck/square/blue.css">  
         <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">-->           
    </head>
    
    
    <body class="hold-transition login-page">
  		
        <?php 
          //  loadCSS('reset');
            loadCSS('style');
            
            
          //  loadJS('jquery');
            loadJS('geral');
            loadmodulo('usuarios','login'); ?>
        
        <script src="bower_components/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- iCheck -->
        <script src="plugins/iCheck/icheck.min.js"></script>
        
        <script>
          $(function () {
            $('input').iCheck({
              checkboxClass: 'icheckbox_square-blue',
              radioClass: 'iradio_square-blue',
              increaseArea: '20%' // optional
            });
          });
        </script>  
    </body>
</html>