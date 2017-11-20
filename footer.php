<?php 
	require_once("funcoes.php");
	protegeArquivo(basename(__FILE__));
?>
 	

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
      <?php      	        
        echo(iconv('ISO-8859-1', 'UTF-8', strftime('%A'))).', '.strftime("%#d").' de '.strftime('%B').' de '.strftime('%Y'); 
      	?>
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
	<!-- CK Editor -->
	<script src="bower_components/ckeditor/ckeditor.js"></script>
	<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
	
	<!-- page script -->
	<script>
	 $(function () {
	    CKEDITOR.replace('editor1')	
	
	  //Date picker
	    $('#datepicker1').datepicker({	    
	      format:"yyyy-mm-dd",
	      todayBtn:true,
	      assumeNearbyYear:true,
	      todayHighlight:true,	                
	      autoclose: true
	    })		  

	    $('#datepicker2').datepicker({	    
	      format:"yyyy-mm-dd",
	      todayBtn:true,
	      assumeNearbyYear:true,
	      todayHighlight:true,	                
	      autoclose: true
	    })
	    
	 }); 	
	
	  
	  $(function () {		
		
	    $('#gridfull').DataTable({
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