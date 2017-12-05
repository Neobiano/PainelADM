

<?php   
    require_once(dirname(dirname(__FILE__))."/funcoes.php");
    protegeArquivo(basename(__FILE__));
    loadJS('bower_components/ckeditor/ckeditor.js',true);	
   
    //verificando se há registros no BD, caso contrario abrirá a inserção.
    if ($tela =='listar')
    {
        $qtarefa = new tarefa();       
        $qtarefa->selecionaTudo($qtarefa);
        if ($qtarefa->linhasafetadas <= 0)
            $tela = 'incluir';        
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
                            'data_inicio'=>$_POST['dataini'],
                            'data_prev_fim'=>$_POST['dataprevfim']
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
                    $tarefabd = new tarefa();
                    $tarefabd->extras_select = "WHERE id=$id";
                    $tarefabd->selecionaTudo($tarefabd);
                    $resbd = $tarefabd->retornaDados();
                }
                else
                    printMSG('tarefa não definido, <a href="?m=tarefas&t=listar">escolha um tarefa para alterar</a>','erro');
                                                   
                ?>
                    			            	
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
                              <!-- <button type="submit" name="insert" id="insert" class="btn btn-primary">Salvar</button> -->
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
    			<section class="content">      				    	           
    						<div class="box box-primary">    								
    							<form class="userform" role="form" method="post" action="">
    								<div class="box-body">
    									<div class="row">
    									 	<div class="form-group">
            									<div class="col-xs-2">
                      								<label>Código</label>
                      								<input disabled name="assunto" type="text" class="form-control" placeholder="Código é Automático" value="<?php if($resbd) echo $resbd->id;?>">
            									</div>
            									<div class="col-xs-8">
                      								<label>Assunto</label>
                      								<input autofocus name="assunto" type="text" class="form-control" placeholder="Assunto da Tarefa" value="<?php if($resbd) echo $resbd->assunto;?>">
            									</div>            									                                                         								
            									<div class="col-xs-2">
                      								<label>Tipo</label>
                                                    <select name="tipo" class="form-control select2" style="width: 100%;">
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
                          						    <div class="input-group">
                                                        <select name="prioridade" class="form-control select2 " style="width: 100%;">
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
                                                          <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#add_data_Modal"> + </button>
                                                        </span>
                                                        
													</div>                                                        
            									</div>              									
                                                
            									<div class="col-xs-4">
                      								<label>Categoria</label>
                                                    <select name="categoria" class="form-control select2 " style="width: 100%;">
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
                                                    <select name="status" class="form-control select2" style="width: 100%;">
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
                                                    <select name="projeto" class="form-control select2 " style="width: 100%;">
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
                                                      <input name="dataini" type="text" class="form-control pull-right input-sm" id="datepicker1" value="<?php if($resbd) echo $resbd->data_inicio;?>">
                                                    </div>
                                                                                                                                                
            									</div>  
            									<div class="col-xs-2">
                      								<label>Data Prev. Fim</label>
                      								<div class="input-group date">
                                                      <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                      </div>
                                                      <input name="dataprevfim" type="text" class="form-control pull-right input-sm" id="datepicker2" value="<?php if($resbd) echo $resbd->data_prev_fim;?>">
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
            if (isset($_POST['cadastrar']))
            {    
                //identificando o usuário logado
                $sessao = new sessao();
                $iduser = $sessao->getVar('iduser');
                
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
                    'data_inicio'=>$_POST['dataini'],
                    'data_prev_fim'=>$_POST['dataprevfim'],
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
       
			    <script type="text/javascript">
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
                }
                );
                </script>  
                
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
                      								<input disabled name="assunto" type="text" class="form-control " placeholder="Código é Automático" >
            									</div>
            									<div class="col-xs-8">
                      								<label>Assunto</label>
                      								<input autofocus name="assunto" type="text" class="form-control " placeholder="Assunto da tarefa" value="<?php echo $_POST['assunto']?>">
            									</div>            									                                                         								
            									<div class="col-xs-2">
                      								<label>Tipo</label>
                                                    <select name="tipo" class="form-control select2 " style="width: 100%;">
                                                    	<option selected="selected" value="0"> </option>
                                                    	<?php 
                                                        	$qtipo = new tipo();    
                                                        	$qtipo->extras_select = " order by nome";
                                                            $qtipo->selecionaTudo($qtipo);                                                	                                                	                                                                                                                                                              
                                                            while ($res = $qtipo->retornaDados())
                                                            {                                                                                                         
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
                                                    <select name="prioridade" class="form-control select2 " style="width: 100%;">
                                                    <option selected="selected" value="0"> </option>
                                                    	<?php 
                                                        	$qprioridade = new prioridade();
                                                        	$qprioridade->extras_select = " order by nome";
                                                        	$qprioridade->selecionaTudo($qprioridade);
                                                        	while ($res = $qprioridade->retornaDados())
                                                        	{                                                        	    
                                                        	    printf('<option value="%s">%s</option>',$res->id,$res->nome);
                                                        	} 
                                                        ?>                                              
                                                    </select>
            									</div>  
            									<div class="col-xs-4">
                      								<label>Categoria</label>
                                                    <select name="categoria" class="form-control select2 " style="width: 100%;">
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
            									</div> 
            									<div class="col-xs-4">
                      								<label>Status</label>
                                                    <select name="status" class="form-control select2 " style="width: 100%;">
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
            									</div>       									
            							 	</div>            							 	   	
            							</div>	  
            							
            							<div class="row top-buffer">
    									 	<div class="form-group">            								
            									<div class="col-xs-4">
                      								<label>Projeto</label>
                                                    <select name="projeto" class="form-control select2 " style="width: 100%;">
                                                       <option selected="selected" value="0"> </option>
                                                    	<?php 
                                                    	   $qprojeto = new projeto();
                                                    	   $qprojeto->extras_select = " order by nome";
                                                    	   $qprojeto->selecionaTudo($qprojeto);
                                                    	   while ($res = $qprojeto->retornaDados())
                                                        	{                                                        	   
                                                        	   printf('<option value="%s">%s</option>',$res->id,$res->nome);
                                                        	} 
                                                        ?>                                              
                                                    </select>
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
                                                      <input name="dataini" type="text" class="form-control pull-right input-sm" id="datepicker1" value="<?php echo $_POST['dataini'];?>">
                                                    </div>
                                                                                                                                                
            									</div>  
            									<div class="col-xs-2">
                      								<label>Data Prev. Fim</label>
                      								<div class="input-group date">
                                                      <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                      </div>
                                                      <input name="dataprevfim" type="text" class="form-control pull-right input-sm" id="datepicker2" value="<?php echo $_POST['dataprevfim'];;?>">
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
                        	<table id="gridfull" class="table table-bordered  table-sm">
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
                                                    when (tarefas.data_fim >0) then null
                                                    else DATEDIFF (CURRENT_DATE(),tarefas.data_prev_fim)
                                                end atraso, c.nome categoria, p.nome prioridade, pj.nome projeto,
                                                st.nome status, st.cor, tp.nome tipo, u1.nome usr_criador, u2.nome usr_atribuido,
                                                case
                                                    when (tarefas.data_fim >0) then null
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
                                        printf('<td>%s</td>',$res->data_inicio);                                        
                                      
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
                	<script type="text/javascript">
                    $(document).ready(function()
                    {	             		
                      	CKEDITOR.replace('editor1')	                	
                    });            	  									
                	</script> 	 
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
                                                      <input disabled name="dataini" type="text" class="form-control pull-right input-sm" id="datepicker1" value="<?php if($resbd) echo $resbd->data_inicio;?>">
                                                    </div>
                                                                                                                                                
            									</div>  
            									<div class="col-xs-2">
                      								<label>Data Prev. Fim</label>
                      								<div class="input-group date">
                                                      <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                      </div>
                                                      <input disabled name="dataprevfim" type="text" class="form-control pull-right input-sm" id="datepicker2" value="<?php if($resbd) echo $resbd->data_prev_fim;?>">
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