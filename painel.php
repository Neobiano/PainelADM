<?php include('header.php');
if (isset($_GET['m'])) $modulo = $_GET['m'];
if (isset($_GET['t'])) $tela = $_GET['t'];
?>
    <?php 
    if ($modulo && $tela):
        loadmodulo($modulo,$tela);
    else:
        echo '<div class="content-wrapper">
                <section class="content-header">
            	<h1>
            		Gestão
            		<small>Resumo</small>
              	</h1>
              	<ol class="breadcrumb">
            		<li><a ><i class="fa fa-dashboard"></i> Gestão</a></li>
            		<li class="active">Resumo</li>
              	</ol>
            </section> 
            </div> <!-- /.content-wrapper -->';
    endif;
    ?>

	
<?php //include('sidebar.php'); ?>
<?php include('footer.php'); ?>