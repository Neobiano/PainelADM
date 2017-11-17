<?php 
	require_once("funcoes.php");
	protegeArquivo(basename(__FILE__));
	verificaLogin();
	$sessao = new sessao();
?>
<!DOCTYPE html>
<html lang="pt">
	<head>
		<meta charset="UTF-8" >
		<!-- Font Awesome -->
		<link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css" >
		<!-- Ionicons -->
		<link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css" >
		<!-- Theme style -->
		<link rel="stylesheet" href="dist/css/AdminLTE.min.css" >		  
		<link rel="stylesheet" href="dist/css/skins/skin-blue.min.css">
		<!--<link rel="stylesheet"  href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
		<!-- Bootstrap 3.3.7 -->
		<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css" >
	    <!-- DataTables -->
		<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css" >		 
		<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css" >
		<link rel="stylesheet" href="plugins/iCheck/square/blue.css" >
      
		<title>Painel Administrativo</title>
		<?php
			loadCSS('style');			
	        loadJS('geral');			 
		?>
	</head> 

	<body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<header class="main-header">
				 <!-- Logo -->
			    <a href="painel.php" class="logo">
			      <!-- mini logo for sidebar mini 50x50 pixels -->
			      <span class="logo-mini"><b>C</b>T</span>
			      <!-- logo for regular state and mobile devices -->
			      <span class="logo-lg"><b>Controle de </b>Tarefas</span>
			    </a>
			    
			    <!-- Header Navbar -->
			    <nav class="navbar navbar-static-top" role="navigation">
			      <!-- Sidebar toggle button-->
			      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
			        <span class="sr-only">Toggle navigation</span>
			      </a>
			      <!-- Navbar Right Menu -->
			      <div class="navbar-custom-menu">
			        <ul class="nav navbar-nav">
			          <!-- Messages: style can be found in dropdown.less-->
			          <li class="dropdown messages-menu">
			            <!-- Menu toggle button -->
			            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
			              <i class="fa fa-envelope-o"></i>
			              <span class="label label-success">4</span>
			            </a>
			            <ul class="dropdown-menu">
			              <li class="header">You have 4 messages</li>
			              <li>
			                <!-- inner menu: contains the messages -->
			                <ul class="menu">
			                  <li><!-- start message -->
			                    <a href="#">
			                      <div class="pull-left">
			                        <!-- User Image -->
			                        <img src="images/Fabiano.png" class="img-circle" alt="User Image">
			                      </div>
			                      <!-- Message title and timestamp -->
			                      <h4>
			                        Support Team
			                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
			                      </h4>
			                      <!-- The message -->
			                      <p>Why not buy a new awesome theme?</p>
			                    </a>
			                  </li>
			                  <!-- end message -->
			                </ul>
			                <!-- /.menu -->
			              </li>
			              <li class="footer"><a href="#">See All Messages</a></li>
			            </ul>
			          </li>
			          <!-- /.messages-menu -->
			
			          <!-- Notifications Menu -->
			          <li class="dropdown notifications-menu">
			            <!-- Menu toggle button -->
			            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
			              <i class="fa fa-bell-o"></i>
			              <span class="label label-warning">10</span>
			            </a>
			            <ul class="dropdown-menu">
			              <li class="header">You have 10 notifications</li>
			              <li>
			                <!-- Inner Menu: contains the notifications -->
			                <ul class="menu">
			                  <li><!-- start notification -->
			                    <a href="#">
			                      <i class="fa fa-users text-aqua"></i> 5 new members joined today
			                    </a>
			                  </li>
			                  <!-- end notification -->
			                </ul>
			              </li>
			              <li class="footer"><a href="#">View all</a></li>
			            </ul>
			          </li>
			          <!-- Tasks Menu -->
			          <li class="dropdown tasks-menu">
			            <!-- Menu Toggle Button -->
			            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
			              <i class="fa fa-flag-o"></i>
			              <span class="label label-danger">9</span>
			            </a>
			            <ul class="dropdown-menu">
			              <li class="header">You have 9 tasks</li>
			              <li>
			                <!-- Inner menu: contains the tasks -->
			                <ul class="menu">
			                  <li><!-- Task item -->
			                    <a href="#">
			                      <!-- Task title and progress text -->
			                      <h3>
			                        Design some buttons
			                        <small class="pull-right">20%</small>
			                      </h3>
			                      <!-- The progress bar -->
			                      <div class="progress xs">
			                        <!-- Change the css width attribute to simulate progress -->
			                        <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar"
			                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
			                          <span class="sr-only">20% Complete</span>
			                        </div>
			                      </div>
			                    </a>
			                  </li>
			                  <!-- end task item -->
			                </ul>
			              </li>
			              <li class="footer">
			                <a href="#">View all tasks</a>
			              </li>
			            </ul>
			          </li>
			          <!-- User Account Menu -->
			          <li class="dropdown user user-menu">
			            <!-- Menu Toggle Button -->
			            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
			              <!-- The user image in the navbar-->
			              <img src="images/Fabiano.png" class="user-image" alt="User Image">
			              <!-- hidden-xs hides the username on small devices so only the image appears. -->
			              <span class="hidden-xs"><?php echo $sessao->getVar('nomeuser'); ?></span>
			            </a>
			            <ul class="dropdown-menu">
			              <!-- The user image in the menu -->
			              <li class="user-header">
			                <img src="images/Fabiano.png" class="img-circle" alt="User Image">
			
			                <p>
			                  <?php echo $sessao->getVar('nomeuser'); ?>			                  
			                  <small>Membro desde <?php
			                  						 setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
	    			                  				 echo strftime('%B').' de '.strftime('%Y');
			                  					 ?>
			                  </small>
			                </p>
			              </li>
			          
			              </li>
			              <!-- Menu Footer-->
			              <li class="user-footer">
			                <div class="pull-left">
			                  <a href="#" class="btn btn-default btn-flat">Dados Pessoais</a>
			                </div>
			                <div class="pull-right">
			                  <a href="?logoff=true" class="btn btn-default btn-flat">Sair</a>
			                </div>
			              </li>
			            </ul>
			          </li>
			          <!-- Control Sidebar Toggle Button, vou usar apenas como 'decorativo' para o perfil -->
			          <li>
			            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
			          </li>
			        </ul>
			      </div>
			    </nav>
			</header><!-- header -->	
			
	<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="images/Fabiano.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $sessao->getVar('nomeuser');?></p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MENU</li>          
       	<li class="active"><a href="#"><i class="fa fa-tasks"></i> <span>Tarefas</span></a></li>                           
        <li class="treeview">
          <a href="#">
            <i class="fa fa-file-text""></i> <span>Cadastros</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="?m=tipos&t=listar"><i class="fa fa-edit"></i>Tipos</a></li>
            <li class="active"><a href="?m=status&t=listar"><i class="fa fa-ticket"></i>Status</a></li>
            <li class="active"><a href="?m=prioridades&t=listar"><i class="fa fa-calendar-check-o"></i>Prioridade</a></li>    
            <li class="active"><a href="?m=categorias&t=listar"><i class="fa fa-tag"></i>Categoria</a></li>           
          </ul>
        </li>

       <li class="active"><a href="?m=projetos&t=listar"><i class="fa fa-product-hunt"></i> <span>Projetos</span></a></li>
       <li class="active"><a href="?m=usuarios&t=listar"><i class="fa fa-users"></i> <span>Usuários</span></a></li>
           
        <li class="treeview">
          <a href="#">
            <i class="fa fa-line-chart"></i> <span>Relatórios</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="invoice.html"><i class="fa fa-circle-o text-withe"></i>Demandas por Colaborador</a></li>
            <li class="active"><a href="invoice.html"><i class="fa fa-circle-o text-withe"></i>Demandas por Período</a></li>
            <li class="active"><a href="invoice.html"><i class="fa fa-circle-o text-withe"></i>Demandas Por Projeto</a></li>            
            <li class="active"><a href="invoice.html"><i class="fa fa-circle-o text-withe"></i>Pendência de Resposta</a></li>
          </ul>
        </li>
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>
	

   
			
