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
	<!-- DataTables -->
	<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<!-- SlimScroll -->
	<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<!-- FastClick -->
	<script src="bower_components/fastclick/lib/fastclick.js"></script>
	<!-- AdminLTE App -->
	<script src="dist/js/adminlte.min.js"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="dist/js/demo.js"></script>
	<!-- page script -->
	<script>
	  $(function () {
	  	
	    $('#gridprojetos').DataTable({
	    	"oLanguage": {
	                    "sZeroRecords": "Nenhum dado econtrado para exibição",
	                    "sInfo": "Exibindo _START_ à _END_ de _TOTAL_ de registros",
	                    "sInfoEmpty": "Nenhum registro para ser exibido",
	                    "sInfoFiltered": "(filtrado de _MAX_ registros no total)",
	                    "slengthMenu":     "Show _MENU_ entries",
	                    "sSearch": "Pesquisar",
	                    "sLengthMenu" : "Exibir _MENU_ registros por Página",
	                    "oPaginate": {
      							  "sFirst":      "Primeiro",
        						  "sLast":       "Último",
        						  "sNext":       "Próximo",
        						  "sPrevious":   "Anterior"
    					},
	                },
	               
	                "bPaginate": true,
	                 
	                "aaSorting": [[0, "asc"]] 
	    })	  
	  })
	</script>
</body>
</html>