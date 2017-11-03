<?php 
	require_once("funcoes.php");
	protegeArquivo(basename(__FILE__));
?>

 		</section>
  	    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
      <?php
      	
      	//echo strftime("%A"); 
      	echo strftime("%A").', '.strftime("%#d").' de '.strftime('%B').' de '.strftime('%Y'); ?>
    </div>
    <!-- Default to the left -->
    <strong>Desenvolvido por CERAT-FO &copy; 2017 <a href="#"></a>.</strong> 
  </footer>

  
 
</div>
<!-- ./wrapper -->
	<!-- jQuery 3 -->
	<script src="bower_components/jquery/dist/jquery.min.js"></script>
	<!-- Bootstrap 3.3.7 -->
	<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<!-- AdminLTE App -->
	<script src="dist/js/adminlte.min.js"></script>
</body>
</html>