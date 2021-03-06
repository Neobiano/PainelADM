
<?php   
    require_once(dirname(dirname(__FILE__))."/funcoes.php");
           
    //verificando se há registros no BD, caso contrario abrirá a inserção.
    if ($tela =='listar')
    {
        $qtarefa = new tarefa();       
        $qtarefa->selecionaTudo($qtarefa);
        if ($qtarefa->linhasafetadas <= 0)
            $tela = 'incluir';        
    }
    
    //todas as telas de edição usarão os códigos abaixo
    if ($tela !='listar')
    {
        protegeArquivo(basename(__FILE__));
        loadJS('bower_components/ckeditor/ckeditor.js',true);       
        //loadJS('http://malsup.github.com/jquery.form.js',true);  
        loadJS('js/jquery.form.js',true);
        ?>
        	<script>  	
        		   //função que irá efetivamente enviar os arquivos ao servidor				      	  		    		               	
                   $('body').on('click', '#upload', function(e){
                            //e.preventDefault();
                            var formData = new FormData($(this).parents('form')[0]);                                                    
                            $.ajax({
                                url: 'modulos/arquivos_upload.php',
                                type: 'POST',
                                xhr: function() {
                                    var myXhr = $.ajaxSettings.xhr();
                                    return myXhr;
                                },
                                success: function (data) {
                                    alert("Arquivo enviado: "+data);
                                    $('#insert_voltar').trigger('click');
                                },
                                data: formData,
                                cache: false,
                                contentType: false,
                                processData: false
                            });                            
                            return false;
                             
                    });	                 
                   
                   function myFunction(val) {
                	    //alert(val);
                	};

                	function deleteFile() {
                		
						   var id = [];
					   
						   $(':checkbox:checked').each(function(i)
						   {
							  id[i] = $(this).val();
						   });
					   
						   if(id.length === 0) //se não houver checkbox selecionado
						   {
							  alert("Selecione um arquivo para exclusão!");
						   }
						   else
						   {	
							   if(confirm("Deseja realmente excluir o(s) arquivo(s) selecionado(s)?"))
							   {	
    								$.ajax({
        										 url:'modulos/arquivos_delete.php',
        										 method:'POST',
        										 data:{id:id},
        										 success:function()
        										 {        							
            										 alert("Arquivo(s) excluído(s) com sucesso!");        						
        											 $('#list_voltar').trigger('click'); 
        										 },
        										 error: function() {
                           							window.alert('Atenção! Erro na exclusão do arquivo');                           							                          							
                           						  }									
        								});
							   }
							   else							   	
								  return false;
								  
						   }							   
						              	    
                	};
               		
					 //função que irá 'limpar' o imput de arquivos antes de exibir (onclick do botao)
                     function initImput(codTarefa)
                     {					
                         	
                    	 $('#file').val('');                    	 
                    	 $('#file-list').html("");                    	 
                    	 $("#codTarefa2").val(codTarefa);
                     };    

                   //função utilizada para listar os arquivos (msg) vinculados a tarefa
                	 function qtdeArquivo(Tipo){                   	  	
                   	    //event.preventDefault();  
                   	    $span = $('#qtdearquivos');
                   	    codTarefa = $("#formEditar").find('input[name="codTarefa"]').val(); //get the value..                   	  
                    
                   	    	
                       	$.ajax({  
                      		url:"modulos/arquivos_dados.php",                 			  
                      		method:'POST',                           		
                      		dataType: 'json',	
                      		data: {idtarefa: codTarefa},				  
                      		success:function(data){   
                          	var  qtde; 	
                          						$span.html('');                          						
                          						qtde = 0;            	    							                         																											                     			                                                                     
                                                $.each(data.jarquivos, function (key, val) 
												{                                    							                              				                            															                                    				
                                         	 		qtde = 	val.total_arquivos;   
                                        	 		return false;                										   
                   								 });             
                   								 
												 if (qtde == 0)	
                       							   $span.removeClass('badge bg-blue').addClass('badge bg-red');
												 else                               							
												   $span.removeClass('badge bg-red').addClass('badge bg-blue');	                        							                                                   

                                                 $span.text(qtde);
        												                   								               				
        							 				                    							                                                  	      
                      							   },
                      		error: function() {
                      							window.alert('erro');                           							                          							
                      						  }
                      
                      						  
                      	});                        	 
                   	}; 
                   		
	                 //função utilizada para listar os arquivos (msg) vinculados a tarefa
                	 function modalArquivo(pidTarefa){                   	  	
                   	   // event.preventDefault();  
                   	    $janela = $('#add_data_Modal_arquivo');                    	  
        
                       	$.ajax({  
                      		url:"modulos/arquivos_dados.php",                 			  
                      		method:'POST',                           		
                      		dataType: 'json',	
                      		data: {idtarefa: pidTarefa},				  
                      		success:function(data){   
                          	var chtml; 	
				                     			$janela.html('');           	    							                         								
															

				                     			chtml =  '  		<div class="modal-dialog modal-lg"> '+
                                                         '  			<div class="modal-content"> '+
                                                         '        		<form method="post" id="list_form_arquivo">	'+
                                                         '        			<section class="content"> '+                                                         
                                                         '              			<div class="row"> '+                                    
                                                         '                			<div> '+                                 
                                                         '                  				<div class="box box-primary"> '+
                                                         '                    				<div class="box-header with-border"> '+
                                                         '                      					<h3 class="box-title">Lista de Arquivos</h3> '+                        
                                                         '                      					<div class="box-tools pull-right"> '+
                                                                             '                        <div class="has-feedback"> '+
                                                                             '                          <input type="text" class="form-control input-sm" placeholder="Procurar Mensagem"> '+
                                                                             '                          <span class="glyphicon glyphicon-search form-control-feedback"></span> '+
                                                                             '                        </div> '+
                                      					'					                    </div> '+                                    
                                                         '                                  </div> '+                                                                            
                                                         '                    			   <div class="box-body no-padding"> '+
                                                         '                                    <div class="mailbox-controls"> '+                                                                                               
                                                                         '                       <div class="btn-group"> '+
                                                                         '                          <button name="btn_delete" type="button" onclick="deleteFile()" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button> '+//deletar                                   
                                                                         '                       </div> '+                                                                                                                                            
                                                         '             				         </div> '+
                                                                     '                        <div class="table-responsive mailbox-messages"> '+
                                                                     '                          <table id="gridfull" class="table table-hover table-striped table-bordered table-hover"> '+                                                                   
                                                                     '								 <thead class="thead-light">'+
                                                                     	'								 <tr>'+
                                                                     		'								 <td></td>'+
                                                                     		'								 <td>Arquivo</td>'+
                                                                     		'								 <td>Descrição</td>'+
                                                                     		'								 <td>Usuário</td>'+
                                                                     		'								 <td>Data & Hora</td>'+
                                                                     		'							  <tr>'+
                                                                     		'						 </thead>'+
                                                                     		  '                      <tbody>';
                                                                     		
                                                         $.each(data.jarquivos, function (key, val) 
    														{                                    							                              				                            	
	          													$valor = val.nome_arquivo+'<>'+val.referencia;
    		                                                	chtml +=  '<tr>'; 
                                                        	 	chtml +=  '<td><input type="checkbox" value="'+val.id+'" onchange="myFunction(this.value)"></td>'; 
                                                                chtml +=  '<td class="mailbox-attachment"><a href="modulos/arquivos_download.php?file='+$valor+'">'+ val.nome_arquivo +'</a></td>';                         									                                                                                                                              
                                                                chtml +=  '<td class="mailbox-name">'+ val.descricao +'</td>';
                                                                chtml +=  '<td class="mailbox-name">'+ val.usuario +'</td>'; 
                                                                                        									                            									
                                                                chtml +=  '<td class="mailbox-date	">'+  (val.data_hora) +'</td>';
                                                                chtml +=  '</tr>'; 	                  										   
                               								 });             
                                                                     
                                                         chtml +=   '                             </tbody> '+
                                                                     '                          </table> '+                                   
                                                                     '                        </div> '+                                   
                                                         '                    </div> '+                                                                                                                                                       
                                                         '                  </div> '+
                                                         '                </div> '+
                                                         '              </div> '+
                                                         '            </section> '+  
                                                         '        	<div class="modal-footer"> '+    
                                                         '        		<button type="button" data-dismiss="modal" name="list_voltar" id="list_voltar" onclick="qtdeArquivo('+pidTarefa+')" class="btn btn-primary">Voltar</button> '+                                                        
                                                         '        	</div> '+ 	                            	                          	   		                                                  		                                                                                        
                                                         '        </form> '+                                                                                                         
                                                         '    </div> '+                                                          
                                                         '  </div> ';
                                                         $janela.append(chtml);
        												                   								               				
        							 				                    							                                                  	      
                      							   },
                      		error: function() {
                      							window.alert('erro');                           							                          							
                      						  }
                      
                      						  
                      	});                        	 
                   	};      
                   			                
         			$(document).ready(function()
                 	{ 			

         				var filesUpload = document.getElementById("file"),
         			    fileList = document.getElementById("file-list");

         				function uploadFile (file) {
         				    var 
         				    	
         				    	li = document.createElement('li'),
         				        div = document.createElement("div"),            
         				        reader,
         				        xhr,
         				        fileInfo;
         				    
         				    li.appendChild(div);

         				    // Present file info and append it to the list of files class=\"neutral\"
         				    fileInfo = "<div>Arquivo: <strong>" + file.name + "</strong> tamanho <strong>" + parseInt(file.size / 1024, 10) + "</strong> kb esta na lista.</div>";
         				    div.innerHTML = fileInfo;

         				    fileList.appendChild(div);
         				}
         				
         				function traverseFiles (files) {
         				    if (typeof files !== "undefined") {
         				        for (var i=0, l=files.length; i<l; i++) {
         				            uploadFile(files[i]);
         				        }
         				    }
         				    else {
         				        fileList.innerHTML = "<div class=\"neutral\">Seu navegador não suporte o envio de multiplos arquivos ao mesmo tempo. Use outro navegador ou envie um arquivo por vez. <div>";
         				    }   
         				}                	    			                       
         				filesUpload.addEventListener("change", function () {
         				    document.getElementById('file-list').innerHTML = "";
         				    traverseFiles(this.files);
         				}, false);
         				
         				//----------------------------------JAVASCRIPT CONTROLES - Data, Editor de Texto, Selects------------------ --//
                        $('.js_date_time').datepicker({
                            format:"dd/mm/yyyy",
                            todayBtn:true,
                            assumeNearbyYear:true,
                            todayHighlight:true,
                            autoclose: true
                        });
	
                      	//editor de texto
						CKEDITOR.replace('editor1');

                        //selects
                        $('.select2').select2();

                        //----------------------------------JAVASCRIPT FORMULÁRIOS MODAIS -------------------------------- --//
						//faz com que seja possível atribuir autofocus para imputs de janelas modais 
                        $('.modal').on('shown.bs.modal', function() {
                        	
                        	  $(this).find('[autofocus]').focus();
                        	});

                       
                      	
                 		//modal prioridade		             	    		    	                          
                        $('#insert_form_prioridade').on("submit", function(event){ 
                            $select = $('#idprioridade');       
                            //event.preventDefault();          	                 	                   	 
                            $.ajax({  
                            		url:"modulos/prioridades.php",                 			  
                            		method:"POST",  
                            		data: $('#insert_form_prioridade').serialize(),                              	    
                            		//dataType:'html',
                            		dataType: 'json',					  
                            		success:function(data){                              	    							
                            								 $('#insert_form_prioridade')[0].reset();  
                            								 $('#add_data_Modal_prioridade').modal('hide');                   										                 										 
                            								                	     
                            								//clear the current content of the select                                
                            								 $select.html('');
                            								 //iterate over the data and append a select option
                            								 $.each(data.jprioridades, function (key, val) {
                                								 if (val.lastid){	 							                                    								 
                            									    $select.append('<option selected value="' + val.id + '">' + val.nome + '</option>');
                                								 }
                                								 else {
                                									 $select.append('<option value="' + val.id + '">' + val.nome + '</option>');
                                    							  }	                  										   
                            								 })	                                                   	       
                            							   },
                            		error: function() {
                            							alert(data);                            							 
                            							$select.html('<option value="-1">ERRO NA INSERÇÃO</option>');
                            						  }
                            
                            						  
                            	});                     	             		                 		                 		
						});

                        //modal categoria		             	    		    	                          
                        $('#insert_form_categoria').on("submit", function(event){ 
                            $select = $('#idcategoria');       
                            //event.preventDefault();          	                 	                   	 
                            $.ajax({  
                            		url:"modulos/categorias.php",                 			  
                            		method:"POST",  
                            		data: $('#insert_form_categoria').serialize(),                              	    
                            		//dataType:'html',
                            		dataType: 'json',					  
                            		success:function(data){                              	    							
                            								 $('#insert_form_categoria')[0].reset();  
                            								 $('#add_data_Modal_categoria').modal('hide');                   										                 										 
                            								                	     
                            								 //clear the current content of the select                                
                            								 $select.html('');                            								 
                            								 //iterate over the data and append a select option                            								 
                            								 $.each(data.jcategorias, function (key, val) {
                                								 if (val.lastid){	 							                                    								 
                            									    $select.append('<option selected value="' + val.id + '">' + val.nome + '</option>');
                                								 }
                                								 else {
                                									 $select.append('<option value="' + val.id + '">' + val.nome + '</option>');
                                    							  }	                  										   
                            								 })	                                                   	       
                            							   },
                            		error: function() {
                            							alert(data);                            							 
                            							$select.html('<option id="-1">ERRO NA INSERÇÃO</option>');
                            						  }
                            
                            						  
                            	});                     	             		                 		                 		
						});

                        //modal status		             	    		    	                          
                        $('#insert_form_status').on("submit", function(event){ 
                            console.log('1');
                            $select = $('#idstatus');       
                            //event.preventDefault();          	                 	                   	 
                            $.ajax({  
                            		url:"modulos/status.php",                 			  
                            		method:"POST",  
                            		data: $('#insert_form_status').serialize(),                              	    
                            		//dataType:'html',
                            		dataType: 'json',					  
                            		success:function(data){                              	    							
                            								 $('#insert_form_status')[0].reset();  
                            								 $('#add_data_Modal_status').modal('hide');                   										                 										 
                            								  console.log('sucesso');               	     
                            								 //clear the current content of the select                                
                            								 $select.html('');                            								 
                            								 //iterate over the data and append a select option                            								 
                            								 $.each(data.jstatus, function (key, val) {
                                								 if (val.lastid){	 							                                    								 
                            									    $select.append('<option selected value="' + val.id + '">' + val.nome + '</option>');
                                								 }
                                								 else {
                                									 $select.append('<option value="' + val.id + '">' + val.nome + '</option>');
                                    							  }	                  										   
                            								 })	                                                   	       
                            							   },
                            		error: function() {
                            							console.log('erri');		
            											//alert(data);                            							 
                            							$select.html('<option id="-1">ERRO NA INSERÇÃO</option>');
                            						  }
                            
                            						  
                            	});                     	             		                 		                 		
						});

                        //modal projetos		             	    		    	                          
                        $('#insert_form_projeto').on("submit", function(event){ 
                            $select = $('#idprojeto');       
                            //event.preventDefault();          	                 	                   	 
                            $.ajax({  
                            		url:"modulos/projetos.php",                 			  
                            		method:"POST",  
                            		data: $('#insert_form_projeto').serialize(),                              	    
                            		//dataType:'html',
                            		dataType: 'json',					  
                            		success:function(data){                              	    							
                            								 $('#insert_form_projeto')[0].reset();  
                            								 $('#add_data_Modal_projeto').modal('hide');                   										                 										 
                            								                	     
                            								 //clear the current content of the select                                
                            								 $select.html('');                            								 
                            								 //iterate over the data and append a select option                            								 
                            								 $.each(data.jprojetos, function (key, val) {
                                								 if (val.lastid){	 							                                    								 
                            									    $select.append('<option selected value="' + val.id + '">' + val.nome + '</option>');
                                								 }
                                								 else {
                                									 $select.append('<option value="' + val.id + '">' + val.nome + '</option>');
                                    							  }	                  										   
                            								 })	                                                   	       
                            							   },
                            		error: function() {
                            							alert(data);                            							 
                            							$select.html('<option id="-1">ERRO NA INSERÇÃO</option>');
                            						  }
                            
                            						  
                            	});                     	             		                 		                 		
						});

                        //modal tipos		             	    		    	                          
                        $('#insert_form_tipo').on("submit", function(event){ 
                            $select = $('#idtipo');       
                            //event.preventDefault();          	                 	                   	 
                            $.ajax({  
                            		url:"modulos/tipos.php",                 			  
                            		method:"POST",  
                            		data: $('#insert_form_tipo').serialize(),                              	    
                            		//dataType:'html',
                            		dataType: 'json',					  
                            		success:function(data){                              	    							
                            								 $('#insert_form_tipo')[0].reset();  
                            								 $('#add_data_Modal_tipo').modal('hide');                   										                 										 
                            								                	     
                            								 //clear the current content of the select                                
                            								 $select.html('');                            								 
                            								 //iterate over the data and append a select option                            								 
                            								 $.each(data.jtipos, function (key, val) {
                                								 if (val.lastid){	 							                                    								 
                            									    $select.append('<option selected value="' + val.id + '">' + val.nome + '</option>');
                                								 }
                                								 else {
                                									 $select.append('<option value="' + val.id + '">' + val.nome + '</option>');
                                    							  }	                  										   
                            								 })	                                                   	       
                            							   },
                            		error: function() {
                            							alert(data);                            							 
                            							$select.html('<option id="-1">ERRO NA INSERÇÃO</option>');
                            						  }
                            
                            						  
                            	});                     	             		                 		                 		
						});
                 	});   
                 	         			           	                    
                </script> 
                     <!-- testes de modal -->
                     <div class="modal fade" id="insert_form_arquivo">
            			<div class="modal-dialog">
            				<div class="modal-content">        					
            					<div class="container"></div>
            					<div class="modal-body">
            					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            						<form enctype="multipart/form-data" action="arquivos_upload.php" method="post">
                						<fieldset>                						
                							<legend>Selecionar</legend>
                    						<div class="form-group">      
                    						    <input type="hidden"  id="codTarefa2" name="codTarefa2"  class="form-control" >              							
                    							<div class="input-group input-file">
        											<span class="input-group-btn">   
        												<button class="btn btn-default btn-choose" type="button">Escolha</button>                                                                                 	
                                                    </span>
                                                    	<input type="file" name="file[]"  id="file" multiple class="form-control" placeholder='Selecione os arquivos...'  />                                                   
                                                                                            
                                            	</div>
                                            	<div id="file-list"></div> 
        									</div>
                                        </fieldset>
                                        	
                                    	<fieldset>
                                        	<input type="button" id="upload" value="Enviar Arquivos" class="btn btn-info pull-left" />
                                            <button type="button" class="btn btn-primary pull-right" onclick="qtdeArquivo(1)"  name="insert_voltar" id="insert_voltar" data-dismiss="modal">Voltar</button>
                                        </fieldset>
                                      </form>       
                                </div>                                                                                                                                                                                                                                      
            				</div>        				
            			</div>        			
            		</div>
        		
        		
                <!----------------------------------HTML FORMULÁRIOS MODAIS -------------------------------- -->
                <!-- Modal Prioridade -->	
                <div class="modal fade" id="add_data_Modal_prioridade" data-backdrop="static">
                  <div class="dialog"></div>
                  <div class="modal-dialog">
                    <div class="modal-content">                                                                     
                        <form method="post" id="insert_form_prioridade">	
                        	<div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Prioridades - Incluir</h4>
                        	</div>   
                        	<div class="modal-body">	
                                <div class="box-body">
                                	<div class="row">
                        				<div class="form-group">
                        					<div class="col-xs-2">
                        						<label>Código</label>
                        						<input disabled name="id" type="text" class="form-control input-sm" placeholder="Automático">
                        					</div>        									
                        				
                        					<div class="col-xs-10">
                        						<label>Nome</label>
                        						<input autofocus name="nome" type="text" class="form-control input-sm" placeholder="Nome da prioridade">
                        					</div>                                        
                        				</div>
                        			</div>                         			                                                              								
                        		</div> 
                        	</div>   
                        	<div class="modal-footer">
                        		<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>                         		    
                        		<button type="submit" name="insert" id="insert" class="btn btn-primary">Salvar</button>                                                           
                        	</div>  	                            	                          	   		                                                  		                                                                                        
                        </form>                                                                                                         
                    </div>
                    <!-- /.modal-content -->
                  </div>
                  <!-- final modal prioridade -->
                </div>
                
                <!-- Modal Categoria -->	
                <div class="modal fade" id="add_data_Modal_categoria" data-backdrop="static">
                  <div class="dialog"></div>
                  <div class="modal-dialog">
                    <div class="modal-content">                                                                     
                        <form method="post" id="insert_form_categoria">	
                        	<div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Categorias - Incluir</h4>
                        	</div>   
                        	<div class="modal-body">	
                                <div class="box-body">
                                	<div class="row">
                        				<div class="form-group">
                        					<div class="col-xs-2">
                        						<label>Código</label>
                        						<input disabled name="id" type="text" class="form-control input-sm" placeholder="Automático">
                        					</div>        									
                        				
                        					<div class="col-xs-10">
                        						<label>Nome</label>
                        						<input autofocus name="nome" type="text" class="form-control input-sm" placeholder="Nome da categoria">
                        					</div>                                        
                        				</div>
                        			</div>                         			                                                              								
                        		</div> 
                        	</div>   
                        	<div class="modal-footer">
                        		<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>                         		    
                        		<button type="submit" name="insert" id="insert" class="btn btn-primary">Salvar</button>                                                           
                        	</div>  	                            	                          	   		                                                  		                                                                                        
                        </form>                                                                                                         
                    </div>
                    <!-- /.modal-content -->
                  </div>
                  <!-- final modal Categoria -->
                </div>
        		
        		<!-- Modal Status -->	
                <div class="modal fade" id="add_data_Modal_status" data-backdrop="static">
                  <div class="dialog"></div>
                  <div class="modal-dialog">
                    <div class="modal-content">                                                                     
                        <form method="post" id="insert_form_status">	
                        	<div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Status - Incluir</h4>
                        	</div>   
                        	<div class="modal-body">	
                                <div class="box-body">
                                	<div class="row">
                        				<div class="form-group">
                        					<div class="col-xs-2">
                        						<label>Código</label>
                        						<input disabled name="id" type="text" class="form-control input-sm" placeholder="Automático">
                        					</div>        									
                        				
                        					<div class="col-xs-10">
                        						<label>Nome</label>
                        						<input autofocus name="nome" type="text" class="form-control input-sm" placeholder="Nome do Status">
                        					</div>                                        
                        				</div>
                        			</div>                         			                                                              								
                        		</div> 
                        	</div>   
                        	<div class="modal-footer">
                        		<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>                         		    
                        		<button type="submit" name="insert" id="insert" class="btn btn-primary">Salvar</button>                                                           
                        	</div>  	                            	                          	   		                                                  		                                                                                        
                        </form>                                                                                                         
                    </div>
                    <!-- /.modal-content -->
                  </div>
                  <!-- final modal status -->
                </div>
                
                 <!-- Modal Tipo -->	
                <div class="modal fade" id="add_data_Modal_tipo" data-backdrop="static">
                  <div class="dialog"></div>
                  <div class="modal-dialog">
                    <div class="modal-content">                                                                     
                        <form method="post" id="insert_form_tipo">	
                        	<div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Tipos - Incluir</h4>
                        	</div>   
                        	<div class="modal-body">	
                                <div class="box-body">
                                	<div class="row">
                        				<div class="form-group">
                        					<div class="col-xs-2">
                        						<label>Código</label>
                        						<input disabled name="id" type="text" class="form-control input-sm" placeholder="Automático">
                        					</div>        									
                        				
                        					<div class="col-xs-10">
                        						<label>Nome</label>
                        						<input autofocus name="nome" type="text" class="form-control input-sm" placeholder="Nome do tipo">
                        					</div>                                        
                        				</div>
                        			</div>                         			                                                              								
                        		</div> 
                        	</div>   
                        	<div class="modal-footer">
                        		<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>                         		    
                        		<button type="submit" name="insert" id="insert" class="btn btn-primary">Salvar</button>                                                           
                        	</div>  	                            	                          	   		                                                  		                                                                                        
                        </form>                                                                                                         
                    </div>
                    <!-- /.modal-content -->
                  </div>
                  <!-- final modal tipos -->
                </div>
                
                <!-- Modal Projeto -->	
                <div class="modal fade" id="add_data_Modal_projeto" data-backdrop="static">
                  <div class="dialog"></div>
                  <div class="modal-dialog">
                    <div class="modal-content">                                                                     
                        <form method="post" id="insert_form_projeto">	
                        	<div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Projetos - Incluir</h4>
                        	</div>   
                        	<div class="modal-body">	
                                <div class="box-body">
                                	<div class="row">
                        				<div class="form-group">
                        					<div class="col-xs-2">
                        						<label>Código</label>
                        						<input disabled name="id" type="text" class="form-control input-sm" placeholder="Automático">
                        					</div>        									
                        				
                        					<div class="col-xs-10">
                        						<label>Nome</label>
                        						<input autofocus name="nome" type="text" class="form-control input-sm" placeholder="Nome do projeto">
                        					</div>                                        
                        				</div>
                        			</div>                         			                                                              								
                        		</div> 
                        	</div>   
                        	<div class="modal-footer">
                        		<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>                         		    
                        		<button type="submit" name="insert" id="insert" class="btn btn-primary">Salvar</button>                                                           
                        	</div>  	                            	                          	   		                                                  		                                                                                        
                        </form>                                                                                                         
                    </div>
                    <!-- /.modal-content -->
                  </div>
                  <!-- final modal projetos -->
                </div>
                
                                
                <div class="modal fade" id="add_data_Modal_arquivo" data-backdrop="static">                
                  
                </div>
     
        <?php 
    } //FINAL ($tela !='listar')
    else
    {
        //------------DEPENDENCIAS DEVEXTREME-----------//
        loadCSS('Lib/css/dx.spa','screen',true);
        loadCSS('Lib/css/dx.common','screen',true);
        loadCSS('Lib/css/dx.light','screen',true);
        loadJS('Lib/js/jszip.min.js',true);
        loadJS('Lib/js/dx.all.js',true);
    }
    
    switch ($tela)     
    {                      
        case 'editar':                     
            $sessao = new sessao();
            
            //verificando se o usuário logado é admin            
            if (isAdmin()==true)
            {
                //se possui ID definido no roteamento, pois se não tiver indica que o usuário tentou 'entrar direto na página'    
                if (isset($_GET['id']))
                {
                    $id = $_GET['id'];
                    
                    //verificando se ele escolheu a botão 'editar' 
                    if (isset($_POST['editar']))
                    {                                                                                    
                        $dataini =$_POST['dataini'];                                                
                        $dataini = date("Y-m-d",strtotime(str_replace('/','-',$dataini)));
                        
                        $dataprevfim =$_POST['dataprevfim'];
                        $dataprevfim = date("Y-m-d",strtotime(str_replace('/','-',$dataprevfim)));
                        
                        
                        $tarefa = new tarefa(array(
                            'assunto'=>$_POST['assunto'],
                            'descricao'=>$_POST['editor1'],
                            'id_tipo'=>$_POST['tipo'],
                            'id_status'=>$_POST['status'],
                            'id_prioridade'=>$_POST['prioridade'],
                            'id_projeto'=>$_POST['projeto'],
                            'id_categoria'=>$_POST['categoria'],
                            'id_atribuido'=>$_POST['atribuido'],
                            'id_criador'=>$_POST['atribuido'],
                            'data_inicio'=>$dataini,
                            'data_prev_fim'=>$dataprevfim
                        ));
                                                
                        $duplicado=false;
                        $tarefa->valorpk = $id;
                        $tarefa->extras_select = "WHERE id=$id";
                        $tarefa->selecionaTudo($tarefa);
                        $res = $tarefa->retornaDados();
                        
                        //se o assunto foi alterado do inicilamente carregado para o registro
                        if ($res->assunto != $_POST['assunto'])
                        {
                            //verificando se já existe um email no BD como o 'novo' email cadastrado
                            if ($tarefa->existeRegistro('assunto',$_POST['assunto']))
                            {
                                printMSG('tarefa já existe no sistema, escolha outro assunto!','erro');
                                $duplicado = TRUE;
                            }
                        }

                        //se não existe vai atualizar normalmente
                        if ($duplicado!=TRUE)
                        {
                            $tarefa->atualizar($tarefa);
                            if ($tarefa->linhasafetadas==1)
                            {
                                printMSG('Dados alterados com sucesso. <a href="?m=tarefas&t=listar">Exibir cadastros</a>','sucesso');
                                unset($_POST);
                            }
							else                         
                            	printMSG('Nenhum dado foi alterado. <a href="?m=tarefas&t=listar">Exibir cadastros</a>','alerta');
                        }
                                    
                    }//if (isset($_POST['editar'])) - final
                    
                    //se não clicou no botão salvar, so vai carregar os registros do usuário em tela para edição
                    $select = ' select tarefas.*,
                                (select count(*) from arquivos a where a.id_tarefa = tarefas.id) qtde_arquivos
                                from ';
                    $tarefabd = new tarefa();
                    $tarefabd->extras_select = "WHERE id=$id";                    
                    $tarefabd->selecionaTudo($tarefabd,$select);                   
                    
                       
                  
                    $resbd = $tarefabd->retornaDados();
                }
                else
                    printMSG('tarefa não definido, <a href="?m=tarefas&t=listar">escolha um tarefa para alterar</a>','erro');
                                                   
                ?>
                    			            	
                       
                <div class="content-wrapper">
                <!-- Content Header (Page header) --> 
        
                <section class="content-header">
                	<h1>
                		Demandas
                		<small>Editar</small>
                  	</h1>
                  	<ol class="breadcrumb">
                		<li><a ><i class="fa fa-dashboard"></i> Editar</a></li>
                		<li class="active">Editar</li>
                  	</ol>
                </section>     			    			    	
                		               
    			<section class="content">      				    	           
    						<div class="box box-primary">    								
    							<form id="formEditar" class="userform" role="form" method="post" action="">
    								<div class="box-body">
    									<div class="row">
    									 	<div class="form-group">
            									<div class="col-xs-2">
                      								<label>Código</label>
                      								<input disabled name="codTarefa" type="text" class="form-control" placeholder="Código é Automático" value="<?php if($resbd) echo $resbd->id;?>">
            									</div>
            									<div class="col-xs-8">
                      								<label>Assunto</label>
                      								<input autofocus name="assunto" type="text" class="form-control" placeholder="Assunto da Tarefa" value="<?php if($resbd) echo $resbd->assunto;?>">
            									</div>            									                                                         								
            									<div class="col-xs-2">
                      								<label>Tipo</label>
                      								<div class="input-group">
                                                        <select id="idtipo"  name="tipo" class="form-control select2" style="width: 100%;">
                                                        	<option selected="selected" value="0"> </option>
                                                        	<?php 
                                                            	$qtipo = new tipo();                                                	
                                                            	$qtipo->extras_select = " order by nome";
                                                            	$qtipo->selecionaTudo($qtipo);                                                                
                                                                while ($res = $qtipo->retornaDados())
                                                                {                                         
                                                                    if ($resbd->id_tipo == $res->id)
                                                                        printf('<option selected="selected" value="%s">%s</option>',$res->id,$res->nome);
                                                                    else
                                                                        printf('<option value="%s">%s</option>',$res->id,$res->nome);
                                                                } 
                                                            ?>                                              
                                                        </select>
                                                        <span class="input-group-btn">
                                                          <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#add_data_Modal_tipo"> + </button>
                                                        </span>                                                        
													</div> 
            									</div>        									
            							 	</div>            							 	   	
            							</div>	
            							<div class="row top-buffer">
    									 	<div class="form-group">    									 	
                                            	<div class="col-xs-12" >                                                               
                                            			<label>Descrição</label>
                                            			<textarea form-control id="editor1" name="editor1" rows="10" cols="80">
    															<?php if($resbd) echo html_entity_decode($resbd->descricao);?>                                        				                                            				
                                            			</textarea>                                                                                                                                       
                                            	</div>                                            			                                    	     									                                             
    										</div>            							 	   	
            							</div> 	
            							<div class="row top-buffer">
    									 	<div class="form-group">            								
            									<div class="col-xs-4" >            										
                          							<label>Prioridade</label>
                          						    <div class="input-group" id="divselectprioridade">
                                                        <select id="idprioridade" name="prioridade" class="form-control select2 " style="width: 100%;">
                                                        <option selected="selected" value="0"> </option>
                                                        	<?php 
                                                            	$qprioridade = new prioridade();
                                                            	$qprioridade->extras_select = " order by nome";
                                                            	$qprioridade->selecionaTudo($qprioridade);
                                                            	
                                                            	while ($res = $qprioridade->retornaDados())
                                                            	{
                                                            	    if ($resbd->id_prioridade == $res->id)
                                                            	        printf('<option selected="selected" value="%s">%s</option>',$res->id,$res->nome);
                                                            	    else
                                                            	        printf('<option value="%s">%s</option>',$res->id,$res->nome);
                                                            	} 
                                                            ?>                                              
                                                        </select>
                                                        <span class="input-group-btn">
                                                          <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#add_data_Modal_prioridade"> + </button>
                                                        </span>
                                                        
													</div>                                                        
            									</div>              									
                                                
            									<div class="col-xs-4">
                      								<label>Categoria</label>
                      								<div class="input-group">
                                                        <select id="idcategoria" name="categoria" class="form-control select2 " style="width: 100%;">
                                                           <option selected="selected" value="0"> </option>
                                                        	<?php 
                                                            	$qcategoria = new categoria();
                                                            	$qcategoria->extras_select = " order by nome";
                                                            	$qcategoria->selecionaTudo($qcategoria);
                                                            	while ($res = $qcategoria->retornaDados())
                                                            	{
                                                            	    if ($resbd->id_categoria == $res->id)
                                                            	        printf('<option selected="selected" value="%s">%s</option>',$res->id,$res->nome);
                                                            	    else
                                                            	        printf('<option value="%s">%s</option>',$res->id,$res->nome);
                                                            	} 
                                                            ?>                                              
                                                        </select>
                                                        <span class="input-group-btn">
                                                          <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#add_data_Modal_categoria"> + </button>
                                                        </span>
                                                    </div>
            									</div> 
            									<div class="col-xs-4">
                      								<label>Status</label>
                      								<div class="input-group">
                                                        <select id="idstatus" name="status" class="form-control select2" style="width: 100%;">
                                                           <option selected="selected" value="0"> </option>
                                                        	<?php 
                                                            	$qstatus= new status();
                                                            	$qstatus->extras_select = " order by nome";
                                                            	$qstatus->selecionaTudo($qstatus);
                                                            	while ($res = $qstatus->retornaDados())
                                                            	{
                                                            	    if ($resbd->id_status == $res->id)
                                                            	       printf('<option selected="selected" value="%s">%s</option>',$res->id,$res->nome);
                                                            	    else
                                                            	       printf('<option value="%s">%s</option>',$res->id,$res->nome);
                                                            	} 
                                                            ?>                                              
                                                        </select>
                                                        <span class="input-group-btn">
                                                          <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#add_data_Modal_status"> + </button>
                                                        </span>
                                                    </div>
            									</div>       									
            							 	</div>            							 	   	
            							</div>	  
            							
            							<div class="row top-buffer">
    									 	<div class="form-group">            								
            									<div class="col-xs-4">
            										<label>Projeto</label>
            										<div class="input-group">                          								
                                                        <select id="idprojeto" name="projeto" class="form-control select2 " style="width: 100%;">
                                                           <option selected="selected" value="0"> </option>
                                                        	<?php 
                                                        	   $qprojeto = new projeto();
                                                        	   $qprojeto->extras_select = " order by nome";
                                                        	   $qprojeto->selecionaTudo($qprojeto);
                                                        	   while ($res = $qprojeto->retornaDados())
                                                            	{
                                                            	    if ($resbd->id_projeto == $res->id)
                                                            	        printf('<option selected="selected" value="%s">%s</option>',$res->id,$res->nome);
                                                            	    else
                                                            	        printf('<option value="%s">%s</option>',$res->id,$res->nome);
                                                            	} 
                                                            ?>                                              
                                                        </select>
                                               			<span class="input-group-btn">
                                                          	<button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#add_data_Modal_projeto"> + </button>
                                                        </span>
                                                    </div>    
            									</div>  
            									<div class="col-xs-2">
                      								<label>Atribuido à</label>
                                                    <select name="atribuido" class="form-control select2 " style="width: 100%;">
                                                    	<option selected="selected" value="0"> </option>
                                                    	<?php 
                                                        	$qusuario = new usuario();
                                                        	$qusuario->extras_select = " order by nome";
                                                        	$qusuario->selecionaTudo($qusuario);
                                                        	while ($res = $qusuario->retornaDados())
                                                            	{
                                                            	    if ($resbd->id_atribuido == $res->id)
                                                            	       printf('<option selected="selected" value="%s">%s</option>',$res->id,$res->nome);
                                                            	    else
                                                            	       printf('<option value="%s">%s</option>',$res->id,$res->nome);
                                                            	} 
                                                         ?>                                              
                                                    </select>
            									</div>                									
            									<div class="col-xs-2">
                      								<label>Data Início</label>
                      								<div class="input-group date">
                                                      <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                      </div>
                                                      <input class="js_date_time form-control pull-right input-sm" name="dataini" type="text" id="datepicker1" onkeypress="mascaraData(this, event)" value="<?php if($resbd) echo  date('d/m/Y', strtotime($resbd->data_inicio)); ?>">
                                                    </div>
                                                                                                                                                
            									</div>  
            									<div class="col-xs-2">
                      								<label>Data Prev. Fim</label>
                      								<div class="input-group date">
                                                      <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                      </div> <!-- class="" -->
                                                      <input class="js_date_time form-control pull-right input-sm " name="dataprevfim" type="text"  id="datepicker2" onkeypress="mascaraData(this, event)" value="<?php if($resbd) echo date('d/m/Y',strtotime($resbd->data_prev_fim));?>">
                                                    </div>
                                                                                                                                                
            									</div>   
            									             									
            									<div class="col-xs-0  right-buffer">  
            									  <div class="btn-group"> 
                                                      <button type="button" class="btn btn-success top-buffer20" href="#" data-toggle="modal"data-target="#add_data_Modal_arquivo"  onclick="modalArquivo(<?php if($resbd) echo $resbd->id; else echo 0 ?>)">
                                                      <i> Arquivos  </i>
                                                      <?php if($resbd){
                                                    						if ($resbd->qtde_arquivos == 0)
                                                    							echo  '<span id="qtdearquivos" class="badge bg-red">'.$resbd->qtde_arquivos.'</span>';
                                                    						else    
                                                    							echo  '<span id="qtdearquivos" class="badge bg-blue">'.$resbd->qtde_arquivos.'</span>';
                                                    		   }    
                                                     ?>                                                                                                           	
                                                      </button>
                                                      <button aria-expanded="false" type="button" class="btn btn-success dropdown-toggle top-buffer20" data-toggle="dropdown">
                                                          <span class="caret"></span>                                                         
                                                      </button>
                                                      <ul class="dropdown-menu" role="menu">                                                                                                              
                                                         <li id="inserefile" onclick="initImput(<?php if($resbd) echo $resbd->id; else echo 0 ?>)"><a data-toggle="modal" href="#insert_form_arquivo"><i class="fa fa-file-o fa-fw"></i> Inserir</a></li>                                                                                                                                                                                                                           
                                                      </ul>
                                                  </div>
                                                </div>
                										           									     									
            							 	</div>            							 	   	
            							</div>	               							            							
    								</div> 	  	                               
                                  		 
    								<div class="box-footer">  
    									 <button type="button" class="btn btn-default" onclick="location.href='?m=tarefas&t=listar'" >Cancelar</button>
    									 <button type="submit" name="editar" class="btn btn-info pull-right">Salvar Alterações</button>  									    									 
    								</div>     							                          
    						</form>
    		 			</div><!-- Final box-primary -->    					  			
    			</section>
                <!-- /.content -->
			</div> <!-- /.content-wrapper -->
			
                                     
                <?php   
            }//final  if ((isAdmin()==true)||$sessao->getVar('iduser')==$_GET['id'])
            else
                printMSG('Você não tem permissão para acessar essa página. <a href="#" onclick="history.back()">Voltar</a>','erro');
        break;      
            
        case 'incluir':  
            //identificando o usuário logado
            $sessao = new sessao();
            $iduser = $sessao->getVar('iduser');
            
            if (isset($_POST['cadastrar']))
            {    
                               
                $dataini =$_POST['dataini'];
                $dataini = date("Y-m-d",strtotime(str_replace('/','-',$dataini)));
                
                $dataprevfim =$_POST['dataprevfim'];
                $dataprevfim = date("Y-m-d",strtotime(str_replace('/','-',$dataprevfim)));
                
                $tarefa = new tarefa(array(
                    'assunto'=>$_POST['assunto'],
                    'descricao'=>$_POST['editor1'],
                    'id_tipo'=>$_POST['tipo'],
                    'id_status'=>$_POST['status'],
                    'id_prioridade'=>$_POST['prioridade'],
                    'id_projeto'=>$_POST['projeto'],
                    'id_categoria'=>$_POST['categoria'],
                    'id_atribuido'=>$_POST['atribuido'],
                    'id_criador'=>$_POST['atribuido'],
                    'data_inicio'=>$dataini,
                    'data_prev_fim'=>$dataprevfim,
                    'data_cacad'=>date("Y-m-d") 
                ));
             
            
                //verificando se ja existem registros com o parametro solicitado para inserção      
                if ($tarefa->existeRegistro('assunto',$_POST['assunto'])) 
                {
                    printMSG('tarefa já existe no sistema, escolha outro assunto!','erro');
                    $duplicado = true;
                }
                               
                if ($duplicado!=true) 
                {
                    $tarefa->inserir($tarefa);
                   
                    if ($tarefa->linhasafetadas==1)
                    {
                        printMSG('Dados inseridos com sucesso. <a href="'.ADMURL.'?m=tarefas&t=listar">Exibir Cadastros</a>','sucesso');   
                        unset($_POST);                                                                                                                                           
                    }   
                }                               
            }
           
        ?>          
       			                     
                <div class="content-wrapper">
                <!-- Content Header (Page header) --> 
        
                <section class="content-header">
                	<h1>
                		Demandas
                		<small>Incluir</small>
                  	</h1>
                  	<ol class="breadcrumb">
                		<li><a ><i class="fa fa-dashboard"></i> Editar</a></li>
                		<li class="active">Incluir</li>
                  	</ol>
                </section> 
    
                
    			<section class="content">      				    	           
    						<div class="box box-primary">    								
    							<form class="userform" role="form" method="post" action="">
    								<div class="box-body">
    									<div class="row">
    									 	<div class="form-group">
            									<div class="col-xs-2">
                      								<label>Código</label>
                      								<input disabled name="codigo" type="text" class="form-control " placeholder="Automático" >
            									</div>
            									<div class="col-xs-8">
                      								<label>Assunto</label>
                      								<input autofocus name="assunto" type="text" class="form-control"  value="<?php echo $_POST['assunto']?>">
            									</div>            									                                                         								
            									<div class="col-xs-2">
                      								<label>Tipo</label>
                      								<div class="input-group">
                                                        <select id="idtipo" name="tipo" class="form-control select2 " style="width: 100%;">
                                                        	<option selected="selected" value="0"> </option>
                                                        	<?php 
                                                            	$qtipo = new tipo();    
                                                            	$qtipo->extras_select = " order by nome";
                                                                $qtipo->selecionaTudo($qtipo);                                                	                                                	                                                                                                                                                              
                                                                while ($res = $qtipo->retornaDados())
                                                                {                                                                                                         
                                                                
                                                                    if (strtoupper($res->padrao_abertura=='S'))
                                                                        printf('<option selected="selected" value="%s">%s</option>',$res->id,$res->nome);
                                                                    else
                                                                        printf('<option value="%s">%s</option>',$res->id,$res->nome);
                                                                     
                                                                } 
                                                            ?>                                              
                                                        </select>
                                                         <span class="input-group-btn">
                                                          <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#add_data_Modal_tipo"> + </button>
                                                        </span>                                                        
													</div>
            									</div>        									
            							 	</div>            							 	   	
            							</div>	
            							<div class="row top-buffer">
    									 	<div class="form-group">    									 	
                                            	<div class="col-xs-12" >                                                               
                                            			<label>Descrição</label>
                                            			<textarea form-control id="editor1" name="editor1" rows="10" cols="80">
    															<?php if($resbd) echo html_entity_decode($resbd->descricao);?>                                        				                                            				
                                            			</textarea>                                                                                                                                       
                                            	</div>		                                    	     									                                             
    										</div>            							 	   	
            							</div> 	
            							<div class="row top-buffer">
    									 	<div class="form-group">            								
            									<div class="col-xs-4">
                      								<label>Prioridade</label>                      								
                      								<div class="input-group" >
                                                        <select id="idprioridade" name="prioridade" class="form-control select2 " style="width: 100%;">
                                                        <option selected="selected" value="0"> </option>
                                                        	<?php 
                                                            	$qprioridade = new prioridade();
                                                            	$qprioridade->extras_select = " order by nome";
                                                            	$qprioridade->selecionaTudo($qprioridade);
                                                            	while ($res = $qprioridade->retornaDados())
                                                            	{   if (strtoupper($res->padrao_abertura=='S'))
                                                            	       printf('<option selected="selected" value="%s">%s</option>',$res->id,$res->nome);
                                                            	    else
                                                            	       printf('<option value="%s">%s</option>',$res->id,$res->nome);
                                                            	} 
                                                            ?>                                              
                                                        </select>
                                                        <span class="input-group-btn">
                                                		  <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#add_data_Modal_prioridade"> + </button>
                                                		</span>
                                                	</div>  
            									</div>  
            									<div class="col-xs-4">
                      								<label>Categoria</label>
                      								<div class="input-group" >
                                                        <select id="idcategoria" name="categoria" class="form-control select2 " style="width: 100%;">
                                                           <option selected="selected" value="0"> </option>
                                                        	<?php 
                                                            	$qcategoria = new categoria();
                                                            	$qcategoria->extras_select = " order by nome";
                                                            	$qcategoria->selecionaTudo($qcategoria);
                                                            	while ($res = $qcategoria->retornaDados())
                                                            	{                                                        	   
                                                            	    printf('<option value="%s">%s</option>',$res->id,$res->nome);
                                                            	} 
                                                            ?>                                              
                                                        </select>
                                                        <span class="input-group-btn">
                                                		  <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#add_data_Modal_categoria"> + </button>
                                                		</span>
                                                	</div>
            									</div> 
            									<div class="col-xs-4">
                      								<label>Status</label>
                      								<div class="input-group" >                      								
                                                        <select id="idstatus" name="status" class="form-control select2 " style="width: 100%;">
                                                           <option selected="selected" value="0"> </option>
                                                        	<?php 
                                                            	$qstatus= new status();
                                                            	$qstatus->extras_select = " order by nome";
                                                            	$qstatus->selecionaTudo($qstatus);
                                                            	while ($res = $qstatus->retornaDados())
                                                            	{
                                                            	    if (strtoupper($res->padrao_abertura=='S')) 
                                                            	       printf('<option selected="selected" value="%s">%s</option>',$res->id,$res->nome);
                                                            	    else
                                                            	       printf('<option value="%s">%s</option>',$res->id,$res->nome);
                                                            	} 
                                                            ?>                                              
                                                        </select>                                                        
                                                        <span class="input-group-btn">
                                                		  <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#add_data_Modal_status"> + </button>
                                                		</span>
                                                	</div>
            									</div>       									
            							 	</div>            							 	   	
            							</div>	  
            							
            							<div class="row top-buffer">
    									 	<div class="form-group">            								
            									<div class="col-xs-4">
                      								<label>Projeto</label>
                      								<div class="input-group" >
                                                        <select id="idprojeto" name="projeto" class="form-control select2 " style="width: 100%;">
                                                           <option selected="selected" value="0"> </option>
                                                        	<?php 
                                                        	   $qprojeto = new projeto();
                                                        	   $qprojeto->extras_select = " order by nome";
                                                        	   $qprojeto->selecionaTudo($qprojeto);
                                                        	   while ($res = $qprojeto->retornaDados())
                                                            	{                                                        	   
                                                            	    if (strtoupper($res->padrao_abertura=='S'))
                                                            	       printf('<option selected="selected" value="%s">%s</option>',$res->id,$res->nome);
                                                            	    else
                                                            	       printf('<option value="%s">%s</option>',$res->id,$res->nome);
                                                            	} 
                                                            ?>                                              
                                                        </select>
                                                        <span class="input-group-btn">
                                                		  <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#add_data_Modal_projeto"> + </button>
                                                		</span>
                                                	</div>
            									</div>  
            									<div class="col-xs-4">
                      								<label>Atribuido à</label>                      								
                                                    <select name="atribuido" class="form-control select2 " style="width: 100%;">
                                                    	<option selected="selected" value="0"> </option>
                                                    	<?php 
                                                        	$qusuario = new usuario();
                                                        	$qusuario->extras_select = " order by nome";
                                                        	$qusuario->selecionaTudo($qusuario);
                                                        	while ($res = $qusuario->retornaDados())
                                                            	{
                                                            	    //sugere automaticamento o usuário logado para a tarefa
                                                            	    if ($iduser == $res->id)
                                                            	       printf('<option selected="selected" value="%s">%s</option>',$res->id,$res->nome);
                                                            	    else
                                                            	       printf('<option value="%s">%s</option>',$res->id,$res->nome);
                                                            	} 
                                                         ?>                                              
                                                    </select>
            									</div>                									
            									<div class="col-xs-2">
                      								<label>Data Início</label>
                      								<div class="input-group date">
                                                      <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                      </div>
                                                      <input name="dataini" type="text" class="form-control pull-right input-sm" id="datepicker1" value="<?php echo  date('d/m/Y');?>">
                                                    </div>
                                                                                                                                                
            									</div>  
            									<div class="col-xs-2">
                      								<label>Data Prev. Fim</label>
                      								<div class="input-group date">
                                                      <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                      </div>
                                                      <input name="dataprevfim" type="text" class="form-control pull-right input-sm" id="datepicker2" value="<?php echo date('d/m/Y');?>">
                                                    </div>
                                                                                                                                                
            									</div>           									     									
            							 	</div>            							 	   	
            							</div>	   
    								</div> 	  	                               
                                  		 
    								<div class="box-footer">  
    									 <button type="button" class="btn btn-default" onclick="location.href='?m=tarefas&t=listar'" >Cancelar</button>
    									 <button type="submit" name="cadastrar" class="btn btn-info pull-right">Salvar dados</button>  									    									 
    								</div>       							                          
    						</form>
    		 			</div><!-- Final box-primary -->    					  			
    			</section>
                <!-- /.content -->
			</div> <!-- /.content-wrapper -->
						
        	
            <?php
            break;
        
        case 'listar':
                			       
            ?>
            <!-- todo esse código é feito apenas para criar as classes CSS a serem utilizadas pela grid -->
            <style>
        		.dx-datagrid-headers {
        				color: #FFFFFF !important;
        				background-color: #3C8DBC !important;
        			}
        								
        		 <?php 
        		   //#003666 
                    require_once(dirname(dirname(__FILE__))."/funcoes.php");       
                    $select = " SELECT distinct
                                      coalesce(case
                                                	when (tarefas.data_fim >0) then null
                                                	else (select pe.cor from periodos_entrega pe where (DATEDIFF (CURRENT_DATE(),tarefas.data_prev_fim)) BETWEEN pe.inter_ini and 	pe.inter_fim)
                                            end,'White') cor
                                FROM  ";
                    $tarefa = new tarefa();
                    $tarefa->extras_select = " union select distinct coalesce(cor,'White') cor from status ";
                    
                    $tarefa->selecionaTudo($tarefa,$select);
                    while ($res = $tarefa->retornaDados())
                    {                                             
                        echo " .cls".substr($res->cor,1,strlen($res->cor))."{  background-color:".$res->cor.";  } ";
                    }   
                    
                
                ?>
            </style>
            
            <script type="text/javascript">
            	   
                   
        		   function bindGrid(data) {
        		       $("#gridContainer").dxDataGrid({
        		            dataSource: data,
        		            headerFilter: { visible: true },
        		            columnChooser: 
        			            {
            		             enabled : true,
            		             mode: "select"
        		             	},
        		            stateStoring:{
        						enabled : true,
        						type: "localStorage",
        						storageKey: "storages"
        			            }, 	
        			            keyExpr: "id",
        			         pager: {
        				         	showPageSizeSelector : true,
        				         	allowedPageSizes: [5,10,20]
        				         },
        		            "export": { enabled: true, fileName: "Tarefas"},
        		            columns: [
        		            	{ dataField: "id", dataType: "number", caption: "Código" },		                      
                               'assunto',
                               { dataField: "id_tipo", caption: "Cód. Tipo" },
                               { dataField: "id_status", caption: "Cód. Status" },
                               { dataField: "id_prioridade", caption: "Cód. Prioridade" },
                               
                               { dataField: "data_cad", caption: "Dt. Cadastro" },
                               { dataField: "id_projeto", caption: "Cód. Projeto" },
                               { dataField: "id_categoria", caption: "Cód. Categoria" },
                               { dataField: "data_inicio", caption: "Dt. Inicio" },
                               { dataField: "data_fim", caption: "Dt. Fim" },                       
                               { dataField: "id_atribuido", caption: "Cód. Usr. Resp." },
                               { dataField: "id_criador", caption: "Cód. Usr. Criador" },
                               { dataField: "data_prev_fim", caption: "Dt. Prev. Fim" },
                               { dataField: "atraso", caption: "Atraso(dias)" },                       
                               'categoria',
                               'projeto',
                               'status',
                               'cor',
                               'cor_linha',
                               { dataField: "usr_criador", caption: "Criador" },
                               { dataField: "usr_criador", caption: "Responsável" },                       
                               'tipo',    
        		                {
        		      			  dataField: "acoes",
        		      			  width: 100,
        		      			  dataType: "string",
        		      				cellTemplate: function(container, options) {
        		      		        var productName = options.value;
        		      		        $("<a href=\'?m=tarefas&t=incluir&id=" + options.value + "' title='Novo'><img src='images/add.png' alt='Novo cadastro' /></a>  <a href=\'?m=tarefas&t=editar&id=" + options.value + "' title='Editar'><img src='images/edit.png' alt='Editar'/></a> <a href=\'?m=tarefas&t=excluir&id=" + options.value + "'><img src='images/delete.png' alt='Excluir' /></a>")		      		       
        		      		        .appendTo(container);        		      		       
        		      		      }
        		      			},  		      			
        		            ],		            	
        		    		onCellPrepared: function (e) {
        		                if (e.rowType == 'data') {
        		                    if (e.column.dataField == 'status')  
        		                    {     
        		                    	var str = e.data.cor;		                    	      	
        		                    	e.cellElement.addClass("cls"+str.substr(1, 10));  
        		                      
        		                    }
        		    				else if (e.column.dataField == 'acoes')  
        		                    {                  
        		                      e.cellElement.addClass("clshite");  					
        		                    }
        		                }
        		            },  
        		    		onRowPrepared: function (info) {
        		    					if (info.rowType == 'data' )
        		    					{				    				
        			    				  var str = '';
        			    				  str = info.component.cellValue(info.rowIndex,"cor_linha");
        			    				  info.rowElement.addClass("cls"+str.substr(1, 10));			    					  			                      		    						
        		    					}
        		    				},  
        		            paging: {
        		                pageSize: 10
        		            },
        		            sorting: {
        		                mode: "multiple"
        		            },
        		            filterRow: {
        		                visible: false
        		            },
        		            searchPanel: {
        			            visible : true
        		            },		            
        		            showBorders : true,
        		            showColumnLines : true,
        		            showRowLines : true,
        		            allowColumnReordering: true,
        		            allowColumnResizing: true,
        		            columnResizingMode: "widget",
        		            groupPanel: {
        		                visible: true
        		            },
        		            selection: {
        		                mode: "single"
        		            },
        		            summary: {
        		            	groupItems: [{
        		                    column: "id",
        		                    summaryType: "count",
        		                    showInGroupFooter: true,
        		                }, 
        		                // ...
        		                ]
        		            }
        		        });
        		} 
        		$(document).ready(function () {
        		var hr = new XMLHttpRequest();
        		hr.open("GET", "modulos/tarefas_dados.php", true);
        		hr.setRequestHeader("Content-type", "application/json");
        		hr.onreadystatechange = function() {
        		    if (hr.readyState == 4 && hr.status == 200) {
        		        var data = JSON.parse(hr.responseText);
        		        bindGrid(data.tarefas);
        		    }
        		 }
        		 hr.send();      
        		});

        		$(function(){
					$("#refreshButton").dxButton({
					text: 'Refresh',
					onClick: function (){
                        					var dataGrid = $('#gridContainer').dxDataGrid('instance');
                        					dataGrid.refresh();
					}}) 
                }); 
        		
           </script>
            <div class="content-wrapper">             
                <!-- Content Header (Page header) -->
    		    <section class="content-header">
    		      <h1>
    		        Demandas
    		        <small>Listagem</small>
    		      </h1>
    		      <ol class="breadcrumb">
    		        <li><a ><i class="fa fa-dashboard"></i> Demandas</a></li>
    		        <li class="active">Listagem</li>
    		      </ol>
    		    </section>
    		    
    		     <!-- Main content -->
        		<section class="content container-fluid">                
                	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">		       
                	<div class="box">                              
                    	<div class="box-body">
                        	<div id="gridContainer"></div>
                        	<div style="text-align:center; margin:5px auto">
                        		<div id="refreshButton" style="height: 40px; margin-left:10px auto; display:inline-block">
                        		</div>
                        	</div>
            			</div><!-- /.box -->                    
            		</div><!-- /.box-body -->
            	</section> <!-- /.Main content -->           
			</div> <!-- /.content-wrapper -->
            <?php
            break;  
        
    case 'listar2':
    
    ?>
            <div class="content-wrapper">             
                <!-- Content Header (Page header) -->
    		    <section class="content-header">
    		      <h1>
    		        Demandas
    		        <small>Listagem</small>
    		      </h1>
    		      <ol class="breadcrumb">
    		        <li><a ><i class="fa fa-dashboard"></i> tarefas</a></li>
    		        <li class="active">Listagem</li>
    		      </ol>
    		    </section>
    		    
    		     <!-- Main content -->
        		<section class="content container-fluid">                
                	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">		       
                	<div class="box">                              
                    	<div class="box-body">
                        	<table id="gridfull" class="table table-bordered table-sm table-hover" data-show-toggle="true" data-show-columns="true" data-pagination="true" data-show-filter="true" data-filter-control="true">
                           		<thead>
                            		<tr>
                              			<th>Código</th>
                              			<th>Status</th>
                              			<th>Assunto</th>
                              		                         			
                              			<th>Categoria</th>
                              			
                              			<th>Atribuído à</th>
                              			<th>Dt Ini.</th>
                              		                     			
                              			<th>Atraso</th>
                              			                                			                 
                              			<th>Ações</th>
                            		</tr>
                            	</thead>
                            	<tbody>
                                    <?php 
                                    $select = ' SELECT tarefas.*, 
                                                case
                                                    when (st.fechado = "S") then 0
                                                    else DATEDIFF (CURRENT_DATE(),tarefas.data_prev_fim)
                                                end atraso, c.nome categoria, p.nome prioridade, pj.nome projeto,
                                                st.nome status, st.cor, tp.nome tipo, u1.nome usr_criador, u2.nome usr_atribuido,
                                                case
                                                    when (st.fechado = "S") then "#ffffff"
                                                    else (select pe.cor from periodos_entrega pe where (DATEDIFF (CURRENT_DATE(),tarefas.data_prev_fim)) BETWEEN pe.inter_ini and pe.inter_fim)
                                                end cor_linha 
                                                FROM ';
                                    $tarefa = new tarefa();
                                    $tarefa->extras_select = "  left join categorias c on (c.id = tarefas.id_categoria)
                                                                left join prioridades p on (p.id = tarefas.id_prioridade)
                                                                left join projetos pj on (pj.id = tarefas.id_projeto)
                                                                left join status st on (st.id = tarefas.id_status)
                                                                left join tipos tp on (tp.id = tarefas.id_tipo)
                                                                left join usuarios u1 on (u1.id = tarefas.id_criador)
                                                                left join usuarios u2 on (u2.id = tarefas.id_atribuido) ";
                                    
                                    $tarefa->selecionaTudo($tarefa,$select);                       					                                              
                                    while ($res = $tarefa->retornaDados()):                                       
                                        printf('<tr bgcolor="%s">',$res->cor_linha); 
                                        //echo '<tr>';
                                        printf('<td>%s</td>',$res->id);
                                        printf('<td bgcolor="%s">%s</span></td>',$res->cor,$res->status);
                                        printf('<td>%s</td>',$res->assunto);
                                      
                                        printf('<td>%s</td>',$res->categoria);
                                     
                                        printf('<td>%s</td>',$res->usr_atribuido);
                                        printf('<td>%s</td>',date('d/m/Y', strtotime($res->data_inicio)));                                        
                                      
                                        printf('<td>%s</td>',$res->atraso);                                    ;
                                        printf('<td><a href="?m=tarefas&t=incluir" title="Novo"><img src="images/add.png" alt="Novo cadastro" /></a> <a href="?m=tarefas&t=editar&id=%s" title="Editar"><img src="images/edit.png" alt="Editar" /></a><a href="?m=tarefas&t=excluir&id=%s" title="Excluir"><img src="images/delete.png" alt="Excluir" /></a></td>',$res->id,$res->id);
                                        echo '</tr>';
                                    endwhile;               
                                    ?>
                             	</tbody>
                            	<tfoot>
                            		<tr>
                              			<th></th>
                              			<th></th>
                              		                        			        
                              			<th></th>
                              			<th></th>
                              			<th></th>
                              			
                              			<th></th>
                              			
                              		    <th></th>                  			
                              			<th></th>
                              		
                            		</tr>
                            	</tfoot>
                        	</table>
            			</div><!-- /.box -->                    
            		</div><!-- /.box-body -->
            	</section> <!-- /.Main content -->           
			</div> <!-- /.content-wrapper -->
            <?php
            break;  
            
        case 'excluir':        
            $sessao = new sessao();
            if (isAdmin()==true)
            {
                if (isset($_GET['id'])) 
                {
                    $id = $_GET['id'];
                    
                    //iniciando processo de salvamento se o usuário deu POST
                    if (isset($_POST['excluir']))
                    {
                        $tarefa = new tarefa();
                        $tarefa->valorpk =$id;                   
                                                
                        
                        $tarefa->deletar($tarefa);
                        if ($tarefa->linhasafetadas==1)
                        {
                            printMSG('Registro excluído com sucesso. <a href="?m=tarefas&t=listar">Exibir cadastros</a>','sucesso');                                                     
                            unset($_POST);                           
                        }
                        else 
                            printMSG('Nenhum dado foi excluído. <a href="?m=tarefas&t=listar">Exibir cadastros</a>','alerta');
                        
                    } //final isset $_POST['excluir']
                    $tarefabd = new tarefa();
                    $tarefabd->extras_select = "where id=$id";
                    $tarefabd->selecionaTudo($tarefabd);
                    $resbd = $tarefabd->retornaDados();                   
                }//final isset $_GET['id']
                else
                    printMSG('tarefa não definido, <a href="?tarefas&t=listar">escolha um tarefa para excluir</a>','erro');
                
                //formulário de edição de tarefa   
                ?>   
                	
                	<div class="content-wrapper">
                    <!-- Content Header (Page header) --> 
            
                    <section class="content-header">
                    	<h1>
                    		Demandas
                    		<small>Excluir</small>
                      	</h1>
                      	<ol class="breadcrumb">
                    		<li><a ><i class="fa fa-dashboard"></i> Demandas</a></li>
                    		<li class="active">Excluir</li>
                      	</ol>
                    </section> 
        
                    <section class="content">      				    	           
    						<div class="box box-primary">    								
    							<form class="userform" role="form" method="post" action="">
    								<div class="box-body">
    									<div class="row">
    									 	<div class="form-group">
            									<div class="col-xs-2">
                      								<label>Código</label>
                      								<input disabled name="assunto" type="text" class="form-control " placeholder="Código é Automático" value="<?php if($resbd) echo $resbd->id;?>">
            									</div>
            									<div class="col-xs-8">
                      								<label>Assunto</label>
                      								<input disabled name="assunto" type="text" class="form-control " placeholder="Assunto da Tarefa" value="<?php if($resbd) echo $resbd->assunto;?>">
            									</div>            									                                                         								
            									<div class="col-xs-2">
                      								<label>Tipo</label>
                                                    <select disabled name="tipo" class="form-control select2 " style="width: 100%;">
                                                    	<option selected="selected" value="0"> </option>
                                                    	<?php 
                                                        	$qtipo = new tipo();                                                	
                                                        	$qtipo->extras_select = " order by nome";
                                                        	$qtipo->selecionaTudo($qtipo);                                                                
                                                            while ($res = $qtipo->retornaDados())
                                                            {                                         
                                                                if ($resbd->id_tipo == $res->id)
                                                                    printf('<option selected="selected" value="%s">%s</option>',$res->id,$res->nome);
                                                                else
                                                                    printf('<option value="%s">%s</option>',$res->id,$res->nome);
                                                            } 
                                                        ?>                                              
                                                    </select>
            									</div>        									
            							 	</div>            							 	   	
            							</div>	
            							<div class="row top-buffer">
    									 	<div class="form-group">    									 	
                                            	<div class="col-xs-12" >                                                               
                                            			<label>Descrição</label>
                                            			<textarea disabled form-control id="editor1" name="editor1" rows="10" cols="80">
    															<?php if($resbd) echo html_entity_decode($resbd->descricao);?>                                        				                                            				
                                            			</textarea>                                                                                                                                       
                                            	</div>		                                    	     									                                             
    										</div>            							 	   	
            							</div> 	
            							<div class="row top-buffer">
    									 	<div class="form-group">            								
            									<div class="col-xs-4">
                      								<label>Prioridade</label>
                                                    <select disabled name="prioridade" class="form-control select2 " style="width: 100%;">
                                                    <option selected="selected" value="0"> </option>
                                                    	<?php 
                                                        	$qprioridade = new prioridade();
                                                        	$qprioridade->extras_select = " order by nome";
                                                        	$qprioridade->selecionaTudo($qprioridade);
                                                        	
                                                        	while ($res = $qprioridade->retornaDados())
                                                        	{
                                                        	    if ($resbd->id_prioridade == $res->id)
                                                        	        printf('<option selected="selected" value="%s">%s</option>',$res->id,$res->nome);
                                                        	    else
                                                        	        printf('<option value="%s">%s</option>',$res->id,$res->nome);
                                                        	} 
                                                        ?>                                              
                                                    </select>
            									</div>  
            									<div class="col-xs-4">
                      								<label>Categoria</label>
                                                    <select disabled name="categoria" class="form-control select2 " style="width: 100%;">
                                                       <option selected="selected" value="0"> </option>
                                                    	<?php 
                                                        	$qcategoria = new categoria();
                                                        	$qcategoria->extras_select = " order by nome";
                                                        	$qcategoria->selecionaTudo($qcategoria);
                                                        	while ($res = $qcategoria->retornaDados())
                                                        	{
                                                        	    if ($resbd->id_categoria == $res->id)
                                                        	        printf('<option selected="selected" value="%s">%s</option>',$res->id,$res->nome);
                                                        	    else
                                                        	        printf('<option value="%s">%s</option>',$res->id,$res->nome);
                                                        	} 
                                                        ?>                                              
                                                    </select>
            									</div> 
            									<div class="col-xs-4">
                      								<label>Status</label>
                                                    <select disabled name="status" class="form-control select2 " style="width: 100%;">
                                                       <option selected="selected" value="0"> </option>
                                                    	<?php 
                                                        	$qstatus= new status();
                                                        	$qstatus->extras_select = " order by nome";
                                                        	$qstatus->selecionaTudo($qstatus);
                                                        	while ($res = $qstatus->retornaDados())
                                                        	{
                                                        	    if ($resbd->id_status == $res->id)
                                                        	       printf('<option selected="selected" value="%s">%s</option>',$res->id,$res->nome);
                                                        	    else
                                                        	       printf('<option value="%s">%s</option>',$res->id,$res->nome);
                                                        	} 
                                                        ?>                                              
                                                    </select>
            									</div>       									
            							 	</div>            							 	   	
            							</div>	  
            							
            							<div class="row top-buffer">
    									 	<div class="form-group">            								
            									<div class="col-xs-4">
                      								<label>Projeto</label>
                                                    <select disabled name="projeto" class="form-control select2 " style="width: 100%;">
                                                       <option selected="selected" value="0"> </option>
                                                    	<?php 
                                                    	   $qprojeto = new projeto();
                                                    	   $qprojeto->extras_select = " order by nome";
                                                    	   $qprojeto->selecionaTudo($qprojeto);
                                                    	   while ($res = $qprojeto->retornaDados())
                                                        	{
                                                        	    if ($resbd->id_projeto == $res->id)
                                                        	        printf('<option selected="selected" value="%s">%s</option>',$res->id,$res->nome);
                                                        	    else
                                                        	        printf('<option value="%s">%s</option>',$res->id,$res->nome);
                                                        	} 
                                                        ?>                                              
                                                    </select>
            									</div>  
            									<div class="col-xs-4">
                      								<label>Atribuido à</label>
                                                    <select disabled name="atribuido" class="form-control select2 " style="width: 100%;">
                                                    	<option selected="selected" value="0"> </option>
                                                    	<?php 
                                                        	$qusuario = new usuario();
                                                        	$qusuario->extras_select = " order by nome";
                                                        	$qusuario->selecionaTudo($qusuario);
                                                        	while ($res = $qusuario->retornaDados())
                                                            	{
                                                            	    if ($resbd->id_atribuido == $res->id)
                                                            	       printf('<option selected="selected" value="%s">%s</option>',$res->id,$res->nome);
                                                            	    else
                                                            	       printf('<option value="%s">%s</option>',$res->id,$res->nome);
                                                            	} 
                                                         ?>                                              
                                                    </select>
            									</div>                									
            									<div class="col-xs-2">
                      								<label>Data Início</label>
                      								<div class="input-group date">
                                                      <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                      </div>
                                                      <input disabled name="dataini" type="text" class="form-control pull-right input-sm" id="datepicker1" value="<?php if($resbd) echo date('d/m/Y', strtotime($resbd->data_inicio)) ;?>">
                                                    </div>
                                                                                                                                                
            									</div>  
            									<div class="col-xs-2">
                      								<label>Data Prev. Fim</label>
                      								<div class="input-group date">
                                                      <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                      </div>
                                                      <input disabled name="dataprevfim" type="text" class="form-control pull-right input-sm" id="datepicker2" value="<?php if($resbd) echo date('d/m/Y', strtotime($resbd->data_prev_fim)) ;?>">
                                                    </div>
                                                                                                                                                
            									</div>           									     									
            							 	</div>            							 	   	
            							</div>	   
    								</div> 	  	                               
                                  		 
    								<div class="box-footer">  
        									 <button type="button" class="btn btn-default" onclick="location.href='?m=tarefas&t=listar'" >Cancelar</button>
        									 <button type="submit" name="excluir" class="btn btn-info pull-right">Confirmar exclusão</button>  									        									 
        							</div>        							                          
    						</form>
    		 			</div><!-- Final box-primary -->    					  			
    				</section>
                    
                    <!-- /.content -->
    			</div>                     
                    
                <?php   
            }//final  if ((isAdmin()==true)||$sessao->getVar('iduser')==$_GET['id'])
            else
                printMSG('Você não tem permissão para acessar essa página. <a href="#" onclick="history.back()">Voltar</a>','erro');
        break;      
        
        default:
            echo '<p> A tela solicitada não existe </p>';
            break;
    }