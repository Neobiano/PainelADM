<?php  
//index.php
$connect = mysqli_connect("localhost", "root", "", "aulas");
$query = "SELECT * FROM prioridades ORDER BY id DESC";
$result = mysqli_query($connect, $query);
 ?>  
<!DOCTYPE html>  
<html>  
 <head>  
  <title>Webslesson Tutorial | Bootstrap Modal with Dynamic MySQL Data using Ajax & PHP</title>  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
  <style type="text/css">@import url("http://127.0.0.1/PainelADM/bower_components/font-awesome/css/font-awesome.min.css");</style>
<style type="text/css">@import url("http://127.0.0.1/PainelADM/bower_components/Ionicons/css/ionicons.min.css");</style>
<style type="text/css">@import url("http://127.0.0.1/PainelADM/bower_components/select2/dist/css/select2.min.css");</style>
<style type="text/css">@import url("http://127.0.0.1/PainelADM/dist/css/AdminLTE.min.css");</style>
<style type="text/css">@import url("http://127.0.0.1/PainelADM/dist/css/skins/skin-blue.min.css");</style>
<style type="text/css">@import url("http://127.0.0.1/PainelADM/bower_components/bootstrap/dist/css/bootstrap.min.css");</style>
<style type="text/css">@import url("http://127.0.0.1/PainelADM/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css");</style>
<style type="text/css">@import url("http://127.0.0.1/PainelADM/dist/css/skins/_all-skins.min.css");</style>
<style type="text/css">@import url("http://127.0.0.1/PainelADM/plugins/iCheck/square/blue.css");</style>
<style type="text/css">@import url("http://127.0.0.1/PainelADM/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css");</style>
<link rel="stylesheet" type="text/css" href="http://127.0.0.1/PainelADM/css/style.css" media="screen" />
<script type="text/javascript" src="http://127.0.0.1/PainelADM/js/geral.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
	<script src="'"></script>
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
	
	<script src="dist/js/demo.js"></script>
	<script src="bower_components/select2/dist/js/select2.full.min.js"></script>	
	<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>	         	   	
	   <script type="text/javascript" src="bower_components/fastclick/lib/fastclick.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


<script type="text/javascript" src="bower_components/ckeditor/ckeditor.js"></script>
                    			            	
 </head>  
 <body>  
  <script>
	$(document).ready(function()
	{        
	  console.log('vai seu merda1'); 
	  $('#insert_form').on("submit", function(event){
		   event.preventDefault();                       	   
		   console.log('vai seu merda');	        	                 	                   	 
		   $.ajax({  
			url:"prioridades.php",  
			method:"POST",  
			data:$('#insert_form').serialize(),  
			beforeSend:function(){  
									$('#insert').val("Inserting");  
								 }, 
								  
			success:function(data){  
			 $('#insert_form')[0].reset();  
			 $('#add_data_Modal').modal('hide');  
			 $('#employee_table').html(data);  
			}
									  
		   });                  	 
		});
	});
 
	$(document).ready(function()
	{
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
		
		$('.select2').select2()
	});
	</script> 

  <br /><br />  
  <div class="container" style="width:700px;">  
   <h3 align="center">Insert Data Through Bootstrap Modal by using Ajax PHP</h3>  
   <br />  
   <div class="table-responsive">
    <div align="right">
     <button type="button" name="age" id="age" data-toggle="modal" data-target="#add_data_Modal" class="btn btn-warning">Add</button>
    </div>
    <br />
    <div id="employee_table">
     <table class="table table-bordered">
      <tr>
       <th width="70%">Employee Name</th>  
       <th width="30%">View</th>
      </tr>
      <?php
      while($row = mysqli_fetch_array($result))
      {
      ?>
      <tr>
       <td><?php echo $row["nome"]; ?></td>
       <td><input type="button" name="view" value="view" id="<?php echo $row["id"]; ?>" class="btn btn-info btn-xs view_data" /></td>
      </tr>
      <?php
      }
      ?>
     </table>
    </div>
   </div>  
    <!-- Modal Prioridade -->	
	<div class="modal fade" id="add_data_Modal" data-backdrop="static">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Prioridades - Incluir</h4>
		  </div>
		  
			  <div class="modal-body">
				<form method="post" id="insert_form">	
					<div class="box-body">
						<div class="form-group">
							<label>Código</label>
							<input disabled name="nome" type="text" class="form-control input-sm" placeholder="Automático">
						</div>
						
						<div class="form-group">
							<label>Nome</label>
							<input autofocus name="nome" type="text" class="form-control input-sm" placeholder="Nome da prioridade">
						</div>                                                                								
					</div>      
				  <input type="submit" name="insert" id="insert" value="Insert" class="btn btn-success" />
				</form>
			  </div>   
			  <div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>                                                           
			  </div>                                                      
		</div>
		<!-- /.modal-content -->
	  </div>
	  <!-- /.modal-dialog -->
	</div>
  </div>
 </body>  
</html>  



<div id="dataModal" class="modal fade">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Employee Details</h4>
   </div>
   <div class="modal-body" id="employee_detail">
    
   </div>
   <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
   </div>
  </div>
 </div>
</div>


