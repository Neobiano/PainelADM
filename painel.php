<?php include('header.php');
if (isset($_GET['m'])) $modulo = $_GET['m'];
if (isset($_GET['t'])) $tela = $_GET['t'];
?>
<div id="content">
    <?php 
    if ($modulo && $tela):
        loadmodulo($modulo,$tela);
    else:
        echo '<section class="content-header">
		      <h1>
		       
		      </h1>
		      
		    </section>';
    endif;
    ?>
</div><!--content -->
<?php //include('sidebar.php'); ?>
<?php include('footer.php'); ?>